# Puko - V0.92 Beta
Puko is the Micro Model-View PHP Framework for faster PHP application Development.

*Puko Require **PHP 5.3** or greater*

## Features
**URL Routing**

Basic URL routing follow these rules:
```
localhost/[controller]/ "will search method and view with name 'main'"
localhost/[controller]/[function]/
localhost/[controller]/[function]/[var1]/[var2]/[var3]/...
localhost/[controller]/[ID]/[function]/[var1]/[var2]/[var3]/...
```
**Data Access**

Database Access can configure via **Config/db.php** and you can use static **Data.php** class to perform CRUD operations like:
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
- Build support for PHP template engine ~~This version is Amazing first work for my assigment for job requirement test in Maranatha Christiant University~~

**v0.9 Alfa**
- Build support for PDO Database Connection
- Build support for URL REST style routing
- Build support for Micro Model-View style code and Class Autoloader
- Build support for Combining URL REST and Template Engine

**v0.9.1 Beta**
- Add more human-readable error message

**v0.9.2 Beta**
- Fix controller constructor id variable value error
- Build support for PDO Database delete function
- Build css and js template renderer feature
- Repositioning view hierarchy

## TODO
- Adding support to database complex datatypes handling like BLOB data objects and Date data objects
- Adding support for handle wrong or not find URL routing path
- Adding support for another Database Connection

## About
Crafted with <3 from **Bandung**, Indonesia.

## Contributing
If you find bugs error or you want contribute to this project. 
just send me email to : diditvelliz@gmail.com 
Thanks :)
