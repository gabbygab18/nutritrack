/* ============================================================
   NutriTrack — app.js
   Uses Laravel backend APIs for auth, entries, and goals.
   ============================================================ */
(function () {
    'use strict';

    /* ---------------- Config ---------------- */
    // var USDA_API_KEY = '1KcPg4PuCE0Kdui8vXSvE0w47seIEbxwaJ7RiWUY';
    // var USDA_SEARCH_URL = 'https://api.nal.usda.gov/fdc/v1/foods/search';
    var API_BASE = '/api';

    var DEFAULT_GOALS = { calories: 2000, protein: 120, carbs: 275, fat: 78 };
    // var CARB_REFERENCE = 275;
    // var FAT_REFERENCE = 78;

    /* ---------------- State ---------------- */
    var currentUser = null;
    var authMode = 'login';
    var editingEntryId = null;
    var selectedMeal = 'Breakfast';
    var pendingPhotoDataUrl = null;
    var currentSearchResults = [];
    var historyDateFilter = null;

    /* ---------------- DOM helpers ---------------- */
    function $(id) { return document.getElementById(id); }
    function qs(sel, ctx) { return (ctx || document).querySelector(sel); }
    function qsa(sel, ctx) { return Array.prototype.slice.call((ctx || document).querySelectorAll(sel)); }

    function escapeHtml(str) {
        return String(str == null ? '' : str).replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
        });
    }

    function uid() {
        return Date.now().toString(36) + Math.random().toString(36).slice(2, 8);
    }

    function round1(n) { return Math.round((Number(n) || 0) * 10) / 10; }

    function pct(val, goal) {
        if (!goal) return 0;
        return Math.max(0, Math.min(100, Math.round((val / goal) * 100)));
    }

    function pad2(n) { return String(n).padStart(2, '0'); }

    function todayISO() {
        var d = new Date();
        return d.getFullYear() + '-' + pad2(d.getMonth() + 1) + '-' + pad2(d.getDate());
    }

    function toTitleCase(str) {
        return String(str).toLowerCase().replace(/(^|[\s,(\/])([a-z])/g, function (m, p1, p2) {
            return p1 + p2.toUpperCase();
        });
    }

    function greeting() {
        var h = new Date().getHours();
        if (h < 12) return 'Good morning';
        if (h < 18) return 'Good afternoon';
        return 'Good evening';
    }

    function formatDateHeader(dateStr) {
        var today = todayISO();
        var y = new Date();
        y.setDate(y.getDate() - 1);
        var yISO = y.getFullYear() + '-' + pad2(y.getMonth() + 1) + '-' + pad2(y.getDate());
        if (dateStr === today) return 'Today';
        if (dateStr === yISO) return 'Yesterday';
        var d = new Date(dateStr + 'T00:00:00');
        return d.toLocaleDateString(undefined, { weekday: 'long', month: 'long', day: 'numeric' });
    }

    function emptyStateHTML(text) {
        return '<div class="empty-state">' +
            '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4v6h6M4 10a8 8 0 1 1 2.3 5.6"/><path d="M12 8v4l3 2"/></svg>' +
            '<p>' + escapeHtml(text) + '</p></div>';
    }

    function showToast(text) {
        var toast = $('toast');
        $('toastText').textContent = text;
        toast.classList.add('show');
        clearTimeout(showToast._t);
        showToast._t = setTimeout(function () { toast.classList.remove('show'); }, 2400);
    }

    /**
     * Toggles a spinner + disabled state on any button while an async
     * action is in flight. Safe to call repeatedly; restores the
     * button's original markup when loading is turned off.
     * loadingText is optional — omit it for icon-only buttons.
     */
    function setBtnLoading(btn, loading, loadingText) {
        if (!btn) return;
        if (loading) {
            if (btn.dataset.loading === '1') return;
            btn.dataset.loading = '1';
            btn.dataset.originalHtml = btn.innerHTML;
            btn.disabled = true;
            btn.classList.add('is-loading');
            btn.innerHTML = '<span class="btn-spinner" aria-hidden="true"></span>' +
                (loadingText ? '<span>' + escapeHtml(loadingText) + '</span>' : '');
        } else {
            btn.dataset.loading = '';
            btn.disabled = false;
            btn.classList.remove('is-loading');
            if (btn.dataset.originalHtml != null) {
                btn.innerHTML = btn.dataset.originalHtml;
                delete btn.dataset.originalHtml;
            }
        }
    }

    function getCsrfToken() {
        var match = document.cookie.match(/(?:^|;\s*)XSRF-TOKEN=([^;]*)/);
        if (match) return decodeURIComponent(match[1]);
        var meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.content : '';
    }

    function apiFetch(path, opts) {
        opts = opts || {};
        opts.headers = opts.headers || {};
        opts.headers.Accept = 'application/json';

        if (opts.method && ['POST', 'PUT', 'PATCH', 'DELETE'].indexOf(opts.method.toUpperCase()) >= 0) {
            opts.headers['X-XSRF-TOKEN'] = getCsrfToken();
        }

        if (opts.body && typeof opts.body === 'object' && !(opts.body instanceof FormData)) {
            opts.headers['Content-Type'] = 'application/json';
            opts.body = JSON.stringify(opts.body);
        }

        opts.credentials = opts.credentials || 'same-origin';

        return fetch(API_BASE + path, opts).then(function (res) {
            if (res.status === 204) return null;
            return res.json().then(function (data) {
                if (!res.ok) {
                    var msg = (data && data.message) ? data.message : 'Request failed';
                    var err = new Error(msg);
                    err.response = data;
                    err.status = res.status;
                    throw err;
                }
                return data;
            });
        });
    }

    function fetchCurrentUser() {
        return apiFetch('/user').then(function (user) {
            currentUser = user;
            return user;
        });
    }

    function fetchGoals() {
        return apiFetch('/goals');
    }

    function fetchEntries(date) {
        var query = date ? '?date=' + encodeURIComponent(date) : '';
        return apiFetch('/entries' + query);
    }

    function fetchEntry(id) {
        return apiFetch('/entries/' + encodeURIComponent(id));
    }

    function authRequest(path, body) {
        return apiFetch(path, { method: 'POST', body: body });
    }

    /* ============================================================
       AUTH
       ============================================================ */
    function showAuthError(msg) {
        var el = $('authError');
        el.textContent = msg;
        el.classList.add('show');
    }

    function hideAuthError() {
        $('authError').classList.remove('show');
    }

    function setAuthMode(mode) {
        authMode = mode;
        qsa('.auth-tab').forEach(function (t) { t.classList.toggle('active', t.dataset.tab === mode); });
        $('fieldName').classList.toggle('hidden', mode !== 'signup');
        $('authName').required = mode === 'signup';
        $('authTitle').textContent = mode === 'signup' ? 'Create your account.' : 'Welcome back.';
        $('authSubmit').textContent = mode === 'signup' ? 'Sign up' : 'Log in';
        $('authPassword').autocomplete = mode === 'signup' ? 'new-password' : 'current-password';
        hideAuthError();
    }

    /* ============================================================
       APP SHELL / NAV
       ============================================================ */
    function enterApp() {
        var first = currentUser.name.trim().split(/\s+/)[0] || currentUser.name;
        $('userName').textContent = first;
        updateUserAvatarChip();

        // Determine the view from the URL hash, default to dashboard
        var validViews = ['dashboard', 'history', 'settings'];
        var hashView = (window.location.hash || '#dashboard').replace('#', '');
        var initialView = validViews.includes(hashView) ? hashView : 'dashboard';
        switchView(initialView);
    }

    function updateUserAvatarChip() {
        var el = $('userAvatar');
        if (currentUser.avatar) {
            el.innerHTML = '<img src="' + currentUser.avatar + '" alt="" class="user-avatar-img">';
        } else {
            el.textContent = (currentUser.name.trim().charAt(0) || '?').toUpperCase();
        }
    }

    function initNav() {
        qsa('.tab-btn').forEach(function (btn) {
            btn.addEventListener('click', function () { switchView(btn.dataset.view); });
        });
        qsa('[data-goto]').forEach(function (btn) {
            btn.addEventListener('click', function () { switchView(btn.dataset.goto); });
        });
    }

    function switchView(view) {
        qsa('.view').forEach(function (v) { v.classList.add('hidden'); });
        var target = $('view-' + view);
        if (target) target.classList.remove('hidden');
        qsa('.tab-btn').forEach(function (t) { t.classList.toggle('active', t.dataset.view === view); });

        // Update the URL hash silently
        if (window.location.hash !== '#' + view) {
            history.replaceState(null, '', '#' + view);
        }

        if (view === 'dashboard') renderDashboard();
        if (view === 'history') renderHistory();
        if (view === 'settings') renderSettings();
    }
    function sumEntries(entries) {
        return entries.reduce(function (acc, e) {
            acc.calories += Number(e.calories) || 0;
            acc.protein += Number(e.protein) || 0;
            acc.carbs += Number(e.carbs) || 0;
            acc.fat += Number(e.fat) || 0;
            return acc;
        }, { calories: 0, protein: 0, carbs: 0, fat: 0 });
    }
    /* ============================================================
       DASHBOARD
       ============================================================ */
    function renderDashboard() {
        if (!currentUser) return;
        var first = currentUser.name.trim().split(/\s+/)[0] || currentUser.name;
        $('dashGreeting').textContent = greeting() + ', ' + first + '.';
        $('dashDate').textContent = new Date().toLocaleDateString(undefined, { weekday: 'long', month: 'long', day: 'numeric' });

        Promise.all([fetchGoals(), fetchEntries(todayISO())]).then(function (results) {
            var goals = results[0];
            var todayEntries = results[1];

            $('statCaloriesGoal').textContent = goals.calories;
            $('statProteinGoal').textContent = goals.protein;
            $('statCarbsGoal').textContent = goals.carbs;
            $('statFatGoal').textContent = goals.fat;

            var totals = sumEntries(todayEntries);
            $('statCalories').textContent = Math.round(totals.calories);
            $('statProtein').textContent = Math.round(totals.protein);
            $('statCarbs').textContent = Math.round(totals.carbs);
            $('statFat').textContent = Math.round(totals.fat);

            $('barCalories').style.width = pct(totals.calories, goals.calories) + '%';
            $('barProtein').style.width = pct(totals.protein, goals.protein) + '%';
            $('barCarbs').style.width = pct(totals.carbs, goals.carbs) + '%';
            $('barFat').style.width = pct(totals.fat, goals.fat) + '%';

            var recentWrap = $('dashRecent');
            if (!todayEntries.length) {
                recentWrap.innerHTML = emptyStateHTML('Nothing logged yet today — log your first meal to see it here.');
            } else {
                recentWrap.innerHTML = todayEntries.map(entryRowHTML).join('');
                bindEntryRowEvents(recentWrap);
            }
        }).catch(function () {
            showToast('Could not load dashboard. Please refresh.');
        });
    }

    /* ============================================================
       ENTRY ROWS (shared by dashboard + history)
       ============================================================ */
    function entryRowHTML(entry) {
        var photoEl = entry.photo
            ? '<img class="entry-photo" src="' + entry.photo + '" data-photo="' + entry.id + '" alt="' + escapeHtml(entry.name) + '">'
            : '<div class="entry-photo-placeholder"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><circle cx="9" cy="11" r="2"/><path d="m21 16-4.5-4.5a2 2 0 0 0-2.8 0L5 21"/></svg></div>';

        return '' +
            '<div class="entry-row" data-id="' + entry.id + '">' +
            photoEl +
            '<div class="entry-info">' +
            '<div class="entry-name">' + escapeHtml(entry.name) + '</div>' +
            '<div class="entry-meta">' +
            '<span class="badge">' + escapeHtml(entry.meal) + '</span>' +
            '<span class="entry-macros"><b>' + Math.round(entry.calories) + '</b> kcal &middot; <b>' + round1(entry.protein) + 'g</b> protein</span>' +
            '</div>' +
            '</div>' +
            '<div class="entry-actions">' +
            '<button type="button" class="icon-btn-sm" data-edit="' + entry.id + '" title="Edit">' +
            '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>' +
            '</button>' +
            '<button type="button" class="icon-btn-sm" data-delete="' + entry.id + '" title="Delete">' +
            '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0-1 14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2L4 6"/></svg>' +
            '</button>' +
            '</div>' +
            '</div>';
    }

    function bindEntryRowEvents(container) {
        qsa('[data-edit]', container).forEach(function (btn) {
            btn.addEventListener('click', function () { editEntry(btn.dataset.edit, btn); });
        });
        qsa('[data-delete]', container).forEach(function (btn) {
            btn.addEventListener('click', function () { deleteEntry(btn.dataset.delete, btn); });
        });
        qsa('[data-photo]', container).forEach(function (img) {
            img.addEventListener('click', function () {
                $('lightboxImg').src = img.src;
                openModal('lightboxOverlay');
            });
        });
    }

    function currentActiveView() {
        var el = qs('.view:not(.hidden)');
        return el ? el.id.replace('view-', '') : 'dashboard';
    }

    function refreshCurrentView() {
        var view = currentActiveView();
        if (view === 'dashboard') renderDashboard();
        if (view === 'history') renderHistory();
    }

    function editEntry(id, btn) {
        setBtnLoading(btn, true);
        fetchEntry(id).then(function (entry) {
            setBtnLoading(btn, false);
            openEntryModal({
                editId: entry.id,
                name: entry.name,
                meal: entry.meal,
                servings: entry.servings,
                servingUnit: entry.serving_unit,
                calories: entry.per_calories,
                protein: entry.per_protein,
                carbs: entry.per_carbs,
                fat: entry.per_fat,
                photo: entry.photo,
            });
        }).catch(function () {
            setBtnLoading(btn, false);
            showToast('Could not load entry.');
        });
    }

    function deleteEntry(id, btn) {
        if (!confirm("Delete this entry? This can't be undone.")) return;
        setBtnLoading(btn, true);
        apiFetch('/entries/' + encodeURIComponent(id), { method: 'DELETE' })
            .then(function () {
                showToast('Entry deleted');
                refreshCurrentView();
            }).catch(function () {
                setBtnLoading(btn, false);
                showToast('Could not delete entry.');
            });
    }

    /* ============================================================
       LOG A MEAL — USDA search + manual add
       ============================================================ */
    function initSearch() {
        $('searchForm').addEventListener('submit', function (e) {
            e.preventDefault();
            var q = $('searchInput').value.trim();
            if (!q) return;
            var btn = $('searchBtn');
            setBtnLoading(btn, true, 'Searching…');
            performSearch(q).then(function () {
                setBtnLoading(btn, false);
            });
        });
        $('manualAddBtn').addEventListener('click', function () {
            openEntryModal({ servingUnit: 'serving' });
        });
    }

    function performSearch(query) {
        $('searchResults').innerHTML = '<div class="search-status">Searching…</div>';

        return apiFetch('/foods/search?q=' + encodeURIComponent(query))
            .then(function (data) {
                var local = (data.local || []).map(normalizeFoodResult);
                var usda = (data.usda || []).map(normalizeFoodResult);
                currentSearchResults = local.concat(usda);
                renderSearchResults();
            })
            .catch(function () {
                $('searchResults').innerHTML = '<div class="search-status">Couldn\u2019t reach the food database right now. Please try again in a moment, or add the food manually below.</div>';
            });
    }

    function normalizeFoodResult(food) {
        return {
            id: food.id,
            source: food.source,
            name: food.name,
            brand: food.brand || '',
            servingDescription: food.serving_description || '100 g',
            calories: round1(food.calories),
            protein: round1(food.protein),
            carbs: round1(food.carbs),
            fat: round1(food.fat)
        };
    }

    function renderSearchResults() {
        var wrap = $('searchResults');
        if (!currentSearchResults.length) {
            wrap.innerHTML = '<div class="search-status">No results found. Try a different search term, or add the food manually.</div>';
            return;
        }
        wrap.innerHTML = currentSearchResults.map(function (f, i) {
            return '' +
                '<div class="result-card">' +
                '<div class="result-info">' +
                '<div class="result-name">' + escapeHtml(f.name) +
                (f.source === 'local' ? ' <span class="badge">PH</span>' : '') + '</div>' +
                (f.brand ? '<div class="result-brand">' + escapeHtml(f.brand) + '</div>' : '') +
                '<div class="result-macros"><b>' + f.calories + '</b> kcal &middot; <b>' + f.protein + 'g</b> protein &middot; ' + f.carbs + 'g carbs &middot; ' + f.fat + 'g fat <span class="micro">/ ' + escapeHtml(f.servingDescription) + '</span></div>' +
                '</div>' +
                '<button type="button" class="btn btn-primary btn-sm add-btn" data-index="' + i + '">Add</button>' +
                '</div>';
        }).join('');

        qsa('.add-btn', wrap).forEach(function (btn) {
            btn.addEventListener('click', function () {
                var food = currentSearchResults[Number(btn.dataset.index)];
                openEntryModal({
                    name: food.name,
                    servingUnit: food.servingDescription,
                    calories: food.calories,
                    protein: food.protein,
                    carbs: food.carbs,
                    fat: food.fat
                });
            });
        });
    }

    /* ============================================================
       ENTRY MODAL (add / edit — search-filled or manual)
       ============================================================ */
    function initEntryModal() {
        qsa('.chip-option', $('mealTypeChips')).forEach(function (chip) {
            chip.addEventListener('click', function () {
                selectedMeal = chip.dataset.meal;
                qsa('.chip-option', $('mealTypeChips')).forEach(function (c) { c.classList.toggle('active', c === chip); });
            });
        });

        ['entryServings', 'entryCalories', 'entryProtein'].forEach(function (id) {
            $(id).addEventListener('input', updateModalTotal);
        });

        $('entryPhoto').addEventListener('change', function (e) {
            var file = e.target.files && e.target.files[0];
            if (!file) return;
            if (file.type.indexOf('image/') !== 0) { showToast('Please choose an image file.'); return; }
            resizeImage(file).then(function (dataUrl) {
                pendingPhotoDataUrl = dataUrl;
                $('photoPreviewImg').src = dataUrl;
                $('photoPreviewWrap').classList.remove('hidden');
                $('photoDrop').classList.add('hidden');
            }).catch(function () {
                showToast('Could not read that image.');
            });
        });

        $('photoRemoveBtn').addEventListener('click', function () {
            pendingPhotoDataUrl = null;
            $('entryPhoto').value = '';
            $('photoPreviewWrap').classList.add('hidden');
            $('photoDrop').classList.remove('hidden');
        });

        $('entryModalClose').addEventListener('click', function () { closeModal('entryModalOverlay'); });
        $('entryCancelBtn').addEventListener('click', function () { closeModal('entryModalOverlay'); });

        $('entryForm').addEventListener('submit', function (e) {
            e.preventDefault();
            var name = $('entryName').value.trim();
            if (!name) { showToast('Please enter a food name.'); $('entryName').focus(); return; }

            var servings = Number($('entryServings').value) || 1;
            var servingUnit = $('entryServingUnit').value.trim() || 'serving';
            var perCal = Number($('entryCalories').value) || 0;
            var perPro = Number($('entryProtein').value) || 0;
            var perCarb = Number($('entryCarbs').value) || 0;
            var perFat = Number($('entryFat').value) || 0;

            var dateVal = todayISO();
            var timestampVal = Date.now();
            var payload = {
                id: editingEntryId || uid(),
                name: name,
                meal: selectedMeal,
                servings: servings,
                serving_unit: servingUnit,
                per_calories: perCal,
                per_protein: perPro,
                per_carbs: perCarb,
                per_fat: perFat,
                calories: round1(perCal * servings),
                protein: round1(perPro * servings),
                carbs: round1(perCarb * servings),
                fat: round1(perFat * servings),
                photo: pendingPhotoDataUrl,
                date: dateVal,
                timestamp: timestampVal
            };

            var method = editingEntryId ? 'PUT' : 'POST';
            var path = editingEntryId ? '/entries/' + encodeURIComponent(editingEntryId) : '/entries';
            var saveBtn = $('entrySaveBtn');
            setBtnLoading(saveBtn, true, editingEntryId ? 'Saving…' : 'Logging…');

            apiFetch(path, { method: method, body: payload })
                .then(function () {
                    var wasEditing = !!editingEntryId;
                    editingEntryId = null;
                    setBtnLoading(saveBtn, false);
                    closeModal('entryModalOverlay');
                    showToast(wasEditing ? 'Entry updated' : 'Meal logged');
                    refreshCurrentView();
                }).catch(function () {
                    setBtnLoading(saveBtn, false);
                    showToast('Could not save entry. Please try again.');
                });
        });
    }

    function openEntryModal(opts) {
        opts = opts || {};
        editingEntryId = opts.editId || null;
        pendingPhotoDataUrl = opts.photo || null;

        $('entryModalTitle').textContent = editingEntryId ? 'Edit entry' : 'Add to log';
        $('entryName').value = opts.name || '';
        $('entryServings').value = opts.servings || 1;
        $('entryServingUnit').value = opts.servingUnit || 'serving';
        $('entryCalories').value = opts.calories != null ? opts.calories : '';
        $('entryProtein').value = opts.protein != null ? opts.protein : '';
        $('entryCarbs').value = opts.carbs != null ? opts.carbs : 0;
        $('entryFat').value = opts.fat != null ? opts.fat : 0;

        selectedMeal = opts.meal || 'Breakfast';
        qsa('.chip-option', $('mealTypeChips')).forEach(function (chip) {
            chip.classList.toggle('active', chip.dataset.meal === selectedMeal);
        });

        if (pendingPhotoDataUrl) {
            $('photoPreviewImg').src = pendingPhotoDataUrl;
            $('photoPreviewWrap').classList.remove('hidden');
            $('photoDrop').classList.add('hidden');
        } else {
            $('photoPreviewWrap').classList.add('hidden');
            $('photoDrop').classList.remove('hidden');
        }
        $('entryPhoto').value = '';

        updateModalTotal();
        openModal('entryModalOverlay');
        setTimeout(function () { $('entryName').focus(); }, 50);
    }

    function updateModalTotal() {
        var servings = Number($('entryServings').value) || 0;
        var cal = Number($('entryCalories').value) || 0;
        var pro = Number($('entryProtein').value) || 0;
        var totalCal = Math.round(cal * servings);
        var totalPro = round1(pro * servings);
        $('modalTotalText').textContent = totalCal + ' kcal · ' + totalPro + 'g protein';
    }

    function resizeImage(file, maxDim, quality) {
        maxDim = maxDim || 900;
        quality = quality || 0.72;
        return new Promise(function (resolve, reject) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var img = new Image();
                img.onload = function () {
                    var width = img.width, height = img.height;
                    if (width > maxDim || height > maxDim) {
                        if (width > height) { height = Math.round(height * (maxDim / width)); width = maxDim; }
                        else { width = Math.round(width * (maxDim / height)); height = maxDim; }
                    }
                    var canvas = document.createElement('canvas');
                    canvas.width = width; canvas.height = height;
                    var ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, width, height);
                    resolve(canvas.toDataURL('image/jpeg', quality));
                };
                img.onerror = reject;
                img.src = e.target.result;
            };
            reader.onerror = reject;
            reader.readAsDataURL(file);
        });
    }

    function readFileAsDataUrl(file) {
        return new Promise(function (resolve, reject) {
            var reader = new FileReader();
            reader.onload = function (e) { resolve(e.target.result); };
            reader.onerror = reject;
            reader.readAsDataURL(file);
        });
    }

    /* ============================================================
       CROP MODAL — shared by profile picture + progress photos
       ============================================================ */
    var cropper = null;
    var cropOnConfirm = null; // function(dataUrl) called when the user confirms the crop

    /**
     * Opens the crop modal for a given image file.
     * opts.aspectRatio — width/height ratio for the crop box (1 = square)
     * opts.outputWidth / opts.outputHeight — pixel size of the exported image
     * opts.title — modal heading
     * opts.onConfirm(dataUrl) — called with the cropped JPEG data URL
     */
    function openCropModal(file, opts) {
        opts = opts || {};
        readFileAsDataUrl(file).then(function (dataUrl) {
            $('cropModalTitle').textContent = opts.title || 'Adjust your photo';
            $('cropImage').src = dataUrl;
            cropOnConfirm = opts.onConfirm || null;
            openModal('cropModalOverlay');

            if (cropper) { cropper.destroy(); cropper = null; }
            cropper = new Cropper($('cropImage'), {
                aspectRatio: opts.aspectRatio || 1,
                viewMode: 1,
                dragMode: 'move',
                autoCropArea: 1,
                cropBoxResizable: false,
                cropBoxMovable: false,
                background: false,
                guides: false,
                center: false,
                highlight: false
            });

            $('cropModalOverlay').dataset.outputWidth = opts.outputWidth || 500;
            $('cropModalOverlay').dataset.outputHeight = opts.outputHeight || 500;
        }).catch(function () {
            showToast('Could not read that image.');
        });
    }

    function closeCropModal() {
        closeModal('cropModalOverlay');
        if (cropper) { cropper.destroy(); cropper = null; }
        cropOnConfirm = null;
    }

    function initCropModal() {
        $('cropModalClose').addEventListener('click', closeCropModal);
        $('cropCancelBtn').addEventListener('click', closeCropModal);

        $('cropConfirmBtn').addEventListener('click', function () {
            if (!cropper) return;
            var overlay = $('cropModalOverlay');
            var canvas = cropper.getCroppedCanvas({
                width: Number(overlay.dataset.outputWidth) || 500,
                height: Number(overlay.dataset.outputHeight) || 500,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high'
            });
            if (!canvas) { showToast('Could not crop that image.'); return; }

            var dataUrl = canvas.toDataURL('image/jpeg', 0.88);
            var callback = cropOnConfirm;
            closeCropModal();
            if (callback) callback(dataUrl);
        });
    }

    /* ============================================================
       GOALS MODAL
       ============================================================ */
    function initGoals() {
        $('editGoalsBtn').addEventListener('click', function () {
            fetchGoals().then(function (goals) {
                $('goalCalories').value = goals.calories;
                $('goalProtein').value = goals.protein;
                $('goalCarbs').value = goals.carbs;
                $('goalFat').value = goals.fat;
                openModal('goalsModalOverlay');
            }).catch(function () {
                showToast('Could not load goals.');
            });
        });
        $('goalsModalClose').addEventListener('click', function () { closeModal('goalsModalOverlay'); });
        $('goalsCancelBtn').addEventListener('click', function () { closeModal('goalsModalOverlay'); });

        $('goalsForm').addEventListener('submit', function (e) {
            e.preventDefault();
            var calories = Number($('goalCalories').value) || DEFAULT_GOALS.calories;
            var protein = Number($('goalProtein').value) || DEFAULT_GOALS.protein;
            var carbs = Number($('goalCarbs').value) || DEFAULT_GOALS.carbs;
            var fat = Number($('goalFat').value) || DEFAULT_GOALS.fat;

            Swal.fire({
                title: 'Update your daily goals?',
                html:
                    '<div style="text-align:left;font-size:14px;line-height:1.7;">' +
                    '<b>' + calories + '</b> kcal &middot; ' +
                    '<b>' + protein + '</b>g protein<br>' +
                    '<b>' + carbs + '</b>g carbs &middot; ' +
                    '<b>' + fat + '</b>g fat' +
                    '</div>',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Save goals',
                cancelButtonText: 'Cancel',
                buttonsStyling: false,
                showLoaderOnConfirm: true,
                allowOutsideClick: function () { return !Swal.isLoading(); },
                customClass: {
                    popup: 'swal-dark-popup',
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-secondary',
                    actions: 'swal-actions'
                },
                preConfirm: function () {
                    return apiFetch('/goals', { method: 'POST', body: { calories: calories, protein: protein, carbs: carbs, fat: fat } })
                        .catch(function (err) {
                            Swal.showValidationMessage(err.message || 'Could not update goals.');
                        });
                }
            }).then(function (result) {
                if (!result.isConfirmed) return;
                closeModal('goalsModalOverlay');
                showToast('Goals updated');
                renderDashboard();
            });
        });
    }

    /* ============================================================
       HISTORY
       ============================================================ */
    function initHistory() {
        $('historyDate').addEventListener('change', function (e) {
            historyDateFilter = e.target.value || null;
            renderHistory();
        });
        $('historyShowAll').addEventListener('click', function () {
            historyDateFilter = null;
            $('historyDate').value = '';
            renderHistory();
        });
    }

    function renderHistory() {
        if (!currentUser) return;
        fetchEntries(historyDateFilter).then(function (entries) {
            var filtered = entries.slice().sort(function (a, b) { return b.timestamp - a.timestamp; });
            var wrap = $('historyContent');

            if (!filtered.length) {
                wrap.innerHTML = emptyStateHTML(historyDateFilter ? 'No meals logged on this date.' : 'No meals logged yet. Start by logging your first meal.');
                return;
            }

            var groups = {};
            var order = [];
            filtered.forEach(function (e) {
                if (!groups[e.date]) { groups[e.date] = []; order.push(e.date); }
                groups[e.date].push(e);
            });
            order.sort(function (a, b) { return b.localeCompare(a); });

            wrap.innerHTML = order.map(function (date) {
                return '<div class="day-group">' +
                    '<div class="day-header">' + formatDateHeader(date) + '</div>' +
                    groups[date].map(entryRowHTML).join('') +
                    '</div>';
            }).join('');

            bindEntryRowEvents(wrap);
        }).catch(function () {
            showToast('Could not load history.');
        });
    }

    /* ============================================================
   SETTINGS — profile, password, physique photos
   ============================================================ */
    var pendingAvatarDataUrl = null;
    var pendingPhysiquePhotoDataUrl = null;

    function fetchPhysiquePhotos() {
        return apiFetch('/physique-photos');
    }

    function renderSettings() {
        if (!currentUser) return;
        $('profileName').value = currentUser.name;
        pendingAvatarDataUrl = currentUser.avatar || null;
        if (pendingAvatarDataUrl) {
            $('avatarPreviewImg').src = pendingAvatarDataUrl;
            $('avatarPreviewWrap').classList.remove('hidden');
            $('avatarDrop').classList.add('hidden');
        } else {
            $('avatarPreviewWrap').classList.add('hidden');
            $('avatarDrop').classList.remove('hidden');
        }
        renderPhysiqueGrid();
    }

    function renderPhysiqueGrid() {
        var wrap = $('physiqueGrid');
        wrap.innerHTML = '<div class="search-status">Loading…</div>';
        fetchPhysiquePhotos().then(function (photos) {
            photos.sort(function (a, b) { return b.timestamp - a.timestamp; });
            if (!photos.length) {
                wrap.innerHTML = emptyStateHTML('No progress photos yet. Add your first one to start tracking.');
                return;
            }
            wrap.innerHTML = photos.map(function (p) {
                return '' +
                    '<div class="physique-card" data-id="' + p.id + '">' +
                    '<img src="' + p.photo + '" data-photo="' + p.id + '" alt="Progress photo">' +
                    '<button type="button" class="physique-delete" data-delete-physique="' + p.id + '" title="Delete">' +
                    '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18M6 6l12 12"/></svg>' +
                    '</button>' +
                    '<div class="physique-date">' + formatDateHeader(p.date) + (p.notes ? ' &middot; ' + escapeHtml(p.notes) : '') + '</div>' +
                    '</div>';
            }).join('');

            qsa('[data-photo]', wrap).forEach(function (img) {
                img.addEventListener('click', function () {
                    $('lightboxImg').src = img.src;
                    openModal('lightboxOverlay');
                });
            });
            qsa('[data-delete-physique]', wrap).forEach(function (btn) {
                btn.addEventListener('click', function () { deletePhysiquePhoto(btn.dataset.deletePhysique, btn); });
            });
        }).catch(function () {
            wrap.innerHTML = '<div class="search-status">Could not load progress photos.</div>';
        });
    }

    function deletePhysiquePhoto(id, btn) {
        if (!confirm("Delete this photo? This can't be undone.")) return;
        setBtnLoading(btn, true);
        apiFetch('/physique-photos/' + encodeURIComponent(id), { method: 'DELETE' })
            .then(function () {
                showToast('Photo deleted');
                renderPhysiqueGrid();
            }).catch(function (err) {
                setBtnLoading(btn, false);
                console.error('Physique photo save error:', err.status, err.response);
                showToast((err.response && err.response.message) || 'Could not save photo.');
            });
    }

    function openPhysiqueModal() {
        pendingPhysiquePhotoDataUrl = null;
        $('physiquePhotoInput').value = '';
        $('physiquePreviewWrap').classList.add('hidden');
        $('physiquePhotoDrop').classList.remove('hidden');
        $('physiqueDate').value = todayISO();
        $('physiqueNotes').value = '';
        openModal('physiqueModalOverlay');
    }

    function initSettings() {
        $('avatarInput').addEventListener('change', function (e) {
            var file = e.target.files && e.target.files[0];
            if (!file) return;
            if (file.type.indexOf('image/') !== 0) { showToast('Please choose an image file.'); return; }
            openCropModal(file, {
                aspectRatio: 1,
                outputWidth: 500,
                outputHeight: 500,
                title: 'Adjust your profile picture',
                onConfirm: function (dataUrl) {
                    pendingAvatarDataUrl = dataUrl;
                    $('avatarPreviewImg').src = dataUrl;
                    $('avatarPreviewWrap').classList.remove('hidden');
                    $('avatarDrop').classList.add('hidden');
                }
            });
            // Reset so choosing the same file again still fires 'change'
            $('avatarInput').value = '';
        });
        $('avatarRemoveBtn').addEventListener('click', function () {
            pendingAvatarDataUrl = null;
            $('avatarInput').value = '';
            $('avatarPreviewWrap').classList.add('hidden');
            $('avatarDrop').classList.remove('hidden');
        });

        $('profileForm').addEventListener('submit', function (e) {
            e.preventDefault();
            var name = $('profileName').value.trim();
            if (!name) { showToast('Please enter your name.'); return; }
            var btn = qs('button[type="submit"]', $('profileForm'));
            setBtnLoading(btn, true, 'Saving…');
            apiFetch('/settings/profile', { method: 'POST', body: { name: name, avatar: pendingAvatarDataUrl } })
                .then(function (user) {
                    currentUser = user;
                    updateUserAvatarChip();
                    $('userName').textContent = currentUser.name.trim().split(/\s+/)[0] || currentUser.name;
                    setBtnLoading(btn, false);
                    showToast('Profile updated');
                }).catch(function () {
                    setBtnLoading(btn, false);
                    showToast('Could not update profile.');
                });
        });

        $('passwordForm').addEventListener('submit', function (e) {
            e.preventDefault();
            $('passwordError').classList.remove('show');

            var current = $('currentPassword').value;
            var next = $('newPassword').value;
            var confirmVal = $('confirmPassword').value;

            if (next !== confirmVal) {
                $('passwordError').textContent = 'New passwords do not match.';
                $('passwordError').classList.add('show');
                return;
            }

            var btn = qs('button[type="submit"]', $('passwordForm'));
            setBtnLoading(btn, true, 'Updating…');
            apiFetch('/settings/password', {
                method: 'POST',
                body: { current_password: current, password: next, password_confirmation: confirmVal }
            }).then(function () {
                setBtnLoading(btn, false);
                $('passwordForm').reset();
                showToast('Password updated');
            }).catch(function (err) {
                setBtnLoading(btn, false);
                $('passwordError').textContent = err.message || 'Could not update password.';
                $('passwordError').classList.add('show');
            });
        });

        $('addPhysiqueBtn').addEventListener('click', function () { openPhysiqueModal(); });
        $('physiqueModalClose').addEventListener('click', function () { closeModal('physiqueModalOverlay'); });
        $('physiqueCancelBtn').addEventListener('click', function () { closeModal('physiqueModalOverlay'); });

        $('physiquePhotoInput').addEventListener('change', function (e) {
            var file = e.target.files && e.target.files[0];
            if (!file) return;
            if (file.type.indexOf('image/') !== 0) { showToast('Please choose an image file.'); return; }
            openCropModal(file, {
                aspectRatio: 3 / 4,
                outputWidth: 720,
                outputHeight: 960,
                title: 'Adjust your progress photo',
                onConfirm: function (dataUrl) {
                    pendingPhysiquePhotoDataUrl = dataUrl;
                    $('physiquePreviewImg').src = dataUrl;
                    $('physiquePreviewWrap').classList.remove('hidden');
                    $('physiquePhotoDrop').classList.add('hidden');
                }
            });
            $('physiquePhotoInput').value = '';
        });
        $('physiquePhotoRemoveBtn').addEventListener('click', function () {
            pendingPhysiquePhotoDataUrl = null;
            $('physiquePhotoInput').value = '';
            $('physiquePreviewWrap').classList.add('hidden');
            $('physiquePhotoDrop').classList.remove('hidden');
        });

        $('physiqueForm').addEventListener('submit', function (e) {
            e.preventDefault();
            if (!pendingPhysiquePhotoDataUrl) { showToast('Please choose a photo.'); return; }
            var payload = {
                photo: pendingPhysiquePhotoDataUrl,
                notes: $('physiqueNotes').value.trim(),
                date: $('physiqueDate').value || todayISO(),
                timestamp: Date.now()
            };
            var btn = qs('button[type="submit"]', $('physiqueForm'));
            setBtnLoading(btn, true, 'Saving…');
            apiFetch('/physique-photos', { method: 'POST', body: payload })
                .then(function () {
                    setBtnLoading(btn, false);
                    closeModal('physiqueModalOverlay');
                    showToast('Photo added');
                    renderPhysiqueGrid();
                }).catch(function () {
                    setBtnLoading(btn, false);
                    showToast('Could not save photo.');
                });
        });

        $('logoutBtn').addEventListener('click', function () {
            setBtnLoading($('logoutBtn'), true, 'Logging out…');
            apiFetch('/logout', { method: 'POST' })
                .then(function () {
                    window.location.href = '/login';
                })
                .catch(function () {
                    setBtnLoading($('logoutBtn'), false);
                    showToast('Could not log out right now.');
                });
        });
    }

    /* ============================================================
       GENERIC MODAL DISMISS (backdrop click + Escape)
       ============================================================ */
    function openModal(id) { $(id).classList.add('show'); }
    function closeModal(id) { $(id).classList.remove('show'); }

    function initModalDismiss() {
        qsa('.modal-overlay').forEach(function (overlay) {
            overlay.addEventListener('click', function (e) {
                if (e.target === overlay) {
                    if (overlay.id === 'cropModalOverlay') { closeCropModal(); }
                    else { overlay.classList.remove('show'); }
                }
            });
        });
        document.addEventListener('keydown', function (e) {
            if (e.key !== 'Escape') return;
            if ($('cropModalOverlay').classList.contains('show')) { closeCropModal(); return; }
            qsa('.modal-overlay.show').forEach(function (o) { o.classList.remove('show'); });
        });
        $('lightboxClose').addEventListener('click', function () { closeModal('lightboxOverlay'); });

        window.addEventListener('hashchange', function () {
            var view = window.location.hash.replace('#', '');
            // Only react if the view is known and we’re in the app
            if (['dashboard', 'history', 'settings'].includes(view) && currentUser) {
                switchView(view);
            }
        });
    }

    function init() {
        currentUser = window.CURRENT_USER;
        initNav();
        initSearch();
        initEntryModal();
        initCropModal();
        initGoals();
        initHistory();
        initSettings();
        initModalDismiss();

        // If we already have a user (e.g., passed from Blade), enter the app immediately
        if (currentUser) {
            enterApp();
        }

        // Always fetch the latest user data – on success it will call enterApp again (safe)
        fetchCurrentUser().then(function () {
            enterApp();
        }).catch(function () {
            // Not authenticated
            $('view-app').classList.add('hidden');
            $('view-auth').classList.remove('hidden');
            // Clear the hash to avoid a dead state
            history.replaceState(null, '', window.location.pathname);
        });
    }

    document.addEventListener('DOMContentLoaded', init);
})();
