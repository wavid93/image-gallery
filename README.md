
====== PROJECT EXPLANATION ======

- Simple image gallery made with PHP and Zend Framework
- An user can view the image clicking on it, and download cliking on Download Button.

---> REQUERIMENTS

- PHP 5.6
- Apache
- MySQL: Create table database: "image_gallery". Create table named: "images". SQL QUERY can be found on application/config/dbcreatetablequery file.

---> PROJECT DETAILS

- Project structure based on MVC. Basic structure of Models and Controllers was created with Zend Framework tools with this purpose. Layout "redirect" to index view with HTML and CSS code.
- Controllers/IndexController.php: It's the main controller, with a main function to call another specific function to visualice, upload, or download image depending on the data received in $_POST. Controller send information to the view (views/scripts/index/index.phmtl)
- Models/DBTable/Image.php: Basic model that allows insert new image on database. Specific methods to update "Views" and "Downloads" fields values.
- Images are uploaded to public/uploads folder, with a reference (image name) saved in database
- Extensions supported: .jpeg, .png


---> MORE INFO

- Due to lack of time, I could not start the deployment of a docker image on HEROKU / AWS platforms (unexpected errors configuring docker-compose.yml)

---> SCREENSHOT

![alt text](http://oi64.tinypic.com/350jed4.jpg)
