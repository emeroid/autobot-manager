#!/bin/bash

# Start Laravel's PHP server
php artisan serve &

# Start Vite or Webpack for Laravel frontend
npm run dev &

# Start Laravel Echo server
laravel-echo-server start &

# Start Laravel's Queue Worker
php artisan queue:work &
