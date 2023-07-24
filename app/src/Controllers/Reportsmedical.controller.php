<?php
    class Reportsmedical extends Controllers {
        public function __constructor() {
            parent::__constructor();
        }

        // Appointment all get function for patient
        public function getAppointmentsForPatient() {
            if ($_GET) {
                if (verifyApiKey()) {
                    $this->id_patient = $_GET['id_patient'];
                    $res = $this->model->getAppointmentsForPatient($this->id_patient);
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