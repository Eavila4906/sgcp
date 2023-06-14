<?php
    class Appointment extends Controllers {
        public function __constructor() {
            parent::__constructor();
        }

        // New register appointment function
        public function create() {
            if ($_POST) {
                if (verifyApiKey()) {
                    $this->doctor = $_POST['doctor'];
                    $this->patient = $_POST['patient'];
                    $this->date = $_POST['date'];
                    $this->hour = $_POST['hour'];
                    $this->description = $_POST['description'];
                    $this->status = $_POST['status'];

                    if (empty($this->doctor) || empty($this->patient) || empty($this->date) || empty($this->hour)) {
                        $res = array(
                            'status' => false, 
                            'msg' => 'All fields are required.'
                        );
                    } else {
                        $appointmentData = array(
                            'doctor' => $this->doctor,
                            'patient' => $this->patient,
                            'date' => $this->date,
                            'hour' => $this->hour,
                            'description' => $this->description,
                            'status' => $this->status
                        );  
                        $req = $this->model->create($appointmentData);

                        if ($req > 0) {
                            $res = array(
                                'status' => true, 
                                'msg' => 'Successfully registered appointment.'
                            ); 
                        } else if ($req == '!exists') {
                            $res = array(
                                'status' => false, 
                                'msg' => 'This process could not be performed, The doctor does not have a time allotted on her calendar for the date of .'.$this->date
                            ); 
                        } else if ($req == 'exists') {
                            $res = array(
                                'status' => false, 
                                'msg' => 'This process could not be performed, the appointment already exists in our records.'
                            ); 
                        } else {
                            $res = array(
                                'status' => false, 
                                'msg' => 'This process could not be performed, please try again later [ERROR_APPOINTMENT].'
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

        // Appointment update function
        public function update() {
            if ($_POST) {
                if (verifyApiKey()) {
                    $this->id_appointment = $_POST['id_appointment'];
                    $this->doctor = $_POST['doctor'];
                    $this->patient = $_POST['patient'];
                    $this->date = $_POST['date'];
                    $this->hour = $_POST['hour'];
                    $this->description = $_POST['description'];
                    $this->status = $_POST['status'];

                    if (empty($this->doctor) || empty($this->patient) || empty($this->date) || empty($this->hour)) {
                        $res = array(
                            'status' => false, 
                            'msg' => 'All fields are required.'
                        );
                    } else {
                        $appointmentData = array(
                            'doctor' => $this->doctor,
                            'patient' => $this->patient,
                            'date' => $this->date,
                            'hour' => $this->hour,
                            'description' => $this->description,
                            'status' => $this->status
                        ); 
                        $req = $this->model->update($this->id_appointment, $appointmentData);
                        
                        if ($req > 0) {
                            $res = array(
                                'status' => true, 
                                'msg' => 'Appointment updated successfully.'
                            ); 
                        } else if ($req == '!exists') {
                            $res = array(
                                'status' => false, 
                                'msg' => 'This process could not be performed, The doctor does not have a time allotted on her calendar for the date of .'.$this->date
                            ); 
                        } else if ($req == 'exists') {
                            $res = array(
                                'status' => false, 
                                'msg' => 'This process could not be performed, the appointment already exists in our records.'
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

        // Appointment delete function
        public function delete() {
            if (Http_DELETE()) {
                if (verifyApiKey()) {
                    $this->id_appointment = $_GET['id_appointment'];

                    if (empty($this->id_appointment)) {
                        $res = array(
                            'status' => false, 
                            'msg' => 'Error! appointment ID is required.'
                        );
                    } else {
                        $req = $this->model->delete($this->id_appointment, 0);

                        if ($req > 0) {
                            $res = array(
                                'status' => true, 
                                'msg' => 'Appointment deleted successfully.'
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

        // Appointment all get function
        public function getAll() {
            if ($_GET) {
                if (verifyApiKey()) {
                    $res = $this->model->getAll();
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

        // Unique appointment get function
        public function get() {
            if ($_GET) {
                if (verifyApiKey()) {
                    $this->id_appointment = $_GET['id_appointment'];
                    $req = $this->model->get($this->id_appointment);
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