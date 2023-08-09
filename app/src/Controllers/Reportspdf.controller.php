<?php
    include_once('./app/Helpers/pdf.php');
    require_once("./app/src/Models/Permissions.model.php");
    require_once("./app/src/Models/Roles.model.php");
    require_once("./app/src/Models/User.model.php");
    require_once("./app/src/Models/Notification.model.php");
    require_once("./app/src/Models/Doctor.model.php");
    require_once("./app/src/Models/Calendar.model.php");
    require_once("./app/src/Models/Appointment.model.php");
    require_once("./app/src/Models/Parents.model.php");
    require_once("./app/src/Models/Patient.model.php");

    class Reportspdf extends Controllers {
        public function __constructor() {
            parent::__constructor();
        }

        // Report notifications list
        function rptNotificationsList() {
            if ($_GET) {
                if (verifyApiKey()) {
                    $doctorModel = new Notification_model();
                    $req = array();
                    $req = $doctorModel->getAll();
                    if (!empty($req)) {
                        for ($i=0; $i < count($req); $i++) { 
                            if ($req[$i]['status'] == 1) {
                                $status = 'Aceptado';
                            } else if ($req[$i]['status'] == 2) {
                                $status = 'Visto';
                            } else if ($req[$i]['status'] == 3) {
                                $status = 'Por aceptar';
                            } else {
                                $status = 'Denegado';
                            }
                            $req[$i]['status'] = $status;
                        }
                    }
                    rptNotificationsList($req);
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

        // Report data notification
        function rptNotification() {
            if ($_GET) {
                if (verifyApiKey()) {
                    $this->id_notification = $_GET['id_notification'];
                    $notificationModel = new Notification_model();
                    $req = '';
                    $req = $notificationModel->get($this->id_notification);
                    rptNotification($req);
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

        // Report doctors list
        function rptDoctorsList() {
            if ($_GET) {
                if (verifyApiKey()) {
                    $doctorModel = new Doctor_model();
                    $req = array();
                    $req = $doctorModel->getAll();
                    rptDoctorsList($req);
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

        // Report doctor calendar
        function rptDoctorCalendar() {
            if ($_GET) {
                if (verifyApiKey()) {
                    $this->id_doctor = $_GET['id_doctor'];
                    $this->week_range = generateWeekRange($_GET['week_range']);
                    $calendarModel = new Calendar_model();
                    $req = '';
                    $req = $calendarModel->getCalendarByDoctor($this->id_doctor, $this->week_range);
                    if (!empty($req)) {
                        for ($i=0; $i < count($req); $i++) {
                            $week_range = explode(' - ', $this->week_range); 
                            $req[$i]['week_range'] = formatDate($week_range[0]).' hasta '.formatDate($week_range[1]);
                            $req[$i]['date'] = formatDate($req[$i]['date']);
                        }
                    }
                    rptDoctorCalendar($req);
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

        // Report appointments list
        function rptAppointmentsList() {
            if ($_GET) {
                if (verifyApiKey()) {
                    $appointmentModel = new Appointment_model();
                    $req = array();
                    $req = $appointmentModel->getAll();
                    if (!empty($req)) {
                        for ($i=0; $i < count($req); $i++) { 
                            if ($req[$i]['status'] == 1) {
                                $status = 'Atendido';
                            } else if ($req[$i]['status'] == 2) {
                                $status = 'Pendiente';
                            } else {
                                $status = 'Por confirmar';
                            }
                            $req[$i]['status'] = $status;
                        }
                    }
                    rptAppointmentsList($req);
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

        // Report parents list
        function rptParentsList() {
            if ($_GET) {
                if (verifyApiKey()) {
                    $parentsModel = new Parents_model();
                    $req = array();
                    $req = $parentsModel->getAll();
                    rptParentsList($req);
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

        // Report data parents
        function rptParents() {
            if ($_GET) {
                if (verifyApiKey()) {
                    $this->id_parents = $_GET['id_parents'];
                    $parentsModel = new Parents_model();
                    $req = '';
                    $req = $parentsModel->get($this->id_parents);
                    if (!empty($req)) {
                        $req['cell_phone2'] = $req['cell_phone2'] == '' ? 'No hay registro' : $req['cell_phone2'];
                        $req['status'] = $req['status'] == 1 ? 'Activo' : 'Inactivo';
                    }
                    rptParents($req);
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

        // Report patients list
        function rptPatientList() {
            if ($_GET) {
                if (verifyApiKey()) {
                    $patientModel = new Patient_model();
                    $req = array();
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
                    $patientModel = new Patient_model();
                    $req = '';
                    $req = $patientModel->get($this->id_patient);
                    if (!empty($req)) {
                        $req['age'] = $this->age;
                        $req['sex'] = $req['sex'] == 'M' ? 'Masculino' : 'Femenino';
                        $req['status'] = $req['status'] == 1 ? 'Activo' : 'Inactivo';
                    }
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
                    $patientModel = new Patient_model();
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

        // Report users list
        function rptModulesList() {
            if ($_GET) {
                if (verifyApiKey()) {
                    $permissionsModel = new Permissions_model();
                    $req = array();
                    $req = $permissionsModel->getModules();
                    rptModulesList($req);
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

        // Report users list
        function rptRolesList() {
            if ($_GET) {
                if (verifyApiKey()) {
                    $rolesModel = new Roles_model();
                    $req = array();
                    $req = $rolesModel->getAll();
                    rptRolesList($req);
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

        // Report users list
        function rptUsersList() {
            if ($_GET) {
                if (verifyApiKey()) {
                    $userModel = new User_model();
                    $req = array();
                    $req = $userModel->getAll();
                    rptUsersList($req);
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