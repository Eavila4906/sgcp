<?php
    class Views {
        public function getViews($controllers, $view, $data=""){
            $controllers = get_class($controllers);
            if ($controllers == "Home") {
                $view = VIEWS.$view.".view.php";
            } else {
                $view = VIEWS.$controllers."/".$view.".view.php";
            }
            require_once($view);
        }
    }
?>