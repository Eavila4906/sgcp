<?php
    class Notification extends Controllers {
        public function __constructor() {
            parent::__constructor();
        }

        // New register notification function
        public function create() {
            if ($_POST) {
                if (verifyApiKey()) {
                    $this->id_user = $_POST['id_user'];
                    $this->type = $_POST['type'];
                    $this->description = $_POST['description'];
                    $this->status = 1;

                    if (empty($this->id_user) ||  empty($this->type) || empty($this->description)) {
                        $res = array(
                            'status' => false, 
                            'msg' => 'All fields are required.'
                        );
                    } else {
                        $notificationData = array(
                            'type' => $this->type,
                            'description' => $this->description,
                            'status' => $this->status
                        );  
                        $req_id_notification = $this->model->create($notificationData);

                        if ($req_id_notification > 0) {
                            $req = $this->model->createDetails($this->id_user, $req_id_notification);
                            if ($req) {
                                $res = array(
                                    'status' => true, 
                                    'msg' => 'Successfully registered notification.'
                                ); 
                            } else {
                                $res = array(
                                    'status' => false, 
                                    'msg' => 'This process could not be performed, please try again later [ERROR_DETAILS_NOTIFICATION].'
                                );   
                            }
                        } else {
                            $res = array(
                                'status' => false, 
                                'msg' => 'This process could not be performed, please try again later [ERROR_NOTIFICATION].'
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

        // Notification delete function
        public function delete() {
            if (Http_DELETE()) {
                if (verifyApiKey()) {
                    $this->id_notification = $_GET['id_notification'];

                    if (empty($this->id_notification)) {
                        $res = array(
                            'status' => false, 
                            'msg' => 'Error! notification ID is required.'
                        );
                    } else {
                        $req = $this->model->delete($this->id_notification, 0);

                        if ($req > 0) {
                            $res = array(
                                'status' => true, 
                                'msg' => 'Notification deleted successfully.'
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

        // Notification all get function
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

        // Unique notifications user get function
        public function get() {
            if ($_GET) {
                if (verifyApiKey()) {
                    $this->id_notification = $_GET['id_notification'];
                    $req = $this->model->get($this->id_notification);
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

        // Unique notifications user get function
        public function getNotificationsUser() {
            if ($_GET) {
                if (verifyApiKey()) {
                    $this->id_user = $_GET['id_user'];
                    $res = $this->model->getNotificationsUser($this->id_user);
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