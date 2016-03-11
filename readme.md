# **Puko Framewok** - Version **0.91** Beta
### **Puko** is the MVC based PHP Framework for faster PHP app Development.

#### URL Routing
- localhost/[controller]/ -> will search method main
- localhost/[controller]/[function]/
- localhost/[controller]/[function]/[var1]/[var2]/[var3]/...
- localhost/[controller]/[ID]/[function]/[var1]/[var2]/[var3]/...

#### Data Access

- Data::To("table name")->Save($arraydata); -> insert
- Data::To("table name")->Update($arraywhere, $arraydata); -> update
- Data::From("your query here")->FetchAll(); -> select
- Delete on progress

#### Template Engine

- {!value} -> print simple single value
- {!loop} {!value} {/loop} -> print value on array
- {!!condition} {/condition} -> blocked condition
