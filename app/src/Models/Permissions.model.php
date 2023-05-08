<?php
    class Permissions_model extends MySQL {
        public function __construct(){
            parent::__construct();
        }

        // Extract modules function
        public function getModules() {
            $Query = "SELECT * FROM module WHERE status != 0";
            return $this->SelectAllMySQL($Query);
        }

        // Extract permissions function
        public function getPermissions($id_rol) {
            $Query = "SELECT * FROM permissions WHERE rol = $id_rol";
            return $this->SelectAllMySQL($Query);
        }

        // Assign permissions function
        public function create($id_rol, $modulo, $r, $w, $u, $d) {
            $Query = "INSERT INTO permissions (rol, module, r, w, u, d) VALUES (?, ?, ?, ?, ?, ?)";
            $Array = array($id_rol, $modulo, $r, $w, $u, $d);
            return $this->InsertMySQL($Query, $Array); 
        }

        // Permission delete function
        public function delete($id_rol) {
            $Query = "DELETE FROM permissions WHERE rol = $id_rol";
            return $this->DeleteMySQL($Query);
        }

        // Extract permissions function sesion
        public function modulesPermissions($id_rol){
            $Query = "SELECT p.rol, p.module, m.module AS nameModule, p.r, p.w, p.u, p.d
                            FROM permissions p INNER JOIN module m 
                            ON (p.module=m.id_module)
                            WHERE p.rol = $id_rol";
            $result = $this->SelectAllMySQL($Query);

            $reqPermissions = array();
            for ($i=0; $i < count($result); $i++) { 
                $reqPermissions[$result[$i]['module']] = $result[$i];
            }
            return $reqPermissions;
        }

    }
?>