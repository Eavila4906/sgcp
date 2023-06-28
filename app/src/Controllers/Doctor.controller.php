<?php
    class Doctor extends Controllers {
        public function __constructor() {
            parent::__constructor();
        }

        // New register doctor function
        public function create() {
            if ($_POST) {
                if (verifyApiKey()) {
                    $this->name = $_POST['name'];
                    $this->lastname = $_POST['lastname'];
                    $this->email = $_POST['email'];
                    $this->specialty = $_POST['specialty'];
                    $this->cell_phone = $_POST['cell_phone'];
                    $this->home_address = $_POST['home_address'];
                    $this->rol = 4;
                    $this->status = $_POST['status'];

                    if (empty($this->name) || empty($this->lastname) || empty($this->email) || empty($this->specialty)) {
                        $res = array(
                            'status' => false, 
                            'msg' => 'All fields are required.'
                        );
                    } else {
                        $this->username = usernameGenerator($this->name, $this->lastname, date("d-m-Y h:i:s"));
                        $this->password = passGenerator();
                        $this->password_hash = hash('SHA256', passGenerator());
                        $userData = array(
                            'name' => $this->name,
                            'lastname' => $this->lastname,
                            'username' => $this->username, 
                            'password' => $this->password_hash, 
                            'email' => $this->email
                        ); 
                        $req_id_user = $this->model->createUser($userData);

                        if ($req_id_user > 0) {
                            $roles = $this->model->getRoles();
                            foreach ($roles as $rol) {
                                $id_rol = $rol['id_rol'];
                                $status = $rol['id_rol'] == $this->rol ? 1 : 0; 
                                $this->model->AssignUserRoles($req_id_user, $id_rol, $status);
                            }
                            $dataNewUser = array(
                                'user' => $this->name." ".$this->lastname,
                                'username' => $this->username,
                                'password' => $this->password,
                                'email' => $this->email,
                                'affair' => 'Bienvenido - Credenciales de acceso - '.SENDER_NAME,
                                'url' => BASE_URL()
                            );

                            $doctorData = array(
                                'user' => $req_id_user,
                                'specialty' => $this->specialty,
                                'cell_phone' => $this->cell_phone,
                                'home_address' => $this->home_address,
                                'status' => $this->status
                            ); 
                            $req = $this->model->create($doctorData);
                            $sendEmail = sendEmail($dataNewUser,'AccessCredentials');

                            if ($req > 0) {
                                if ($sendEmail) {
                                    $res = array(
                                        'status' => true, 
                                        'msg' => 'Successfully registered doctor.'
                                    ); 
                                } else {
                                    $res = array(
                                        'status' => true, 
                                        'msg' => 'Successfully registered doctor, but there was an error sending the email.',
                                        'pass' => $this->password
                                    ); 
                                }
                            } else if ($req_id_user == 'exists') {
                                $res = array(
                                    'status' => false, 
                                    'msg' => 'This process could not be performed, the doctor already exists in our records.'
                                ); 
                            } else {
                                $res = array(
                                    'status' => false, 
                                    'msg' => 'This process could not be performed, please try again later [ERROR_DOCTOR].'
                                ); 
                            }
                        } else if ($req_id_user == 'exists') {
                            $res = array(
                                'status' => false, 
                                'msg' => 'This process could not be performed, the user already exists in our records.'
                            ); 
                        } else {
                            $res = array(
                                'status' => false, 
                                'msg' => 'This process could not be performed, please try again later [ERROR_USER].'
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

        // Doctor update function
        public function update() {
            if ($_POST) {
                if (verifyApiKey()) {
                    $this->id_doctor = $_POST['id_doctor'];
                    $this->name = $_POST['name'];
                    $this->lastname = $_POST['lastname'];
                    $this->email = $_POST['email'];
                    $this->specialty = $_POST['specialty'];
                    $this->cell_phone = $_POST['cell_phone'];
                    $this->home_address = $_POST['home_address'];
                    $this->status = $_POST['status'];

                    if (empty($this->id_doctor) || empty($this->name) || empty($this->lastname) 
                        || empty($this->email) || empty($this->specialty) || empty($this->cell_phone)
                        || empty($this->home_address)) {
                        $res = array(
                            'status' => false, 
                            'msg' => 'All fields are required.'
                        );
                    } else {
                        $doctorData = array(
                            'name' => $this->name,
                            'lastname' => $this->lastname,
                            'email' => $this->email,
                            'specialty' => $this->specialty,
                            'cell_phone' => $this->cell_phone,
                            'home_address' => $this->home_address,
                            'status' => $this->status
                        ); 
                        $req = $this->model->update($this->id_doctor, $doctorData);
                        
                        if ($req > 0) {
                            $res = array(
                                'status' => true, 
                                'msg' => 'Doctor updated successfully'
                            ); 
                        } else if ($req == 'exists') {
                            $res = array(
                                'status' => false, 
                                'msg' => 'This process could not be performed, the doctor already exists in our records.'
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

        // Doctor delete function
        public function delete() {
            if (Http_DELETE()) {
                if (verifyApiKey()) {
                    $this->id_doctor = $_GET['id_doctor'];

                    if (empty($this->id_doctor)) {
                        $res = array(
                            'status' => false, 
                            'msg' => 'Error! doctor ID is required.'
                        );
                    } else {
                        $req = $this->model->delete($this->id_doctor, 0);

                        if ($req > 0) {
                            $res = array(
                                'status' => true, 
                                'msg' => 'Doctor deleted successfully.'
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

        // Doctor all get function
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

        // Unique doctor get function
        public function get() {
            if ($_GET) {
                if (verifyApiKey()) {
                    $this->id_doctor = $_GET['id_doctor'];
                    $req = $this->model->get($this->id_doctor);
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

        // Unique doctor for user get function
        public function getUniqueDoctor() {
            if ($_GET) {
                if (verifyApiKey()) {
                    $this->id_user = $_GET['id_user'];
                    $req = $this->model->getUniqueDoctor($this->id_user);
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