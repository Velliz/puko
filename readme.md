Puko Framewok - Version 0.90 Alfa
Puko is the MVC based PHP Framework for faster PHP app Development.

Feature
1. URL Routing
   localhost/[controller] -> will search method with same name with controller name
   localhost/[controller]/[function]
   localhost/[controller]/[function]/[var1]/[var2]/[var3]...
   localhost/[controller]/[ID]/[function]/[var1]/[var2]/[var3]...
2. Data Access
   Data::To("table name")->Save($arraydata); -> insert
   Data::To("table name")->Update($arraywhere, $arraydata); -> update
   Data::From("your query here")->FetchAll(); -> select
   -> Delete on progress
3. Template Engine
   {!value} -> print simple single value
   {!loop} {!value} {/loop} -> print value on array
   {!!condition} {/condition} -> blocked condition