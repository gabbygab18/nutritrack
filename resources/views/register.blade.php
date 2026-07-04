<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'NutriTrack') }} — Register</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        /* Additional styles for the registration wizard */
        .register-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        @media (max-width: 600px) {
            .register-grid {
                grid-template-columns: 1fr;
            }
        }

        .suggestion-box {
            background: var(--surface-2);
            border-radius: var(--r-md);
            padding: 16px;
            margin-top: 4px;
            display: none;
        }

        .suggestion-box.show {
            display: block;
        }

        .suggestion-box .macro-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            border-bottom: 1px solid var(--hairline-soft);
        }

        .suggestion-box .macro-row:last-child {
            border-bottom: none;
        }

        .suggestion-box .label {
            color: var(--ink-muted);
        }

        .suggestion-box .value {
            font-weight: 600;
            color: var(--ink);
        }

        /* ---------- stepper / progress ---------- */
        .stepper {
            margin-bottom: 26px;
        }

        .step-label {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            margin-bottom: 9px;
        }

        .step-label #stepTitle {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--ink);
        }

        .step-label #stepCount {
            font-size: 12px;
            color: var(--ink-muted);
        }

        /* ---------- step panels ---------- */
        .step-panel {
            display: none;
        }

        .step-panel.active {
            display: flex;
            flex-direction: column;
            gap: 14px;
            animation: stepIn .28s var(--ease);
        }

        @keyframes stepIn {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .step-heading {
            margin-bottom: 2px;
        }

        .step-heading h2 {
            font-size: 19px;
            font-weight: 700;
            letter-spacing: -0.4px;
            margin-bottom: 4px;
        }

        /* ---------- choice cards (body type / goal / exercise) ---------- */
        .choice-grid {
            display: flex;
            flex-direction: column;
            gap: 9px;
        }

        .choice-card {
            display: flex;
            flex-direction: column;
            gap: 2px;
            text-align: left;
            width: 100%;
            background: var(--surface-2);
            border: 1.5px solid transparent;
            border-radius: var(--r-lg);
            padding: 13px 16px;
            transition: background .2s var(--ease), border-color .2s var(--ease), transform .15s var(--ease);
        }

        .choice-card:hover {
            background: var(--surface-3);
        }

        .choice-card:active {
            transform: scale(0.99);
        }

        .choice-card.active {
            border-color: var(--accent-blue);
            background: var(--surface-3);
        }

        .choice-card b {
            font-size: 14.5px;
            font-weight: 600;
            letter-spacing: -0.2px;
        }

        .choice-card span {
            font-size: 12.5px;
            color: var(--ink-muted);
        }

        /* ---------- step nav buttons ---------- */
        .step-nav {
            display: flex;
            gap: 10px;
            margin-top: 8px;
        }

        .step-nav .btn {
            flex: 1;
        }

        @media (min-width: 601px) {
            .step-nav {
                justify-content: center;
            }

            .step-nav .btn {
                flex: 0 0 auto;
                min-width: 180px;
            }
        }
    </style>
</head>

<body>
    <div class="auth-shell">
        <div class="auth-card" style="max-width: 520px;">
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
                <h1 class="display-md">Let’s get you set up.</h1>
                <p class="body">A few quick questions so we can calculate your daily targets.</p>
            </div>

            <div class="stepper">
                <div class="step-label">
                    <span id="stepTitle">Create your account</span>
                    <span id="stepCount">Step 1 of 5</span>
                </div>
                <div class="progress-track">
                    <div class="progress-fill" id="stepProgressFill" style="width:20%"></div>
                </div>
            </div>

            <form id="registerForm" class="auth-form" novalidate>

                <!-- ===================== STEP 1 — ACCOUNT ===================== -->
                <div class="step-panel active" data-step="1">
                    <div class="field">
                        <label for="regName">Full name</label>
                        <input class="text-input" id="regName" placeholder="Juan Dela Cruz" autocomplete="name"
                            required>
                    </div>
                    <div class="field">
                        <label for="regEmail">Email address</label>
                        <input class="text-input" id="regEmail" type="email" placeholder="you@email.com"
                            autocomplete="email" required>
                    </div>
                    <div class="field">
                        <label for="regPassword">Password</label>
                        <input class="text-input" id="regPassword" type="password" placeholder="••••••••"
                            autocomplete="new-password" required>
                    </div>
                </div>

                <!-- ===================== STEP 2 — BODY STATS ===================== -->
                <div class="step-panel" data-step="2">
                    <div class="step-heading">
                        <h2>What are your body stats?</h2>
                        <p class="body">We use these to estimate your metabolic rate.</p>
                    </div>
                    <div class="register-grid">
                        <div class="field">
                            <label for="regHeight">Height (cm)</label>
                            <input class="text-input" id="regHeight" type="number" step="0.1" placeholder="175"
                                required>
                        </div>
                        <div class="field">
                            <label for="regWeight">Weight (kg)</label>
                            <input class="text-input" id="regWeight" type="number" step="0.1" placeholder="75"
                                required>
                        </div>
                        <div class="field">
                            <label for="regAge">Age</label>
                            <input class="text-input" id="regAge" type="number" placeholder="25" required>
                        </div>
                        <div class="field">
                            <label>BMI (auto-calc)</label>
                            <input class="text-input" id="regBmi" type="text" readonly placeholder="—">
                        </div>
                    </div>
                </div>

                <!-- ===================== STEP 3 — BODY TYPE ===================== -->
                <div class="step-panel" data-step="3">
                    <div class="step-heading">
                        <h2>What's your body type?</h2>
                        <p class="body">Pick the one that best describes you.</p>
                    </div>
                    <input type="hidden" id="regBodyType" required>
                    <div class="choice-grid" data-group="regBodyType">
                        <button type="button" class="choice-card" data-value="ectomorph">
                            <b>Ectomorph</b>
                            <span>Lean build, fast metabolism</span>
                        </button>
                        <button type="button" class="choice-card" data-value="mesomorph">
                            <b>Mesomorph</b>
                            <span>Muscular, athletic build</span>
                        </button>
                        <button type="button" class="choice-card" data-value="endomorph">
                            <b>Endomorph</b>
                            <span>Stockier build, slower metabolism</span>
                        </button>
                    </div>
                    <p class="auth-error" id="step3Error">Please select a body type.</p>
                </div>

                <!-- ===================== STEP 4 — GOAL ===================== -->
                <div class="step-panel" data-step="4">
                    <div class="step-heading">
                        <h2>What's your goal?</h2>
                        <p class="body">This determines your suggested calorie target.</p>
                    </div>
                    <input type="hidden" id="regGoal" required>
                    <div class="choice-grid" data-group="regGoal">
                        <button type="button" class="choice-card" data-value="stay">
                            <b>Stay in shape</b>
                            <span>Maintain your current weight</span>
                        </button>
                        <button type="button" class="choice-card" data-value="bulk">
                            <b>Build muscle</b>
                            <span>Gain weight and strength</span>
                        </button>
                        <button type="button" class="choice-card" data-value="cut">
                            <b>Lose fat</b>
                            <span>Cut weight while keeping muscle</span>
                        </button>
                    </div>
                    <p class="auth-error" id="step4Error">Please select a goal.</p>
                </div>

                <!-- ===================== STEP 5 — EXERCISE INTENSITY ===================== -->
                <div class="step-panel" data-step="5">
                    <div class="step-heading">
                        <h2>How active are you?</h2>
                        <p class="body">Be honest — this affects your daily calorie needs.</p>
                    </div>
                    <input type="hidden" id="regExercise" required>
                    <div class="choice-grid" data-group="regExercise">
                        <button type="button" class="choice-card" data-value="sedentary">
                            <b>Sedentary</b>
                            <span>Little or no exercise</span>
                        </button>
                        <button type="button" class="choice-card" data-value="light">
                            <b>Light</b>
                            <span>Exercise 1–2 days a week</span>
                        </button>
                        <button type="button" class="choice-card" data-value="moderate">
                            <b>Moderate</b>
                            <span>Exercise 3–5 days a week</span>
                        </button>
                        <button type="button" class="choice-card" data-value="heavy">
                            <b>Heavy</b>
                            <span>Exercise 6–7 days a week</span>
                        </button>
                        <button type="button" class="choice-card" data-value="athlete">
                            <b>Athlete</b>
                            <span>Twice daily, hard training</span>
                        </button>
                    </div>
                    <p class="auth-error" id="step5Error">Please select an activity level.</p>

                    <div id="suggestionBox" class="suggestion-box">
                        <div style="font-weight:600; margin-bottom:6px;">Your suggested daily targets</div>
                        <div class="macro-row"><span class="label">Calories</span><span class="value"
                                id="sugCalories">—</span></div>
                        <div class="macro-row"><span class="label">Protein</span><span class="value"
                                id="sugProtein">—</span></div>
                        <div class="macro-row"><span class="label">Carbs</span><span class="value"
                                id="sugCarbs">—</span></div>
                        <div class="macro-row"><span class="label">Fat</span><span class="value"
                                id="sugFat">—</span></div>
                        <div class="macro-row"
                            style="border-bottom: none; margin-top:6px; font-size:13px; color:var(--ink-muted);">
                            Based on your TDEE: <span id="sugTdee">—</span> kcal
                        </div>
                    </div>
                </div>

                <div id="registerError" class="auth-error"></div>

                <div class="step-nav">
                    <button type="button" class="btn btn-secondary hidden" id="stepBack">Back</button>
                    <button type="button" class="btn btn-primary" id="stepNext">Next</button>
                </div>
            </form>

            <p class="auth-note">
                Already have an account? <a href="{{ route('login') }}" style="color:var(--accent-blue);">Log in</a>
            </p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('registerForm');
            const panels = Array.from(document.querySelectorAll('.step-panel'));
            const totalSteps = panels.length;
            let currentStep = 0;

            const stepTitles = [
                'Create your account',
                'Your body stats',
                'Your body type',
                'Your goal',
                'Activity level'
            ];

            const stepTitleEl = document.getElementById('stepTitle');
            const stepCountEl = document.getElementById('stepCount');
            const stepProgressFill = document.getElementById('stepProgressFill');
            const backBtn = document.getElementById('stepBack');
            const nextBtn = document.getElementById('stepNext');

            const heightInput = document.getElementById('regHeight');
            const weightInput = document.getElementById('regWeight');
            const bmiInput = document.getElementById('regBmi');
            const suggestionBox = document.getElementById('suggestionBox');
            const sugCalories = document.getElementById('sugCalories');
            const sugProtein = document.getElementById('sugProtein');
            const sugCarbs = document.getElementById('sugCarbs');
            const sugFat = document.getElementById('sugFat');
            const sugTdee = document.getElementById('sugTdee');
            const errorEl = document.getElementById('registerError');

            // ---------- choice card wiring (body type / goal / exercise) ----------
            document.querySelectorAll('.choice-grid').forEach(grid => {
                const hiddenInput = document.getElementById(grid.dataset.group);
                grid.querySelectorAll('.choice-card').forEach(card => {
                    card.addEventListener('click', () => {
                        grid.querySelectorAll('.choice-card').forEach(c => c.classList
                            .remove('active'));
                        card.classList.add('active');
                        hiddenInput.value = card.dataset.value;
                        const stepEl = grid.closest('.step-panel');
                        const errEl = stepEl.querySelector('.auth-error');
                        if (errEl) errEl.classList.remove('show');
                        computeAndSuggest();
                    });
                });
            });

            // ---------- BMI + suggestion calc ----------
            function computeAndSuggest() {
                const height = parseFloat(heightInput.value);
                const weight = parseFloat(weightInput.value);
                const age = parseInt(document.getElementById('regAge').value);
                const goal = document.getElementById('regGoal').value;
                const exercise = document.getElementById('regExercise').value;
                const bodyType = document.getElementById('regBodyType').value;

                if (height > 0 && weight > 0) {
                    const bmi = weight / ((height / 100) ** 2);
                    bmiInput.value = bmi.toFixed(1) + (bmi < 18.5 ? ' (underweight)' : bmi < 25 ? ' (normal)' :
                        bmi < 30 ? ' (overweight)' : ' (obese)');
                } else {
                    bmiInput.value = '';
                }

                if (height && weight && age && goal && exercise && bodyType) {
                    const bmr = (10 * weight) + (6.25 * height) - (5 * age) + 5;
                    const factors = {
                        sedentary: 1.2,
                        light: 1.375,
                        moderate: 1.55,
                        heavy: 1.725,
                        athlete: 1.9
                    };
                    const tdee = bmr * (factors[exercise] || 1.2);

                    let suggestedCal;
                    switch (goal) {
                        case 'bulk':
                            suggestedCal = tdee + 500;
                            break;
                        case 'cut':
                            suggestedCal = tdee - 500;
                            break;
                        default:
                            suggestedCal = tdee;
                    }
                    const protein = Math.round(weight * 1.8);
                    const fat = Math.round((suggestedCal * 0.25) / 9);
                    const carbs = Math.round((suggestedCal - protein * 4 - fat * 9) / 4);

                    sugCalories.textContent = Math.round(suggestedCal) + ' kcal';
                    sugProtein.textContent = protein + 'g';
                    sugCarbs.textContent = Math.max(carbs, 50) + 'g';
                    sugFat.textContent = fat + 'g';
                    sugTdee.textContent = Math.round(tdee);

                    suggestionBox.classList.add('show');
                } else {
                    suggestionBox.classList.remove('show');
                }
            }

            ['regHeight', 'regWeight', 'regAge'].forEach(id => {
                document.getElementById(id).addEventListener('input', computeAndSuggest);
            });

            // ---------- step validation ----------
            function validateStep(index) {
                const panel = panels[index];

                // Native inputs (text/number/email/password) inside this panel
                const nativeInputs = panel.querySelectorAll('input:not([type="hidden"])');
                for (const input of nativeInputs) {
                    if (input.hasAttribute('required') && !input.checkValidity()) {
                        input.reportValidity();
                        return false;
                    }
                }

                // Choice-card groups inside this panel
                const grid = panel.querySelector('.choice-grid');
                if (grid) {
                    const hiddenInput = document.getElementById(grid.dataset.group);
                    const errEl = panel.querySelector('.auth-error');
                    if (!hiddenInput.value) {
                        if (errEl) errEl.classList.add('show');
                        return false;
                    }
                    if (errEl) errEl.classList.remove('show');
                }

                return true;
            }

            // ---------- step navigation ----------
            function renderStep() {
                panels.forEach((p, i) => p.classList.toggle('active', i === currentStep));
                stepTitleEl.textContent = stepTitles[currentStep];
                stepCountEl.textContent = `Step ${currentStep + 1} of ${totalSteps}`;
                stepProgressFill.style.width = `${((currentStep + 1) / totalSteps) * 100}%`;
                backBtn.classList.toggle('hidden', currentStep === 0);
                nextBtn.textContent = currentStep === totalSteps - 1 ? 'Create account' : 'Next';
                errorEl.classList.remove('show');
            }

            backBtn.addEventListener('click', () => {
                if (currentStep > 0) {
                    currentStep--;
                    renderStep();
                }
            });

            nextBtn.addEventListener('click', () => {
                if (!validateStep(currentStep)) return;

                if (currentStep < totalSteps - 1) {
                    currentStep++;
                    renderStep();
                } else {
                    submitRegistration();
                }
            });

            // ---------- submit ----------
            function submitRegistration() {
                errorEl.classList.remove('show');

                const payload = {
                    name: document.getElementById('regName').value.trim(),
                    email: document.getElementById('regEmail').value.trim(),
                    password: document.getElementById('regPassword').value,
                    height: parseFloat(heightInput.value),
                    weight: parseFloat(weightInput.value),
                    age: parseInt(document.getElementById('regAge').value),
                    body_type: document.getElementById('regBodyType').value,
                    goal: document.getElementById('regGoal').value,
                    exercise_intensity: document.getElementById('regExercise').value,
                };

                for (let key in payload) {
                    if (!payload[key] && key !== '') {
                        errorEl.textContent = 'Please fill in all fields.';
                        errorEl.classList.add('show');
                        return;
                    }
                }

                nextBtn.disabled = true;
                nextBtn.textContent = 'Creating account…';

                fetch('/api/register', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify(payload),
                    })
                    .then(response => response.json().then(data => ({
                        status: response.status,
                        data
                    })))
                    .then(({
                        status,
                        data
                    }) => {
                        if (status >= 400) {
                            throw new Error(data.message || 'Registration failed.');
                        }
                        document.body.classList.add('page-fade-out');
                        setTimeout(function() {
                            window.location.href = '/';
                        }, 280);
                    })
                    .catch(err => {
                        errorEl.textContent = err.message || 'Something went wrong. Please try again.';
                        errorEl.classList.add('show');
                        nextBtn.disabled = false;
                        nextBtn.textContent = 'Create account';
                    });
            }

            // Prevent implicit form submit on Enter key from skipping validation
            form.addEventListener('submit', e => e.preventDefault());

            renderStep();
        });
    </script>

</body>

</html>
