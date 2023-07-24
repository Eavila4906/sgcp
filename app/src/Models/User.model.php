<?php
    class User_model extends MySQL {
        public function __construct() {
            parent::__construct();
        }

        // New register user function
        public function create($name, $lastname, $username, $password, $email, $rol, $status) {
            $Query_validate = "SELECT * FROM user WHERE (username = '$username' OR email = '$email') AND status != 0";
            $req_validate = $this->SelectAllMySQL($Query_validate);

            if (!empty($req_validate)) {
                $res = "exists";
            } else {
                //Insert user data in table user
                $Query = "INSERT INTO user (name, lastname, username, password, email, status) VALUES (?, ?, ?, ?, ?, ?)";
                $Array = array($name, $lastname, $username, $password, $email, $status);
                $req = $this->InsertMySQL($Query, $Array);
                if ($req) {
                    $res = $req;
                } else {
                    $res = 0;
                } 
            }
            return $res;
        }

        // User update function
        public function update($id_user, $name, $lastname, $username, $password, $email, $status) {
            $Query_validate = "SELECT * FROM user WHERE (username = '$username' OR email = '$email') AND id_user != '$id_user' AND status != 0";
            $req_validate = $this->SelectAllMySQL($Query_validate);

            if (!empty($req_validate)) {
                $res = "exists";
            } else {
                if (empty($password)) {
                    $Query = "UPDATE user SET name=?, lastname=?, username=?, email=?, status=? WHERE id_user = '$id_user'";
                    $Array = array($name, $lastname, $username, $email, $status);
                } else {
                    $Query = "UPDATE user SET name=?, lastname=?, username=?, password=?, email=?, status=? WHERE id_user = '$id_user'";
                    $Array = array($name, $lastname, $username, $password, $email, $status);
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
                      FROM user_roles ur 
                      INNER JOIN user us ON (us.id_user=ur.user)
                      INNER JOIN rol rl ON (rl.id_rol=ur.rol) 
                      WHERE ur.status != 0 AND us.status != 0 GROUP BY us.username ORDER BY us.id_user DESC";
            return $this->SelectAllMySQL($Query);
        }

        // Unique user get function
        public function get($id_user) {
            $Query = "SELECT us.id_user, name, lastname, us.username, us.email, GROUP_CONCAT(rl.rol SEPARATOR ', ') AS rol, us.status 
                      FROM user_roles ur INNER JOIN user us ON (us.id_user=ur.user)
                      INNER JOIN rol rl ON (rl.id_rol=ur.rol) WHERE ur.status != 0 AND us.id_user = '$id_user'";
            return $this->SelectMySQL($Query);
        }

        // Extract user_roles function
        public function getUserRoles($id_user) {
            $Query = "SELECT * FROM user_roles WHERE user = $id_user";
            return $this->SelectAllMySQL($Query);
        }

        // Extract rol function
        public function getRoles() {
            $Query = "SELECT id_rol, rol FROM rol WHERE status = 1";
            return $this->SelectAllMySQL($Query);
        }

        // Assign user roles function
        public function AssignUserRoles($id_user, $rol, $status) {
            $Query = "INSERT INTO user_roles (user, rol, status) VALUES (?, ?, ?)";
            $Array = array($id_user, $rol, $status);
            return $this->InsertMySQL($Query, $Array); 
        }

        // user roles delete function
        public function deleteUserRoles($id_user) {
            $Query = "DELETE FROM user_roles WHERE user = $id_user";
            return $this->DeleteMySQL($Query);
        }

        //Change user password function
        public function ChangePassword($dataChangePassword){
            $id_user = $dataChangePassword['id_user'];
            $current_password = $dataChangePassword['current_password'];
            $new_password = $dataChangePassword['new_password'];

            $Query_validate = "SELECT * FROM user 
                               WHERE id_user = $id_user AND password = '$current_password'";
            $req_validate = $this->SelectAllMySQL($Query_validate);

            if (empty($req_validate)) {
                $res = 'NotPassword';
            } else {
                $Query = "UPDATE user SET password=? WHERE id_user = $id_user";
                $Array = array($new_password);
                $req = $this->UpdateMySQL($Query, $Array);
                $req ?  $res = $req : $res = 0;
            }
            
            return $res;
        }
    }
?>