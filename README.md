# ticket-it-laravel

# Ticketit - Laravel Support Ticket System

A Laravel app with dual authentication support for both staff members (Users) and customers. This app is designed to handle support tickets between customers and staff members efficiently, while making use of the ticketit package .

## Features

- Dual authentication system (Staff/Customers)
- Auto-assignment of agents
- Ticket categories and priorities
- Custom permission system
- Configurable settings

## Requirements

- PHP 7.1.3 or higher
- Laravel 5.8 or higher
- MySQL 

## Installation

1. Clone the Repo:
```bash
git clone 
cd 
```

2. Configure your .env file with the database credentials:
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

```

3. Install ticketit package
```bash
composer require ticket/ticketit
```

4. Publish package resources:
```bash
php artisan vendor:publish --provider="Ticket\Ticketit\TicketitServiceProvider" --tag=ticketit-config

# Publish migrations 
php artisan vendor:publish --provider="Ticket\Ticketit\TicketitServiceProvider" --tag=ticketit-migrations

# Publish routes
php artisan vendor:publish --provider="Ticket\Ticketit\TicketitServiceProvider" --tag=ticketit-routes

# Publish views
php artisan vendor:publish --provider="Ticket\Ticketit\TicketitServiceProvider" --tag=ticketit-views --force


# Publish all assets (views, translations, public files, config)
php artisan vendor:publish --provider="Ticket\Ticketit\TicketitServiceProvider" --tag=ticketit-assets


```

5. Run the migrations:
```bash
php artisan migrate
```

6. Start development server:
```bash
php artisan serve
```


## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
