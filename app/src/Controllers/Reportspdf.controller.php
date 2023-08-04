<?php
    include_once('./app/Helpers/pdf.php');
    require_once("./app/src/Models/Patient.model.php");

    class Reportspdf extends Controllers {
        public function __constructor() {
            parent::__constructor();
        }

        // Report patients list
        function rptPatientList() {
            if ($_GET) {
                if (verifyApiKey()) {
                    $patientModel =new Patient_model();
                    $req = $patientModel->getAll();
                    for ($i = 0; $i < count($req); $i++) {
                        $req[$i]['age'] = calculateAge($req[$i]['birthdate'], date('Y-m-d'));
                    }
                    rptPatientList($req);
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

        // Report data personal patient
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

        // Report medical certificate
        function rptCertificate() {
            if ($_POST) {
                if (verifyApiKey()) {
                    $this->id_patient = $_POST['id_patient'];
                    $patientModel =new Patient_model();
                    $req = $patientModel->get($this->id_patient);
                    setlocale(LC_ALL,"es-MX");
                    $req['pronoun'] = $req['sex'] == 'M' ? 'el' : "la";
                    $req['patient'] = strtoupper($req['patient']);
                    $req['reason'] = strtoupper($_POST['reason']);
                    $req['diagnosis'] = strtoupper($_POST['diagnosis']);
                    $req['disease_code'] = $_POST['disease_code'];
                    $req['rest_time'] = $_POST['rest_quant'].' '.$_POST['rest_quali'];
                    $req['from_date'] = formatDate($_POST['from_date']);
                    $req['till_date'] = formatDate($_POST['till_date']);
                    $current_date = explode(',', formatDate(date('Y-m-d')));
                    $req['current_date'] = $current_date[1];
                    rptCertificate($req);
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