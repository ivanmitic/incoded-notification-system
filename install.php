<?php
define('DS', DIRECTORY_SEPARATOR);
define('INCODED_ROOT', __DIR__ . DS);
define('INCODED_APP',  INCODED_ROOT . 'app' . DS);

include('app/config/database.php');
include('src/Incoded/Core/Database/DBLayer.php');

use Incoded\Core\Database\DBLayer as DBL;

echo "database installation starts\n";
echo "reading queries\n";

$query = file_get_contents('app/install/database.sql');

echo "executing queries\n";

$dbl = new DBL();
$dbl->executeQuery($query);

echo "installation completed\n";
