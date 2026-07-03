<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'NutriTrack') }} — Track calories &amp; protein</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <!-- ============================================================ -->
    <!-- APP SHELL                                                     -->
    <!-- ============================================================ -->
    <div id="view-app" class="app-shell">

        <nav class="top-nav">
            <div class="container nav-inner">
                <a href="#" class="brand">
                    <svg class="logo-mark" viewBox="0 0 40 40" fill="none">
                        <circle cx="20" cy="20" r="20" fill="url(#navLogoGrad)" />
                        <path
                            d="M20 11c-5 0-9 4-9 9.2 0 4.6 3.5 8.3 8 8.7v-3.3c-2.6-.4-4.6-2.6-4.6-5.4 0-3.1 2.5-5.6 5.6-5.6.7 0 1.4.1 2 .4-.3.6-.5 1.3-.5 2 0 2.4 1.9 4.3 4.3 4.3.4 0 .8-.1 1.2-.2-.5 3.9-3.9 6.9-8 6.9h-.9v3.3c.3 0 .6 0 .9 0 6.1 0 11-4.9 11-11S26.1 11 20 11z"
                            fill="#fff" />
                        <defs>
                            <linearGradient id="navLogoGrad" x1="0" y1="0" x2="40"
                                y2="40">
                                <stop stop-color="#a855f7" />
                                <stop offset="1" stop-color="#ea580c" />
                            </linearGradient>
                        </defs>
                    </svg>
                    <span class="wordmark">NutriTrack</span>
                </a>

                <div class="tabbar" id="tabbarDesktop">
                    <button class="tab-btn active" data-view="dashboard">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <rect x="3" y="3" width="7" height="9" rx="1.5" />
                            <rect x="14" y="3" width="7" height="5" rx="1.5" />
                            <rect x="14" y="12" width="7" height="9" rx="1.5" />
                            <rect x="3" y="16" width="7" height="5" rx="1.5" />
                        </svg>
                        Dashboard
                    </button>
                    <button class="tab-btn" data-view="log">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="11" cy="11" r="7" />
                            <path d="m21 21-4.3-4.3" />
                        </svg>
                        Log a meal
                    </button>
                    <button class="tab-btn" data-view="history">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M4 4v6h6M4 10a8 8 0 1 1 2.3 5.6" />
                            <path d="M12 8v4l3 2" />
                        </svg>
                        History
                    </button>
                    <button class="tab-btn" data-view="settings">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="12" cy="12" r="3" />
                            <path
                                d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z" />
                        </svg>
                        Settings
                    </button>
                </div>

                <div class="nav-right">
                    <div class="user-chip">
                        <span class="user-avatar" id="userAvatar">J</span>
                        <span class="u-name" id="userName">Juan</span>
                    </div>
                    <button class="btn btn-secondary btn-sm" id="logoutBtn">Log out</button>
                </div>
            </div>
        </nav>

        <main>
            <div class="container">

                <!-- ---------------- DASHBOARD ---------------- -->
                <section id="view-dashboard" class="view">
                    <div class="view-head">
                        <div>
                            <h1 class="display-lg" id="dashGreeting">Welcome back.</h1>
                            <p class="body" id="dashDate">Today</p>
                        </div>
                        <button class="btn btn-secondary btn-sm" id="editGoalsBtn">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 20h9" />
                                <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z" />
                            </svg>
                            Edit goals
                        </button>
                    </div>

                    <div class="stat-grid">
                        <div class="stat-card tone-cal">
                            <div class="stat-top">
                                <div class="stat-icon"><svg viewBox="0 0 24 24" fill="none" stroke="#fff"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path
                                            d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z" />
                                    </svg></div>
                            </div>
                            <div class="stat-value"><span id="statCalories">0</span><small> / <span
                                        id="statCaloriesGoal">2000</span> kcal</small></div>
                            <div class="stat-label">Calories</div>
                            <div class="progress-track">
                                <div class="progress-fill" id="barCalories" style="width:0%"></div>
                            </div>
                        </div>

                        <div class="stat-card tone-protein">
                            <div class="stat-top">
                                <div class="stat-icon"><svg viewBox="0 0 24 24" fill="none" stroke="#fff"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M6.5 6.5 17.5 17.5" />
                                        <path d="M2.5 12a9.5 9.5 0 0 1 9.5-9.5" />
                                        <circle cx="12" cy="12" r="9.5" />
                                    </svg></div>
                            </div>
                            <div class="stat-value"><span id="statProtein">0</span><small>g / <span
                                        id="statProteinGoal">120</span>g</small></div>
                            <div class="stat-label">Protein</div>
                            <div class="progress-track">
                                <div class="progress-fill" id="barProtein" style="width:0%"></div>
                            </div>
                        </div>

                        <div class="stat-card tone-carb">
                            <div class="stat-top">
                                <div class="stat-icon"><svg viewBox="0 0 24 24" fill="none" stroke="#fff"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 2a10 10 0 1 0 10 10H12V2z" />
                                        <path d="M21.2 8.8A10 10 0 0 0 15.2 2.8" />
                                    </svg></div>
                            </div>
                            <div class="stat-value"><span id="statCarbs">0</span><small>g</small></div>
                            <div class="stat-label">Carbs</div>
                            <div class="progress-track">
                                <div class="progress-fill" id="barCarbs" style="width:0%"></div>
                            </div>
                        </div>

                        <div class="stat-card tone-fat">
                            <div class="stat-top">
                                <div class="stat-icon"><svg viewBox="0 0 24 24" fill="none" stroke="#fff"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 2s6 6.5 6 11a6 6 0 0 1-12 0c0-4.5 6-11 6-11z" />
                                    </svg></div>
                            </div>
                            <div class="stat-value"><span id="statFat">0</span><small>g</small></div>
                            <div class="stat-label">Fat</div>
                            <div class="progress-track">
                                <div class="progress-fill" id="barFat" style="width:0%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="section-row">
                        <h2 class="headline">Today's log</h2>
                        <button class="btn btn-secondary btn-sm" data-goto="log">Log a meal</button>
                    </div>
                    <div id="dashRecent"></div>
                </section>

                <!-- ---------------- LOG A MEAL ---------------- -->
                <section id="view-log" class="view hidden">
                    <div class="view-head">
                        <div>
                            <h1 class="display-lg">Log a meal.</h1>
                            <p class="body">Search the USDA food database, or add something manually.</p>
                        </div>
                    </div>

                    <div class="card search-card">
                        <form id="searchForm" class="search-row">
                            <input class="text-input" id="searchInput"
                                placeholder="Search a food — e.g. “grilled chicken breast”" autocomplete="off">
                            <button type="submit" class="btn btn-primary" id="searchBtn">Search</button>
                        </form>
                        <p class="micro search-hint">Powered by USDA FoodData Central — a free, government-run
                            nutrition database.</p>

                        <div class="divider-or"><span>or</span></div>
                        <div class="manual-toggle">
                            <button class="btn btn-secondary" id="manualAddBtn">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M12 5v14M5 12h14" />
                                </svg>
                                Add a food manually
                            </button>
                        </div>

                        <div id="searchResults" class="result-list"></div>
                    </div>
                </section>

                <!-- ---------------- HISTORY ---------------- -->
                <section id="view-history" class="view hidden">
                    <div class="view-head">
                        <div>
                            <h1 class="display-lg">Your history.</h1>
                            <p class="body">Every meal you've logged — your proof of use, photos included.</p>
                        </div>
                    </div>

                    <div class="history-filters">
                        <div class="field" style="gap:4px;">
                            <label for="historyDate" class="micro">Filter by date</label>
                            <input class="text-input" type="date" id="historyDate">
                        </div>
                        <button class="btn btn-secondary btn-sm" id="historyShowAll">Show all</button>
                    </div>

                    <div id="historyContent"></div>
                </section>

                <!-- ---------------- SETTINGS ---------------- -->
                <section id="view-settings" class="view hidden">
                    <div class="view-head">
                        <div>
                            <h1 class="display-lg">Settings.</h1>
                            <p class="body">Manage your profile and progress photos.</p>
                        </div>
                    </div>

                    <div class="card">
                        <h2 class="headline">Profile</h2>
                        <form id="profileForm" class="modal-form">
                            <div class="field">
                                <label>Profile picture</label>
                                <label class="photo-drop" id="avatarDrop">
                                    <div class="photo-drop-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="5" width="18" height="14" rx="2" />
                                            <circle cx="9" cy="11" r="2" />
                                            <path d="m21 16-4.5-4.5a2 2 0 0 0-2.8 0L5 21" />
                                        </svg>
                                    </div>
                                    <div class="photo-drop-text">
                                        <b>Upload a photo</b>
                                        <span class="micro">Tap to choose a profile picture</span>
                                    </div>
                                    <input type="file" id="avatarInput" accept="image/*">
                                </label>
                                <div id="avatarPreviewWrap" class="photo-preview-wrap hidden">
                                    <img id="avatarPreviewImg" alt="Profile picture preview">
                                    <button type="button" class="photo-remove" id="avatarRemoveBtn">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M18 6 6 18M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="field">
                                <label for="profileName">Name</label>
                                <input class="text-input" id="profileName" required>
                            </div>
                            <div class="modal-actions">
                                <button type="submit" class="btn btn-primary">Save profile</button>
                            </div>
                        </form>
                    </div>

                    <div class="card">
                        <h2 class="headline">Change password</h2>
                        <p id="passwordError" class="auth-error"></p>
                        <form id="passwordForm" class="modal-form">
                            <div class="field">
                                <label for="currentPassword">Current password</label>
                                <input class="text-input" id="currentPassword" type="password"
                                    autocomplete="current-password" required>
                            </div>
                            <div class="form-row-2">
                                <div class="field">
                                    <label for="newPassword">New password</label>
                                    <input class="text-input" id="newPassword" type="password"
                                        autocomplete="new-password" required minlength="8">
                                </div>
                                <div class="field">
                                    <label for="confirmPassword">Confirm new password</label>
                                    <input class="text-input" id="confirmPassword" type="password"
                                        autocomplete="new-password" required minlength="8">
                                </div>
                            </div>
                            <div class="modal-actions">
                                <button type="submit" class="btn btn-primary">Update password</button>
                            </div>
                        </form>
                    </div>

                    <div class="card">
                        <div class="section-row">
                            <h2 class="headline">Progress photos</h2>
                            <button class="btn btn-secondary btn-sm" id="addPhysiqueBtn">Add photo</button>
                        </div>
                        <p class="micro" style="margin-bottom:16px;">Optional — track your physique over time. Only
                            visible to you.</p>
                        <div id="physiqueGrid" class="physique-grid"></div>
                    </div>
                </section>

            </div>
        </main>

        <div class="mobile-tabbar">
            <div class="tabbar">
                <button class="tab-btn active" data-view="dashboard">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="9" rx="1.5" />
                        <rect x="14" y="3" width="7" height="5" rx="1.5" />
                        <rect x="14" y="12" width="7" height="9" rx="1.5" />
                        <rect x="3" y="16" width="7" height="5" rx="1.5" />
                    </svg>
                    Dashboard
                </button>
                <button class="tab-btn" data-view="log">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <circle cx="11" cy="11" r="7" />
                        <path d="m21 21-4.3-4.3" />
                    </svg>
                    Log meal
                </button>
                <button class="tab-btn" data-view="history">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M4 4v6h6M4 10a8 8 0 1 1 2.3 5.6" />
                        <path d="M12 8v4l3 2" />
                    </svg>
                    History
                </button>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- ADD / EDIT ENTRY MODAL                                        -->
    <!-- ============================================================ -->
    <div id="entryModalOverlay" class="modal-overlay">
        <div class="modal">
            <div class="modal-head">
                <h3 class="headline" id="entryModalTitle">Add to log</h3>
                <button class="btn-icon" id="entryModalClose" type="button">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="entryForm" class="modal-form">
                <div class="field" id="manualNameField">
                    <label for="entryName">Food name</label>
                    <input class="text-input" id="entryName" placeholder="e.g. Homemade adobo" required>
                </div>

                <div class="field">
                    <label>Meal</label>
                    <div class="chip-select" id="mealTypeChips">
                        <button type="button" class="chip-option active" data-meal="Breakfast">Breakfast</button>
                        <button type="button" class="chip-option" data-meal="Lunch">Lunch</button>
                        <button type="button" class="chip-option" data-meal="Dinner">Dinner</button>
                        <button type="button" class="chip-option" data-meal="Snack">Snack</button>
                    </div>
                </div>

                <div class="form-row-2">
                    <div class="field">
                        <label for="entryServings">Servings</label>
                        <input class="text-input" id="entryServings" type="number" min="0.1" step="0.1"
                            value="1" required>
                    </div>
                    <div class="field" id="servingUnitField">
                        <label for="entryServingUnit">Per serving</label>
                        <input class="text-input" id="entryServingUnit" readonly>
                    </div>
                </div>

                <div class="form-row-4" id="manualMacroFields">
                    <div class="field">
                        <label for="entryCalories">Calories</label>
                        <input class="text-input" id="entryCalories" type="number" min="0" step="1"
                            required>
                    </div>
                    <div class="field">
                        <label for="entryProtein">Protein (g)</label>
                        <input class="text-input" id="entryProtein" type="number" min="0" step="0.1"
                            required>
                    </div>
                    <div class="field">
                        <label for="entryCarbs">Carbs (g)</label>
                        <input class="text-input" id="entryCarbs" type="number" min="0" step="0.1"
                            value="0">
                    </div>
                    <div class="field">
                        <label for="entryFat">Fat (g)</label>
                        <input class="text-input" id="entryFat" type="number" min="0" step="0.1"
                            value="0">
                    </div>
                </div>

                <div class="field">
                    <label>Photo — proof of your meal (optional)</label>
                    <label class="photo-drop" id="photoDrop">
                        <div class="photo-drop-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="5" width="18" height="14" rx="2" />
                                <circle cx="9" cy="11" r="2" />
                                <path d="m21 16-4.5-4.5a2 2 0 0 0-2.8 0L5 21" />
                            </svg>
                        </div>
                        <div class="photo-drop-text">
                            <b>Upload a photo</b>
                            <span class="micro">Tap to choose an image of your meal</span>
                        </div>
                        <input type="file" id="entryPhoto" accept="image/*">
                    </label>
                    <div id="photoPreviewWrap" class="photo-preview-wrap hidden">
                        <img id="photoPreviewImg" alt="Meal photo preview">
                        <button type="button" class="photo-remove" id="photoRemoveBtn">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 6 6 18M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="modal-total">
                    <span>Total for this entry</span>
                    <b id="modalTotalText">0 kcal · 0g protein</b>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" id="entryCancelBtn">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="entrySaveBtn">Save entry</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- GOALS MODAL                                                   -->
    <!-- ============================================================ -->
    <div id="goalsModalOverlay" class="modal-overlay">
        <div class="modal">
            <div class="modal-head">
                <h3 class="headline">Set your daily goals</h3>
                <button class="btn-icon" id="goalsModalClose" type="button">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="goalsForm" class="modal-form">
                <div class="goal-form-row">
                    <div class="field">
                        <label for="goalCalories">Calorie goal (kcal)</label>
                        <input class="text-input" id="goalCalories" type="number" min="1" step="1"
                            required>
                    </div>
                    <div class="field">
                        <label for="goalProtein">Protein goal (g)</label>
                        <input class="text-input" id="goalProtein" type="number" min="1" step="1"
                            required>
                    </div>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" id="goalsCancelBtn">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save goals</button>
                </div>
            </form>
        </div>
    </div>

    <div id="physiqueModalOverlay" class="modal-overlay">
        <div class="modal">
            <div class="modal-head">
                <h3 class="headline">Add progress photo</h3>
                <button class="btn-icon" id="physiqueModalClose" type="button">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="physiqueForm" class="modal-form">
                <div class="field">
                    <label>Photo</label>
                    <label class="photo-drop" id="physiquePhotoDrop">
                        <div class="photo-drop-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="5" width="18" height="14" rx="2" />
                                <circle cx="9" cy="11" r="2" />
                                <path d="m21 16-4.5-4.5a2 2 0 0 0-2.8 0L5 21" />
                            </svg>
                        </div>
                        <div class="photo-drop-text">
                            <b>Upload a photo</b>
                            <span class="micro">Tap to choose an image</span>
                        </div>
                        <input type="file" id="physiquePhotoInput" accept="image/*" required>
                    </label>
                    <div id="physiquePreviewWrap" class="photo-preview-wrap hidden">
                        <img id="physiquePreviewImg" alt="Progress photo preview">
                        <button type="button" class="photo-remove" id="physiquePhotoRemoveBtn">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 6 6 18M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="field">
                    <label for="physiqueDate">Date</label>
                    <input class="text-input" type="date" id="physiqueDate" required>
                </div>
                <div class="field">
                    <label for="physiqueNotes">Notes (optional)</label>
                    <input class="text-input" id="physiqueNotes" placeholder="e.g. Week 4, 78kg">
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" id="physiqueCancelBtn">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save photo</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- PHOTO LIGHTBOX (view full meal photo from history)            -->
    <!-- ============================================================ -->
    <div id="lightboxOverlay" class="modal-overlay">
        <div class="modal modal-lightbox">
            <div class="lightbox-inner">
                <img id="lightboxImg" alt="Meal photo">
                <button class="lightbox-close" id="lightboxClose" type="button">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div id="toast" class="toast">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m20 6-11 11-5-5" />
        </svg>
        <span id="toastText">Saved</span>
    </div>

    <script>
        window.CURRENT_USER = @json($currentUser);
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
