## Changelog

**v0.1**
- Build support for PHP template engine ~~Actualy this is my test result in Maranatha Christiant University for Backend Developer~~

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
- Adding support to PDO datatypes handling like BLOB data objects and Date data objects

**v0.9.3 Beta**
- Add support for output type in Controller.
```
class Example extends View {
```
Puko will render this controller with HTMLParser. Will result HTML page
```
class Example extends Service {
```
Puko will render this controller with JSONParser. Will result JSON page