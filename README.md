
# DigitalTolk Exam

This project is built with **Laravel 8** and requires **PHP 7.4**.

## Setup Instructions

Clone the repository:
```bash
git clone https://github.com/jmicarus12/digitaltolk-test-bacalla.git
cd digitaltolk-test-bacalla
```

Install dependencies:
```bash
composer Install
```

Configure your environment:
```bash
cp .env.example .env
php artisan key:generate
```
Update your .env file with your database credentials and other settings.
Run database migrations:
```bash
php artisan migrate
```

Seed the database:

```bash
php artisan db:seed
```

Before deploying, you can run:
```bash
php artisan optimize
```

Run Test:
```bash
php artisan test
```