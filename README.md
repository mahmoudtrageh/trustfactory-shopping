# TrustFactory Shopping Cart

A complete e-commerce shopping cart built with Laravel 12, Livewire, and Tailwind CSS. Features include product browsing, cart management, checkout, automated email notifications, and daily sales reports.

---

## Features

**For Customers:**
- Browse products publicly (no login required)
- Real-time stock status indicators
- Guest users can view products and pricing
- Login required to add items to cart
- Add/remove items from cart with instant updates
- Adjust quantities with stock validation
- Complete checkout process
- View order history and details
- Persistent cart (saved to database)

**For Admins:**
- Automatic low stock email alerts
- Daily sales reports (6 PM)
- Product and order management

---

## Tech Stack

- Laravel 12 (PHP 8.2+)
- Livewire 3 (reactive components)
- Tailwind CSS 3
- SQLite database
- Laravel Breeze authentication
- Queue system for background jobs
- Task scheduler for automated reports

---

## Quick Start

### 1. Clone & Install

```bash
# Install PHP dependencies
composer install

# Install frontend dependencies
npm install && npm run build
```

### 2. Configure Environment

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 3. Set Up Database

```bash
# Create database and seed with test data
php artisan migrate:fresh --seed
```

**Test Accounts Created:**
- Admin: `admin@example.com` / `password`
- User 1: `user1@test.com` / `password`
- User 2: `user2@test.com` / `password`

**Test Products:**
- Laptop Pro 15" ($999.99) - 50 in stock
- Wireless Mouse ($29.99) - 100 in stock
- Mechanical Keyboard ($79.99) - 3 in stock (low)
- USB-C Hub ($49.99) - 0 in stock (out)
- 27" Monitor ($299.99) - 25 in stock

### 4. Start Development Server

```bash
# Terminal 1: Start Laravel server
php artisan serve

# Terminal 2: Run queue worker (for emails)
php artisan queue:work

# Terminal 3: Run scheduler (for daily reports)
php artisan schedule:work
```

**Open:** http://localhost:8000

---

## Testing the App

### Quick Test Flow

**Guest User Flow:**
1. Visit http://localhost:8000/products (no login required)
2. Browse all products with stock information
3. Click "Login to Add to Cart" button
4. Redirected to login page

**Authenticated User Flow:**
1. Login as `user1@test.com` / `password`
2. Browse products at `/products`
3. Add items to cart (watch the cart counter update)
4. View cart at `/cart`
5. Update quantities or remove items
6. Proceed to checkout at `/checkout`
7. Place order
8. View order details and history at `/orders`

### Run Automated Tests

```bash
# Run all tests (49 tests)
php artisan test

# Run with coverage
php artisan test --coverage

# Run specific test suite
php artisan test --filter=CartTest
```

**Test Coverage:**
- ✅ 13 Unit tests (Models)
- ✅ 10 Cart feature tests
- ✅ 17 Authentication tests (Breeze)
- ✅ 9 Other feature tests

### Testing Email Jobs

The application includes two automated email jobs that you can test manually:

#### 1. Low Stock Notification

This job sends an email alert when a product's stock falls below the threshold (default: 10).

**Prerequisites:**
- Ensure queue worker is running: `php artisan queue:work`
- Configure mail settings in `.env` (use Mailtrap for testing)

**Test Command:**
```bash
# Option 1: Using tinker (one-line)
php artisan tinker --execute="App\Jobs\SendLowStockNotification::dispatch(App\Models\Product::first());"

# Option 2: Using tinker (interactive)
php artisan tinker
App\Jobs\SendLowStockNotification::dispatch(App\Models\Product::first());
exit
```

**Expected Result:**
- Email sent to `ADMIN_EMAIL` configured in `.env`
- Subject: "Low Stock Alert: [Product Name]"
- Check Mailtrap inbox at: https://mailtrap.io/inboxes

#### 2. Daily Sales Report

This job sends a daily summary of all orders and products sold (scheduled for 6 PM daily).

**Prerequisites:**
- Ensure queue worker is running: `php artisan queue:work`
- Configure mail settings in `.env` (use Mailtrap for testing)

**Test Command:**
```bash
# Option 1: Using tinker (one-line)
php artisan tinker --execute="App\Jobs\SendDailySalesReport::dispatch(now());"

# Option 2: Using tinker (interactive)
php artisan tinker
App\Jobs\SendDailySalesReport::dispatch(now());
exit
```

**Expected Result:**
- Email sent to `ADMIN_EMAIL` configured in `.env`
- Subject: "Daily Sales Report - [Date]"
- Contains: Total orders, total revenue, products sold
- Check Mailtrap inbox at: https://mailtrap.io/inboxes

**Mailtrap Setup (for testing):**
1. Sign up at https://mailtrap.io
2. Get your SMTP credentials
3. Update `.env`:
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=sandbox.smtp.mailtrap.io
   MAIL_PORT=2525
   MAIL_USERNAME=your_username
   MAIL_PASSWORD=your_password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS=noreply@trustfactory-cart.test
   ```
4. Clear config cache: `php artisan config:clear`
5. Run the test commands above

---

## Project Structure

```
app/
├── Livewire/              # UI Components
│   ├── ProductList.php    # Product listing with add to cart
│   ├── ShoppingCart.php   # Cart management
│   ├── CartCounter.php    # Header cart badge
│   ├── Checkout.php       # Order placement
│   ├── OrderHistory.php   # User's orders list
│   └── OrderDetails.php   # Individual order view
├── Models/                # Database Models
│   ├── Product.php        # Products with stock methods
│   ├── CartItem.php       # Shopping cart items
│   ├── Order.php          # Completed orders
│   └── OrderItem.php      # Order line items
├── Services/              # Business Logic
│   └── CheckoutService.php # Order processing
├── Jobs/                  # Background Tasks
│   ├── SendLowStockNotification.php
│   └── SendDailySalesReport.php
└── Mail/                  # Email Templates
    ├── LowStockAlert.php
    └── DailySalesReport.php

database/
├── migrations/            # Database schema
└── seeders/              # Test data

tests/
├── Unit/                 # Unit tests (13 tests)
│   └── Models/
└── Feature/              # Feature tests (27 tests)
    ├── CartTest.php      # Cart operations (10 tests)
    └── Auth/             # Authentication (17 tests)
```

---

## How It Works

### Authentication & Access Control
- **Public Access**: Product browsing (/products) - no login required
- **Requires Authentication**:
  - Adding items to cart
  - Viewing cart (/cart)
  - Checkout process (/checkout)
  - Order history (/orders)
- **Guest User Experience**: Can browse products, see pricing and stock, click "Login to Add to Cart" button

### Checkout Flow
1. User adds products to cart → validated against stock
2. User views cart → can update quantities or remove items
3. User proceeds to checkout → sees order summary
4. User places order:
   - Order created with unique number (ORD-YYYYMMDD-####)
   - Product stock reduced
   - Cart cleared
   - Low stock email sent if threshold reached
5. User views order confirmation and history

### Email Notifications
- **Low Stock Alert**: Sent to admin when stock ≤ 10 (configurable)
- **Daily Sales Report**: Sent at 6 PM with sales summary
- Emails logged to `storage/logs/laravel.log` (dev mode)

### Stock Management
- Real-time stock validation
- Prevents overselling
- Color-coded badges: Green (in stock) / Yellow (low) / Red (out)
- Cart quantities cannot exceed available stock

---

## Common Commands

```bash
# Development
php artisan serve                    # Start server
php artisan queue:work              # Process background jobs
php artisan schedule:work           # Run scheduled tasks

# Database
php artisan migrate:fresh --seed   # Reset DB with test data
php artisan tinker                  # Interactive shell

# Testing & Quality
php artisan test                    # Run all tests
./vendor/bin/pint                  # Format code
./vendor/bin/phpstan analyse       # Static analysis

# Maintenance
php artisan optimize:clear         # Clear all caches
php artisan queue:failed           # View failed jobs
php artisan schedule:list          # View scheduled tasks
```

---

## Configuration

Edit `.env` for customization:

```env
# Low stock threshold (default: 10)
LOW_STOCK_THRESHOLD=10

# Admin email for notifications
ADMIN_EMAIL=admin@example.com

# Queue connection
QUEUE_CONNECTION=database

# Mail driver (log for development, smtp for production)
MAIL_MAILER=log
```

---

## Troubleshooting

**Server won't start:**
```bash
php artisan optimize:clear
composer dump-autoload
```

**Tests failing:**
```bash
php artisan config:clear
php artisan migrate:fresh --env=testing
```

**Queue not processing:**
```bash
php artisan queue:restart
php artisan queue:work --once
```

**Check logs:**
```bash
tail -f storage/logs/laravel.log
```

## License

MIT License - See LICENSE file for details

---

## Support

Built for TrustFactory technical assessment

**Documentation:**
- [Laravel 12](https://laravel.com/docs)
- [Livewire 3](https://livewire.laravel.com/docs)
- [Tailwind CSS](https://tailwindcss.com/docs)
