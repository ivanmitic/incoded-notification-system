# Notifications System

## Installation

To install database and data required for test, do the following:

+ Find `~/app/config/databse.php` and change database connection parameters
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

### Collections and Models

Under that namespace, there are database models and collections made to transform database entity records to PHP objects over database layer object.

### Form

Also, there are form classes made to display notification forms on the frontend.

### Services

Services contains all classes made to send notifications. It's done by Dispatcher class and abstract Service class. Here's an example of releasing an notification:

`NotificationDispatcher::release($user_id, $notification_code, $post_id);`

The usage of Notification system in the application can be found here `~/resources/Humanity/Notifications/Controller/Website.php`

