# Laravel Team Manager

> **Author:** Scott Greenhagen

The **Team Manager** is a web application built on the Laravel PHP framework, intended to manage the organization of related leagues, teams, and players.

---

## Table of Contents

- **Introduction**
- **Description**
- **Laravel**
- **Configuration and Setup**
- **Using the Team Manager**
- **Running Pest Test Suites**
- **Copyright Information**

---

## Introduction

This README contains a description of the **Team Manager** application and instructions for setup.
This application runs the bundled Laravel framework on PHP.

---

## Description

**Team Manager** objects consist of:

- Leagues
- Teams
- Players

### Public Screens

Public screens are available to view:

- A list of leagues, teams, and players
- The details of each individual group

### Administrative Screens

Administrative screens are available to:

- View a list of leagues, teams, and players
- Manage individual groups

### Tech Stack

| Technology | Purpose |
|---|---|
| **PHP** | Foundation |
| **Laravel** | Backend PHP framework |
| **MySQL** | Database |
| **TypeScript/JavaScript** | Frontend events |
| **HTML5** | Frontend presentation |
| **Docker** | Local development environment |
| **Composer** | Dependency management |
| **Pest** | Automated testing |

---

## Laravel

The Team Manager requires proper installation of the following:

- **PHP 8.4**
- **MySQL 8.0**
- **Laravel MVC Framework 13 (bundled)**

Docker files are available for PHP and MySQL. Laravel is available at no cost from the official website:

[Laravel](https://laravel.com/)

For more information on configuration settings for Laravel, see the Laravel user guide:

[Laravel User Guide](https://laravel.com/framework/docs)

---

## Configuration and Setup

### Development Environment

Docker files are available in the root directory to assist with setting up a runtime environment.
A `.env.example` file is provided for setting environment variables. Copy/rename it to `.env`:

```bash
cd laravel-team-manager
cp .env.example .env
```

Then fill in the blanks in your new .env file.

**Composer** is used as the dependency manager. Run composer install to retrieve dependencies:

```bash
cd laravel-team-manager
composer install
```

Run the Docker built step:

```bash
cd laravel-team-manager
docker compose up --build -d
```

### Database

The Team Manager utilizes a relational **MySQL** database to store records.
Configure your database connection parameters in the .env file you copied above.

### Database Setup

Automated database migration scripts are provided for easy database setup. 
Run Laravel database migrations to migrate starter table structures through Docker server:

```bash
docker compose exec server php artisan migrate
```

Seed the database with sample data, using provided database seeder and factories:

```bash
docker compose exec server php artisan db:seed
```

The Team Manager app should then be available at http://localhost:9003/ in your web browser.

---

## Using the Team Manager

From the main index page, you can select from the following screens:

1. **View Leagues**
2. **View Teams**
3. **View Players**
4. **Manage Leagues**
5. **Manage Teams**
6. **Manage Players**

### Navigation

Global navigation is provided at the top of every page.

Click the **Team Manager** title in the top-left corner to return to the home page.

### Public Viewing Screens

On the public viewing screens:

- The group listing provides an overview of that group.
- Click the name of a group to view its details.
- Leagues do not have additional column information, so there are no further details to view.

### Administrative Management

The administrative management pages provide the following options:

1. **Add New Item**
2. **Edit Item**
3. **Delete Item**

---

## Running Pest Test Suites

The included Pest test suites are located in the `tests` directory.

From the `laravel-team-manager` directory, run all available tests via Laravel Artisan console command:

```bash
cd laravel-team-manager
docker compose exec server php artisan test
```

Alternatively, run the following Pest tests directly through Docker:

```bash
cd laravel-team-manager
docker compose exec server ./vendor/bin/pest
```

### Code Coverage

The provided Docker configuration also includes the **PCOV** code coverage client.

To run all tests and display the PCOV coverage report:

```bash
cd laravel-team-manager
docker compose exec server php artisan test --coverage
```

### Refreshing the Database after Testing

At the conclusion of testing, you may wish to refresh the database and roll back to its original state. 
This command will rerun all database seeds and factories to repopulate the migration database tables:

```bash
docker compose exec server php artisan migrate:refresh --seed
```

---

## Copyright Information

Copyright 2026 (built with Laravel 13)  

**Scott Greenhagen**
