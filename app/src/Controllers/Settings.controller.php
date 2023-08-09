<?php
    class Settings extends Controllers {
        public function __construct() {
            parent::__construct();
            $this->className = get_class($this);
            session();
        }
        
        // Settings update function
        public function update() {
            if ($_POST) {
                if (verifyApiKey()) {
                    $this->category = $_POST['category'];

                    if (empty($this->category)) {
                        $res = array(
                            'status' => false, 
                            'msg' => 'All fields are required.'
                        );
                    } else {
                        $req = 0;

                        if ($this->category == 'System') {
                            $dataSystem = array(
                                'system_name' => $_POST['system_name'],
                                'session_time' => $_POST['session_time'],
                                'generate_reports' => $_POST['generate_reports']
                            );
                            $req = $this->model->updateSystem($dataSystem);
                        } 
                        
                        if ($this->category == 'Consultingroom') {
                            $dataConsultingroom = array(
                                'scheduling_time' => $_POST['scheduling_time'],
                                'generate_certificate' => $_POST['generate_certificate'],
                                'print_recipe' => $_POST['print_recipe']
                            );
                            $req = $this->model->updateConsultingroom($dataConsultingroom);
                        }
                        
                        if ($req > 0) {
                            $res = array(
                                'status' => true, 
                                'msg' => 'Settings updated successfully.'
                            ); 
                        } else {
                            $res = array(
                                'status' => false, 
                                'msg' => 'This process could not be performed, please try again later.'
                            ); 
                        }
                    }
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

        // Unique settings get function
        public function get() {
            if ($_GET) {
                if (verifyApiKey()) {
                    $this->id_settings = $_GET['id_settings'];
                    $req = $this->model->get($this->id_settings);
                    $res = array(
                        'status' => true, 
                        'data' => $req
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