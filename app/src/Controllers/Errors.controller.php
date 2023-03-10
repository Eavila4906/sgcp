<?php
    class Errors extends Controllers{
        public function __construct(){
            parent::__construct();
        }

        public function notFound(){
            $this->views->getViews($this, get_class($this));
        }
    }
    $notFound =new Errors();
    $notFound->notFound();
?>