<?php
    class Login_model extends MySQL {
        public function __construct() {
            parent::__construct();
        }

        public function selectUser(String $username, String $password) {
            $Query_Select = "SELECT u.id_user, u.status  FROM user u
                             WHERE (u.username = '$username' OR u.email = '$username') 
                             AND  u.password = '$password' AND u.status != 0 ";
            $res = $this->SelectMySQL($Query_Select);
            return $res;
        }

        public function sessionUser(int $id_user) {
            $Query_Select = "SELECT u.id_user, u.username, u.email, u.status
                            FROM user u 
                            WHERE u.id_user = $id_user";
            $res = $this->SelectMySQL($Query_Select);
            return $res;
        }

        public function SelectRolesUser(int $id_user) {
            $Query_Select = "SELECT r.id_rol, r.rol
                            FROM rol r INNER JOIN user_roles ur ON (ur.rol=r.id_rol) 
                            WHERE ur.user = $id_user";
            $res = $this->SelectAllMySQL($Query_Select);
            return $res;
        }

        public function permissionsRol(int $id_rol) {
            $Query_Select = "SELECT module, r, w, u, d FROM permissions WHERE rol = $id_rol";
            $res = $this->SelectMySQL($Query_Select);
            return $res;
        }

        public function SelectUserEmail(String $email) {
            $Query_Select = "SELECT id_user, username, status FROM user WHERE email='$email' AND status=1";
            $res = $this->SelectMySQL($Query_Select);
            return $res;
        }

        public function InsertTokenUser(int $id_user, string $token) {
			$Query_Update = "UPDATE user SET token=? WHERE id_user = $id_user";
            $Array_Query = array($token);
            $res = $this->UpdateMySQL($Query_Update, $Array_Query);
            return $res;
		}

        public function SelectUserToken(String $email, String $token) {
            $Query_Select = "SELECT id_user FROM user WHERE email='$email' AND token='$token' AND status=1";
            $res = $this->SelectMySQL($Query_Select);
            return $res;
        }

        public function UpdatePassword(int $id_user, String $password) {  
            $Query_Update = "UPDATE user SET password=?, token=? WHERE id_user=$id_user";
            $Array_Query = array($password, "");
            $res = $this->UpdateMySQL($Query_Update, $Array_Query);
            return $res;
        }
    }
?>