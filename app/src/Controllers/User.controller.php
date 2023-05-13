<?php
    class User extends Controllers {
        public function __construct() {
            parent::__construct();
            $this->className = get_class($this);
        }

        // New register user function
        public function create() {
            if ($_POST) {
                $this->name = $_POST['name'];
                $this->lastname = $_POST['lastname'];
                $this->email = $_POST['email'];
                $this->rol = $_POST['rol'];
                $this->status = $_POST['status'];

                if (empty($this->name) || empty($this->lastname) || empty($this->email) || empty($this->rol) || empty($this->status)) {
                    $res = array(
                        'status' => false, 
                        'msg' => 'All fields are required.'
                    );
                } else {
                    $this->username = usernameGenerator($this->name, $this->lastname, date("d-m-Y h:i:s"));
                    $this->password = passGenerator();
                    $this->password_hash = hash('SHA256', passGenerator());
                    $req = $this->model->create(
                        $this->name,
                        $this->lastname,
                        $this->username, 
                        $this->password_hash, 
                        $this->email,
                        $this->rol,
                        $this->status
                    );

                    

                    if ($req > 0) {
                        $roles = $this->model->getRoles();
                        foreach ($roles as $rol) {
                            $id_rol = $rol['id_rol'];
                            $status = $rol['id_rol'] == $this->rol ? 1 : 0; 
                            $this->model->AssignUserRoles($req, $id_rol, $status);
                        }
                        
                        $dataNewUser = array(
                            'user' => $this->name." ".$this->lastname,
                            'username' => $this->username,
                            'password' => $this->password,
                            'email' => $this->email,
                            'affair' => 'Bienvenido - Credenciales de acceso - '.SENDER_NAME,
                            'url' => BASE_URL()
                        );
                        $sendEmail = sendEmail($dataNewUser,'AccessCredentials');
                        if ($sendEmail) {
                            $res = array(
                                'status' => true, 
                                'msg' => 'Successfully registered user.'
                            ); 
                        } else {
                            $res = array(
                                'status' => true, 
                                'msg' => 'Successfully registered user, but there was an error sending the email.',
                                'pass' => $this->password
                            ); 
                        }
                    } else if ($req == "exists") {
                        $res = array(
                            'status' => false, 
                            'msg' => 'This process could not be performed, the user already exists in our records.'
                        ); 
                    } else {
                        $res = array(
                            'status' => false, 
                            'msg' => 'This process could not be performed, please try again later.'
                        ); 
                    }
                }
                echo json_encode($res, JSON_UNESCAPED_UNICODE);
            }   
            die();
        }
        
        // User update function
        public function update() {
            if ($_POST) {
                $this->id_user = $_POST['id_user'];
                $this->name = $_POST['name'];
                $this->lastname = $_POST['lastname'];
                $this->email = $_POST['email'];
                $this->password = $_POST['newpassword'];
                $this->status = $_POST['status'];

                if (empty($this->id_user) || empty($this->name) || empty($this->lastname) || empty($this->email) || empty($this->status)) {
                    $res = array(
                        'status' => false, 
                        'msg' => 'All fields are required except the password field.'
                    );
                } else {
                    $this->username = usernameGenerator($this->name, $this->lastname, date("d-m-Y h:i:s"));
                    $this->passwordUpdate = hash('SHA256', $this->password);
                    $req = $this->model->update(
                        $this->id_user, 
                        $this->name, 
                        $this->lastname, 
                        $this->username, 
                        $this->passwordUpdate, 
                        $this->email, 
                        $this->status
                    );
                    
                    if ($req > 0) {
                        $dataNewUser = array(
                            'user' => $this->name." ".$this->lastname,
                            'username' => $this->username,
                            'password' => $this->password,
                            'email' => $this->email,
                            'affair' => 'Actualización - Credenciales de acceso - '.SENDER_NAME,
                            'url' => BASE_URL()
                        );
                        $sendEmail = sendEmail($dataNewUser,'UpdatedAccessCredentials');
                        if ($sendEmail) {
                            $res = array(
                                'status' => true, 
                                'msg' => 'User updated successfully.'
                            ); 
                        } else {
                            $res = array(
                                'status' => true, 
                                'msg' => 'User updated successfully, but there was an error sending the email.'
                            ); 
                        }
                    } else if ($req == "exists") {
                        $res = array(
                            'status' => false, 
                            'msg' => 'This process could not be performed, the rol already exists in our records.'
                        ); 
                    } else {
                        $res = array(
                            'status' => false, 
                            'msg' => 'This process could not be performed, please try again later.'
                        ); 
                    }
                }
                echo json_encode($res, JSON_UNESCAPED_UNICODE);
            }
            die();
        }

        // User delete function
        public function delete() {
            if (Http_DELETE()) {
                $this->id_user = $_GET['id_user'];

                if (empty($this->id_user)) {
                    $res = array(
                        'status' => false, 
                        'msg' => 'Error! user ID is required.'
                    );
                } else {
                    $req = $this->model->delete($this->id_user, 0);

                    if ($req > 0) {
                        $res = array(
                            'status' => true, 
                            'msg' => 'User deleted successfully.'
                        );
                    } else {
                        $res = array(
                            'status' => false, 
                            'msg' => 'This process could not be performed, please try again later.'
                        ); 
                    }
                }
                echo json_encode($res, JSON_UNESCAPED_UNICODE);
            }
            die();
        } 

        // Users all get function
        public function getAll() {
            if ($_GET) {
                $res = $this->model->getAll();
                echo json_encode($res, JSON_UNESCAPED_UNICODE);
            }
            die();
        }

        // Unique user get function
        public function get() {
            if ($_GET) {
                $this->id_user = $_GET['id_user'];
                $req = $this->model->get($this->id_user);
                $res = array(
                    'status' => true, 
                    'data' => $req
                );
                echo json_encode($res, JSON_UNESCAPED_UNICODE);
            }
            die();
        }

        // Extract permissions function
        public function getUserRoles() {
            if ($_GET) {
                $this->id_user = intval($_GET['id_user']);

                if ($this->id_user > 0) {
                    $req_rol = $this->model->getRoles();
                    $req_user_roles = $this->model->getUserRoles($this->id_user);
                    
                    $reqUserRoles = array(
                        'status' => 0
                    );

                    $reqUR = array(
                        'id_user' => $this->id_user
                    );

                    if (empty($req_user_roles)) {
                        for ($i=0; $i < count($req_rol); $i++) { 
                            $req_rol[$i]['userRoles'] = $reqUserRoles;
                        }
                    } else {
                        for ($i=0; $i < count($req_rol); $i++) { 
                            $reqUserRoles = array(
                                'status' => 0
                            );
                            if (isset($req_user_roles[$i])) {
                                $reqUserRoles = array(
                                    'status' => $req_user_roles[$i]['status']
                                );
                            }
                            $req_rol[$i]['userRoles'] = $reqUserRoles;  
                        }   
                    }
                    $reqUR['rol'] = $req_rol;
                    //$html = getModal('permisos_modal', $reqPermissionsRol);
                    $res = array(
                        'status' => true, 
                        'data' => $reqUR
                    );
                }
                echo json_encode($res, JSON_UNESCAPED_UNICODE);
            }
            die();
        }

        // Assign user roles function
        public function AssignUserRoles() {
            if ($_POST) {
                $id_user = intval($_POST['id_user']);
                $roles = $_POST['rol'];

                $this->model->deleteUserRoles($id_user);
                foreach ($roles as $rol) {
                    $id_rol = $rol['id_rol'];
                    $status = empty($rol['status']) ? 0 : 1; 
                    $req = $this->model->AssignUserRoles($id_user, $id_rol, $status);
                }

                if ($req > 0) {
                    $res = array(
                        'status' => true, 
                        'msg' => 'Roles assigned successfully.'
                    );
                } else {
                    $res = array(
                        'status' => false, 
                        'msg' => 'This process could not be performed, please try again later.'
                    );
                }
                echo json_encode($res, JSON_UNESCAPED_UNICODE);
            }
            die();
        }
    }
?>