===============================
Vehicles OOP Demo README
Author: Scott Greenhagen
===============================

===============================
Table of Contents
===============================

I. Introduction

II. Description

III. Running the Vehicles OOP Demo

IV. Running PHPUnit Test Suites

V. Copyright Information

===============================

-------------------------------
I. Introduction
-------------------------------

This README file contains a description of the Vehicles OOP Demo project, and instructions to run it.
I designed this project to help train junior developers in learning PHP.

-------------------------------
II. Description
-------------------------------

The Vehicles OOP Demo project is a set of classes and a command-line interface (CLI) script intended to 
demonstrate PHP object-oriented concepts. The various types of vehicles (child classes) inherit properties 
and functions from the parent classes they extend. 

It demonstrates the object-oriented concepts of encapsulation, inheritance, abstraction, and polymorphism.
Contains the following PHP class types and structures: 
standard concrete classes, an abstract class, an interface, a trait, an enum, and a static class.

-------------------------------
III. Running the Vehicles OOP Demo
-------------------------------

See the demo in action by running the primary PHP CLI script as described below with any modern version of PHP.
From a command-line interface, navigate to the "vehicles-oop-demo" directory, and run the PHP script as follows:
php vehicles_run.php

Alternatively, Docker configuration files are provided to run within the specified PHP 8.5 environment.
Run the PHP script from within a Docker environment by adding your server name in the following command:
docker exec -it [SERVER_NAME] php vehicles_run.php

-------------------------------
IV. Running PHPUnit Test Suites
-------------------------------

To run the included PHPUnit test suites in the "tests" directory from a command-line interface, 
navigate to the "vehicles-oop-demo" directory, and enter the following command:
./vendor/phpunit --configuration phpunit.xml tests

Alternatively, run PHPUnit from within a Docker environment:
docker compose exec server ./vendor/phpunit --configuration phpunit.xml tests

The provided Docker configuration files also includes the PCOV code coverage client. 
Display PCOV code coverage report and run all tests as follows:
docker compose exec server ./vendor/phpunit --configuration phpunit.xml --coverage-text tests

-------------------------------
V. Copyright Information
-------------------------------

Copyright Scott Greenhagen
