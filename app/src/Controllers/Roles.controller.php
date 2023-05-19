<?php
    class Roles extends Controllers {
        public function __construct() {
            parent::__construct();
            $this->className = get_class($this);
            session();
        }

        // New register rol function
        public function create() {
            if ($_POST) {
                if (verifyApiKey()) {
                    $this->rol = $_POST['rol'];
                    $this->description = $_POST['description'];
                    $this->status = $_POST['status'];

                    if (empty($this->rol) || empty($this->description) || empty($this->status)) {
                        $res = array(
                            'status' => false, 
                            'msg' => 'All fields are required.'
                        );
                    } else {
                        $req = $this->model->create($this->rol, $this->description, $this->status);

                        if ($req > 0) {
                            $res = array(
                                'status' => true, 
                                'msg' => 'Successfully registered rol.'
                            );
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
        
        // Rol update function
        public function update() {
            if ($_POST) {
                if (verifyApiKey()) {
                    $this->id_rol = $_POST['id_rol'];
                    $this->rol = $_POST['rol'];
                    $this->description = $_POST['description'];
                    $this->status = $_POST['status'];

                    if (empty($this->id_rol) || empty($this->rol) || empty($this->description) || empty($this->status)) {
                        $res = array(
                            'status' => false, 
                            'msg' => 'All fields are required.'
                        );
                    } else {
                        $req = $this->model->update($this->id_rol, $this->rol, $this->description, $this->status);
                        
                        if ($req > 0) {
                            $res = array(
                                'status' => true, 
                                'msg' => 'Rol updated successfully.'
                            ); 
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

        // Rol delete function
        public function delete() {
            if (Http_DELETE()) {
                if (verifyApiKey()) {
                    $this->id_rol = $_GET['id_rol'];

                    if (empty($this->id_rol)) {
                        $res = array(
                            'status' => false, 
                            'msg' => 'Error! rol ID is required.'
                        );
                    } else {
                        $req = $this->model->delete($this->id_rol, 0);

                        if ($req > 0) {
                            $res = array(
                                'status' => true, 
                                'msg' => 'rol deleted successfully.'
                            );
                        } else if ($req == "exists") {
                            $res = array(
                                'status' => false, 
                                'msg' => 'This process could not be performed, a role that is assigned to a user cannot be deleted.'
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

        // Rol all get function
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

        // Unique rol get function
        public function get() {
            if ($_GET) {
                if (verifyApiKey()) {
                    $this->id_rol = $_GET['id_rol'];
                    $req = $this->model->get($this->id_rol);
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