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
                $this->status = 1;

                if (empty($this->name) || empty($this->lastname) || empty($this->email)) {
                    $res = array(
                        'status' => false, 
                        'msg' => 'All fields are required.'
                    );
                } else {
                    $this->username = usernameGenerator($this->name, $this->lastname, date("d-m-Y h:i:s"));
                    $this->password = passGenerator();
                    $this->password_hash = hash('SHA256', passGenerator());
                    $req = $this->model->create($this->username, $this->password_hash, $this->email, $this->status);

                    if ($req > 0) {
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
            if (Http_PUT()) {
                $this->id_user = $_POST['id_user'];
                $this->name = $_POST['name'];
                $this->lastname = $_POST['lastname'];
                $this->email = $_POST['email'];
                $this->password = $_POST['password'];
                $this->status = $_POST['status'];

                if (empty($this->id_user) || empty($this->name) || empty($this->lastname) || empty($this->email)) {
                    $res = array(
                        'status' => false, 
                        'msg' => 'All fields are required except the password field.'
                    );
                } else {
                    $this->username = usernameGenerator($this->name, $this->lastname, date("d-m-Y h:i:s"));
                    $this->passwordUpdate = hash('SHA256', $this->password);
                    $req = $this->model->update($this->id_user, $this->username, $this->passwordUpdate, $this->email, $this->status);
                    
                    if ($req > 0) {
                        $dataNewUser = array(
                            'user' => $this->name." ".$this->lastname,
                            'username' => $this->username,
                            'password' => $this->password,
                            'email' => $this->email,
                            'affair' => 'Actualización - Credenciales de acceso - '.SENDER_NAME,
                            'url' => BASE_URL()
                        );
                        $sendEmail = sendEmail($dataNewUser,'UpdatedAccessCredential.email');
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
    }
?>