<?php
    class Parents_model extends MySQL {
        public function __construct() {
            parent::__construct();
        }

        // New register parents function
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

        public function create($user, $parentsData) {
            $repr = $parentsData['repr'];
            $father_name = $parentsData['father_name'];
            $father_lastname = $parentsData['father_lastname'];
            $mother_name = $parentsData['mother_name'];
            $mother_lastname = $parentsData['mother_lastname'];
            $home_phone = $parentsData['home_phone'];
            $cell_phone = $parentsData['cell_phone'];
            $cell_phone2 = $parentsData['cell_phone2'];
            $home_address = $parentsData['home_address'];
            $status = $parentsData['status'];

            $Query_validate = "SELECT * FROM parents 
                               WHERE (father_name = '$father_name' AND father_lastname = '$father_lastname')
                               OR (mother_name = '$mother_name' AND mother_lastname = '$mother_lastname') AND status != 0";
            $req_validate = $this->SelectAllMySQL($Query_validate);

            if (!empty($req_validate)) {
                $res = 'exists';
            } else {
                $Query = "INSERT INTO parents (user, repr, father_name, father_lastname, mother_name, mother_lastname, home_phone, cell_phone, cell_phone2, home_address, status) 
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $Array = array(
                    $user, $repr, $father_name, $father_lastname, $mother_name, $mother_lastname, 
                    $home_phone, $cell_phone, $cell_phone2, $home_address, $status
                );
                $req = $this->InsertMySQL($Query, $Array);
                $req ?  $res = $req : $res = 0;
            }
            return $res;
        }

        // Patient update function
        public function update($id_parents, $parentsData) {
            $name = $parentsData['name'];
            $lastname = $parentsData['lastname'];
            $repr = $parentsData['repr'];
            $father_name = $parentsData['father_name'];
            $father_lastname = $parentsData['father_lastname'];
            $mother_name = $parentsData['mother_name'];
            $mother_lastname = $parentsData['mother_lastname'];
            $email = $parentsData['email'];
            $home_phone = $parentsData['home_phone'];
            $cell_phone = $parentsData['cell_phone'];
            $cell_phone2 = $parentsData['cell_phone2'];
            $home_address = $parentsData['home_address'];
            $status = $parentsData['status'];

            $Query_validate = "SELECT * FROM parents 
                               WHERE father_name = '$father_name' AND father_lastname = '$father_lastname'
                                AND mother_name = '$mother_name' AND mother_lastname = '$mother_lastname'
                                AND id_parents != '$id_parents' AND status != 0";
            $req_validate = $this->SelectAllMySQL($Query_validate);

            if (!empty($req_validate)) {
                $res = 'exists';
            } else {
                $Query = "UPDATE parents ps INNER JOIN user us ON (ps.user = us.id_user)
                                 SET us.name=?, us.lastname=?, us.email=?, ps.repr=?,
                                 ps.father_name=?, ps.father_lastname=?, ps.mother_name=?, ps.mother_lastname=?,
                                 ps.home_phone=?, ps.cell_phone=?, ps.cell_phone2=?, ps.home_address=?, ps.status=? 
                                 WHERE ps.id_parents = $id_parents";
                $Array = array(
                    $name, $lastname, $email, $repr,
                    $father_name, $father_lastname, $mother_name, $mother_lastname,
                    $home_phone, $cell_phone, $cell_phone2, $home_address, $status
                );
                $req = $this->UpdateMySQL($Query, $Array);
                $req ?  $res = 1 : $res = 0;
            }
            return $res;            
        }

        // Parents delete function
        public function delete($id_parents, $status) {
            $Query_validate = "SELECT * FROM patient WHERE parents = '$id_parents' AND status != 0";
            $req_validate = $this->SelectAllMySQL($Query_validate);

            if (!empty($req_validate)) {
                $res = "exists";
            } else {
                $Query = "UPDATE parents ps INNER JOIN user us ON (ps.user=us.id_user)
                            SET ps.status=?, us.status=? WHERE id_parents = $id_parents";
                $Array = array($status, $status);
                $req = $this->UpdateMySQL($Query, $Array);
                $req ?  $res = 1 : $res = 0;
            }
            return $res;
        }

        // Parents all get function
        public function getAll() {
            $Query = "SELECT * FROM parents WHERE status != 0 ORDER BY id_parents DESC"; 
            return $this->SelectAllMySQL($Query);
        }

        // Unique parents get function
        public function get($id_parents) {
            $Query = "SELECT us.username, us.email, us.name, us.lastname, ps.*,
                        CONCAT(us.name, ' ', us.lastname) AS representative,
                        CONCAT(ps.father_name, ' ', ps.father_lastname) AS father, 
                        CONCAT(ps.mother_name, ' ', ps.mother_lastname) AS mother
                        FROM parents ps 
                        INNER JOIN user us 
                        ON (ps.user=us.id_user) 
                        WHERE id_parents = $id_parents";
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