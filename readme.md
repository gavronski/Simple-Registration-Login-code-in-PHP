OOP PHP , MySQl , HTML ,CSS
___
## PHP registration/login form which saves and reads users data using PDO. 


___
# Instalation 
1. Create a table with columns id,login,password,email,time in phpMyAdmin.
2. Insert your database configurations in config.php file.
___

# Files

* ## index.php
This script displays the registration form. 
When the user submits the filled form, the script calls out methods to initialize databese seetings and passes data.



* ## Controller.php 
This script contains the main class that controlls : database configuration,data receiving and validation from login.php form,
data receiving from registration form, layout of page.

* ## View.php
Displays index.html layout.

* ## index.html
Contains main registration form.

* ## Database.php

This script connects to database,inserts and returns data.

* ## config.php 
Returns database configuration which are required by PDO.

* ## login.php
The user can login through the login page. If login is successful(matched email and password),page shows user's login.
If inputs are not matched to data,the page shows propper informations.

* ## pages.php
Sets and gets page and message depends on login form inputs.

* ## Monit.php 
Displays information referenced to passed email and password in login.php.

* ## messagge.php
Displays main heading.
