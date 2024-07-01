# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/10.x/installation)

Alternative installation is possible without local dependencies relying on [Docker](#docker). 

Clone the repository

    git clone https://github.com/mdnurulmomen/wall-street-doc.git

Switch to the repo folder

    cd wall-street-doc

Install all the dependencies using composer

    composer install

Install node dependencies using npm

    npm install
    npm run dev

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Install the PHP extension for MongoDB. Run the following command (*Optioal*):

```
sudo pecl install mongodb
```

**You will also need to ensure that the mongodb extension is enabled in your php.ini file.**

Now, Run the database migrations.
(**Before migration, make sure MongoDB connection is configured**)

    php artisan migrate

Start the local development server and you're done

    php artisan serve

You can now access the server at http://localhost:8000/register for new user registration

----------

# Code overview

## Dependencies

- [laravel/breeze](https://laravel.com/docs/10.x/starter-kits#laravel-breeze) - For authentication features.
- [mongodb/laravel-mongodb](https://www.mongodb.com/docs/drivers/php/laravel-mongodb/current/) - To work with MongoDB data.

## Folders

- `app` - Contains all the Eloquent models
- `app/Http/Controllers/Admin` - Contains controllers for Admin
- `app/Http/Middleware` - Contains the JWT auth middleware
- `app/Http/Requests` - Contains all the form-requests
- `config` - Contains all the application configuration files
- `database/factories` - Contains the model factory for all the models
- `database/migrations` - Contains all the database migrations
- `database/seeders` - Contains the database seeder
- `routes` - Contains all the api routes defined in api.php file
- `tests` - Contains all the application tests

## Environment variables

- `.env` - Environment variables can be set in this file

***Note*** : You can quickly set the database information and other variables in these files and have the application fully working.

----------

# Testing Application

Run the laravel development server

    php artisan serve

Refresh the database migrations 
(**Make sure MongoDB connection is configured**)

    php artisan migrate:refresh

Application can now be tested with following command

```
    php artisan test
```
