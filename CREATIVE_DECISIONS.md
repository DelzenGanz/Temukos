# Creative Decisions Log — Temukos

As requested by the project prompt, this document outlines the creative freedom exercised and the design/architectural decisions made during the rebuild of the Temukos application.

## 1. Branding & Copywriting
*   **Tagline:** The prompt suggested "Temu kosmu dengan mudah" or generating a new one. I decided to stick with the original **"Temu kosmu dengan mudah"** as it is highly effective, concise, and clearly communicates the value proposition in Indonesian.
*   **Color Palette:** I chose a vibrant gradient of Emerald (`#10b981`) and Teal (`#0d9488`) as the primary brand colors. Green shades evoke feelings of trust, growth, and home, aligning well with a property rental platform. The background uses a soft `gray-50` to make the white cards pop.
*   **Typography:** Google's **Inter** font was selected for the entire application. It provides a clean, modern, and highly legible interface, essential for reading property details and pricing.

## 2. UI/UX Design (Frontend)
*   **Modern "Glassmorphic" Touches:** The navigation bar employs a subtle backdrop blur (glassmorphism) to ensure it remains visible and stylish when scrolling over property photos.
*   **Property Cards:** Designed to emulate modern platforms like Airbnb or Mamikos. They hide complex details upfront, focusing on the primary photo, price, property type badge (color-coded: Kos is green, Kontrakan is amber, Apartemen is indigo), and the top facilities.
*   **Filter System:** Instead of cluttering the homepage toolbar, the advanced filters (price range, property type, specific facilities) are placed into an elegant slide-over modal. This keeps the initial view clean while offering powerful search capabilities.
*   **Sticky Booking Sidebar:** On the property detail page, the booking form (date selection and duration) is placed in a sticky sidebar on the right (on desktop screens). This allows users to read the long description and see photos while the "Pesan Sekarang" (Book Now) CTA is always within reach.

## 3. Architecture & Backend (Laravel)
*   **Tailwind CSS v4:** The project utilizes the newly released Tailwind CSS v4, which uses the `@import "tailwindcss";` syntax and offers significant performance improvements via Vite.
*   **Separate Admin Guard:** Instead of adding an `is_admin` boolean to the `users` table, I created a dedicated `admins` table and a separate authentication guard. This is a more robust architectural choice that prevents accidental privilege escalation and keeps user code separate from admin code.
*   **Midtrans Integration Architecture:** 
    *   A dedicated `MidtransService` class encapsulates all the Midtrans-specific logic (generating Snap tokens, verifying webhook signatures). This keeps the Controllers clean.
    *   A `MidtransController` handles the asynchronous webhook callbacks to update booking statuses (`pending` -> `paid` or `cancelled`) safely in the background.
*   **Eloquent Scopes for Filtering:** To adhere to the "Fat Model, Skinny Controller" principle, complex filtering logic (by name, city, type, price range, and facilities) was moved into reusable local scopes on the `Property` model (e.g., `scopeFilterByType`, `scopeFilterByFacilities`).
*   **Extensibility Hooks:** Comments like `// extensible` were left in the database migrations and models to show where future features (like multi-landlord support or notification preferences) can be easily added without rewriting the core structure.

## 4. Security & Optimization
*   **Route Model Binding:** Used extensively to automatically inject Eloquent models into routes, simultaneously handling 404 errors automatically.
*   **Authorization Policies:** Implemented a `BookingPolicy` to ensure that tenants can only view, pay for, and access their own specific bookings, preventing IDOR (Insecure Direct Object Reference) vulnerabilities.
*   **CSRF Exceptions:** Properly configured the Laravel bootstrap file (`app.php`) to exempt the `/midtrans/callback` route from CSRF verification, as this endpoint receives server-to-server POST requests from Midtrans.
