# BusinessOS — Website Flow

## Overview

BusinessOS is a Laravel-based business management system. It handles authentication, customer management, and a central dashboard for business operations.

---

## 1. Authentication Flow

```
/ (welcome)
    │
    ├── /login
    │       ├── [invalid] → back to /login with errors
    │       └── [valid]   → /dashboard
    │
    ├── /register
    │       ├── [invalid] → back to /register with errors
    │       └── [valid]   → /dashboard (auto-login)
    │
    ├── /forgot-password
    │       └── [submit email] → /reset-password?token=xxx
    │
    └── /reset-password
            ├── [invalid] → back with errors
            └── [valid]   → /login
```

> All routes under `/dashboard`, `/customers`, `/profile` require authentication (`auth` middleware).  
> `/dashboard` additionally requires email verification (`verified` middleware).

---

## 2. Dashboard Flow

```
/dashboard
    ├── Stat Cards
    │       ├── Total Customers
    │       ├── Active Customers
    │       ├── Inactive Customers
    │       └── New This Month
    │
    └── Recent Customers Table (last 5)
            └── "View all" → /customers
```

---

## 3. Customer Management Flow

```
/customers  (index)
    ├── Search by name → /customers?search=xxx
    ├── "+ Add Customer" → /customers/create
    ├── "Edit" → /customers/{id}/edit
    └── "Delete" → DELETE /customers/{id} → back to /customers
```

### Create Customer
```
/customers/create
    ├── [validation fails] → back with errors
    └── [success] → /customers  (flash: "Customer added successfully.")
```

### Edit Customer
```
/customers/{id}/edit
    ├── [validation fails] → back with errors
    └── [success] → /customers  (flash: "Customer Updated successfully.")
```

### Delete Customer
```
DELETE /customers/{id}
    └── [confirm dialog] → /customers  (flash: "Customer Deleted Successfully.")
```

---

## 4. Profile Flow

```
/profile
    ├── Update profile info  → PATCH /profile → back to /profile
    ├── Update password      → PUT /profile/password → back to /profile
    └── Delete account       → DELETE /profile → / (logged out)
```

---

## 5. Route Summary

| Method    | URI                    | Action                  | Middleware        |
|-----------|------------------------|-------------------------|-------------------|
| GET       | `/`                    | Welcome page            | —                 |
| GET       | `/login`               | Login form              | guest             |
| POST      | `/login`               | Authenticate            | guest             |
| GET       | `/register`            | Register form           | guest             |
| POST      | `/register`            | Create account          | guest             |
| GET       | `/forgot-password`     | Forgot password form    | guest             |
| POST      | `/forgot-password`     | Send reset link         | guest             |
| GET       | `/reset-password`      | Reset password form     | guest             |
| POST      | `/reset-password`      | Reset password          | guest             |
| GET       | `/dashboard`           | Dashboard               | auth, verified    |
| GET       | `/customers`           | Customer list           | —                 |
| GET       | `/customers/create`    | Create form             | —                 |
| POST      | `/customers`           | Store customer          | —                 |
| GET       | `/customers/{id}/edit` | Edit form               | —                 |
| PUT       | `/customers/{id}`      | Update customer         | —                 |
| DELETE    | `/customers/{id}`      | Delete customer         | —                 |
| GET       | `/profile`             | Profile edit            | auth              |
| PATCH     | `/profile`             | Update profile          | auth              |
| DELETE    | `/profile`             | Delete account          | auth              |

---

## 6. Data Models

### User
| Field              | Type      | Notes                    |
|--------------------|-----------|--------------------------|
| `id`               | bigint    | Primary key              |
| `name`             | string    |                          |
| `email`            | string    | Unique                   |
| `password`         | string    | Hashed                   |
| `email_verified_at`| timestamp | Nullable                 |

### Customer
| Field        | Type      | Notes                        |
|--------------|-----------|------------------------------|
| `id`         | bigint    | Primary key                  |
| `first_name` | string    | Required                     |
| `last_name`  | string    | Required                     |
| `email`      | string    | Unique, required             |
| `phone`      | string    | Nullable                     |
| `address`    | string    | Nullable                     |
| `birth_date` | date      | Nullable, must be before today |
| `gender`     | enum      | male / female / other        |
| `is_active`  | boolean   | Default: true                |
| `deleted_at` | timestamp | Soft delete                  |

---

## 7. Planned Modules (Sidebar)

These modules are listed in the sidebar but not yet implemented:

- **Products** — `/products`
- **Inventory** — `/inventory`
- **Suppliers** — `/suppliers`
- **Reports** — `/reports`
- **Settings** — `/settings`

---

## 8. Tech Stack

| Layer      | Technology                  |
|------------|-----------------------------|
| Framework  | Laravel 12                  |
| Frontend   | Blade + Tailwind CSS + Vite |
| Database   | MySQL                       |
| Auth       | Laravel Breeze              |
| Testing    | Pest PHP                    |
| Local Dev  | Laravel Herd                |
