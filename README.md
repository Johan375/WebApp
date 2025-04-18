All the codes are in Master branch.

Laravel To-Do App ( Input Validation and Profile Page )

This is a Laravel-based To-Do application with user authentication and enhanced profile management features. Below are the enhancements and modifications made across the MVC structure of Laravel (Model, View, Controller).

---

Enhancements 

### ✅ Authentication Input Validation
- Implemented **Form Request validation** for the **Login** and **Register** pages.
- Enforced **regex validation rules**:
  - Names only accept alphabets (`A-Z`, `a-z`).
- Custom `FormRequest` classes used:
  - `StoreUserRequest`
  - `LoginUserRequest`

### ✅ User Profile Features
- Added support to update:
  - Nickname
  - Email
  - Phone number
  - City
  - Password
  - Avatar/Profile picture (with file upload)
- Added option to **delete account** completely.

---

## 📁 Files Modified or Added

### 🧠 Model (`app/Models/User.php`)
- **New fillable fields** added:
  - `nickname`
  - `phone`
  - `city`
  - `avatar`

---

### 🎮 Controllers (`app/Http/Controllers/`)
| File | Enhancements |
|------|--------------|
| `Auth/RegisterController.php` | Uses `StoreUserRequest` for form validation and formatting `start_at`, `password` |
| `Auth/LoginController.php` | Uses `LoginUserRequest` for secure login validation |
| `ProfileController.php` *(new)* | Handles profile edit, update, avatar upload, and account deletion |
| `TodoController.php` | No major changes unless connected to profile logic |

---

### 📄 Views (`resources/views/`)

#### Auth
- `auth/register.blade.php`
  - Added `@if($errors->any())` to display validation messages.
  - Integrated custom input validation using Form Request.
  
- `auth/login.blade.php`
  - Same as register; added error feedback and form validation rules.

#### Profile
- `profile/edit.blade.php` *(new)*
  - Form to update nickname, email, phone, city, avatar, password.
  - Display current avatar and file upload field.
  - Added delete account form.

#### Layout
- Updated layout to show `nickname` instead of `name` in top-right user menu (if applicable).

---

### 🌐 Routes (`routes/web.php`)
- Added routes for:
  ```php
  Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.destroy');
