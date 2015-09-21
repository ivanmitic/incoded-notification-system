<?php
// start session
session_start();

// define short directory separator
define('DS', DIRECTORY_SEPARATOR);

// define paths
define('INCODED_ROOT',      __DIR__ . DS . '..' . DS);
define('INCODED_CACHE',     INCODED_ROOT . 'cache' . DS);
define('INCODED_CONFIG',    INCODED_ROOT . 'config' . DS);
define('INCODED_PUBLIC',    INCODED_ROOT . 'public' . DS);
define('INCODED_APP',       INCODED_ROOT . 'app' . DS);
define('INCODED_RESOURCES', INCODED_ROOT . 'resources' . DS);
define('INCODED_SRC',       INCODED_ROOT . 'src' . DS);

// define environment
define('INCODED_LOCAL', in_array(@$_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1')));

// load launcher class
require_once INCODED_APP . DS . 'Launcher.php';

// launch application
new \App\Launcher();
