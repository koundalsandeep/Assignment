<?php
include_once 'config.php';
if (!empty($_REQUEST['url'])) {
    $query = explode('/', $_REQUEST['url']);
    $controller = ucfirst($query[0]);
    array_shift($query);
} else {
    $controller = DEFAULT_CONTROLLER;
}

if (!empty($query[0])) {
    $action = $query[0];
} else {
    $action = 'index';
}
spl_autoload_register(function ($class) {
    $path = str_replace('_', '/', $class);

    if (file_exists(CONTROLLERS_PATH . "$path.php")) {
        $path = CONTROLLERS_PATH . "$path.php";
    } else if (file_exists(LIB_PATH . "$path.php")) {
        $path = LIB_PATH . "$path.php";
    }
    require_once $path;
});

if (!empty($query)) {
    call_user_func_array(array(new $controller(), $action), $query);
} else {
    call_user_func(array(new $controller(), $action));
}
