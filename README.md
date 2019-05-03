# isu-textbook-marketplace
PHP project that was done for System Development Course.

Tools used:
  - php 4
  - Bootstrap 3
  - MySQL (myPHPadmin)
  - sendMail (email service)
  - jQuery (part of bootstrap)
  
 Project TimeSpan:
  - 2-3 weeks.  Refactoring would be the next step before production.
  
  
PROJECT SETUP:
-------------
  
To get the project running locally, you must have the following installed:

- XAMPP

1. Make sure that the php.ini, and the sendmail.ini from this folder get placed in the correct place in your XAMPP directory.
  1. php.ini overrides ..xampp/php/php.ini
  2. sendmail.ini overrides ..xampp/sendmail/sendmail.ini

2. Upzip the isu_tb_mp.zip folder into ..xampp/htdocs/isu_tb_mp
3. Open XAMPP Control Panel and Start Apache and MySQL
4. Import Database
  4.1 Click MySQL Admin, once on the Admin page, create a new database called isu_tb_mp
  4.2 Click on the newly created database, On the top Nav bar, click Import
  4.3 Choose the isu_tb_mp.sql file to import, click Go
5. in the browser, go to http://localhost/isu_tb_mp/login.php

You can now use the website.
  
