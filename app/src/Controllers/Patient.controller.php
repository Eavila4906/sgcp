<?php
    class Patient extends Controllers {
        public function __constructor() {
            parent::__constructor();
        }

        // New register patient function
        public function create() {
            if ($_POST) {
                if (verifyApiKey()) {
                    $this->id_parents = $_POST['id_parents'];
                    $this->dni = $_POST['dni'];
                    $this->name = $_POST['name'];
                    $this->lastname = $_POST['lastname'];
                    $this->birthdate = $_POST['birthdate'];
                    $this->sex = $_POST['sex'];
                    $this->weight_kg = $_POST['weight_kg'];
                    $this->weight_pounds = $_POST['weight_pounds'];
                    $this->height = $_POST['height'];
                    $this->blood_type = $_POST['blood_type'];
                    $this->family_obs = $_POST['family_obs'];
                    $this->othersCheckOf = $_POST['othersCheckOf'] == false ? 0 : 1;
                    $this->personal_obs = $_POST['personal_obs'];
                    $this->othersCheckOp = $_POST['othersCheckOp'] == false ? 0 : 1;
                    $this->general_obs = $_POST['general_obs'];
                    $this->status = $_POST['status'];

                    if (empty($this->dni) || empty($this->name) || empty($this->lastname) || empty($this->birthdate) 
                        || empty($this->sex) || empty($this->weight_kg) || empty($this->weight_pounds) 
                        || empty($this->height) || empty($this->blood_type)) 
                    {
                        $res = array(
                            'status' => false, 
                            'msg' => 'All fields are required.'
                        );
                    } else {

                        if ($this->othersCheckOf > 0) {
                            if (empty($this->family_obs)) {
                                $family_obs = $_POST['others_of'];
                            } else {
                                if (empty($_POST['others_of'])) {
                                    $family_obs = $this->family_obs;
                                } else {
                                    $family_obs = $this->family_obs.', '.$_POST['others_of'];
                                }
                            }
                        } else {
                            $family_obs = $this->family_obs;
                        }

                        if ($this->othersCheckOp > 0) {
                            if (empty($this->personal_obs)) {
                                $personal_obs = $_POST['others_op'];
                            } else {
                                if (empty($_POST['others_op'])) {
                                    $personal_obs = $this->personal_obs;
                                } else {
                                    $personal_obs = $this->personal_obs.', '.$_POST['others_op'];
                                }
                            }
                        } else {
                            $personal_obs = $this->personal_obs;
                        }

                        $patientData = array(
                            'parents' => $this->id_parents,
                            'dni' => $this->dni,
                            'name' => $this->name,
                            'lastname' => $this->lastname,
                            'birthdate' => $this->birthdate,
                            'sex' => $this->sex,
                            'weight_kg' => $this->weight_kg,
                            'weight_pounds' => $this->weight_pounds,
                            'height' => $this->height,
                            'blood_type' => $this->blood_type,
                            'family_obs' => $family_obs == '' ? 'Ninguna' : $family_obs,
                            'personal_obs' => $personal_obs == '' ? 'Ninguna' : $personal_obs,
                            'general_obs' => $this->general_obs == '' ? 'Ninguna' : $this->general_obs,
                            'status' => $this->status
                        );
                        $req = $this->model->create($patientData);

                        if ($req > 0) {
                            $res = array(
                                'status' => true, 
                                'msg' => 'Successfully registered patient.'
                            ); 
                        } else if ($req == 'exists') {
                            $res = array(
                                'status' => false, 
                                'msg' => 'This process could not be performed, the patient already exists in our records.'
                            ); 
                        } else {
                            $res = array(
                                'status' => false, 
                                'msg' => 'This process could not be performed, please try again later [ERROR_PATIENT].'
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

        // Patient update function
        public function update() {
            if ($_POST) {
                if (verifyApiKey()) {
                    $this->id_patient = $_POST['id_patient'];
                    $this->dni = $_POST['dni'];
                    $this->name = $_POST['name'];
                    $this->lastname = $_POST['lastname'];
                    $this->birthdate = $_POST['birthdate'];
                    $this->sex = $_POST['sex'];
                    $this->weight_kg = $_POST['weight_kg'];
                    $this->weight_pounds = $_POST['weight_pounds'];
                    $this->height = $_POST['height'];
                    $this->blood_type = $_POST['blood_type'];
                    $this->family_obs = $_POST['family_obs'];
                    $this->othersCheckOf = $_POST['othersCheckOf'] == false ? 0 : 1;
                    $this->personal_obs = $_POST['personal_obs'];
                    $this->othersCheckOp = $_POST['othersCheckOp'] == false ? 0 : 1;
                    $this->general_obs = $_POST['general_obs'];
                    $this->status = $_POST['status'];

                    if (empty($this->id_patient) || empty($this->dni) || empty($this->name) 
                        || empty($this->lastname) || empty($this->birthdate) || empty($this->sex)
                        || empty($this->blood_type)) {
                        $res = array(
                            'status' => false, 
                            'msg' => 'All fields are required.'
                        );
                    } else {

                        if ($this->othersCheckOf > 0) {
                            if (empty($this->family_obs)) {
                                $family_obs = $_POST['others_of'];
                            } else {
                                if (empty($_POST['others_of'])) {
                                    $family_obs = $this->family_obs;
                                } else {
                                    $family_obs = $this->family_obs.', '.$_POST['others_of'];
                                }
                            }
                        } else {
                            $family_obs = $this->family_obs;
                        }

                        if ($this->othersCheckOp > 0) {
                            if (empty($this->personal_obs)) {
                                $personal_obs = $_POST['others_op'];
                            } else {
                                if (empty($_POST['others_op'])) {
                                    $personal_obs = $this->personal_obs;
                                } else {
                                    $personal_obs = $this->personal_obs.', '.$_POST['others_op'];
                                }
                            }
                        } else {
                            $personal_obs = $this->personal_obs;
                        }

                        $patientData = array(
                            'dni' => $this->dni,
                            'name' => $this->name,
                            'lastname' => $this->lastname,
                            'birthdate' => $this->birthdate,
                            'sex' => $this->sex,
                            'weight_kg' => $this->weight_kg,
                            'weight_pounds' => $this->weight_pounds,
                            'height' => $this->height,
                            'blood_type' => $this->blood_type,
                            'family_obs' => $family_obs == '' ? 'Ninguna' : $family_obs,
                            'personal_obs' => $personal_obs == '' ? 'Ninguna' : $personal_obs,
                            'general_obs' => $this->general_obs == '' ? 'Ninguna' : $this->general_obs,
                            'status' => $this->status
                        ); 
                        $req = $this->model->update($this->id_patient, $patientData);
                        
                        if ($req > 0) {
                            $res = array(
                                'status' => true, 
                                'msg' => 'Patient updated successfully'
                            ); 
                        } else if ($req == 'exists') {
                            $res = array(
                                'status' => false, 
                                'msg' => 'This process could not be performed, the patient already exists in our records.'
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

        // Patient delete function
        public function delete() {
            if (Http_DELETE()) {
                if (verifyApiKey()) {
                    $this->id_patient = $_GET['id_patient'];

                    if (empty($this->id_patient)) {
                        $res = array(
                            'status' => false, 
                            'msg' => 'Error! parents ID is required.'
                        );
                    } else {
                        $req = $this->model->delete($this->id_patient, 0);

                        if ($req > 0) {
                            $res = array(
                                'status' => true, 
                                'msg' => 'Patient deleted successfully.'
                            );
                        } else if ($req == "exists") {
                            $res = array(
                                'status' => false, 
                                'msg' => 'This process could not be performed, You cannot delete a patient who has an active medical record.'
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

        // Patient all get function
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

        // Unique patient get function
        public function get() {
            if ($_GET) {
                if (verifyApiKey()) {
                    $this->id_patient = $_GET['id_patient'];
                    $req = $this->model->get($this->id_patient);
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
 
        // Patients all get function for parents
        public function getPatientsForParents() {
            if ($_GET) {
                if (verifyApiKey()) {
                    $this->id_user = $_GET['id_user'];
                    $res = $this->model->getPatientsForParents($this->id_user);
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

        // Appointments all get function for patient
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