
====== PROJECT EXPLANATION ======

- Simple image gallery made with PHP and Zend Framework
- An user can view the image clicking on it, and download cliking on Download Button.

---> REQUERIMENTS

- PHP 5.6
- Apache
- MySQL: Create table database: "image_gallery". Create table named: "images"

---> DETAILS ABOUT THE PROJECT

- Project structure based on MVC. Basic structure of Models and Controllers was created with Zend Frameworks tools with this proposit.
- IndexController.php: It's the main controller, with a main function to call another specific function to View, upload, or download image depending on the data received in $_POST.
- Models/DBTable/Image.php: Basic model that allows insert new image on database. Specific methods to update "Views" and "Downloads" fields values.
- Extensions supported: .jpeg, .png


---> MORE INFO

- Unsuccessful deployment intent of a docker image on Heroku platform:
