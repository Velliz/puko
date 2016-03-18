# Puko - V0.92 Beta
Puko is the Micro Model-View PHP Framework for faster PHP application Development.
*Puko Require PHP 5 or greater*

## Features
**URL Routing**

Basic URL routing folow these rules:
```
localhost/[controller]/ "will search method and view with name 'main'"
localhost/[controller]/[function]/
localhost/[controller]/[function]/[var1]/[var2]/[var3]/...
localhost/[controller]/[ID]/[function]/[var1]/[var2]/[var3]/...
```
**Data Access**

Database Acces can configure via **Config/db.php** and you can use static **Data.php** class to perform CRUD operations like:
```
Data::To("table name")->Save($arraydata); "insert"
Data::To("table name")->Update($arraywhere, $arraydata); "update"
Data::To("table name")->Delete($arraydata); -> "delete"
Data::From("your query here")->FetchAll(); -> "select"
```
**Template Engine**

Puko use **.html** file for view. So if you want to do styling or scripting:
```
<!--@css{bootstrap.min,datatable}-->
<!--@js{jquery.min,datatable.min}-->
```
For data Boilerplates, you can print data returned by Controller class like this:
```
{!value} "print simple single value"
{!loop} {!value} {/loop} "print value on array"
{!!condition} {/condition} "blocked condition"
```

## Changelog
**v0.1**
- build support for PHP template engine

**v0.9 Alfa**
- build support for PDO Database connection
- build support for URL REST style routing
- build support for MVC style code and Autoloader
- build support for combining URL REST and Template Engine

**v0.9.1 Beta**
- add more human-readable error message

**v0.9.2 Beta**
- fix controller constructor id variable value error
- build support for PDO Database delete function
- build css and js template render feature
- repositioning view hierarchy

## About
Crafted with <3 from **Bandung**, Indonesia.

## Contributing
If you find bugs error or you want contribute to this project. 
just send me email to : diditvelliz@gmail.com 
Thanks :)
