<?php
    class Calendar extends Controllers {
        public function __constructor() {
            parent::__constructor();
        }

        // New register doctor function
        public function create() {
            if ($_POST) {
                if (verifyApiKey()) {
                    $this->id_doctor = $_POST['id_doctor'];
                    $this->date = $_POST['date'];
                    $this->start_time = $_POST['start_time'];
                    $this->final_time = $_POST['final_time'];
                    $this->status = $_POST['status'];

                    if (empty($this->id_doctor) ||  empty($this->date) || empty($this->start_time) || empty($this->final_time)) {
                        $res = array(
                            'status' => false, 
                            'msg' => 'All fields are required.'
                        );
                    } else {
                        $calendarData = array(
                            'id_doctor' => $this->id_doctor,
                            'date' => $this->date,
                            'start_time' => $this->start_time,
                            'final_time' => $this->final_time,
                            'status' => $this->status
                        );  
                        $req = $this->model->create($calendarData);

                        if ($req > 0) {
                            $res = array(
                                'status' => true, 
                                'msg' => 'Successfully registered calendar.'
                            ); 
                        } else if ($req == 'exists') {
                            $res = array(
                                'status' => false, 
                                'msg' => 'This process could not be performed, the calendar already exists in our records.'
                            ); 
                        } else {
                            $res = array(
                                'status' => false, 
                                'msg' => 'This process could not be performed, please try again later [ERROR_CALENDAR].'
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

        // Calendar update function
        public function update() {
            if ($_POST) {
                if (verifyApiKey()) {
                    $this->id_calendar = $_POST['id_calendar'];
                    $this->id_doctor = $_POST['id_doctor'];
                    $this->date = $_POST['date'];
                    $this->start_time = $_POST['start_time'];
                    $this->final_time = $_POST['final_time'];
                    $this->status = $_POST['status'];

                    if (empty($this->id_calendar) || empty($this->id_doctor) ||  empty($this->date) 
                        || empty($this->start_time) || empty($this->final_time)) {
                        $res = array(
                            'status' => false, 
                            'msg' => 'All fields are required.'
                        );
                    } else {
                        $calendarData = array(
                            'id_doctor' => $this->id_doctor,
                            'date' => $this->date,
                            'start_time' => $this->start_time,
                            'final_time' => $this->final_time,
                            'status' => $this->status
                        ); 
                        $req = $this->model->update($this->id_calendar, $calendarData);
                        
                        if ($req > 0) {
                            $res = array(
                                'status' => true, 
                                'msg' => 'Calendar updated successfully'
                            ); 
                        } else if ($req == 'exists') {
                            $res = array(
                                'status' => false, 
                                'msg' => 'This process could not be performed, the calendar already exists in our records.'
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

        // Calendar delete function
        public function delete() {
            if (Http_DELETE()) {
                if (verifyApiKey()) {
                    $this->id_calendar = $_GET['id_calendar'];

                    if (empty($this->id_calendar)) {
                        $res = array(
                            'status' => false, 
                            'msg' => 'Error! calendar ID is required.'
                        );
                    } else {
                        $req = $this->model->delete($this->id_calendar, 0);

                        if ($req > 0) {
                            $res = array(
                                'status' => true, 
                                'msg' => 'Calendar deleted successfully.'
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

        // Calendar all get function
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

        // Unique calendar get function
        public function get() {
            if ($_GET) {
                if (verifyApiKey()) {
                    $this->id_calendar = $_GET['id_calendar'];
                    $req = $this->model->get($this->id_calendar);
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