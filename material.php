#!/usr/bin/env php
<?php
if (PHP_SAPI !== 'cli') {
    die('You are not allowed to perform this action');
}

echo "Puko Framework Material Development Tool";
echo "\n";
echo "apps name: ";
$app = preg_replace('/\s+/', '', fgets(STDIN));

$dir = sprintf('apps/%s', $app);
if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
    mkdir(sprintf("%s/assets/html", $dir), 0777, true);
    mkdir(sprintf("%s/assets/master", $dir), 0777, true);
    mkdir(sprintf("%s/assets/system", $dir), 0777, true);
    mkdir(sprintf("%s/config", $dir), 0777, true);
    mkdir(sprintf("%s/controller", $dir), 0777, true);
} else {
    echo "\n";
    echo "apps with name %s already created!";
    echo "\n";
    exit();
}
$index = file_get_contents("template/index");
$index = str_replace("{{apps}}", $app, $index);
file_put_contents(sprintf("%s/index.php", $dir), $index);

$puko = file_get_contents("template/puko");
file_put_contents(sprintf("%s/puko", $dir), $puko);

$routes = file_get_contents("template/routes.php");
file_put_contents(sprintf("%s/routes.php", $dir), $routes);