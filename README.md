<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Vuelos App

App para reservas de vuelos

## Requirements 
 - PHP >= 8 
 - Composer >= 2
 - MySql
 - SQLite (for testing db)
 - Nodejs >= 16 (frontend builds)

## Installation

Copy repository
```bash
git clone https://github.com/PedGarblue/vuelos.git
```

Install dependencies
```bash
composer install
```

Install node dependencies
```bash
npm install
```

Create .env file
```bash
cp .env.example .env
```

Generate key
```bash
php artisan key:generate
```

Create database and configure .env file

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=[YOU DATABASE NAME]
DB_USERNAME=[YOU DATABASE USERNAME]
DB_PASSWORD=[YOU DATABASE PASSWORD]
```

Migrate database
```bash
php artisan migrate
php artisan db:seed
```
Run tests
```bash
php artisan test
```

Build frontend
```bash
npm run dev
```

Run server
```bash
php artisan serve
```
