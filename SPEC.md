# Antigravity Prompt — Temukos (Laravel Rebuild)

## PRODUCT IDENTITY

- **Product name: Temukos** — this is fixed and must not be changed
- Tagline: *Temu kosmu dengan mudah* (or AI may suggest a better one — document it in the Creative Decisions Log)
- Use "Temukos" consistently across: page titles, navbar brand, email templates, README, meta tags, and all user-facing text
- Laravel project folder name: `temukos`
- App name in `.env`: `APP_NAME=Temukos`

---

Build a **kos/kontrakan rental web application** called **Temukos** using **Laravel** (latest stable), **Tailwind CSS**, and **Midtrans Snap** for payment. This is a full rebuild of an existing PHP native MVC project. The domain, features, and UI flow are preserved — but the entire codebase must be rewritten cleanly from scratch.

---

## CREATIVE FREEDOM DIRECTIVE

This project is meant to grow beyond a school submission. You are allowed — and encouraged — to make creative decisions on anything not explicitly specified in this prompt. This includes UI layout choices, component design, micro-interactions, color decisions within the palette, naming conventions, helper utilities, and architecture patterns.

**However: every creative decision you make must be documented.** At the end of your output, include a section called `## Creative Decisions Log` that lists each decision you made independently, in this format:

```
- [Area] What you did → Why you chose it → How to change or extend it later
```

Example:
```
- [UI] Used a sticky booking sidebar on desktop with scroll-aware behavior → Improves UX for long property descriptions → To disable, remove `sticky top-4` from the sidebar wrapper in `property/show.blade.php`
- [Architecture] Extracted Midtrans logic into a dedicated `MidtransService` class → Keeps controller thin and makes it easy to swap payment providers → Located in `app/Services/MidtransService.php`
```

This log is required. Do not skip it. It is how the developer will understand, modify, and extend what you built.

---

## CONTEXT FROM OLD PROJECT (issues to fix in the rebuild)

The old project had these specific problems that must NOT be repeated:

1. **Ghost column** — `available_from` was used in filters and queries but never existed in the database schema. Do NOT include this field. Remove the date availability filter entirely.
2. **Fake sort option** — `"Paling populer"` sort was wired to the same `created_at DESC` as "newest." Either implement it properly using booking count, or remove the option entirely.
3. **Redundant type-filter logic** — The old controller had bloated if/else handling for whether `type` was a string or array. In Laravel, use a single consistent `array` input via `request()->input('type', [])` and scope the Eloquent query cleanly.
4. **Raw SQL string manipulation** — The facility filter used `str_replace()` on a raw SQL string to inject WHERE clauses. In Laravel, use Eloquent scopes and `whereHas()` for relationship filtering.
5. **Plaintext passwords** — Admin password was stored as plain string. Use `bcrypt` via Laravel's `Hash::make()`.
6. **`global $dbConfig` antipattern** — Every controller called `global $dbConfig`. In Laravel, use Eloquent models directly — no manual DB config passing needed.
7. **WhatsApp number hardcoded** — The detail page had a hardcoded `wa.me/6282146008889`. Replace with a bookable flow via Midtrans instead.

---

## DATABASE SCHEMA (implement as Laravel migrations)

```
admins          — id, username, password (bcrypt), remember_token, timestamps
users           — id, name, email, password (bcrypt), phone, email_verified_at, remember_token, timestamps
properties      — id, name, city, address, price_month (unsignedInteger), description (text), property_type (enum: kos/kontrakan/apartemen), timestamps
facilities      — id, name
property_facility — property_id (FK), facility_id (FK) [pivot, no timestamps]
property_photos — id, property_id (FK cascade), filename, is_primary (boolean default false), timestamps
bookings        — id, user_id (FK), property_id (FK), start_date (date), duration_months (tinyInteger), total_price (unsignedBigInteger), status (enum: pending/paid/cancelled, default: pending), midtrans_order_id (string nullable unique), snap_token (text nullable), timestamps
```

---

## ELOQUENT RELATIONSHIPS

- `Property` hasMany `PropertyPhoto`, belongsToMany `Facility` (via `property_facility`)
- `Property` hasMany `Booking`
- `User` hasMany `Booking`
- `Booking` belongsTo `User`, belongsTo `Property`
- `PropertyPhoto` belongsTo `Property`

---

## FEATURES

### Public / Tenant Side

**Homepage (`/`)**
- Grid of property cards (4 columns desktop, 2 tablet, 1 mobile)
- Each card: primary photo, property name, city · address, price/month in Rupiah format, type badge, top 3 facility tags
- Search bar at top: location keyword input + filter modal trigger button + search submit
- Filter modal (slide-in panel) containing:
  - Sort: Terbaru, Harga Terendah, Harga Tertinggi *(remove "Paling Populer" unless booking count is implemented)*
  - Property type: checkbox cards for Kos, Kontrakan, Apartemen
  - Price range: min and max number inputs
  - Facilities: checkbox list from DB
- Filter state must persist in URL query params and pre-fill form on reload
- Show total count of results found

**Property Detail (`/property/{id}`)**
- Photo carousel (primary photo first, rest follow)
- Property name, city, address, type badge
- Price per month (formatted Rupiah)
- Full description
- Facilities as pill badges
- Booking panel (right sidebar on desktop, bottom on mobile):
  - If guest: show "Login untuk Memesan" button
  - If logged in: show booking form (start date picker, duration in months selector 1–12, calculated total price preview, "Pesan Sekarang" button)

**Auth (`/register`, `/login`, `/logout`)**
- Standard Laravel auth for tenants (name, email, password, phone)
- Separate from admin auth

**Booking Flow**
- On submit: create booking record with status `pending`, generate Midtrans Snap token server-side, return `snap_token` to frontend
- Frontend opens Midtrans Snap popup using `snap.pay(token)`
- On payment success callback: update booking status to `paid` via AJAX or redirect
- Midtrans webhook at `POST /midtrans/callback` to handle server-side status updates

**Booking History (`/bookings`)**
- Logged-in user sees their booking list: property name, dates, total, status badge (pending/paid/cancelled)
- If status is still `pending`, show "Bayar Sekarang" button that reopens Snap popup using stored `snap_token`

---

### Admin Panel (`/admin`)

Separate auth guard (`admin` guard), login at `/admin/login`.

- **Dashboard** — summary cards (total properties, total bookings, total paid bookings), recent bookings table
- **Properties** — paginated table with search, add/edit/delete actions
- **Property Form** — name, city, address, type (select), price, description, facilities (checkbox list), multiple photo upload (first uploaded = primary, can change primary later)
- **Bookings** — list all bookings with filters by status, manual status update dropdown

---

## MIDTRANS INTEGRATION

```
MIDTRANS_SERVER_KEY=
MIDTRANS_CLIENT_KEY=
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_SNAP_URL=https://app.sandbox.midtrans.com/snap/snap.js
```

Server-side Snap token generation:
```php
\Midtrans\Config::$serverKey = config('midtrans.server_key');
\Midtrans\Config::$isProduction = config('midtrans.is_production');
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;

$params = [
    'transaction_details' => [
        'order_id'     => $booking->midtrans_order_id,
        'gross_amount' => $booking->total_price,
    ],
    'customer_details' => [
        'first_name' => $user->name,
        'email'      => $user->email,
        'phone'      => $user->phone,
    ],
];

$snapToken = \Midtrans\Snap::getSnapToken($params);
```

Webhook handler must:
- Verify signature: `hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey)`
- Update booking status to `paid` on `transaction_status = settlement` or `capture`
- Update to `cancelled` on `cancel` or `expire`

---

## TECH REQUIREMENTS

- Laravel (latest stable), PHP 8.2+
- Tailwind CSS via Vite (no Bootstrap)
- Eloquent ORM — no raw SQL queries except where unavoidable
- Form Requests for all validation
- Route model binding on property and booking routes
- Image storage in `storage/app/public/uploads` with `php artisan storage:link`
- `flipbox/laravel-midtrans` or `midtrans/midtrans-php` composer package
- Pagination on all list views (admin and public)
- CSRF on all POST forms
- Gates or Policies for booking ownership check

---

## SEEDERS

- `AdminSeeder` — one admin: username `admin`, password `admin123` (bcrypt)
- `FacilitySeeder` — AC, WiFi, Kamar mandi dalam, Dapur bersama, Parkir motor, Parkir mobil, Laundry, Security 24 jam
- `PropertySeeder` — 2 sample properties with facilities and placeholder photo filenames

---

## UI STYLE

- Tailwind utility classes only, no custom CSS files
- Inspired by Rukita / Mamikos: clean, card-based, warm neutral palette (white, cream `#FAF9F6`, soft green or indigo accents)
- Responsive: mobile-first
- Booking panel on detail page should feel like an Airbnb-style sticky sidebar on desktop
- Beyond these constraints, you have full creative freedom on layout rhythm, spacing, typography scale, hover states, transitions, and empty states. Document every non-trivial design decision in the Creative Decisions Log.

---

## EXTENSIBILITY NOTES

Design the codebase with future growth in mind. These are features that may be added later — do not build them now, but make sure the architecture does not block them:

- Multiple landlords (the `properties` table may later need an `owner_id` FK to a `landlords` table)
- Property reviews and ratings
- Room availability calendar
- Notification system (email or in-app) for booking status changes
- Admin revenue reports

Where relevant, leave a comment in the code like `// extensible: add owner_id FK here when multi-landlord is implemented` to guide future development.

---

## DELIVERABLES

- Full Laravel project (routes, controllers, models, migrations, views, seeders, config)
- `config/midtrans.php` config file
- `.env.example` with all keys
- `README.md` with setup steps: `composer install`, `npm install && npm run build`, `php artisan migrate --seed`, `php artisan storage:link`
- `## Creative Decisions Log` section documenting every independent decision made during generation
