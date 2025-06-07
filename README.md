This will be a short guide to get the project running as a local server:
This platform requires having php, composer, a database server and NodeJS installed.
With all of this installed, you need to execute in the backend the command: composer install
Create a copy of the .env.example file and change it to .env 
After this, create the database and edit the database configuration in the .env file
Execute the command: php artisan migrate --seed to create the database tables and an example of data
In the frontend folder, execute the command npm run dev
In the backend folder, execute the command php artisan serve
The project is running in the port you have defined for npm
