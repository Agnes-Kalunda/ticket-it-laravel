# Ticketit Laravel Implementation

A Laravel application implementing the Ticketit package for customer support ticket management.

## Features

- Dual authentication (Staff/Customer portals)
- Ticket management system
- Role-based permissions (Admin/Agent/Customer)
- Dashboard for both staff and customers
- Both customers and assigned agents can leave comments under tickets.


## Requirements

- PHP 7.1.3
- Laravel 5.8
- MySQL
- Composer

## Installation & Setup

1. Clone the repository:
```bash
git clone https://github.com/Agnes-Kalunda/ticket-it-laravel.git
cd ticketit-laravel
```

2. Install dependencies:
```bash
composer install
```


3. Configure database in `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ticketit_laravel
DB_USERNAME=root
DB_PASSWORD=
```

4. Generate application key:
```bash
php artisan key:generate
```

5. Run migrations:
```bash
php artisan migrate
```

6. Install ticketit package
```bash
composer require ticket/ticketit
```

7. Publish Assets/View/Migrations/Routes
```bash
php artisan vendor:publish --provider="Ticket\Ticketit\TicketitServiceProvider" --tag=ticketit-views --force

php artisan vendor:publish --provider="Ticket\Ticketit\TicketitServiceProvider" --tag=ticketit-routes --force

php artisan vendor:publish --provider="Ticket\Ticketit\TicketitServiceProvider" --tag=ticketit-migrations --force

php artisan vendor:publish --provider="Ticket\Ticketit\TicketitServiceProvider" --tag=ticketit-config --force

```

8. Run Migrations
```bash
php artisan migrate
```

## Authentication Setup

### User Model (`app/User.php`):
```php
use Ticket\Ticketit\Traits\HasTickets;

class User extends Authenticatable
{
    use HasTickets;

    protected $fillable = [
        'name', 'email', 'password', 'ticketit_admin', 'ticketit_agent'
    ];

    protected $casts = [
        'ticketit_admin' => 'boolean',
        'ticketit_agent' => 'boolean'
    ];
}
```

### Customer Model (`app/Customer.php`):
```php
use Ticket\Ticketit\Traits\HasTickets;

class Customer extends Authenticatable
{
    use HasTickets;

    protected $guard = 'customer';

    protected $fillable = [
        'name', 'email', 'password', 'username'
    ];
}
```

### Auth Configuration (`config/auth.php`):
```php
return [
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'customer' => [
            'driver' => 'session',
            'provider' => 'customers',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],
        'customers' => [
            'driver' => 'eloquent',
            'model' => App\Customer::class,
        ],
    ],
];
```

## Routes Structure

### Customer Routes (`routes/web.php`):
```php
Route::group(['middleware' => ['web', 'auth:customer'], 'prefix' => 'customer'], function () {
    Route::get('/dashboard', 'Customer\DashboardController@index')->name('customer.dashboard');
    Route::get('/profile', 'Customer\ProfileController@show')->name('customer.profile');
});
```

### Staff Routes (`routes/web.php`):
```php
Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'staff'], function () {
    Route::get('/dashboard', 'Staff\DashboardController@index')->name('staff.dashboard');
    Route::get('/profile', 'Staff\ProfileController@show')->name('staff.profile');
});
```


## Usage

### Running the Application
```bash
php artisan serve
```

### Test the app

Staff:
- Since there is no registration form for the Users, use Tinker to create an Admin User, who will help create/manage/assign roles to other users.

```bash
php artisan tinker


$user = new \App\User;
$user->name = 'John Doe';
$user->email = 'johndoe@example.com';
$user->password = bcrypt('password123');
$user->ticketit_admin = true; 
$user->ticketit_agent = false; 
$user->save();

```

Customer:
- Register as a customer and submit your tickets for management by the users.


## Troubleshooting

1. Clear caches after updates:
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

2. Regenerate autoload files:
```bash
composer dump-autoload
```

## License

The MIT License (MIT). See [License File](LICENSE.md).