<?php
    class Medicalcontrol extends Controllers {
        public function __constructor() {
            parent::__constructor();
        }

        // New register medical control function
        public function create() {
            if ($_POST) {
                if (verifyApiKey()) {
                    $this->appointment = $_POST['appointment'];
                    $this->months_age = $_POST['months_age'];
                    $this->weight_kg = $_POST['weight_kg'];
                    $this->weight_pounds = $_POST['weight_pounds'];
                    $this->height_cm = $_POST['height_cm'];
                    $this->bmi_quant = $_POST['bmi_quant'];
                    $this->bmi_quali = $_POST['bmi_quali'];
                    $this->temperature = $_POST['temperature'] == '' ? 0 : $_POST['temperature'];
                    $this->observation = $_POST['observation'];
                    $this->medication = $_POST['medication'];
                    $this->indication = $_POST['indication'];

                    if (empty($this->appointment) || empty($this->months_age) 
                        || empty($this->weight_kg) || empty($this->weight_pounds) || empty($this->height_cm)
                        || empty($this->bmi_quant) || empty($this->bmi_quali)) {
                        $res = array(
                            'status' => false, 
                            'msg' => 'All fields are required!'
                        );
                    } else {
                        $recipeData = array(
                            'medication' => $this->medication,
                            'indication' => $this->indication
                        );  
                        $req_id_recipe = $this->model->createRecipe($recipeData);

                        if ($req_id_recipe > 0) {
                            $medicalcontrolData = array(
                                'appointment' => $this->appointment,
                                'recipe' => $req_id_recipe,
                                'months_age' => $this->months_age,
                                'weight_kg' => $this->weight_kg,
                                'weight_pounds' => $this->weight_pounds,
                                'height_cm' => $this->height_cm,
                                'bmi_quant' => $this->bmi_quant,
                                'bmi_quali' => $this->bmi_quali,
                                'temperature' => $this->temperature,
                                'observation' => $this->observation
                            ); 
                            $req = $this->model->create($medicalcontrolData);

                            if ($req > 0) {
                                $res = array(
                                    'status' => true, 
                                    'msg' => 'Successfully registered medical control.'
                                );
                            } else {
                                $res = array(
                                    'status' => false, 
                                    'msg' => 'This process could not be performed, please try again later [ERROR_MEDICAL_CONTROL].'
                                ); 
                            }
                        } else {
                            $res = array(
                                'status' => false, 
                                'msg' => 'This process could not be performed, please try again later [ERROR_RECIPE].'
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

        // Medical control update function
        public function update() {
            if ($_POST) {
                if (verifyApiKey()) {
                    $this->appointment = $_POST['appointment'];
                    $this->weight_kg = $_POST['weight_kg'];
                    $this->weight_pounds = $_POST['weight_pounds'];
                    $this->height_cm = $_POST['height_cm'];
                    $this->bmi_quant = $_POST['bmi_quant'];
                    $this->bmi_quali = $_POST['bmi_quali'];
                    $this->temperature = $_POST['temperature'];
                    $this->observation = $_POST['observation'];
                    $this->medication = $_POST['medication'];
                    $this->indication = $_POST['indication'];

                    if (empty($this->appointment) || empty($this->weight_kg) 
                        || empty($this->weight_pounds) || empty($this->height_cm)
                        || empty($this->bmi_quant) || empty($this->bmi_quali)) {
                        $res = array(
                            'status' => false, 
                            'msg' => 'All fields are required!'
                        );
                    } else {
                        $medicalcontrolData = array(
                            'appointment' => $this->appointment,
                            'weight_kg' => $this->weight_kg,
                            'weight_pounds' => $this->weight_pounds,
                            'height_cm' => $this->height_cm,
                            'bmi_quant' => $this->bmi_quant,
                            'bmi_quali' => $this->bmi_quali,
                            'temperature' => $this->temperature,
                            'observation' => $this->observation,
                            'medication' => $this->medication,
                            'indication' => $this->indication
                        ); 
                        $req = $this->model->update($medicalcontrolData);
                        
                        if ($req > 0) {
                            $res = array(
                                'status' => true, 
                                'msg' => 'Medical control updated successfully'
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

        // Medical control delete function
        public function delete() {
            if (Http_DELETE()) {
                if (verifyApiKey()) {
                    $this->id_medicalcontrol = $_GET['id_medicalcontrol'];

                    if (empty($this->id_medicalcontrol)) {
                        $res = array(
                            'status' => false, 
                            'msg' => 'Error! medical control ID is required.'
                        );
                    } else {
                        $req = $this->model->delete($this->id_medicalcontrol, 0);

                        if ($req > 0) {
                            $res = array(
                                'status' => true, 
                                'msg' => 'Medical control deleted successfully.'
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

        // Medical control all get function
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

        // Unique medical control get function
        public function get() {
            if ($_GET) {
                if (verifyApiKey()) {
                    $this->id_medicalcontrol = $_GET['id_medicalcontrol'];
                    $req = $this->model->get($this->id_medicalcontrol);
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

        // Unique medical control get function by appointment
        public function getByAppointment() {
            if ($_GET) {
                if (verifyApiKey()) {
                    $this->id_appointment = $_GET['id_appointment'];
                    $req = $this->model->getByAppointment($this->id_appointment);
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

        function Recipe() {
            if ($_GET) {
                $this->appointment = $_GET['appointment'];
                $req = $this->model->getByAppointment($this->appointment);
                if (!empty($req)) {
                    $req['age'] = calculateAge($req['birthdate'], $req['date']);
                }
                $this->views->getViews($this,"Recipe", $req);
            }
            die();
        }
    }
?>