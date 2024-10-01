# 🐳 Docker + PHP 8.1 + MariaDB + Nginx + Symfony 6.1 Boilerplate

This project is a fork from [ger86/symfony-docker](https://github.com/ger86/symfony-docker). 

----

## Description

This is a complete stack for running Symfony 6.1 in Docker containers using `docker-compose`.

It is composed by 3 containers:

- `nginx`, acting as the webserver.
- `php`, the PHP-FPM container with the 8.1 version of PHP.
- `db` which is the MariaDB database container with a **MariaDB 10.8** image.


## Project setup

**Notice:** For this you'll need composer to be installed on your local machine.

If you want to use this project as a base template for your new project, 
simply initialize your project using:
    
    composer create-project opctim/symfony-docker <your new project directory name>

This will set everything up for you. You can have a look what it does post-install [here](https://github.com/opctim/symfony-docker/blob/master/post-create-project-cmd.sh)

## Manual Installation

Clone or download this repo instead of running composer create-project.


## Infrastructure setup

1. In your project root, run `docker-compose up -d`

2. You should work inside the `php` container.

3. Inside the `php` container, run `composer install` to install dependencies from `/var/www/symfony` folder.

4. Use the following value for the DATABASE_URL environment variable:

```
DATABASE_URL=mysql://root:your_db_password@db:3306/app_db?serverVersion=mariadb-10.8.2
```

You can change the database and nginx settings in the `.env` file at the root of the project. This file is meant to be tracked by git.
