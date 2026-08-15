# Vehicles OOP Demo

> **Author:** Scott Greenhagen

A PHP command-line project designed to demonstrate core object-oriented programming concepts through a set of vehicle classes.

---

## Table of Contents

- **Introduction**
- **Description**
- **Running the Vehicles OOP Demo**
- **Running PHPUnit Test Suites**
- **Copyright Information**

---

## Introduction

This README contains a description of the **Vehicles OOP Demo** project and instructions for running it.

The project was designed to help train junior developers in learning PHP.

---

## Description

The **Vehicles OOP Demo** project is a collection of classes and a command-line interface (CLI) script intended to demonstrate PHP object-oriented concepts.

Various types of vehicles are implemented as child classes that inherit properties and functions from the parent classes they extend.

### Object-Oriented Concepts

The project demonstrates:

- **Encapsulation**
- **Inheritance**
- **Abstraction**
- **Polymorphism**

It contains the following PHP class types and structures:

- Standard concrete classes
- Abstract class
- Interface
- Trait
- Enum
- Static class

### Tech Stack

| Technology | Purpose |
|---|---|
| **PHP** | Vanilla PHP — no framework |
| **Docker** | Local development environment |
| **PHPUnit** | Automated testing |

---

## Running the Vehicles OOP Demo

The demo can be run using any modern version of PHP.

From a command-line interface, navigate to the `vehicles-oop-demo` directory and run:

```bash
php vehicles_run.php
```

### Running with Docker

Docker configuration files are provided for running the project within the specified **PHP 8.5** environment.

Replace `[SERVER_NAME]` with your Docker server/container name:

```bash
docker exec -it [SERVER_NAME] php vehicles_run.php
```

---

## Running PHPUnit Test Suites

The included PHPUnit test suites are located in the `tests` directory.

From the `vehicles-oop-demo` directory, run:

```bash
./vendor/phpunit --configuration phpunit.xml tests
```

### Running PHPUnit with Docker

Alternatively, run the PHPUnit test suite from within the Docker environment:

```bash
docker compose exec server ./vendor/phpunit --configuration phpunit.xml tests
```

### Code Coverage

The provided Docker configuration also includes the **PCOV** code coverage client.

To run all tests and display the PCOV coverage report:

```bash
docker compose exec server ./vendor/phpunit --configuration phpunit.xml --coverage-text tests
```

---

## © Copyright Information

Copyright Scott Greenhagen
