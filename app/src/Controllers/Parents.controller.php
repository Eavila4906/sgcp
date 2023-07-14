<?php
    class Parents extends Controllers {
        public function __constructor() {
            parent::__constructor();
        }

        // New register parents function
        public function create() {
            if ($_POST) {
                if (verifyApiKey()) {
                    //Data personal
                    $this->father_name = $_POST['father_name'];
                    $this->father_lastname = $_POST['father_lastname'];
                    $this->mother_name = $_POST['mother_name'];
                    $this->mother_lastname = $_POST['mother_lastname'];
                    //Representative
                    $this->repr_check = $_POST['repr_check'];
                    $this->repr_name = $_POST['repr_name'];
                    $this->repr_lastname = $_POST['repr_lastname'];
                    //Contacts
                    $this->home_phone = $_POST['home_phone'];
                    $this->cell_phone = $_POST['cell_phone'];
                    $this->cell_phone2 = $_POST['cell_phone2'];
                    $this->email = $_POST['email'];
                    $this->home_address = $_POST['home_address'];
                    $this->rol = 5;
                    $this->status = $_POST['status'];

                    if (empty($this->cell_phone) || empty($this->email) || empty($this->status)) {
                        $res = array(
                            'status' => false, 
                            'msg' => 'All fields are required.'
                        );
                    } else {
                        if ($this->repr_check == 1) {
                            $name = $this->father_name;
                            $lastname = $this->father_lastname;
                        } else if ($this->repr_check == 2) {
                            $name = $this->mother_name;
                            $lastname = $this->mother_lastname;
                        } else if ($this->repr_check == 3) {
                            $name = $this->repr_name;
                            $lastname = $this->repr_lastname;
                        }

                        $this->username = usernameGenerator($name, $lastname, date("h:i:s"));
                        $this->password = passGenerator();
                        $this->password_hash = hash('SHA256', passGenerator());
                        $userData = array(
                            'name' => $name,
                            'lastname' => $lastname,
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
                                'user' => $name." ".$lastname,
                                'username' => $this->username,
                                'password' => $this->password,
                                'email' => $this->email,
                                'affair' => 'Bienvenido - Credenciales de acceso - '.SENDER_NAME,
                                'url' => BASE_URL()
                            );

                            $parentsData = array(
                                'repr' => $this->repr_check,
                                'father_name' => $this->father_name,
                                'father_lastname' => $this->father_lastname,
                                'mother_name' => $this->mother_name,
                                'mother_lastname' => $this->mother_lastname,
                                'home_phone' => $this->home_phone,
                                'cell_phone' => $this->cell_phone,
                                'cell_phone2' => $this->cell_phone2,
                                'home_address' => $this->home_address,
                                'status' => $this->status
                            ); 
                            $req = $this->model->create($req_id_user, $parentsData);

                            if ($req > 0) {
                                $sendEmail = sendEmail($dataNewUser,'AccessCredentials');
                                if ($sendEmail) {
                                    $res = array(
                                        'status' => true, 
                                        'msg' => 'Successfully registered parents.'
                                    ); 
                                } else {
                                    $res = array(
                                        'status' => true, 
                                        'msg' => 'Successfully registered parents, but there was an error sending the email.',
                                        'pass' => $this->password
                                    ); 
                                }
                            } else if ($req_id_user == 'exists') {
                                $res = array(
                                    'status' => false, 
                                    'msg' => 'This process could not be performed, the parents already exists in our records.'
                                ); 
                            } else {
                                $res = array(
                                    'status' => false, 
                                    'msg' => 'This process could not be performed, please try again later [ERROR_PARENTS].'
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

        // Parents update function
        public function update() {
            if ($_POST) {
                if (verifyApiKey()) {
                    //Id parents
                    $this->id_parents = $_POST['id_parents'];
                    //Data personal
                    $this->father_name = $_POST['father_name'];
                    $this->father_lastname = $_POST['father_lastname'];
                    $this->mother_name = $_POST['mother_name'];
                    $this->mother_lastname = $_POST['mother_lastname'];
                    //Representative
                    $this->repr_check = $_POST['repr_check'];
                    $this->repr_name = $_POST['repr_name'];
                    $this->repr_lastname = $_POST['repr_lastname'];
                    //Contacts
                    $this->home_phone = $_POST['home_phone'];
                    $this->cell_phone = $_POST['cell_phone'];
                    $this->cell_phone2 = $_POST['cell_phone2'];
                    $this->email = $_POST['email'];
                    $this->home_address = $_POST['home_address'];
                    $this->status = $_POST['status'];

                    if (empty($this->id_parents) || empty($this->father_name) || empty($this->father_lastname) 
                        || empty($this->mother_name) || empty($this->mother_lastname) || empty($this->home_phone)
                        || empty($this->cell_phone) || empty($this->home_address) || empty($this->status)) {
                        $res = array(
                            'status' => false, 
                            'msg' => 'All fields are required.'
                        );
                    } else {
                        if ($this->repr_check == 1) {
                            $name = $this->father_name;
                            $lastname = $this->father_lastname;
                        } else if ($this->repr_check == 2) {
                            $name = $this->mother_name;
                            $lastname = $this->mother_lastname;
                        } else if ($this->repr_check == 3) {
                            $name = $this->repr_name;
                            $lastname = $this->repr_lastname;
                        }

                        $parentsData = array(
                            'name' => $name,
                            'lastname' => $lastname,
                            'repr' => $this->repr_check,
                            'father_name' => $this->father_name,
                            'father_lastname' => $this->father_lastname,
                            'mother_name' => $this->mother_name,
                            'mother_lastname' => $this->mother_lastname,
                            'email' => $this->email,
                            'home_phone' => $this->home_phone,
                            'cell_phone' => $this->cell_phone,
                            'cell_phone2' => $this->cell_phone2,
                            'home_address' => $this->home_address,
                            'status' => $this->status
                        );

                        $req = $this->model->update($this->id_parents, $parentsData);
                        
                        if ($req > 0) {
                            $res = array(
                                'status' => true, 
                                'msg' => 'Parents updated successfully'
                            );
                        } else if ($req == 'exists') {
                            $res = array(
                                'status' => false, 
                                'msg' => 'This process could not be performed, the parents already exists in our records.'
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

        // Parents delete function
        public function delete() {
            if (Http_DELETE()) {
                if (verifyApiKey()) {
                    $this->id_parents = $_GET['id_parents'];

                    if (empty($this->id_parents)) {
                        $res = array(
                            'status' => false, 
                            'msg' => 'Error! parents ID is required.'
                        );
                    } else {
                        $req = $this->model->delete($this->id_parents, 0);

                        if ($req > 0) {
                            $res = array(
                                'status' => true, 
                                'msg' => 'Parents deleted successfully.'
                            );
                        } else if ($req == "exists") {
                            $res = array(
                                'status' => false, 
                                'msg' => 'This process could not be performed, cannot delete a parent that has patients assigned to it.'
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

        // Parents all get function
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

        // Unique parents get function
        public function get() {
            if ($_GET) {
                if (verifyApiKey()) {
                    $this->id_parents = $_GET['id_parents'];
                    $req = $this->model->get($this->id_parents);
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