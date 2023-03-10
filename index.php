<?php
    require_once("./app/Config/Config.php");
    require_once("./app/Helpers/Helpers.php");

    $url = !empty($_GET['url']) ? $_GET['url'] : 'Home/Home';

    $arrayUrl = explode("/", $url);

    $controller = $arrayUrl[0];
    $method = $arrayUrl[0];
    $parameter = "";

    if (!empty($arrayUrl[1])) {
        if ($arrayUrl[1] != "") {
            $method = $arrayUrl[1];
        }
    }

    if (!empty($arrayUrl[2])) {
        if ($arrayUrl[2] != "") {
            for ($i=2; $i < count($arrayUrl); $i++) { 
                $parameter .= $arrayUrl[$i].',';
            }
            $parameter = trim($parameter, ',');
        }
    }

    //Access-Control-Allow-Origin
    Cors();
    
    require_once(LIBS."Core/Autoload.php");
    require_once(LIBS."Core/Load.php");
?>