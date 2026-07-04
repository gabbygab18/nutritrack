# NutriTrack — How this app works (end-to-end)

This document explains how NutriTrack functions from the moment a user opens the app UI, through the Laravel routes/controllers/models, down to the database schema and the frontend API calls.

> Scope: Auth → dashboard → goals → entry logging/history → food search (local + USDA fallback) → settings (profile/password) → physique photos.

---

## 1) High-level architecture

NutriTrack is a Laravel application:
- **Blade** renders the initial HTML pages.
- **Frontend JavaScript** (in `public/js/*.js`) drives UI interactions and calls the backend using `fetch()`.
- **Backend** exposes JSON APIs under `/api/*` implemented as Laravel controller methods.
- **Database** uses Eloquent models + migrations.

### Key directories
- Routing:
  - `routes/web.php`
- API controllers:
  - `app/Http/Controllers/Api/*.php`
- Models:
  - `app/Models/*.php`
- Schema/migrations:
  - `database/migrations/*.php`
- Seed data:
  - `database/seeders/*.php`
- Frontend views:
  - `resources/views/*.blade.php`
- Frontend JS:
  - `public/js/app.js`
  - `public/js/auth.js`

---

## 2) Routing: what URLs exist?

### Web routes (HTML pages)
Defined in `routes/web.php`:
- `GET /login` → renders `resources/views/auth.blade.php`
- `GET /register` → renders `resources/views/register.blade.php`

Inside `Route::middleware('auth')`:
- `GET /` → renders `resources/views/app.blade.php` and injects:
  - `currentUser => auth()->user()`

### API routes (JSON)
Also in `routes/web.php`, under authentication middleware:
- `POST /api/register` → `AuthController@register`
- `POST /api/login` → `AuthController@login`
- `POST /api/logout` → `AuthController@logout`
- `GET /api/user` → `AuthController@user`

Then:
- Goals
  - `GET /api/goals` → `GoalController@show`
  - `POST /api/goals` → `GoalController@update`

- Foods
  - `GET /api/foods/search` → `FoodController@search`

- Entries
  - `GET /api/entries` → `EntryController@index`
  - `GET /api/entries/{entry}` → `EntryController@show`
  - `POST /api/entries` → `EntryController@store`
  - `PUT /api/entries/{entry}` → `EntryController@update`
  - `DELETE /api/entries/{entry}` → `EntryController@destroy`

- Settings / photos
  - `POST /api/settings/profile` → `SettingsController@updateProfile`
  - `POST /api/settings/password` → `SettingsController@updatePassword`
  - `GET /api/physique-photos` → `SettingsController@physiquePhotos`
  - `POST /api/physique-photos` → `SettingsController@storePhysiquePhoto`
  - `DELETE /api/physique-photos/{physiquePhoto}` → `SettingsController@destroyPhysiquePhoto`

---

## 3) Database schema (what tables exist)

NutriTrack stores:
- users
- user daily goals (macros)
- entry logs (meals + macro totals + optional photos)
- a local food catalog for fast matching
- physique/progress photos

### 3.1 `users`
Initial Laravel user table + migrations for profile fields.
- Base (`0001_01_01_000000_create_users_table.php`) includes:
  - `id`, `name`, `email`, `password`, `email_verified_at`, `rememberToken`, timestamps
- Avatar (`2026_07_03_141440_add_avatar_to_users_table.php`):
  - `avatar` (longText, nullable)
- Profile stats (`2026_07_04_001637_add_profile_fields_to_users_table.php`):
  - `height`, `weight`, `age`
  - `body_type` (ectomorph/mesomorph/endormorph)
  - `goal` (stay/bulk/cut)
  - `exercise_intensity` (sedentary/light/moderate/heavy/athlete)

### 3.2 `goals`
Created in `2026_07_03_000000_create_goals_table.php`:
- `id`
- `user_id` (unique)
- `calories` (default 2000)
- `protein` (default 120)
- timestamps

Extended by `2026_07_03_232455_add_carbs_fat_to_goals_table.php`:
- `carbs` (default 275)
- `fat` (default 78)

### 3.3 `entries`
Created in `2026_07_03_000001_create_entries_table.php`:
- `id` (string primary key)
- `user_id`
- `name`, `meal`
- `servings` + `serving_unit`
- per-serving macros: `per_calories`, `per_protein`, `per_carbs`, `per_fat`
- totals: `calories`, `protein`, `carbs`, `fat`
- `photo` (longText, nullable)
- `date` (date-only) and `timestamp` (unix ms as bigint)

**Important detail:** `id` is a string primary key, not auto-increment.
Frontend generates it (see `public/js/app.js`), using:
- `uid()` for new entries
- `editingEntryId` for updates

### 3.4 `foods`
Created in `2026_07_03_230850_create_foods_table.php`:
- `id`
- `name`
- `name_normalized` (indexed)
- `aliases` (JSON, nullable)
- `category`
- `serving_description`
- `serving_grams` (nullable)
- macros per serving: `calories`, `protein`, `carbs`, `fat`
- `source` (string, default estimated)

### 3.5 `physique_photos`
Created in `2026_07_03_141419_create_physique_photos_table.php`:
- `id`
- `user_id`
- `photo` (longText)
- `notes` (nullable)
- `date`
- `timestamp`

---

## 4) Eloquent models & relationships

### `User`
File: `app/Models/User.php`
- `$fillable`: includes profile fields + avatar
- Relationships:
  - `entries()` → hasMany `Entry`
  - `goal()` → hasOne `Goal`
  - `physiquePhotos()` → hasMany `PhysiquePhoto`

### `Entry`
File: `app/Models/Entry.php`
- `$incrementing = false`, `$keyType = 'string'`
- `user()` → belongsTo `User`

### `Goal`
File: `app/Models/Goal.php`
- `user()` → belongsTo `User`

### `Food`
File: `app/Models/Food.php`
- `$table = 'foods'`
- `aliases` cast to array

### `PhysiquePhoto`
File: `app/Models/PhysiquePhoto.php`
- `$fillable = ['user_id', 'photo', 'notes', 'date', 'timestamp']`

---

## 5) Authentication & account creation

### 5.1 `/api/register` flow
Controller: `app/Http/Controllers/Api/AuthController.php@register`

**Step-by-step**
1. Validate request fields:
   - `name`, `email` (unique), `password`
   - profile inputs: `height`, `weight`, `age`, `body_type`, `goal`, `exercise_intensity`
2. Compute BMR using **Mifflin-St Jeor** (`computeBMR`):
   - For `male` default:
     - `BMR = (10*weightKg) + (6.25*heightCm) - (5*age) + 5`
   - For `female` variant (only if gender input was provided; current UI doesn’t send it):
     - subtract 161 instead of add 5
3. Convert BMR to TDEE with an **activity factor**:
   - sedentary 1.2, light 1.375, moderate 1.55, heavy 1.725, athlete 1.9
4. Compute **suggested daily calories** based on `goal`:
   - `bulk` → `tdee + 500`
   - `cut` → `tdee - 500`
   - `stay` → `tdee`
5. Compute macros (rough allocation):
   - protein: `weightKg * 1.8` (rounded)
   - fat: `(suggestedCalories * 0.25) / 9` (rounded)
   - carbs: remaining kcal converted to grams:
     - `carbs = (suggestedCalories - protein*4 - fat*9) / 4`
     - then `max(carbs, 50)` for safety
6. Create:
   - `users` row
   - `goals` row (with calculated macros)
7. Log the user in via `Auth::login($user)` and regenerate session.
8. Return JSON:
   - `user`
   - `suggested`: `bmr`, `tdee`, `calories`, `protein`, `carbs`, `fat`

### 5.2 `/api/login` flow
Controller: `AuthController@login`
- Validate `email`, `password`
- `Auth::attempt()` to authenticate
- regenerate session
- return `Auth::user()` as JSON

### 5.3 `/api/logout`
- `Auth::logout()`
- invalidate session + regenerate CSRF token
- returns HTTP 204

### 5.4 `/api/user`
Returns the authenticated user JSON: `response()->json($request->user())`

---

## 6) Frontend boot flow (how the UI loads)

The core authenticated UI is rendered by `resources/views/app.blade.php` and controlled by:
- `window.CURRENT_USER = @json($currentUser)`
- then `public/js/app.js`

### `public/js/auth.js` (login/register page)
- Intercepts form submit
- Sends:
  - `POST /api/login` with `{ email, password }`
  - or `POST /api/register` with registration wizard payload
- On success, redirects to `/`

### `public/js/app.js` (dashboard application)
Main responsibilities:
1. Initialize `currentUser` from `window.CURRENT_USER`
2. Setup navigation tabs (dashboard / history / settings)
3. Fetch:
   - `GET /api/user`
   - `GET /api/goals`
   - `GET /api/entries?date=YYYY-MM-DD`
   - etc.
4. Handle:
   - entry modal (add/edit)
   - food search results
   - cropping + photo encoding
   - saving settings

The JS also keeps the current tab in the URL hash (e.g. `#dashboard`, `#history`, `#settings`).

---

## 7) Goals module

### API
Controller: `app/Http/Controllers/Api/GoalController.php`

#### `GET /api/goals`
- Uses `Goal::firstOrCreate()` by `user_id`.
- Defaults if none exists:
  - calories 2000, protein 120, carbs 275, fat 78
- Returns goal as JSON.

#### `POST /api/goals`
- Validates:
  - integers min 1 for `calories`, `protein`, `carbs`, `fat`
- Uses `Goal::updateOrCreate()` by `user_id`.
- Returns updated goal.

### Frontend
In `public/js/app.js`:
- Dashboard shows:
  - current totals from entries for today
  - progress bars comparing totals to goal
- “Edit goals” button opens modal:
  - saves via `POST /api/goals`

---

## 8) Entries module (meal logging + CRUD)

### API (CRUD)
Controller: `app/Http/Controllers/Api/EntryController.php`

#### `GET /api/entries?date=YYYY-MM-DD`
- Base query: `request->user()->entries()->orderBy('timestamp','desc')`
- If `date` query parameter exists, adds:
  - `where('date', query('date'))`
- Returns an array of entries.

#### `GET /api/entries/{entry}`
- Authorizes ownership via `authorizeEntry()`.
  - If `entry->user_id !== request->user()->id` → abort(403)
- Returns the entry JSON.

#### `POST /api/entries`
Validates required payload fields:
- `id` (required string)
- `name`, `meal`
- `servings` numeric min 0.1
- `serving_unit`
- per-serving macros: `per_calories`, `per_protein`, `per_carbs`, `per_fat`
- totals: `calories`, `protein`, `carbs`, `fat`
- `photo` nullable string (in practice it is a Data URL)
- `date` date
- `timestamp` integer

Then:
- `Entry::create(array_merge($data, ['user_id' => request->user()->id]))`

Returns created entry JSON.

#### `PUT /api/entries/{entry}`
- Checks authorization
- Validates a similar set of fields (no `id` field in validation)
- Updates entry.

#### `DELETE /api/entries/{entry}`
- Checks authorization
- deletes entry
- returns HTTP 204

### How the frontend calculates entry totals
File: `public/js/app.js`.
When the user saves the entry modal:
- it builds payload fields:
  - `per_*` = input fields (per serving)
  - `calories/protein/carbs/fat` = per serving × servings
  - `id` = existing editing id or generated `uid()`
  - `photo` = pending Data URL or null
  - `date` = `todayISO()`
  - `timestamp` = `Date.now()`

### Entry photo handling
Frontend:
- user selects an image file
- file is resized to JPEG and converted to Data URL
- for profile/physique photos, there’s an additional crop step
- for entry photos, cropping isn’t done in the shown code; it just resizes & previews
- the Data URL string is stored directly in the DB `entries.photo`

---

## 9) Food search module (local-first + USDA fallback)

### API: `GET /api/foods/search?q=...`
Controller: `app/Http/Controllers/Api/FoodController.php`

#### Request
- Query param `q` is the user search term.

If `q` is empty:
- returns `{ local: [], usda: [] }`

#### Normalization
- `normalized = Str::lower()->ascii()->trim()->value()`

#### Local search (fast)
Local query logic:
- `where('name_normalized','like','%'+normalized+'%')`
- OR `orWhereJsonContains('aliases', normalized)`
- `orderBy('name')`
- `limit(15)`
- returns mapped objects shaped as:
  ```json
  {
    "source": "local",
    "id": "local-<food_id>",
    "name": "...",
    "brand": "<category>",
    "serving_description": "...",
    "calories": <number>,
    "protein": <number>,
    "carbs": <number>,
    "fat": <number>
  }
  ```

#### Local threshold
- If local results count >= 3:
  - USDA search is skipped.
- Otherwise:
  - USDA search results are added.

#### USDA fallback (external API)
If `config('services.usda.key')` is empty:
- returns empty USDA list.

Otherwise it calls:
- `https://api.nal.usda.gov/fdc/v1/foods/search`
with parameters:
- `api_key`
- `query`
- `pageSize=12`
- `dataType=Foundation,SR Legacy,Branded`

It then parses `foodNutrients` by searching for nutrientName matches like:
- `Energy` with unit `KCAL`
- `Protein`
- `Carbohydrate, by difference`
- `Total lipid (fat)`

Mapping to unified response format:
```json
{
  "source": "usda",
  "id": "usda-<fdcId>",
  "name": "...",
  "brand": "...",
  "serving_description": "100 g",
  "calories": <number>,
  "protein": <number>,
  "carbs": <number>,
  "fat": <number>
}
```

### Frontend integration
In `public/js/app.js`:
- `performSearch(query)`:
  - calls `GET /api/foods/search?q=<query>`
  - concatenates `local` + `usda` into `currentSearchResults`
- Renders cards with “Add” button.
- On add:
  - opens the entry modal prefilled with that food’s macros and serving description.

---

## 10) Settings module

### 10.1 Profile update
API: `POST /api/settings/profile` → `SettingsController@updateProfile`
Validation:
- `name` required string max 255
- `avatar` nullable string

Behavior:
- `request->user()->update($data)`

Frontend:
- `public/js/app.js` uses cropper to crop uploaded avatar image
- exports a JPEG Data URL
- sends it as `avatar` in JSON

### 10.2 Password update
API: `POST /api/settings/password` → `SettingsController@updatePassword`
Validation:
- `current_password` required
- `password` required min 8 and must match `password_confirmation`

Behavior:
- checks `Hash::check(current_password, user->password)`
- if incorrect:
  - returns `422` with `{ message: 'Current password is incorrect.' }`
- otherwise updates password hash.

Frontend:
- validates “new password == confirm password” before sending

### 10.3 Physique photos
APIs:
- `GET /api/physique-photos`
  - returns `request->user()->physiquePhotos()->orderBy('timestamp','desc')->get()`
- `POST /api/physique-photos`
  - validation:
    - `photo` required string (Data URL)
    - `notes` nullable string max 255
    - `date` required date
    - `timestamp` required integer
  - creates record with `user_id`
- `DELETE /api/physique-photos/{physiquePhoto}`
  - checks ownership manually (`physiquePhoto->user_id !== request->user()->id`) → abort(403)
  - deletes and returns HTTP 204

Frontend:
- uses CropperJS to crop progress photos (aspect ratio 3:4)
- stores the exported Data URL into `photo`
- renders cards in a grid with delete buttons

---

## 11) Seed data & local food dataset

Local foods are created using:
- `database/seeders/FilipinoFoodSeeder.php`

### What it is
The seeder:
- contains a hardcoded list of Filipino food items
- each item has:
  - name, category, serving description
  - macros per serving (calories/protein/carbs/fat)
  - `aliases` array
- `Food::updateOrCreate(['name' => ...], [...])`
  - sets `name_normalized` by lowercased + ascii + trimmed name
  - sets `source='estimated'`

### How it’s used
`DatabaseSeeder.php` currently shows only a user factory seeding:
- `User::factory()->create([...])`

So for foods to exist, you must either:
- register `FilipinoFoodSeeder` inside `DatabaseSeeder.php`, or
- run the seeder directly.

---

## 12) API request/response schemas (quick reference)

### Auth
#### POST `/api/register`
Request body:
```json
{
  "name": "...",
  "email": "...",
  "password": "...",
  "height": 175,
  "weight": 75,
  "age": 25,
  "body_type": "ectomorph",
  "goal": "stay",
  "exercise_intensity": "moderate"
}
```
Response:
```json
{
  "user": { /* created user */ },
  "suggested": {
    "bmr": 0,
    "tdee": 0,
    "calories": 0,
    "protein": 0,
    "carbs": 0,
    "fat": 0
  }
}
```

#### POST `/api/login`
Request:
```json
{ "email": "...", "password": "..." }
```
Response: authenticated user JSON.

### Goals
#### GET `/api/goals`
Response:
```json
{
  "id": 1,
  "user_id": 2,
  "calories": 2000,
  "protein": 120,
  "carbs": 275,
  "fat": 78
}
```

#### POST `/api/goals`
Request:
```json
{ "calories": 2000, "protein": 120, "carbs": 275, "fat": 78 }
```
Response: updated goal JSON.

### Food search
#### GET `/api/foods/search?q=term`
Response:
```json
{
  "local": [ { "source":"local", "id":"local-1", "name":"...", "brand":"...", "serving_description":"...", "calories":0, "protein":0, "carbs":0, "fat":0 } ],
  "usda": [ { "source":"usda", "id":"usda-123", "name":"...", "brand":"...", "serving_description":"100 g", "calories":0, "protein":0, "carbs":0, "fat":0 } ]
}
```

### Entries
#### GET `/api/entries?date=YYYY-MM-DD`
Response: array of entries:
```json
[
  {
    "id": "string-id",
    "user_id": 2,
    "name": "Adobo",
    "meal": "Dinner",
    "servings": 1,
    "serving_unit": "serving",
    "per_calories": 280,
    "per_protein": 25,
    "per_carbs": 6,
    "per_fat": 18,
    "calories": 280,
    "protein": 25,
    "carbs": 6,
    "fat": 18,
    "photo": "data:image/jpeg;base64,...",
    "date": "2026-07-04",
    "timestamp": 1720000000000
  }
]
```

#### POST `/api/entries`
Request must include (as validated by backend):
```json
{
  "id": "string-id",
  "name": "...",
  "meal": "Breakfast|Lunch|Dinner|Snack",
  "servings": 1,
  "serving_unit": "...",
  "per_calories": 0,
  "per_protein": 0,
  "per_carbs": 0,
  "per_fat": 0,
  "calories": 0,
  "protein": 0,
  "carbs": 0,
  "fat": 0,
  "photo": null,
  "date": "YYYY-MM-DD",
  "timestamp": 1720000000000
}
```
Response: created entry JSON.

#### PUT `/api/entries/{entry}`
Same fields as `POST` except `id` is not re-validated by backend update validation.

#### DELETE `/api/entries/{entry}`
Response: HTTP 204.

### Physique photos
#### GET `/api/physique-photos`
Response: array of photos (sorted by timestamp desc).

#### POST `/api/physique-photos`
Request:
```json
{
  "photo": "data:image/jpeg;base64,...",
  "notes": "optional",
  "date": "YYYY-MM-DD",
  "timestamp": 1720000000000
}
```
Response: created record JSON.

#### DELETE `/api/physique-photos/{physiquePhoto}`
Response: HTTP 204.

---

## 13) Operational notes

### 13.1 USDA API key
Food search USDA fallback uses:
- `config/services.php` → `services.usda.key` from `env('USDA_API_KEY')`

If `USDA_API_KEY` is missing:
- USDA results are empty
- local search still works.

### 13.2 Session/auth
All API endpoints require authentication due to middleware grouping in `routes/web.php`.
The frontend relies on same-origin cookies + XSRF token:
- `app.js` builds an `X-XSRF-TOKEN` header for unsafe methods.

## 13.3 Photo storage strategy
All photos are stored as **Data URLs in the database** (the backend expects them as strings and the migrations use `longText`).

Where they are saved:
- `entries.photo` (meal photo; optional)
- `users.avatar` (profile picture; optional)
- `physique_photos.photo` (progress photo; required)

### What exactly is a “Data URL”?
A Data URL is a string like:
- `data:image/jpeg;base64,/9j/4AAQSk...`

The frontend creates these strings by using:
- `FileReader().readAsDataURL(file)`
- image resizing to JPEG (`canvas.toDataURL('image/jpeg', quality)`)
- optional cropping with CropperJS (`canvas.toDataURL('image/jpeg', 0.88)`)

### Why this design exists (tradeoffs)
Pros:
- No separate file storage service needed (S3/local disk not required)
- One request/response flow (everything is JSON)

Cons:
- DB can grow quickly (base64 inflates size)
- Backups/migrations become heavier
- You lose streaming benefits you’d get with file uploads

---

## 13.4 Frontend behavior details (important user flows)
This section describes the “everything” view: a user’s journey through the UI and the exact API calls triggered.

### A) User opens the app (GET `/`)
1. Laravel renders `resources/views/app.blade.php`.
2. Blade injects the authenticated session user as:
   - `window.CURRENT_USER`
3. `public/js/app.js` starts immediately:
   - it calls `enterApp()` to show the dashboard UI
   - it also calls `fetchCurrentUser()` to refresh data

### B) Logging in
1. User submits `resources/views/auth.blade.php`.
2. `public/js/auth.js` sends:
   - `POST /api/login` with `{ email, password }`
3. On success, JS redirects to `/`.

### C) Registering
1. User goes through the 5-step wizard in `resources/views/register.blade.php`.
2. Wizard computes a *preview* of suggested macros locally (BMR/TDEE logic).
3. On final submit, JS sends:
   - `POST /api/register` with all wizard inputs.
4. Backend recomputes suggested macros again (source of truth).
5. Backend logs the user in and JS redirects to `/`.

### D) Dashboard totals
Dashboard always shows *today’s* totals (by default) using:
- `GET /api/goals`
- `GET /api/entries?date=<todayISO>`

Then JS sums:
- `calories`/`protein`/`carbs`/`fat` across today’s entries

…and compares to `goals.*` to render progress bars.

### E) Logging a meal
Entry creation happens through the modal in `app.blade.php`.

Two ways to prefill:
1. Search foods:
   - user types into search
   - JS calls `GET /api/foods/search?q=<query>`
   - results are rendered as cards with an **Add** button
2. Add manually:
   - user clicks “Add a food manually”

When user clicks **Save entry**:
1. JS generates an entry payload:
   - `id`: either `editingEntryId` or a new `uid()`
   - `per_*`: per serving values from the modal
   - `calories/protein/carbs/fat`: per_* × servings
   - `photo`: optional Data URL (resized)
   - `date`: today
   - `timestamp`: `Date.now()`
2. JS calls either:
   - `POST /api/entries` (create)
   - or `PUT /api/entries/{entry}` (edit)
3. On success, UI refreshes the active view (dashboard or history).

### F) Editing & deleting entries
- Edit:
  - UI calls `GET /api/entries/{entry}`
  - fills modal with per-serving macros and servings/unit
- Delete:
  - UI calls `DELETE /api/entries/{entry}`
  - backend checks ownership and returns 204

### G) Food search (local first)
Food search is optimized for speed:
1. Backend runs local database search.
2. If local has enough results (>= 3), USDA is not queried.
3. Otherwise, USDA fallback is called and results are appended.

This means that common Filipino dishes should usually come from the local dataset quickly.

### H) Settings & photos
- Profile:
  - JS lets user upload a picture
  - CropperJS crops it
  - JS sends cropped JPEG Data URL to `POST /api/settings/profile`
- Password:
  - `POST /api/settings/password`
  - requires current password to match
- Progress photos:
  - `GET /api/physique-photos` to render the grid
  - Add photo:
    - crop in UI
    - `POST /api/physique-photos`
  - Delete photo:
    - ownership check → `DELETE /api/physique-photos/{id}`

---

## 14) Source map: where to look in code


- Routes: `routes/web.php`
- Auth controller: `app/Http/Controllers/Api/AuthController.php`
- Goals controller: `app/Http/Controllers/Api/GoalController.php`
- Entry controller: `app/Http/Controllers/Api/EntryController.php`
- Food controller: `app/Http/Controllers/Api/FoodController.php`
- Settings controller: `app/Http/Controllers/Api/SettingsController.php`
- Frontend:
  - `public/js/auth.js`
  - `public/js/app.js`
- Frontend views:
  - `resources/views/auth.blade.php`
  - `resources/views/register.blade.php`
  - `resources/views/app.blade.php`

---

End of documentation.

