<?php
$code = @file_get_contents("Assets/html/main/main.html");
$tokens = strtok($code, '<!-- -->');
var_dump($tokens);
