<?php
    class Login extends Controllers {
        public function __construct() {
            parent::__construct();
            $this->className = get_class($this);
        }
        
        // Login control function
        public function login() {
            if ($_POST) {
                if (verifyApiKey()) {
                    if (empty($_POST['user']) || empty($_POST['password'])) {
                        $res = array(
                            'status' => false, 
                            'msg' => 'Todos los campos son obligatorios.'
                        );
                    } else {
                        $this->username = strtolower(strClean($_POST['user']));
                        $this->password = hash("SHA256", $_POST['password']);
                        $req = $this->model->selectUser($this->username, $this->password);

                        if (empty($req)) {
                            $res = array(
                                'status' => false, 
                                'msg' => 'Usuario o contraseña incorrecta.'
                            );
                        } else {
                            if ($req['status'] == 1) {
                                session();
                                $_SESSION['id_user'] = $req['id_user'];
                                $_SESSION['login-successful'] = true; 
                                
                                $req_userData = $this->model->sessionUser($_SESSION['id_user']);
                                $req_userRoles = $this->model->SelectRolesUser($_SESSION['id_user']);

                                $_SESSION['userData'] = $req_userData;
                                $username = $req_userData['username'];

                                $res = array(
                                    'status' => true, 
                                    'login' => true,
                                    'username' => $username, 
                                    'roles' => $req_userRoles
                                );
                            } else {
                                $res = array(
                                    'status' => false, 
                                    'msg' => 'Acceso denegado!, Usuario inactivo.'
                                );
                            }  
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

        // Password reset function in case the user loses his password 
        public function PasswordReset() {
            if ($_POST) {
                if (verifyApiKey()) {
                    if (empty($_POST['email'])) {
                        $res = array(
                            'status' => false, 
                            'msg' => 'El campo email es obligatorio.'
                        );
                    } else {
                        $this->token = token();
                        $this->email = $_POST['email'];
                        $req = $this->model->SelectUserEmail($this->email);

                        if (empty($req)) {
                            $res = array(
                                'status' => false, 
                                'msg' => 'El email ingresado no se encuentra asociado con ningún usuario, o aquel usuario esta inactivo.'
                            );
                        } else {
                            $this->id_user = $req['id_user'];
                            $this->username = $req['username'];

                            $this->url_recovery = BASE_URL().'login/PassResetConfirm/'.$this->email.'/'.$this->token;
                            $req_1 = $this->model->InsertTokenUser($this->id_user, $this->token);

                            $this->userData = array(
                                'user' => $this->username,
                                'email' => $this->email,
                                'affair' => 'Recuperar cuenta - '.SENDER_NAME,
                                'url_recovery' => $this->url_recovery
                            );

                            if ($req_1) {
                                $this->sendEmail = sendEmail($this->userData, 'RecoverPassword');

                                if ($this->sendEmail) {
                                    $res = array(
                                        'status' => true, 
                                        'msg' => 'Se ha enviado un email para restablecer tu contraseña, revisa tu correo.'
                                    );
                                } else {
                                    $res = array(
                                        'status' => false, 
                                        'msg' => 'No es posible realizar este proceso, intenta más tarde.',
                                        'url' => $this->url_recovery
                                    );
                                }
                            } else {
                                $res = array(
                                    'status' => false, 
                                    'msg' => 'Unable to perform this process, please try again later.' 
                                );
                            }
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

        // Change password function
        public function PassResetConfirm(String $params) {
            if (empty($params)) {
                header('Location: '.BASE_URL().'error');
            } else {
                $arrayParams = explode(',',$params);
                $email = $arrayParams[0];
                $token = $arrayParams[1];
                $req = $this->model->SelectUserToken($email, $token);
                if (empty($req)) {
                    header('Location: '.BASE_URL().'login');
                } else {
                    $data['service'] = BASE_URL()."app/src/Services/RecoveryPassword.js";
                    $data['id_user'] = $req['id_user'];
                    $data['email'] = $email;
                    $data['token'] = $token;
                    $this->views->getViews($this,"ResetPassword", $data);
                }
            }
            die();
        }

        // Password update function
        public function PasswordUpdate() {
            if ($_POST) {
                if (verifyApiKey()) {
                    if (empty($_POST['id_user']) || empty($_POST['email']) || empty($_POST['token'])) {
                        $res = array(
                            'status' => false, 
                            'msg' => 'Data error, the application may be being tampered with with malicious code.' 
                        );
                        exit;
                    }
                    if (empty($_POST['id_user']) || empty($_POST['token']) || empty($_POST['password']) || empty($_POST['passwordconfirmation'])) {
                        $res = array(
                            'status' => false, 
                            'msg' => 'Todos los campos son obligatorios' 
                        );
                    } else {
                        $this->id_user = intval($_POST['id_user']);
                        $this->password = $_POST['password'];
                        $this->passwordconfirmation = $_POST['passwordconfirmation'];
                        $this->email = $_POST['email'];
                        $this->token = $_POST['token'];

                        if ($this->password != $this->passwordconfirmation) {
                            $res = array(
                                'status' => false, 
                                'msg' => 'Las contraseñas no son iguales.'
                            );
                        } else {
                            $req = $this->model->SelectUserToken($this->email, $this->token);

                            if (empty($req)) {
                                $res = array(
                                    'status' => false, 
                                    'msg' => 'Data error, the application may be being tampered with with malicious code.' 
                                );
                            } else {
                                $this->passwordHash = hash("SHA256", $this->password);
                                $req_1 = $this->model->UpdatePassword($this->id_user, $this->passwordHash);

                                if ($req_1) {
                                    $res = array(
                                        'status' => true, 
                                        'msg' => 'Su contraseña ha sido actualizada con éxito.'
                                    );
                                } else {
                                    $res = array(
                                        'status' => false, 
                                        'msg' => 'No es posible realizar este proceso, intente más tarde.'
                                    );
                                }
                            }
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
    }
?>