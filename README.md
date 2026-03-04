# Temukos

> **Temu kosmu dengan mudah** — Platform pencarian dan penyewaan kos, kontrakan, dan apartemen di Indonesia.

## Tech Stack

- **Backend**: Laravel 12 (PHP 8.2+)
- **Frontend**: Tailwind CSS 4 via Vite
- **Payment**: Midtrans Snap (Sandbox/Production)
- **Database**: MySQL

## Setup

### Prerequisites
- PHP 8.2+
- Composer
- Node.js 18+ & npm
- MySQL
- XAMPP or similar local server

### Installation

```bash
# 1. Install PHP dependencies
composer install

# 2. Install frontend dependencies
npm install

# 3. Copy environment file (if not already done)
cp .env.example .env

# 4. Generate app key
php artisan key:generate

# 5. Create MySQL database
mysql -u root -e "CREATE DATABASE IF NOT EXISTS temukos"

# 6. Configure .env
#    - Set DB_DATABASE=temukos
#    - Set DB_USERNAME and DB_PASSWORD
#    - Set MIDTRANS_SERVER_KEY and MIDTRANS_CLIENT_KEY (from Midtrans Dashboard)

# 7. Run migrations and seed
php artisan migrate --seed

# 8. Create storage symlink
php artisan storage:link

# 9. Build frontend assets
npm run build
```

### Running Locally

```bash
# Start the development server
php artisan serve

# In another terminal, start Vite for hot reloading
npm run dev
```

Then visit: `http://localhost:8000`

## Default Accounts

| Role   | Username/Email | Password   |
|--------|---------------|------------|
| Admin  | `admin`       | `admin123` |

## Features

### Public / Tenant
- 🏠 Browse properties with search, filter, and sort
- 📋 Property detail with photo carousel
- 💳 Book and pay via Midtrans Snap
- 📜 Booking history with "Pay Now" for pending bookings

### Admin Panel (`/admin`)
- 📊 Dashboard with stats and recent bookings
- 🏗 Full property CRUD with photo management
- 📦 Booking management with status updates

## Midtrans Setup

1. Create a Midtrans Sandbox account at https://dashboard.sandbox.midtrans.com
2. Get your **Server Key** and **Client Key** from Settings → Access Keys
3. Update `.env`:
   ```
   MIDTRANS_SERVER_KEY=your-server-key
   MIDTRANS_CLIENT_KEY=your-client-key
   MIDTRANS_IS_PRODUCTION=false
   ```
4. For webhook: set Notification URL to `https://your-domain.com/midtrans/callback`

## Project Structure

```
app/
├── Http/Controllers/
│   ├── Auth/        → Login, Register, AdminLogin
│   ├── Admin/       → Dashboard, Property CRUD, Booking management
│   ├── HomeController.php
│   ├── PropertyController.php
│   ├── BookingController.php
│   └── MidtransController.php
├── Models/          → User, Admin, Property, Facility, PropertyPhoto, Booking
├── Policies/        → BookingPolicy
├── Services/        → MidtransService
└── Http/Middleware/ → AdminAuth

resources/views/
├── layouts/         → app.blade.php, admin.blade.php
├── auth/            → login, register, admin-login
├── property/        → show (detail page)
├── bookings/        → index (booking history)
├── admin/           → dashboard, properties/*, bookings/*
└── home.blade.php
```

## License

Proprietary. All rights reserved.
