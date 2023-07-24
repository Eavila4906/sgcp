<?php
    include_once('./app/Helpers/pdf.php');
    require_once("./app/src/Models/Patient.model.php");

    class Reportspdf extends Controllers {
        public function __constructor() {
            parent::__constructor();
        }

        // Reports data personal patient
        function rptPatient() {
            if ($_GET) {
                if (verifyApiKey()) {
                    $this->id_patient = $_GET['id_patient'];
                    $this->age = $_GET['age'];
                    $patientModel =new Patient_model();
                    $req = $patientModel->get($this->id_patient);
                    $req['age'] = $this->age;
                    $req['sex'] = $req['sex'] == 'M' ? 'Masculino' : 'Femenino';
                    $req['status'] = $req['status'] == 1 ? 'Activo' : 'Inactivo';
                    rptPatient($req);
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

        function pr() {
            pr();
        }

    }
?>