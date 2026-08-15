# CodeIgniter Team Manager

> **Author:** Scott Greenhagen

A web application intended to manage the organization of leagues, teams, and players.

---

## Table of Contents

- **Introduction**
- **Description**
- **Installing CodeIgniter**
- **Configuration and Setup**
- **Using the Team Manager**
- **Copyright Information**

---

## Introduction

This README contains a description of the **Team Manager** application and instructions for setup.

---

## Description

The **Team Manager** is a web application built on the CodeIgniter framework, intended to manage the organization of teams and related records.

Teams consist of:

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
| **JavaScript ES6+** | Frontend events |
| **HTML** | Frontend presentation |
| **Docker** | Local development environment |
| **Composer** | Dependency management |
| **PHPUnit** | Automated testing |

---

## Installing CodeIgniter

The Team Manager assumes proper installation of:

- **PHP 8.3**
- **CodeIgniter MVC Framework 4.7**

CodeIgniter is available at no cost from the CodeIgniter website:

[CodeIgniter](http://codeigniter.com/)

For more information on installing and setting up CodeIgniter, see the CodeIgniter user guide:

[CodeIgniter User Guide](http://codeigniter.com/user_guide/)

---

## Configuration and Setup

### Development Environment

Docker files are available in the root directory to assist with setting up a runtime environment.

**Composer** is used as the dependency manager.

### Database

The Team Manager utilizes a relational **MySQL** database to store records.

A `.env.example` file is provided for setting environment variables. Rename it to `.env` and configure your database connection parameters:

```text
codeigniter-team-manager/.env
```

### Database Setup

A `team_mgr.sql` SQL file is provided for easy database setup.

Run the SQL file to:

1. Create the necessary database tables
2. Import sample data

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

## Copyright Information

Copyright 2011 (version 1 build with CodeIgniter 2)  
Updated 2026 (version 2 build with CodeIgniter 4)

**Scott Greenhagen**
