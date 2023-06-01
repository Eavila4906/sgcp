<?php
    class Doctor_model extends MySQL {
        public function __construct() {
            parent::__construct();
        }

        // New register doctor function
        public function createUser($userData) {
            $name = $userData['name'];
            $lastname = $userData['lastname'];
            $username = $userData['username'];
            $password = $userData['password'];
            $email = $userData['email'];
            $status = 1;

            $Query_validate = "SELECT * FROM user WHERE (username = '$username' OR email = '$email') AND status != 0";
            $req_validate = $this->SelectAllMySQL($Query_validate);

            if (!empty($req_validate)) {
                $res = 'exists';
            } else {
                $Query = "INSERT INTO user (name, lastname, username, password, email, status) VALUES (?, ?, ?, ?, ?, ?)";
                $Array = array($name, $lastname, $username, $password, $email, $status);
                $req = $this->InsertMySQL($Query, $Array);
                $req ?  $res = $req : $res = 0;
            }
            return $res;
        }

        public function create($doctorData) {
            $user = $doctorData['user'];
            $specialty = $doctorData['specialty'];
            $cell_phone = $doctorData['cell_phone'];
            $home_address = $doctorData['home_address'];
            $status = $doctorData['status'];
            $Query = "INSERT INTO doctor (user, specialty, cell_phone, home_address, status) 
                        VALUES (?, ?, ?, ?, ?)";
            $Array = array(
                $user, $specialty, $cell_phone, $home_address, $status
            );
            $req = $this->InsertMySQL($Query, $Array);
            $req ?  $res = $req : $res = 0;
            return $res;
        }

        // Doctor update function
        public function update($id_doctor, $doctorData) {
            $name = $doctorData['name'];
            $lastname = $doctorData['lastname'];
            $email = $doctorData['email'];
            $specialty = $doctorData['specialty'];
            $cell_phone = $doctorData['cell_phone'];
            $home_address = $doctorData['home_address'];
            $status = $doctorData['status'];

            $Query_validate = "SELECT * FROM doctor dc INNER JOIN user us ON (dc.user=us.id_user)
                                        WHERE us.email = '$email' AND id_doctor != $id_doctor";
            $req_validate = $this->SelectAllMySQL($Query_validate);

            if (!empty($req_validate)) {
                $res = 'exists';
            } else {
                $Query = "UPDATE doctor dc INNER JOIN user us ON (dc.user=us.id_user)
                            SET us.name=?, us.lastname=?, us.email=?, dc.specialty=?,
                                 dc.cell_phone=?, dc.home_address=?, dc.status=?
                            WHERE id_doctor = $id_doctor";
                $Array = array(
                    $name, $lastname, $email, $specialty, $cell_phone, $home_address, $status
                );
                $req = $this->UpdateMySQL($Query, $Array);
                $req ?  $res = 1 : $res = 0;
            }
            return $res;
        }

        // Doctor delete function
        public function delete($id_doctor, $status) {
            $Query = "UPDATE doctor dc INNER JOIN user us ON (us.id_user=dc.user) 
                      SET dc.status=?, us.status=? WHERE id_doctor = $id_doctor";
            $Array = array($status, $status);
            $req = $this->UpdateMySQL($Query, $Array);
            $req ?  $res = 1 : $res = 0;
            return $res;
        }

        // Doctor all get function
        public function getAll() {
            $Query = "SELECT us.name, us.lastname, us.username, us.email, dc.* 
                      FROM doctor dc INNER JOIN user us ON (dc.user=us.id_user) WHERE dc.status != 0"; 
            return $this->SelectAllMySQL($Query);
        }

        // Unique doctor get function
        public function get($id_doctor) {
            $Query = "SELECT us.name, us.lastname, us.username, us.email, dc.*
                      FROM doctor dc INNER JOIN user us ON (dc.user=us.id_user) 
                      WHERE dc.id_doctor = $id_doctor";
            return $this->SelectMySQL($Query);
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
    }
?>