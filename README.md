# Installation

To install PHP and Laravel dependecies:
```bash
composer install
```

And node dependencies:
```bash
npm install
```

Clone .env.example as .env, then use your local settings for DB connection and generate app-key with
```bash
php artisan key:generate
```

Run migrations and seed the database with
```bash
php artisan migrate --seed
```

# Run locally

To run the application, use the following commands in separate terminal windows:
```bash
php artisan serve
```
```bash
npm run dev
```

The application will be accessible at `http://localhost:8000`.

Access route '/' for home page of the e-shop, '/admin' for admin panel (login required). Admin user is created by the seeder with email and password defined in env file.