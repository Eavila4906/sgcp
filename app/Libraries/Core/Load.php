<?php
    $controller = ucwords($controller);
    $controllerRoute = CONTRS.$controller.".controller.php";
    if (file_exists($controllerRoute)) {
        require_once($controllerRoute);
        $controller = new $controller();
        if (method_exists($controller, $method)) {
            $controller -> {$method}($parameter);
        } else {
            require_once(CONTRS."Errors.controller.php");
        }
    } else {
        require_once(CONTRS."Errors.controller.php");
    }
?>