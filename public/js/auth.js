(function () {
    'use strict';

    var authMode = 'login';

    function $(id) { return document.getElementById(id); }
    function qsa(sel, ctx) { return Array.prototype.slice.call((ctx || document).querySelectorAll(sel)); }

    function getCsrfToken() {
        var match = document.cookie.match(/(?:^|;\s*)XSRF-TOKEN=([^;]*)/);
        if (match) return decodeURIComponent(match[1]);
        var meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.content : '';
    }

    function authRequest(path, body) {
        return fetch('/api' + path, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-XSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify(body)
        }).then(function (res) {
            return res.json().then(function (data) {
                if (!res.ok) {
                    var err = new Error((data && data.message) || 'Request failed');
                    err.response = data;
                    throw err;
                }
                return data;
            });
        });
    }

    function showAuthError(msg) {
        var el = $('authError');
        el.textContent = msg;
        el.classList.add('show');
    }

    function hideAuthError() { $('authError').classList.remove('show'); }

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

    // Fade the page out, then hand off to the next page — avoids the hard
    // "flash" of an instant redirect right after a successful login/signup.
    function goToApp() {
        document.body.classList.add('page-fade-out');
        setTimeout(function () {
            window.location.href = '/';
        }, 280);
    }

    function init() {
        qsa('.auth-tab').forEach(function (tab) {
            tab.addEventListener('click', function () { setAuthMode(tab.dataset.tab); });
        });

        $('authForm').addEventListener('submit', function (e) {
            e.preventDefault();
            hideAuthError();

            var email = $('authEmail').value.trim().toLowerCase();
            var password = $('authPassword').value;

            if (!email || !password) return showAuthError('Please fill in all fields.');

            var payload = { email: email, password: password };
            var path = '/login';

            if (authMode === 'signup') {
                var name = $('authName').value.trim();
                if (!name) return showAuthError('Please enter your name.');
                payload.name = name;
                path = '/register';
            }

            var submitBtn = $('authSubmit');
            var originalLabel = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = authMode === 'signup' ? 'Creating account…' : 'Logging in…';

            authRequest(path, payload).then(function () {
                goToApp();
            }).catch(function (err) {
                showAuthError(err.message || 'Incorrect email or password.');
                submitBtn.disabled = false;
                submitBtn.textContent = originalLabel;
            });
        });
    }

    document.addEventListener('DOMContentLoaded', init);
})();
