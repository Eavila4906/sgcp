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

        // Unique medical control get function by appointment
        public function getByAppointment() {
            if ($_GET) {
                if (verifyApiKey()) {
                    $this->id_appointment = $_GET['id_appointment'];
                    $req = $this->model->getByAppointment($this->id_appointment);
                    $req['age'] = calculateAge($req['birthdate'], $req['date']);
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

        // Unique medical control get function by charts
        public function getRecordsByCharts() {
            if ($_GET) {
                if (verifyApiKey()) {
                    $this->id_patient = $_GET['id_patient'];
                    $res = $this->model->getRecordsByCharts($this->id_patient);
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