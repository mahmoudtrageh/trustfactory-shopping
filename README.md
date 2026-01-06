# Laravel E-commerce Shopping Cart

A simple e-commerce shopping cart system built with Laravel, Livewire, and Tailwind CSS. This project demonstrates user authentication, product management, shopping cart functionality, and automated email notifications.

> **Note**: This project is configured for local development using MySQL database and Mailtrap for email testing.

---

## Features

### Core Functionality
- **User Authentication** - Registration, login, logout, and password reset using Laravel Breeze
- **Product Browsing** - View all available products with prices and stock information
- **Shopping Cart** - Add products to cart, update quantities, and remove items
- **Checkout** - Complete orders and view order history
- **User-Based Carts** - Each cart is stored in the database and linked to the authenticated user

### Automated Notifications
- **Low Stock Alerts** - Automatic email notification to admin when product stock drops to 10 or below
- **Daily Sales Report** - Scheduled email sent to admin every evening at 6 PM with daily sales summary

---

## Tech Stack

- **Backend**: Laravel (latest version)
- **Frontend**: Livewire (Laravel starter kit)
- **Styling**: Tailwind CSS
- **Database**: MySQL
- **Queue**: Database driver
- **Mail**: Mailtrap (for local development)

---

## Installation

### Prerequisites
- PHP 8.1 or higher
- Composer
- Node.js & NPM
- MySQL

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd trustfactory-cart
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**
   ```bash
   npm install
   ```

4. **Configure environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Create MySQL database**

   Create a new MySQL database:
   ```bash
   mysql -u root -p
   CREATE DATABASE trustfactory_cart;
   exit;
   ```

6. **Configure database**

   Edit `.env` file and set your MySQL credentials:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=trustfactory_cart
   DB_USERNAME=root
   DB_PASSWORD=your_mysql_password
   ```

7. **Configure queue and mail (Mailtrap)**

   Add these to your `.env`:
   ```
   QUEUE_CONNECTION=database
   LOW_STOCK_THRESHOLD=10
   ADMIN_EMAIL=admin@example.com

   # Mailtrap Configuration (for local development)
   MAIL_MAILER=smtp
   MAIL_HOST=sandbox.smtp.mailtrap.io
   MAIL_PORT=2525
   MAIL_USERNAME=your_mailtrap_username
   MAIL_PASSWORD=your_mailtrap_password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS=noreply@trustfactory-cart.test
   MAIL_FROM_NAME="${APP_NAME}"
   ```

   **To get Mailtrap credentials**:
   - Sign up for free at [https://mailtrap.io](https://mailtrap.io)
   - Go to Email Testing → Inboxes → My Inbox
   - Copy SMTP credentials and paste them in your `.env` file

8. **Run migrations and seed database**
   ```bash
   php artisan migrate:fresh --seed
   ```

9. **Build frontend assets**
   ```bash
   npm run build
   ```

   For development with hot reload:
   ```bash
   npm run dev
   ```

10. **Start the application**
   ```bash
   php artisan serve
   ```

   Visit: http://localhost:8000

11. **Start queue worker** (in a separate terminal)
    ```bash
    php artisan queue:work
    ```

12. **Start task scheduler** (in a separate terminal, for local development)
    ```bash
    php artisan schedule:work
    ```

---

## Usage

### Login Credentials

After seeding the database, you can use these accounts:

**Admin User**:
- Email: `admin@example.com`
- Password: `password`

**Regular User**:
- Email: `user@example.com`
- Password: `password`

You can also register a new account.

### Testing the Application

1. **Browse Products**: Navigate to the products page to see all available items
2. **Add to Cart**: Click "Add to Cart" button on any product
3. **View Cart**: Click the cart icon in the navigation to see your cart
4. **Update Quantities**: Change quantities directly in the cart
5. **Remove Items**: Click remove button to delete items from cart
6. **Checkout**: Click checkout button to complete the order
7. **View Orders**: Navigate to order history to see your past orders

### Testing Email Notifications

**Low Stock Alert**:
1. Add products to cart and checkout
2. If a product's stock drops to 10 or below, an email will be queued
3. Check your Mailtrap inbox at [https://mailtrap.io](https://mailtrap.io) to see the email

**Daily Sales Report**:
1. Make some orders during the day
2. At 6 PM, the scheduled job will run automatically
3. Or manually trigger: `php artisan schedule:run`
4. Check your Mailtrap inbox to see the daily sales report email

---

## Project Structure

### Database Models
- **User** - Customer accounts with authentication
- **Product** - Items available for purchase (name, price, stock_quantity)
- **CartItem** - Shopping cart items linked to users
- **Order** - Completed orders
- **OrderItem** - Individual items in each order

### Livewire Components
- **ProductList** - Display all products in a grid
- **ShoppingCart** - Manage cart items (view, update, remove)
- **CartCounter** - Show cart item count in navigation
- **Checkout** - Complete the purchase
- **OrderHistory** - View past orders
- **OrderDetails** - View individual order details

### Jobs (Background Processing)
- **SendLowStockNotification** - Email admin when stock is low
- **SendDailySalesReport** - Email daily sales summary to admin

### Key Files
```
app/
├── Livewire/          # Livewire components
├── Models/            # Database models
├── Jobs/              # Background jobs
├── Mail/              # Email templates
└── Services/          # Business logic (CheckoutService)

database/
├── migrations/        # Database schema
└── seeders/           # Sample data

resources/views/
├── livewire/          # Livewire component views
└── emails/            # Email templates

routes/
└── web.php            # Application routes
```

---

## How It Works

### Shopping Cart Flow
1. User logs in or registers
2. User browses products
3. User adds products to cart (stored in database `cart_items` table)
4. User can update quantities or remove items
5. User proceeds to checkout
6. System validates stock availability
7. Order is created and cart is cleared
8. Product stock is reduced
9. If stock drops to 10 or below, low stock email is queued

### Order Management
- Orders are stored with a unique order number (e.g., ORD-20260106-0001)
- Order items snapshot product details (name, price) at time of purchase
- Users can view their order history and details

### Background Jobs
- **Queue Worker**: Processes email jobs asynchronously
- **Task Scheduler**: Runs daily sales report at 6 PM
- Both run in separate processes for better performance

---

## Configuration

### Low Stock Threshold
Change the threshold for low stock alerts in `.env`:
```
LOW_STOCK_THRESHOLD=10
```

### Admin Email
Set the admin email address in `.env`:
```
ADMIN_EMAIL=admin@example.com
```

### Mail Configuration (Mailtrap for Local Development)

This project uses Mailtrap for email testing in local development. Mailtrap catches all emails sent by the application without actually sending them to real email addresses.

**Setup Mailtrap**:
1. Create a free account at [https://mailtrap.io](https://mailtrap.io)
2. Go to "Email Testing" → "Inboxes" → "My Inbox"
3. Copy your SMTP credentials
4. Add them to your `.env` file:

```
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@trustfactory-cart.test
MAIL_FROM_NAME="${APP_NAME}"
```

**Testing Emails**:
- All emails sent by the application will appear in your Mailtrap inbox
- You can view low stock alerts and daily sales reports there
- No real emails are sent, making it perfect for development

---

## Development Commands

```bash
# Run migrations
php artisan migrate

# Reset database and seed
php artisan migrate:fresh --seed

# Start development server
php artisan serve

# Start queue worker
php artisan queue:work

# Start task scheduler (development)
php artisan schedule:work

# Manually trigger scheduled jobs
php artisan schedule:run

# Build assets for production
npm run build

# Watch assets during development
npm run dev

# Clear all caches
php artisan optimize:clear

# Testing
php artisan test                    # Run all tests
php artisan test --coverage         # Test with coverage report
php artisan test --filter CartTest  # Run specific test

# Code Quality
./vendor/bin/pint                   # Format code (Laravel Pint)
./vendor/bin/pint --test            # Check formatting without fixing
./vendor/bin/phpstan analyse        # Static analysis (Larastan)
```

---

## Testing

### Manual Testing Checklist
- [ ] User registration and login
- [ ] Browse products page
- [ ] Add product to cart
- [ ] Update cart quantities
- [ ] Remove items from cart
- [ ] Cart counter updates
- [ ] Checkout creates order
- [ ] View order history
- [ ] View order details
- [ ] Low stock email sent (check Mailtrap inbox)
- [ ] Daily sales report (manually trigger and check Mailtrap inbox)

### Automated Tests

This project includes comprehensive unit and feature tests covering:
- Models and their relationships
- Shopping cart operations
- Checkout process and order creation
- Background jobs (low stock alerts, daily sales reports)
- User authentication

**Run all tests**:
```bash
php artisan test
```

**Run tests with coverage report**:
```bash
php artisan test --coverage
```

**Run specific test file**:
```bash
php artisan test --filter CartTest
```

**Test Files**:
- `tests/Unit/Models/` - Model unit tests
- `tests/Unit/Services/` - Service class tests
- `tests/Feature/` - Integration and feature tests

---

## Code Quality & Best Practices

This project follows Laravel best practices and includes tools for maintaining code quality:

### Laravel Pint
Code formatting tool that ensures consistent code style across the project.

```bash
# Format all code files
./vendor/bin/pint

# Check formatting without making changes
./vendor/bin/pint --test
```

Configuration: `pint.json` in project root with Laravel preset.

### Larastan (PHPStan for Laravel)
Static analysis tool that finds bugs and type errors before runtime.

```bash
# Run static analysis
./vendor/bin/phpstan analyse
```

Configuration: `phpstan.neon` in project root (Level 5 analysis).

### Code Quality Standards
- PSR-12 coding standard (enforced by Pint)
- Type hints on all methods
- Proper return types
- Comprehensive PHPDoc blocks
- No unused imports or variables
- Database transactions for data integrity
- Proper exception handling

---

## Features Implementation

### Database-Backed Cart
Unlike session-based carts, this implementation:
- Stores cart items in the database
- Associates each cart with an authenticated user
- Persists cart across browser sessions
- Allows cart retrieval from any device

### Stock Management
- Real-time stock validation when adding to cart
- Stock reduction only happens at checkout
- Automatic low stock notifications
- Prevents overselling with database transactions

### Email Notifications
- Asynchronous processing via queues
- Admin receives low stock alerts automatically
- Daily sales reports with comprehensive metrics
- Easily configurable email templates

---

## Troubleshooting

### Queue Jobs Not Processing
- Ensure queue worker is running: `php artisan queue:work`
- Check `failed_jobs` table for failures
- View logs: `storage/logs/laravel.log`

### Emails Not Appearing in Mailtrap
- Ensure queue worker is running: `php artisan queue:work`
- Check Mailtrap credentials in `.env` are correct
- Verify `MAIL_MAILER=smtp` in `.env`
- Check `failed_jobs` table for failures
- Verify admin user exists with `is_admin = true`
- View Laravel logs: `storage/logs/laravel.log`

### Scheduler Not Running
- Development: Run `php artisan schedule:work`
- Production: Verify cron job is configured
- Test manually: `php artisan schedule:run`

### Database Errors
- Run migrations: `php artisan migrate`
- Reset database: `php artisan migrate:fresh --seed`
- Check database credentials in `.env`

---

## Laravel Best Practices Used

1. **Eloquent Relationships** - Clean model relationships
2. **Service Classes** - Business logic separation (CheckoutService)
3. **Jobs & Queues** - Asynchronous email processing
4. **Task Scheduling** - Built-in scheduler for cron jobs
5. **Livewire Components** - Reactive UI without writing JavaScript
6. **Middleware** - Route protection with auth middleware
7. **Migrations** - Version-controlled database schema
8. **Seeders** - Reproducible test data
9. **Mailables** - Clean, testable email templates
10. **Environment Configuration** - Secure configuration management
11. **Testing** - Comprehensive unit and feature tests with PHPUnit
12. **Code Quality** - Laravel Pint for consistent formatting
13. **Static Analysis** - Larastan for type safety and bug prevention
14. **Database Transactions** - Data integrity in checkout process
15. **Test Database** - Isolated testing with .env.testing

---

## License

This project is open-source and available under the MIT License.

---

## Author

Built as a practical demonstration of Laravel e-commerce fundamentals with Livewire and Tailwind CSS.