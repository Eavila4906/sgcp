<?php
    class My extends Controllers {
        public function __constructor() {
            parent::__constructor();
        }

        // Appointment all get function doctor
        public function getAppointmentsDoctor() {
            if ($_GET) {
                if (verifyApiKey()) {
                    $this->id_user = $_GET['id_user'];
                    $res = $this->model->getAppointmentsDoctor($this->id_user);
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

        // Appointment all get function patient
        public function getAppointmentsPatient() {
            if ($_GET) {
                if (verifyApiKey()) {
                    $this->id_user = $_GET['id_user'];
                    $res = $this->model->getAppointmentsPatient($this->id_user);
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