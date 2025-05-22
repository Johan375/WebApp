All the codes are in Master branch

Laravel To-Do App ( Input Validation and Profile Page )

This is a Laravel-based To-Do application with user authentication and enhanced profile management features. Below are the enhancements and modifications made across the MVC structure of Laravel (Model, View, Controller).

---
Assignment 3
Features
- User Roles: Users are assigned roles (admin or user) stored in the user_roles table.
- Role Permissions: Each role has specific permissions (e.g., Create, Retrieve, Update, Delete) stored in the role_permissions table.
- RBAC Enforcement: Buttons and actions in the UI are shown or hidden based on the user's permissions.
- Admin Dashboard: Admins can manage users, activate/deactivate accounts, and view To-Do tasks created by each user.

Table of Contents
1. Database Schema
2. RBAC Implementation
3. Authorization Logic
4. Blade Views
5. Testing RBAC

Database Schema
1. user_roles Table
This table stores the roles assigned to users, including columns for the role ID, user ID, role name, and an optional description.

2. role_permissions Table
This table stores the permissions associated with each role, including columns for the permission ID, role ID, and a description of the permission (e.g., Create, Retrieve, Update, Delete).

RBAC Implementation
1. Middleware for Role Checking
A custom middleware ensures that only users with the correct role can access specific routes. Unauthorized users are redirected to a default page or shown an error.

2. Route Protection
Routes are grouped and protected using middleware. For example, routes for To-Do tasks are accessible only to users with the user role, while admin routes are restricted to users with the admin role.

Authorization Logic
1. Controller Logic
Controllers pass the user's permissions to the Blade views. This ensures that the views can dynamically show or hide buttons and actions based on the user's permissions.

Blade Views
1. index.blade.php
This view displays the list of To-Do items and enforces RBAC for buttons like "New List," "Edit," and "Delete."

2. add.blade.php
This view provides a form for creating a new To-Do item. The form is accessible only to users with the Create permission.

3. dashboard.blade.php
This view serves as the admin dashboard, where admins can manage users and view their To-Do tasks.


---

Assignment 2 
1. Multi-Factor Authentication (MFA)
- Implemented the Laravel Fortify package to provide MFA.
- MFA is set to deliver verification codes via email.
- After logging in, users are required to authenticate their identity using a code delivered to their email address.

2. Password Hashing
- Passwords are securely hashed using Laravel's built-in **Hash** facade.
- The application uses Argon2 (configurable via `config/hashing.php`) to ensure strong password encryption.

3. Rate Limiting
- Implemented rate limiting using Laravel’s RateLimiter.
- Login attempts are limited to 3 failed tries before being temporarily disabled to prevent brute force attacks.

---
Assignment 1

Authentication Input Validation
- Implemented **Form Request validation** for the **Login** and **Register** pages.
- Enforced **regex validation rules**:
  - Names only accept alphabets (`A-Z`, `a-z`).
- Custom `FormRequest` classes used:
  - `StoreUserRequest`
  - `LoginUserRequest`

User Profile Features
- Added support to update:
  - Nickname
  - Email
  - Phone number
  - City
  - Password
  - Avatar/Profile picture (with file upload)
- Added option to **delete account** completely.

---

Files Modified or Added

Model (`app/Models/User.php`)
- **New fillable fields** added:
  - `nickname`
  - `phone`
  - `city`
  - `avatar`

---

Controllers (`app/Http/Controllers/`)
| File | Enhancements |
|------|--------------|
| `Auth/RegisterController.php` | Uses `StoreUserRequest` for form validation and formatting `start_at`, `password` |
| `Auth/LoginController.php` | Uses `LoginUserRequest` for secure login validation |
| `ProfileController.php` *(new)* | Handles profile edit, update, avatar upload, and account deletion |
| `TodoController.php` | No major changes unless connected to profile logic |

---

Views (`resources/views/`)

Auth
- `auth/register.blade.php`
  - Added `@if($errors->any())` to display validation messages.
  - Integrated custom input validation using Form Request.
  
- `auth/login.blade.php`
  - Same as register; added error feedback and form validation rules.

Profile
- `profile/edit.blade.php` *(new)*
  - Form to update nickname, email, phone, city, avatar, password.
  - Display current avatar and file upload field.
  - Added delete account form.

Layout
- Updated layout to show `nickname` instead of `name` in top-right user menu (if applicable).

---

Routes (`routes/web.php`)
- Added routes for:
  ```php
  Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.destroy');
