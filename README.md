# TrustFactory Shopping Cart

A simple e-commerce shopping cart system built with Laravel, Livewire, and Tailwind CSS. Users can browse products, manage their cart, and admins receive automated notifications about low stock and daily sales reports.

---

## What This Project Does

This is a shopping cart application where:
- Users can **browse products** and see prices and stock availability
- Users can **add products to their cart** and manage quantities
- Users can **checkout** to place orders
- Admins get **email notifications** when products are running low on stock
- Admins get a **daily sales report** every evening showing what was sold

---

## Tech Stack

- **Backend**: Laravel 12 (PHP framework)
- **Frontend**: Livewire (reactive components without JavaScript)
- **Styling**: Tailwind CSS (utility-first CSS framework)
- **Database**: SQLite (for local development)
- **Queue**: Database-based queue for background jobs
- **Email**: Log driver (for testing - emails saved to logs)

---

## Installation & Setup

### 1. Install Dependencies
```bash
composer install
npm install && npm run dev
```

### 2. Set Up Database
The project uses SQLite by default (no configuration needed).

Run migrations to set up the database:
```bash
php artisan migrate:fresh --seed
```

This will create the database file and populate it with test data.

### 3. Start the Development Server
```bash
php artisan serve
```

Visit: http://localhost:8000

### 4. Run Queue Worker (For Email Jobs)
In a separate terminal:
```bash
php artisan queue:work
```

### 5. Run Task Scheduler (For Daily Reports)
In development:
```bash
php artisan schedule:work
```

---

## Key Features (When Complete)

### For Shoppers
- Browse all available products
- See product prices and stock levels
- Add products to shopping cart
- Update quantities or remove items from cart
- Checkout to place orders
- View order history and details
- Cart items saved to database (persist across sessions)

### For Admins
- Receive email alerts when products are low on stock
- Get daily sales report every evening at 6 PM showing:
  - Total orders placed
  - Total revenue
  - Which products were sold and quantities

### Technical Features
- User authentication (login, register, password reset)
- Each user has their own isolated cart
- Cart items stored in database (not session)
- Stock validation (can't buy more than available)
- Background email jobs using queues
- Scheduled daily reports using Laravel scheduler

---

## How It Works

### 1. Products
Products have:
- Name
- Price
- Stock quantity
- Description (optional)

### 2. Shopping Cart
- Each logged-in user has their own cart
- Cart items are stored in the database
- Users can add, update quantities, or remove items
- Cart shows total price

### 3. Checkout Process
When a user checks out:
1. System validates all products are still in stock
2. Creates an order record
3. Saves order items (snapshot of products at purchase time)
4. Reduces product stock quantities
5. Clears user's cart
6. If any product drops to low stock, sends email to admin

### 4. Email Notifications

**Low Stock Alert**:
- Triggered automatically after checkout
- Sent when a product has 10 or fewer items left
- Goes to admin email address

**Daily Sales Report**:
- Runs automatically every evening at 6 PM
- Shows all orders from that day
- Includes total revenue and products sold
- Sent to admin email address

---

## Database Structure

### Users
- Comes from Laravel Breeze (authentication)
- Tracks which cart and orders belong to which user

### Products
- Stores all products available for sale
- Tracks current stock quantity

### Cart Items
- Links users to products they want to buy
- Stores quantity for each item
- Each user can only have one cart item per product

### Orders
- Stores completed purchases
- Has unique order number
- Tracks total amount and status

### Order Items
- Individual products in an order
- Saves product name and price at time of purchase (snapshot)
- Calculates subtotal for each item

---

## Development Commands

### Database
```bash
# Run migrations
php artisan migrate

# Reset database and add test data
php artisan migrate:fresh --seed
```

### Queue & Scheduler
```bash
# Start queue worker (background jobs)
php artisan queue:work

# Start scheduler (for daily reports)
php artisan schedule:work
```

### Testing
```bash
# Run all tests
php artisan test

# Run tests with coverage report
php artisan test --coverage
```

### Code Quality
```bash
# Format code (fix style issues)
./vendor/bin/pint

# Check code formatting (without fixing)
./vendor/bin/pint --test

# Run static code analysis
./vendor/bin/phpstan analyse
```

### Cache
```bash
# Clear all cache
php artisan optimize:clear
```

---

## Environment Configuration

The `.env` file contains important settings:

```env
# App
APP_NAME="TrustFactory Cart"
APP_ENV=local

# Database (SQLite - no additional config needed)
DB_CONNECTION=sqlite

# Queue (database)
QUEUE_CONNECTION=database

# Mail (Log driver - emails saved to storage/logs/laravel.log)
MAIL_MAILER=log
MAIL_FROM_ADDRESS=noreply@trustfactory.test
MAIL_FROM_NAME="${APP_NAME}"

# Cart Settings
LOW_STOCK_THRESHOLD=10
ADMIN_EMAIL=admin@example.com
```

---

## File Structure (When Complete)

```
trustfactory-cart/
├── app/
│   ├── Models/              # Database models (Product, Cart, Order)
│   ├── Livewire/            # UI components (ProductList, ShoppingCart)
│   ├── Jobs/                # Background jobs (email notifications)
│   ├── Mail/                # Email templates
│   └── Services/            # Business logic (CheckoutService)
├── database/
│   ├── migrations/          # Database structure
│   └── seeders/             # Test data
├── resources/
│   └── views/
│       ├── livewire/        # Component views
│       └── emails/          # Email templates
├── routes/
│   └── web.php              # Application routes
├── tests/                   # Automated tests
├── .env                     # Environment configuration
├── phpstan.neon             # Static analysis config
└── pint.json                # Code formatting config
```

---

## Testing Strategy

### Unit Tests
- Test individual model methods
- Test business logic in isolation
- Test checkout service functions

### Feature Tests
- Test complete user flows
- Test authentication
- Test adding to cart
- Test checkout process
- Test email notifications
- Test order management

---

## Laravel Best Practices Used

1. **Eloquent ORM** - Database interactions using models
2. **Migrations** - Version-controlled database schema
3. **Seeders** - Reproducible test data
4. **Livewire Components** - Reactive UI without writing JavaScript
5. **Jobs & Queues** - Background processing for emails
6. **Task Scheduling** - Automated daily reports
7. **Service Classes** - Separate business logic from controllers
8. **Middleware** - Protect routes (authentication required)
9. **Mailables** - Clean, testable email templates
10. **Validation** - Input validation in components
11. **Testing** - Comprehensive test coverage
12. **Code Quality** - Automated formatting and static analysis

---

## Support & Documentation

- **Laravel Documentation**: https://laravel.com/docs
- **Livewire Documentation**: https://livewire.laravel.com/docs
- **Tailwind CSS Documentation**: https://tailwindcss.com/docs

---

## Project Requirements

This project was built for the TrustFactory technical assessment.

**Requirements**:
- Simple e-commerce shopping cart
- User authentication (Laravel Breeze)
- Product browsing and cart management
- Database-backed cart (per user)
- Low stock email notifications (using Jobs/Queues)
- Daily sales report (scheduled task)
- Clean code following Laravel best practices
- Tailwind CSS for styling

**Deliverables**:
- GitHub repository with code
- Working application following requirements
- Clean, maintainable code structure

---

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
