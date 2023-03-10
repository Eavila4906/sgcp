<?php
    class Roles_model extends MySQL {
        public function __construct() {
            parent::__construct();
        }

        // New register rol function
        public function create($rol, $description, $status) {
            $Query_validate = "SELECT * FROM rol WHERE rol = '$rol'";
            $req_validate = $this->SelectAllMySQL($Query_validate);

            if (!empty($req_validate)) {
                $res = "exists";
            } else {
                $Query = "INSERT INTO rol (rol, description, status) VALUES (?, ?, ?)";
                $Array = array($rol, $description, $status);
                $req = $this->InsertMySQL($Query, $Array);
                if ($req) {
                    $res = 1;
                } else {
                    $res = 0;
                } 
            }
            return $res;
        }

        // Rol update function
        public function update($id_rol, $rol, $description, $status) {
            $Query_validate = "SELECT * FROM rol WHERE rol = '$rol' AND id_rol != '$id_rol'";
            $req_validate = $this->SelectAllMySQL($Query_validate);

            if (!empty($req_validate)) {
                $res = "exists";
            } else {
                $Query = "UPDATE rol SET rol=?, description=?, status=? WHERE id_rol = '$id_rol'";
                $Array = array($rol, $description, $status);
                $req = $this->UpdateMySQL($Query, $Array);

                if ($req) {
                    $res = 1;
                } else {
                    $res = 0;
                } 
            }
            return $res;
        }

        // Rol delete function
        public function delete($id_rol, $status) {
            $Query_validate = "SELECT * FROM user_roles WHERE rol = '$id_rol'";
            $req_validate = $this->SelectAllMySQL($Query_validate);

            if (!empty($req_validate)) {
                $res = "exists";
            } else {
                $Query = "UPDATE rol SET status=? WHERE id_rol = '$id_rol'";
                $Array = array($status);
                $req = $this->UpdateMySQL($Query, $Array);
                if ($req) {
                    $res = 1;
                } else {
                    $res = 0;
                } 
            }
            return $res;
        }

        // Rol all get function
        public function getAll() {
            $Query = "SELECT * FROM rol WHERE status != 0"; 
            return $this->SelectAllMySQL($Query);
        }

        // Unique rol get function
        public function get($id_rol) {
            $Query = "SELECT * FROM rol WHERE id_rol = '$id_rol'";
            return $this->SelectMySQL($Query);
        }
    }
?>