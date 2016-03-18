# **Puko Framewok** - Version **0.92** Beta
### **Puko** is the MVC based PHP Framework for faster PHP app Development.

#### URL Routing
  - localhost/[controller]/ -> will search method and view with name 'main'
  - localhost/[controller]/[function]/
  - localhost/[controller]/[function]/[var1]/[var2]/[var3]/...
  - localhost/[controller]/[ID]/[function]/[var1]/[var2]/[var3]/...

#### Data Access
  - Data::To("table name")->Save($arraydata); -> insert
  - Data::To("table name")->Update($arraywhere, $arraydata); -> update
  - Data::To("table name")->Delete($arraydata); -> delete
  - Data::From("your query here")->FetchAll(); -> select

#### Template Engine
  - <!--@css{bootstrap.min,datatable}-->
  - <!--@js{jquery.min,datatable.min}-->
  - {!value} -> print simple single value
  - {!loop} {!value} {/loop} -> print value on array
  - {!!condition} {/condition} -> blocked condition
