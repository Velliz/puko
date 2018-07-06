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
    mkdir(sprintf("%s/assets/html/id", $dir), 0777, true);
    mkdir(sprintf("%s/assets/html/en", $dir), 0777, true);
    mkdir(sprintf("%s/assets/master", $dir), 0777, true);
    mkdir(sprintf("%s/assets/system", $dir), 0777, true);
    mkdir(sprintf("%s/config", $dir), 0777, true);
    mkdir(sprintf("%s/controller", $dir), 0777, true);
} else {
    echo "\n";
    echo "Aborting: apps with name %s already created!";
    echo "\n";
    exit();
}
$index = file_get_contents("template/index");
$index = str_replace("{{apps}}", $app, $index);
file_put_contents(sprintf("%s/index.php", $dir), $index);

$routes = file_get_contents("template/routes");
file_put_contents(sprintf("%s/routes.php", $dir), $routes);

$apache = file_get_contents("template/.htaccess");
file_put_contents(sprintf("%s/.htaccess", $dir), $apache);

$database = file_get_contents("template/config/database");
file_put_contents(sprintf("%s/config/database.php", $dir), $database);

$encryption = file_get_contents("template/config/encryption");
file_put_contents(sprintf("%s/config/encryption.php", $dir), $encryption);

$routes = file_get_contents("template/config/routes");
file_put_contents(sprintf("%s/config/routes.php", $dir), $routes);

echo "\n";
echo "Success: apps with name %s created!";
echo "\n";
exit();