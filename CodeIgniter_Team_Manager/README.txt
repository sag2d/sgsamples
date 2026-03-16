===============================
Team Manager README
Author: Scott Greenhagen
===============================

===============================
Table of Contents
===============================

I. Introduction

II. Description

III. Installing CodeIgniter

IV. Configuration and Setup

V. Using the Team Manager

VI. Copyright Information

===============================

-------------------------------
I. Introduction
-------------------------------

This README file contains a description of the Team Manager application and instructions for setup.

-------------------------------
II. Description
-------------------------------

The Team Manager is a web application intended to manage the organization of teams.
Teams consist of leagues, teams, and players. 

Public screens are available to view a list of these groups and the details of each individual group.

Administrative screens are available to view a list of these groups and manage the individual groups.
(Note: Administrative management screens are openly available for demonstration purposes only. 
       These capabilities would normally require a login.)
       
-------------------------------
III. Installing CodeIgniter
-------------------------------

The Team Manager assumes proper installation of PHP 5.1 and the CodeIgniter MVC framework 2.0.2, which
is available at no cost from the CodeIgniter website:
http://codeigniter.com/

For more information on installing and setting up CodeIgniter, please see
the CodeIgniter user guide:
http://codeigniter.com/user_guide/

-------------------------------
IV. Configuration and Setup
-------------------------------

The Team Manager utilizes a relational MySQL database to store the records.
The connection login parameters will need to be changed to work with your 
database. The following file is where you set this:
"Team_Manager/config/database.php"

A SQL file has been provided for easy setup of the database. Simply run the SQL file to
create the necessary database tables and import sample data.

If you use anything other than the default directory structure, you will need
to modify the system and application folder names, located in the main index file.

If you wish to run the application on a web server, rather than locally,
you will need to change the "base_url" variable in this file to match your domain:
"Team_Manager/config/config.php"

-------------------------------
V. Using the Team Manager
-------------------------------

From the main index page, you can select from the following screens:

1. View Leagues
2. View Teams
3. View Players
4. Manage Leagues
5. Manage Teams
6. Manage Players

A global navigation is also provided at the top of every page. Click on the
"Team Manager" title in the top left corner to return to the home page.

On the public viewing screens, the group listing provides an overview of that group.
The details of each group can be viewed by clicking on the name of the group.
(Note: Leagues do not have extra column information, so there are no further details to view.)

On the administrative management pages, the following options are available:

1. Add New Group
2. Edit Group
3. Delete Group

The database ID is also provided on the group listing for administrators.

-------------------------------
VI. Copyright Information
-------------------------------

Copyright 2011
Scott Greenhagen
