<?php

/*
 * Configuration file
 */

define('DB_DATABASE', 'new');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('BASE_PATH', __DIR__);
define('LIB_PATH', 'lib/');
define('CONTROLLERS_PATH', 'src/');
define('TABLES', 'assets/databseTables/');
define('COUNTRY', TABLES . '02-Countries.csv');
define('CURRENCY', TABLES . '01-Currencies.csv');
define('DEFAULT_CONTROLLER', 'ImportDatabase');
