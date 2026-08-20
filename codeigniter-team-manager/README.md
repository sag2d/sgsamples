# CodeIgniter Team Manager

> **Author:** Scott Greenhagen

The **CodeIgniter Team Manager** is a web application built on the CodeIgniter PHP framework, intended to manage the organization of related leagues, teams, and players.

---

## Table of Contents

- **Introduction**
- **Description**
- **CodeIgniter**
- **Configuration and Setup**
- **Using the Team Manager**
- **Running PHPUnit Test Suites**
- **Copyright Information**

---

## Introduction

This README contains a description of the **Team Manager** application and instructions for setup.
This application runs the bundled CodeIgniter framework on PHP.

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

> **Note:** Administrative management screens are openly available for demonstration purposes only. These capabilities would normally require a login.

### Tech Stack

| Technology | Purpose |
|---|---|
| **PHP** | Foundation |
| **CodeIgniter** | Backend PHP framework |
| **MySQL** | Database |
| **TypeScript/JavaScript** | Frontend events |
| **HTML5** | Frontend presentation |
| **Docker** | Local development environment |
| **Composer** | Dependency management |
| **PHPUnit** | Automated testing |

---

## CodeIgniter

The Team Manager requires proper installation of the following:

- **PHP 8.3**
- **MySQL 8.0**
- **CodeIgniter MVC Framework 4.7 (bundled)**

Docker files are available for PHP and MySQL. CodeIgniter is available at no cost from the official website:

[CodeIgniter](http://codeigniter.com/)

For more information on configuration settings for CodeIgniter, see the CodeIgniter user guide:

[CodeIgniter User Guide](http://codeigniter.com/user_guide/)

---

## Configuration and Setup

### Development Environment

Docker files are available in the root directory to assist with setting up a runtime environment.
A `.env.example` file is provided for setting environment variables. Copy/rename it to `.env`:

```bash
cd codeigniter-team-manager
cp .env.example .env
```

Then fill in the blanks in your new .env file.

**Composer** is used as the dependency manager. From the `codeigniter-team-manager` directory, 
run composer install to retrieve dependencies:

```bash
composer install
```

From the `codeigniter-team-manager` directory, run the Docker build step:

```bash
docker compose up --build -d
```

### Database

The Team Manager utilizes a relational **MySQL** database to store records.
Configure your database connection parameters in the .env file you copied above.

### Database Setup

A `team_mgr.sql` SQL file is provided for easy database setup. Run the SQL file to create the necessary database tables and import sample data. Replace `[MYSQL_ROOT_PASSWORD]` with the MySQL password you set:

```bash
docker compose exec -T db mysql -u root -p"[MYSQL_ROOT_PASSWORD]" team_mgr < team_mgr.sql
```

The Team Manager app should then be available at http://localhost:9001/ in your web browser.

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

> **Note:** Administrative management screens are openly available for demonstration purposes only. These capabilities would normally require a login.

---

## Running PHPUnit Test Suites

The included PHPUnit test suites are located in the `tests` directory.

From the `codeigniter-team-manager` directory, run the following through Docker:

```bash
docker compose exec server ./vendor/bin/phpunit --configuration phpunit.xml tests
```

### Code Coverage

The provided Docker configuration also includes the **PCOV** code coverage client.

From the `codeigniter-team-manager` directory, run all tests and display the PCOV coverage report:

```bash
docker compose exec server ./vendor/bin/phpunit --configuration phpunit.xml --coverage-text tests
```

---

## Copyright Information

Copyright 2011 (version 1 build with CodeIgniter 2)  
Updated 2026 (version 2 build with CodeIgniter 4)

**Scott Greenhagen**
