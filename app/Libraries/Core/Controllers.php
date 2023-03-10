<?php
    class Controllers {
        public function __construct() {
            $this->views =new Views();
            $this->loadModel();
        }

        public function loadModel() {
            $model = get_class($this);
            $modelRoute = MODELS.$model.".model.php";
            if (file_exists($modelRoute)) {
                require_once($modelRoute);
                $instance = $model."_model";
                $this->model =new $instance();
            }
        }
    }
?>