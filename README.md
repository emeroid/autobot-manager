
# Autobot Manager

Autobot Manager makes a background process that automatically creates 500 new unique Autobots every
hour in a background.

## Prerequisites

- PHP >= 8.0
- Composer
- Node.js & npm
- MySQL
- Redis (for queue management)
- Laravel Echo Server (for real-time event broadcasting)

## Setup Instructions

### 1. Clone the Repository

```bash
git clone https://github.com/emeroid/autobot-manager.git
cd autobot-manager
```

### 2. Install PHP Dependencies

Make sure you have [Composer](https://getcomposer.org/) installed, then run:

```bash
composer install
```

### 3. Install Node.js Dependencies

Make sure you have [Node.js](https://nodejs.org/en/) and npm installed, then run:

```bash
npm install
```

### 4. Setup Environment Variables

Copy the `.env.example` file to `.env` and adjust the settings according to your environment:

```bash
cp .env.example .env
```

**Update the following in `.env`:**
- Database credentials (DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD)
- Redis credentials
- Pusher or Laravel Echo Server settings (for real-time features)
- API Base URLs (for external API integrations)
  
```bash
APP_NAME="Autobot Manager"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=autobot_manager
DB_USERNAME=your_user
DB_PASSWORD=your_password

# Redis Queue Settings
QUEUE_CONNECTION=redis
REDIS_CLIENT=predis

# Laravel Echo Server or Pusher settings
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=your_pusher_app_id
PUSHER_APP_KEY=your_pusher_app_key
PUSHER_APP_SECRET=your_pusher_app_secret
PUSHER_APP_CLUSTER=mt1
```

### 5. Generate Application Key

Run the following command to generate a new application key:

```bash
php artisan key:generate
```

### 6. Setup the Database

Make sure your database is running, then run the migrations:

```bash
php artisan migrate 
```

### 7. Start The laravel project

In your project root folder run this bash script to start the project:

```bash
 ./start_all.sh
```

### 8. Run the Autobot Creation Command

You can manually create Autobots with the following Artisan command:

```bash
php artisan autobots:create {autobots=500} {posts=10} {comments=10}
```

### 9 Developer API Documentation

This project uses [Swagger](https://swagger.io/) to document the API.

after running the project, just visit [Documentation](http://localhost:8000/api/documentation)


## Incase the Swagger API Documentation does not work

### Setup Swagger

1. Install Swagger dependencies via Composer:

   ```bash
   composer require darkaonline/l5-swagger
   ```

2. Publish the Swagger configuration file:

   ```bash
   php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
   ```

3. Add annotations to your API routes and controllers.

4. Generate Swagger documentation:

   ```bash
   php artisan l5-swagger:generate
   ```

5. Access the documentation in your browser:

   - Visit `http://localhost:8000/api/documentation` to view the Swagger UI.

### Viewing Documentation

You can view the API documentation generated by Swagger UI by accessing the `/api/documentation` route in your application:

```bash
http://localhost:8000/api/documentation
```

This will display a user-friendly interface where you can see all your API endpoints, parameters, and responses.
```