# Notifications System


## Specification

Design a component responsible for notifying user of certain actions that may occur in some application. For example, 
in case of some CMS, site moderator should be notified after new comment is posted on some page. Similarly, 
administrator should be notified after some author create a article draft.

Implementation should be flexible and scalable in sense that various strategies for notifying user should be supported, 
for example through emails, SMS, push notifications and similar, depending on his/her contacting information. 
Notifications themselves should contain information about the action that has occurred (i.e. new comment) and their 
content should be customizable for every distinct sending strategy. For example:

Email:

+ subject: New comment has been posted
+ body: Dear moderator, new comment has been posted on your site on page “My blog post”. Go to comments panel and moderate it.

SMS:
+ text: New comment has been posted on page “My blog post”.

### Tips

Sketch out all classes and interfaces that are involved. Focus on abstraction and modeling, instead of concrete 
implementations. Purpose of this test is to examine your OOP skills, you don’t have to go deep in details. Use plain 
PHP, without frameworks.

### Sending solution

Upload your solution on GitHub and provide us link to your repository. Good luck!

Disclaimer: Your code will be used ONLY for evaluating your development skill set, and not for any other purpose.


## Installation

To install database and data required for test, do the following:

+ Find `app/config/databse.php` and change database connection parametres
+ In the root of the project, locate `install.php` and exectute it `php install.php`


## Databse Diagram

![Database-Diagram](http://ivanmitic.com/humanity-ns/img/Database-Diagram.png "Database-Diagram")


## Code Structure

Notificatation System is made as a part of a custom PHP framework (made by myself). The framework is created in MVC concept and here are some basics about it's code structure.

`~/app` directory contains main configuration files and application launcher and autoloader.

`~/public` directory should be set as Document Root and contains index.php, .htaccess, css, javascript, images etc.

`~/resources` contains PHP classes and files that supports MVC concept like Controllers, Views and it basically runs the application.

`~/src` contains the code of the framework and the Notification System classes but the idea is to keep all additional resources like Blog, Admin Panel etc.

## Notificatation System Code Structure

Classes are located under this location: 

```
~/src/Incoded/Notification/
```

And, in the application, it is under namespace:

```
Incoded\Notification
```
