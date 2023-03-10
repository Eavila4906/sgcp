<?php
    class User_model extends MySQL {
        public function __construct() {
            parent::__construct();
        }

        // New register user function
        public function create($username, $password, $email, $status) {
            $Query_validate = "SELECT * FROM user WHERE username = '$username' OR email = '$email'";
            $req_validate = $this->SelectAllMySQL($Query_validate);

            if (!empty($req_validate)) {
                $res = "exists";
            } else {
                $Query = "INSERT INTO user (username, password, email, status) VALUES (?, ?, ?, ?)";
                $Array = array($username, $password, $email, $status);
                $req = $this->InsertMySQL($Query, $Array);
                if ($req) {
                    $res = 1;
                } else {
                    $res = 0;
                } 
            }
            return $res;
        }

        // User update function
        public function update($id_user, $username, $password, $email, $status) {
            $Query_validate = "SELECT * FROM user WHERE username = '$username' OR email = '$email' AND id_user != '$id_user'";
            $req_validate = $this->SelectAllMySQL($Query_validate);

            if (!empty($req_validate)) {
                $res = "exists";
            } else {
                if (empty($password)) {
                    $Query = "UPDATE user SET username, password, email, status WHERE id_user = '$id_user'";
                    $Array = array($username, $email, $status);
                } else {
                    $Query = "UPDATE user SET username, email, status WHERE id_user = '$id_user'";
                    $Array = array($username, $password, $email, $status);
                }
                $req = $this->UpdateMySQL($Query, $Array);

                if ($req) {
                    $res = 1;
                } else {
                    $res = 0;
                } 
            }
            return $res;
        }

        // User delete function
        public function delete($id_user, $status) {
            $Query = "UPDATE user SET status=? WHERE id_user = '$id_user'";
            $Array = array($status);
            $req = $this->UpdateMySQL($Query, $Array);
            if ($req) {
                $res = 1;
            } else {
                $res = 0;
            } 
            return $res;
        }

        // Users all get function
        public function getAll() {
            $Query = "SELECT us.id_user, us.username, us.email, GROUP_CONCAT(rl.rol SEPARATOR ', ') AS rol, us.status 
                      FROM user_roles ur INNER JOIN user us ON (us.id_user=ur.user)
                      INNER JOIN rol rl ON (rl.id_rol=ur.rol) GROUP BY us.username";
            return $this->SelectAllMySQL($Query);
        }

        // Unique user get function
        public function get($id_user) {
            $Query = "SELECT us.id_user, us.username, us.email, GROUP_CONCAT(rl.rol SEPARATOR ', ') AS rol, us.status 
                      FROM user_roles ur INNER JOIN user us ON (us.id_user=ur.user)
                      INNER JOIN rol rl ON (rl.id_rol=ur.rol) WHERE us.id_user = '$id_user'";
            return $this->SelectMySQL($Query);
        }
    }
?>