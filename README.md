# 🧾 Order Management API

A RESTful API built with **Laravel** following **SOLID principles**, featuring JWT authentication, order lifecycle management, background job processing, and global search.

---

## ✨ Features

- 🔐 JWT Authentication (login & protected routes)
- 📦 Create & manage orders
- 💳 Flag orders as **paid** or **expired**
- 🔍 Global search across orders & transactions
- 📄 Simple pagination
- ⚙️ Background job queue support
- ⏰ Artisan command for expired order processing (cron-ready)

---

## 🏗️ Architecture

This project is structured following **SOLID principles**, with a **Repository Pattern** for data access abstraction:

| Principle | Implementation |
|---|---|
| **S** — Single Responsibility | Controllers delegate to Services; Services delegate to Repositories; DTOs handle data shaping; Jobs handle async side-effects |
| **O** — Open/Closed | New repository implementations can be swapped in without touching Services or Controllers |
| **L** — Liskov Substitution | `OrderRepository` and `TransactionRepository` are interchangeable through their interfaces |
| **I** — Interface Segregation | `OrderRepositoryInterface` and `TransactionRepositoryInterface` expose only what each domain needs |
| **D** — Dependency Inversion | Controllers depend on Services; Services depend on Repository interfaces — all wired via `RepositoryServiceProvider` |

---

## 🚀 Getting Started

### Prerequisites

- PHP >= 8.1
- Composer
- PostgreSQL
- Laravel 10+

### Installation

**1. Clone the repository**
```bash
git clone <your-repo-url>
cd <project-folder>
```

**2. Install dependencies**
```bash
composer install
```

**3. Copy environment file**
```bash
cp .env.example .env
```

**4. Configure your database** in `.env`
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

**5. Run database migrations**
```bash
php artisan migrate
```

**6. Seed the database** *(creates admin account + dummy orders)*
```bash
php artisan db:seed
```

**7. Generate JWT secret**
```bash
php artisan jwt:secret
```

**8. Start the queue worker** *(for background job processing)*
```bash
php artisan queue:work
```

**9. Start the development server**
```bash
php artisan serve
```

The API will be available at `http://127.0.0.1:8000`.

---

## 🔑 Default Credentials

| Field | Value |
|---|---|
| Email | `admin@admin.com` |
| Password | `admin` |

---

## 📡 API Endpoints

### Auth
| Method | Endpoint | Middleware | Description |
|---|---|---|---|
| `POST` | `/api/v1/auth/login` | — | Login and receive JWT token (set as cookie) |
| `GET` | `/api/v1/@me` | `auth:api` | Get authenticated user info |

### Orders & Transactions
> All routes below are protected by both `sec.token` and `auth:api` middleware.

| Method | Endpoint | Description |
|---|---|---|
| `POST` | `/api/v1/order` | Create a new order |
| `POST` | `/api/v1/payment` | Flag an order as paid or expired |
| `GET` | `/api/v1/status?reff={reff}` | Check order status by reference number |
| `GET` | `/api/v1/orders?search={keyword}` | List all orders with optional search |
| `GET` | `/api/v1/transactions?search={keyword}` | List all transactions with optional search |

---

## ⏰ Expired Order Processing

To mark unpaid orders as expired, run the following command manually or via cron:

```bash
php artisan app:process-expired-order
```

**Recommended crontab setup** (runs every minute):
```cron
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

Or add directly to your crontab for the command itself:
```cron
* * * * * cd /path-to-your-project && php artisan app:process-expired-order >> /dev/null 2>&1
```

---

## 🗂️ Project Structure

```
app/
├── Console/
│   ├── Commands/
│   │   └── ProcessExpiredOrder.php       # Artisan command to expire unpaid orders
│   └── Kernel.php
├── DTOs/
│   └── OrderDTO.php                      # Data Transfer Object for order input
├── Exceptions/
│   ├── Handler.php
│   └── PaymentException.php              # Custom exception for payment failures
├── Http/
│   ├── Controllers/Api/V1/
│   │   ├── AuthController.php            # Login & authenticated user info
│   │   ├── OrderController.php           # Order CRUD & payment flagging
│   │   └── TransactionController.php     # Transaction listing
│   ├── Middleware/
│   │   ├── Authenticate.php
│   │   ├── SecTokenMiddleware.php        # Custom security token middleware
│   │   └── ...                           # Laravel default middlewares
│   ├── Requests/
│   │   ├── LoginRequest.php
│   │   ├── OrderRequest.php
│   │   └── PaymentRequest.php
│   └── Resources/
│       ├── OrderResource.php
│       ├── PaymentResource.php
│       └── StatusResource.php
├── Jobs/
│   └── ProcessPaidOrder.php              # Background job for paid order processing
├── Models/
│   ├── Order.php
│   ├── Transaction.php
│   └── User.php
├── Providers/
│   ├── AppServiceProvider.php
│   ├── RepositoryServiceProvider.php     # Binds repository interfaces to implementations
│   └── ...                               # Laravel default providers
├── Repositories/
│   ├── Contracts/
│   │   ├── OrderRepositoryInterface.php
│   │   └── TransactionRepositoryInterface.php
│   └── Eloquents/
│       ├── OrderRepository.php
│       └── TransactionRepository.php
├── Rules/
│   └── ValidExpiredDate.php              # Custom validation rule for expiry dates
└── Services/
    ├── OrderService.php                  # Order business logic
    └── TransactionService.php            # Transaction business logic
```

---

## 📝 License

This project is open-sourced under the [MIT License](LICENSE).