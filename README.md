# Ecommerce Cart

A simple, opinionated Laravel e-commerce shopping cart application with Livewire components, background jobs, scheduled reports, and notifications. This repository demonstrates a small but production-minded approach to cart, order management, and automated notifications.

---

## Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [Prerequisites](#prerequisites)
- [Quick Start](#quick-start)
- [Development & Useful Commands](#development--useful-commands)
- [Testing](#testing)
- [Architecture & Key Files](#architecture--key-files)
- [Background Jobs & Scheduling](#background-jobs--scheduling)
- [Deployment Checklist](#deployment-checklist)
- [Troubleshooting](#troubleshooting)
- [Contributing](#contributing)
- [License & Credits](#license--credits)

---

## Features ✅

- Add products to a shopping cart (persistent for authenticated users)
- Checkout to create orders and order items
- Live UI powered by `Livewire` components (`app/Livewire`)
- Background jobs for sending daily reports and low-stock notifications
- Email notifications via `Mail` classes
- Observers to keep cart items and inventories in sync
- Artisan scripts and convenient composer scripts for development

---

## Tech Stack 🔧

- PHP 8.2+
- Laravel ^12.0
- Livewire ^3.x
- SQLite (configurable via `.env`)
- Node / Vite for frontend assets
- PHPUnit for testing

(Exact versions come from `composer.json`.)

---

## Prerequisites ✅

- PHP 8.2 or newer
- Composer
- Node.js (16+) and npm/yarn
- A database (MySQL, Postgres, or SQLite)
- Redis (recommended for queues in production) or other queue driver

---

## Quick Start 🚀

Clone the repository and use the provided composer scripts for a quick setup:

```bash
git clone <repo-url> ecommerce-cart
cd ecommerce-cart
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run dev
php artisan serve
```

Alternatively, run the convenience composer script defined in `composer.json`:

```bash
composer run setup
```

Open http://127.0.0.1:8000 in your browser.

---

## Development & Useful Commands 🧰

- Start dev stack (server, queue, logs, vite):
  - `composer run dev` (uses `concurrently`) or run services individually
- Run migrations:
  - `php artisan migrate`
- Seed database:
  - `php artisan db:seed`
- Queue worker (development):
  - `php artisan queue:work --tries=3`
- Queue listener (as used in composer `dev`):
  - `php artisan queue:listen --tries=1`
- Schedule worker (cron needs `php artisan schedule:run` every minute):
  - `php artisan schedule:run`
- Clear caches (config/route/view):
  - `php artisan config:cache && php artisan route:cache && php artisan view:cache`

---

## Testing 🧪

Run the test suite with:

```bash
composer test
# or
php artisan test
# or
vendor/bin/phpunit
```

Add tests under `tests/Feature` and `tests/Unit`. The project includes factories in `database/factories` and a `DatabaseSeeder` to support test setups.

---

## Architecture & Key Files 📁

- `app/Models` — `Product`, `Cart`, `CartItem`, `Order`, `OrderItem`, `User`
- `app/Livewire` — UI components: `CartButton`, `ProductList`, `ShoppingCart`
- `app/Jobs` — `SendDailySalesReport`, `SendLowStockNotification`
- `app/Mail` — Mailable classes used to send emails
- `app/Observers` — `CartItemObserver` keeps cart item business logic consistent
- `database/migrations` — schema definitions; review `2024_*_create_*` files
- `routes/web.php` — application web routes and endpoints
- `tests/` — unit and feature tests

Use PSR-4 autoloading and Laravel conventions. If you need to extend behavior start from the relevant Livewire component or Model.

---

## Background Jobs & Scheduling ⏱️

The app uses queued jobs for heavy/async tasks and scheduled tasks for reports:

- Jobs:
  - `SendDailySalesReport` — generates and emails a report
  - `SendLowStockNotification` — notifies about low-stock products
- Scheduling is defined in `app/Console/Kernel.php`.

In production, run queue workers with a process manager (Supervisor, systemd) and ensure the scheduler is called every minute via cron.

Example queue worker (systemd / supervisor recommendation):

```bash
# Simple foreground worker for testing
php artisan queue:work --sleep=3 --tries=3
```

---

## Environment Variables (.env) 🔐

Important keys you should configure in `.env`:

- `APP_ENV`, `APP_DEBUG`, `APP_URL`
- `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
- `MAIL_MAILER`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`
- `QUEUE_CONNECTION` (e.g., `database`, `redis`)

---

## Deployment Checklist ✅

1. Pull latest code, run `composer install --no-dev --optimize-autoloader`.
2. Set `.env` for production and run `php artisan key:generate` if needed.
3. Run `php artisan migrate --force`.
4. Queue worker process: configure Supervisor/systemd to run `php artisan queue:work`.
5. Configure scheduled tasks (run `php artisan schedule:run` every minute via cron).
6. Cache config & routes: `php artisan config:cache && php artisan route:cache`.
7. Build assets for production: `npm run build`.
8. Ensure `storage` & `bootstrap/cache` permissions are correct and `php artisan storage:link` is run.

---

## Troubleshooting ⚠️

- Permission errors: ensure `storage` and `bootstrap/cache` are writable by the web server user.
- Missing PHP extensions: install required extensions listed by `php -m` (pdo, pdo_mysql/pdo_pgsql, openssl, mbstring, bcmath, etc.).
- Queue jobs not processed: confirm `QUEUE_CONNECTION` and that a worker is running.
- Mail not sending: check `MAIL_MAILER` configuration and credentials.

---

## Contributing 🤝

Thanks for helping improve the project! Please follow these steps:

1. Fork the repository and create a feature branch.
2. Write tests for new functionality and ensure all tests pass.
3. Run `composer test` and `composer run dev` to validate locally.
4. Keep code style consistent; this project uses `laravel/pint` (`composer run`) to lint & format code.
5. Open a PR describing the change and link relevant issues.

---

## License & Credits

This project is licensed under the **MIT License**. See the `LICENSE` file for details.

Built with ❤️ using Laravel and Livewire. If you'd like, I can also add CI configuration, Docker support, or a short architecture diagram—just say which one you'd prefer.
