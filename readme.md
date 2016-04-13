# Puko - V0.93 Beta [![Build Status](https://travis-ci.org/Velliz/puko.svg?branch=master)](https://travis-ci.org/Velliz/puko)

Puko is the Micro Model-View PHP Framework for faster PHP application Development.

*Puko Require* **PHP 5.3** *or greater*

## Main Features

**URL Routing**

Basic URL routing follows these rules:
```PHP
localhost/[controller]/ "will search method and view with name 'main'"
localhost/[controller]/[function]/
localhost/[controller]/[function]/[var1]/[var2]/[var3]/...
localhost/[controller]/[ID]/[function]/[var1]/[var2]/[var3]/... "ID accepts [0-9] only"
```
**Data Access**

Database Access can configure via **Config/db.php** and you can use static **Data.php** class to perform CRUD operations like:
```PHP
Data::To("table name")->Save($arraydata);
Data::To("table name")->Update($arraywhere, $arraydata);
Data::To("table name")->Delete($arraydata);
Data::From("your query here")->FetchAll();
```
**Template Engine**

Puko use **.html** file for view. So if you want to do styling or scripting:
```
<!--@css{bootstrap.min,datatable}-->
<!--@js{jquery.min,datatable.min}-->
```
And the **.html** file has always have their partners. **.css** and **.js** located in Assets

For data Boilerplates, you can print data returned by Controller class like this:
```
{!value} "print simple single value"
{!loop} {!value} {/loop} "print value on array"
{!!condition} {/condition} "blocked condition"
```

And many more you can find in the [DOCS / WIKI.](https://github.com/Velliz/puko/wiki/Welcome-to-Puko-Docs)

## About

Crafted with <3 from **Bandung**, Indonesia.

If you find bugs error or you want contribute to this project. 

just send me email to : diditvelliz@gmail.com 

Thanks :)

## License

Copyright **2016 - Didit Velliz**

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
