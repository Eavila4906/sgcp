<?php
    class Logout extends Controllers {
        public function __construct() {
            parent::__construct();
        }

        // Logout control function
        public function logout() {
            if ($_POST) {
                if (verifyApiKey()) {
                    if(!isset($_SESSION)) { 
                        session_start(); 
                    }
                    session_unset();
                    session_destroy();
                    $res = array(
                        'status' => true, 
                        'login' => false
                    );
                } else {
                    $res = array(
                        'status' => false,
                        'msg' => 'Attention! You need a key to access the API.'
                    ); 
                } 
                echo json_encode($res, JSON_UNESCAPED_UNICODE);  
            }
            die();
        }
    }
?>