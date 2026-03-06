# Project Recap: Temukos

## 1. Project Overview
**Temukos** is a web platform for searching and booking temporary rentals such as *kos* (boarding houses), *kontrakan* (rented houses), and apartments in Indonesia. The goal is to provide a premium, minimalist, and transparent booking experience.

## 2. Tech Stack
- **Framework**: Laravel 12.x (PHP 8.2+)
- **Styling**: Tailwind CSS v4 (configured via Vite plugin, class-based dark mode)
- **Database**: MySQL (using XAMPP)
- **Payment Gateway**: Midtrans Snap (currently configured for **Sandbox**)
- **State Management**: `localStorage` (for theme persistence)

## 3. Key Features & Implementation Details

### A. Switchable Dark Mode
- **Method**: Class-based toggling (`dark` class on `<html>`).
- **Persistence**: Saved in `localStorage` and respects system preferences.
- **FOUC Prevention**: An inline script in [layouts/app.blade.php](file:///Applications/XAMPP/xamppfiles/htdocs/Temukos/resources/views/layouts/app.blade.php) applies the theme immediately before the page renders.
- **Styling**: Every major section (Hero, About, Properties, How It Works, CTA) in [home.blade.php](file:///Applications/XAMPP/xamppfiles/htdocs/Temukos/resources/views/home.blade.php) has been meticulously updated with specific `dark:` utility classes.
- **Toggle**: A smooth Sun/Moon icon toggle in the primary navigation bar.

### B. Booking System & Availability
- **Flow**: User selects start date and duration -> Backend generates `midtrans_order_id` -> Returns `snap_token` -> Frontend opens Midtrans popup.
- **Double-Booking Prevention**:
    - **Model Logic**: `Property::isAvailableBetween($startDate, $durationMonths)` uses SQL `DATE_ADD` to check for overlapping `pending` or `paid` bookings.
    - **Frontend Validation**: The "Booking" sidebar shows "Jadwal Terisi" (Booked Schedules) and validates overlap via JavaScript before even calling the server.
    - **Backend Validation**: `BookingController@store` re-verifies availability to prevent race conditions.

### C. Admin Interface
- **Separation**: The admin area is strictly kept in light mode as per the user's request.
- **Logic**: It uses a separate layout (`layouts/admin.blade.php`) which does not contain the dark mode initialization scripts or toggle.

### D. Mobile & External Access (Ngrok)
- **Fixes**: Implemented (and then reverted) `URL::forceScheme('https')` in [AppServiceProvider](file:///Applications/XAMPP/xamppfiles/htdocs/Temukos/app/Providers/AppServiceProvider.php#10-22) to allow styling assets to load correctly over HTTPS tunnels on devices like iPhone.

## 4. Notable File Interactions

- **[resources/views/layouts/app.blade.php](file:///Applications/XAMPP/xamppfiles/htdocs/Temukos/resources/views/layouts/app.blade.php)**: Core layout, contains the theme toggle logic and the main dark mode initialization script.
- **[resources/views/home.blade.php](file:///Applications/XAMPP/xamppfiles/htdocs/Temukos/resources/views/home.blade.php)**: The hub of the frontend UI; contains all the "wow-factor" styling and sections.
- **[app/Http/Controllers/BookingController.php](file:///Applications/XAMPP/xamppfiles/htdocs/Temukos/app/Http/Controllers/BookingController.php)**: Manages the booking lifecycle and Midtrans Snap integration.
- **[app/Models/Property.php](file:///Applications/XAMPP/xamppfiles/htdocs/Temukos/app/Models/Property.php)**: Contains the critical helper methods for formatting prices and checking availability.
- **[routes/web.php](file:///Applications/XAMPP/xamppfiles/htdocs/Temukos/routes/web.php)**: Defined routes for public views, tenant auth, bookable properties, and profile management.
- **[app/Http/Controllers/ProfileController.php](file:///Applications/XAMPP/xamppfiles/htdocs/Temukos/app/Http/Controllers/ProfileController.php)**: A newly created controller to fix missing profile routes.

## 5. Current Configuration (Environment)
- **APP_URL**: `http://localhost:8000`
- **Midtrans**: Sandbox mode enabled (`MIDTRANS_IS_PRODUCTION=false`).
- **Assets**: Most recently compiled using `npm run build`.

---
*Generated for use in Windsurf / Coding Assistants.*
