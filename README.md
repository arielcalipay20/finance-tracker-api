# Finance Tracker API

> Finance Tracker API is for tracking budgets, income, and expenses.

## Tech Stack

| Technology         | Purpose                                                                                                                                                       |
| ------------------ | ------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Laravel 12         | Used for built in validation, Eloquent ORM for database modeling, and migrations for database version control.                                                |
| Laravel Sanctum    | Used for token-based auth and SPA for integrating my frontend which is react typescript.                                                                      |
| MySQL              | Used for relational structure because my transactions and budgets belongs to categories and have a foreign key for reference and using constraints for rules. |
| React + TypeScript | Used for maintainable interfaces, type safety and reusable component.                                                                                         |

## API Endpoints

| Method | Endpoint               | Auth Required | Description                 |
| ------ | ---------------------- | ------------- | --------------------------- |
| POST   | /api/register          | No            | API for Registration        |
| POST   | /api/login             | No            | API for Login               |
| POST   | /api/logout            | Yes           | API for Logout              |
| GET    | /api/transactions      | Yes           | API for Transactions list   |
| POST   | /api/transactions      | Yes           | API for Store Transactions  |
| PUT    | /api/transactions/{id} | Yes           | API for Update Transactions |
| DELETE | /api/transactions/{id} | Yes           | API for Delete Transactions |
| GET    | /api/categories        | Yes           | API for Categories list     |
| POST   | /api/categories        | Yes           | API for Store Categories    |
| PUT    | /api/categories/{id}   | Yes           | API for Update Categories   |
| DELETE | /api/categories/{id}   | Yes           | API for Delete Categories   |
| GET    | /api/budgets           | Yes           | API for Budgets list        |
| POST   | /api/budgets           | Yes           | API for Store Budgets       |
| PUT    | /api/budgets/{id}      | Yes           | API for Update Budgets      |
| DELETE | /api/budgets/{id}      | Yes           | API for Delete Budgets      |

## Getting Started

### Prerequisites

- PHP 8.2+
- Composer
- MySQL
- Node.js

### Installation

```bash
git clone https://github.com/arielcalipay20/finance-tracker-api.git
cd finance-tracker-api
composer install
php artisan install:api
cp .env.example .env
# Edit .env with your database credentials
php artisan key:generate
php artisan migrate
php artisan serve
```

## Design Decisions

- Used Sanctum over Passport because the project uses token-based auth for a SPA — no OAuth complexity needed.
- Applied strict rate limiting (5 requests/minute) on auth routes to prevent brute force attacks instead of the default 60 requests/minute.
- Transaction type is derived from the selected category instead of manually entered — prevents data inconsistency between category and transaction types.
- Used `first()` instead of `get()` for single record lookups because `get()` returns a collection that is always truthy, breaking ownership checks.

## What's Next

-Integrate on my frontend which is React Typescript
-Deployment of server
-Add monthly spending summary endpoint for dashboard charts
-Add CSV export for transaction history
-Use Complex Auth
