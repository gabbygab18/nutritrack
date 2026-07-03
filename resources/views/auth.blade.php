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
    <div id="view-auth" class="auth-shell">
        <div class="auth-card">
            <div class="auth-brand">
                <svg class="logo-mark" viewBox="0 0 40 40" fill="none">
                    <circle cx="20" cy="20" r="20" fill="url(#authLogoGrad)" />
                    <path
                        d="M20 11c-5 0-9 4-9 9.2 0 4.6 3.5 8.3 8 8.7v-3.3c-2.6-.4-4.6-2.6-4.6-5.4 0-3.1 2.5-5.6 5.6-5.6.7 0 1.4.1 2 .4-.3.6-.5 1.3-.5 2 0 2.4 1.9 4.3 4.3 4.3.4 0 .8-.1 1.2-.2-.5 3.9-3.9 6.9-8 6.9h-.9v3.3c.3 0 .6 0 .9 0 6.1 0 11-4.9 11-11S26.1 11 20 11z"
                        fill="#fff" />
                    <defs>
                        <linearGradient id="authLogoGrad" x1="0" y1="0" x2="40" y2="40">
                            <stop stop-color="#a855f7" />
                            <stop offset="1" stop-color="#ea580c" />
                        </linearGradient>
                    </defs>
                </svg>
                <span class="wordmark">NutriTrack</span>
            </div>

            <div class="auth-head">
                <h1 class="display-md" id="authTitle">Welcome back.</h1>
                <p class="body">Log your meals, hit your macros, keep the receipts.</p>
            </div>

            <div class="auth-tabs">
                <button type="button" class="auth-tab active" data-tab="login">Log in</button>
                <button type="button" class="auth-tab" data-tab="signup">Sign up</button>
            </div>

            <p id="authError" class="auth-error"></p>

            <form id="authForm" class="auth-form">
                <div class="field hidden" id="fieldName">
                    <label for="authName">Your name</label>
                    <input class="text-input" id="authName" placeholder="Juan Dela Cruz" autocomplete="name">
                </div>
                <div class="field">
                    <label for="authEmail">Email address</label>
                    <input class="text-input" id="authEmail" type="email" placeholder="you@email.com"
                        autocomplete="email" required>
                </div>
                <div class="field">
                    <label for="authPassword">Password</label>
                    <input class="text-input" id="authPassword" type="password" placeholder="••••••••"
                        autocomplete="current-password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block" id="authSubmit">Log in</button>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/auth.js') }}"></script>
</body>

</html>
