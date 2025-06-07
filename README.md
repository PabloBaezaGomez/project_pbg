# Setup Guide

This short guide will help you get the project running as a local server.

## Requirements

The following tools are required to execute the program:

- [PHP](https://www.php.net/)
- [Composer](https://getcomposer.org/)
- A MySQL database server
- [Node.js & npm](https://nodejs.org/)

---

## Backend Setup

1. Open a terminal in the backend folder.  
2. Install PHP dependencies:

   ```bash
   composer install
3. Copy the example environment file and rename it:
    ```bash
    cp .env.example .env
4. Create your database manually in the server.
5. Open the .env file and update the database configuration.
6. Run migrations and seed example data:
     ```bash
     php artisan migrate --seed
7. Start the backend development server:
     ```bash
     php artisan serve

## Frontend Setup

1. Navigate to the frontend folder.
2. Start the development server:
    ```bash
    npm run dev
