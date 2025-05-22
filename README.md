All the codes are in Master branch

Laravel To-Do App ( Input Validation and Profile Page )

This is a Laravel-based To-Do application with user authentication and enhanced profile management features. Below are the enhancements and modifications made across the MVC structure of Laravel (Model, View, Controller).

---

Assignment 3
# Features
- **User Roles**: Users are assigned roles (`admin` or `user`) stored in the `user_roles` table.
- **Role Permissions**: Each role has specific permissions (e.g., `Create`, `Retrieve`, `Update`, `Delete`) stored in the `role_permissions` table.
- **RBAC Enforcement**: Buttons and actions in the UI are shown or hidden based on the user's permissions.
- **Admin Dashboard**: Admins can manage users, activate/deactivate accounts, and view To-Do tasks created by each user.

---

## Database Schema

### 1. `user_roles` Table
This table stores the roles assigned to users.

| Column       | Type         | Description                     |
|--------------|--------------|---------------------------------|
| `RoleID`     | Primary Key  | Unique identifier for the role. |
| `UserID`     | Foreign Key  | Links to the `users` table.     |
| `RoleName`   | String       | Name of the role (e.g., `admin`, `user`). |
| `Description`| String       | Optional description of the role. |

### 2. `role_permissions` Table
This table stores the permissions associated with each role.

| Column         | Type         | Description                     |
|----------------|--------------|---------------------------------|
| `PermissionID` | Primary Key  | Unique identifier for the permission. |
| `RoleID`       | Foreign Key  | Links to the `user_roles` table. |
| `Description`  | String       | Permission type (e.g., `Create`, `Retrieve`, `Update`, `Delete`). |

---

## RBAC Implementation

### 1. Middleware for Role Checking
The `RoleMiddleware` ensures that only users with the correct role can access specific routes.

```php
// filepath: app/Http/Middleware/RoleMiddleware.php
public function handle($request, Closure $next, $role)
{
    if (!Auth::check() || Auth::user()->role !== $role) {
        return redirect('/'); // Redirect unauthorized users
    }
    return $next($request);
}
```

### 2. Route Protection
Routes are grouped and protected using the `auth` and `role` middleware.

```php
// filepath: routes/web.php
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::resource('/todo', TodoController::class);
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
});
```

---

## Authorization Logic

### 1. Controller Logic
The `TodoController` passes the user's permissions to the Blade view.

```php
// filepath: app/Http/Controllers/TodoController.php
public function index()
{
    $user = auth()->user();
    $permissions = $user->role->permissions->pluck('Description')->toArray();
    $todos = Todo::where('user_id', $user->id)->get();

    return view('todo.index', compact('todos', 'permissions'));
}
```

### 2. Blade View Logic
The `index.blade.php` file shows or hides buttons based on the user's permissions.

```php
// filepath: resources/views/todo/index.blade.php
@if(in_array('Create', $permissions))
    <a href="{{ route('todo.create') }}" class="btn btn-primary">New List</a>
@endif

@foreach($todos as $todo)
    @if(in_array('Update', $permissions))
        <a href="{{ route('todo.edit', $todo) }}" class="btn btn-warning">Edit</a>
    @endif

    @if(in_array('Delete', $permissions))
        <form action="{{ route('todo.destroy', $todo) }}" method="POST">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Delete</button>
        </form>
    @endif
@endforeach
```

---

## Blade Views

### 1. `index.blade.php`
Displays the list of To-Do items and enforces RBAC for buttons.

### 2. `add.blade.php`
Form for creating a new To-Do item.

```php
// filepath: resources/views/todo/add.blade.php
<form action="{{ route('todo.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" class="form-control" id="title" name="title">
    </div>
    <div class="form-group">
        <label for="description">Description:</label>
        <textarea name="description" class="form-control" id="description"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
```

---

## Testing RBAC

1. **Assign Roles and Permissions**:
   - Assign roles (`admin`, `user`) to users in the `user_roles` table.
   - Assign permissions (`Create`, `Retrieve`, `Update`, `Delete`) to roles in the `role_permissions` table.

2. **Login as a User**:
   - Test with a user who has limited permissions (e.g., only `Create`).
   - Verify that only the "New List" button is visible.

3. **Login as an Admin**:
   - Test with an admin user who has full permissions.
   - Verify that all buttons (Create, Edit, Delete) are visible.




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
