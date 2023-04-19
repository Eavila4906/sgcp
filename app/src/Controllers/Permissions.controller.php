<?php
    class Permissions extends Controllers {
        public function __construct() {
            parent::__construct();
        }

        // Assign permissions function
        public function Assign() {
            if ($_POST) {
                $id_rol = intval($_POST['id_rol']);
                $module = $_POST['module'];

                $this->model->delete($id_rol);
                foreach ($module as $module) {
                    $id_module = $module['id_module'];
                    $r = empty($module['r']) ? 0 : 1;
                    $w = empty($module['w']) ? 0 : 1;
                    $u = empty($module['u']) ? 0 : 1;
                    $d = empty($module['d']) ? 0 : 1;  
                    $req = $this->model->create($id_rol, $id_module, $r, $w, $u, $d);  
                }

                if ($req > 0) {
                    $res = array(
                        'status' => true, 
                        'msg' => 'Permissions assigned successfully.'
                    );
                } else {
                    $res = array(
                        'status' => false, 
                        'msg' => 'This process could not be performed, please try again later.'
                    );
                }
                echo json_encode($res, JSON_UNESCAPED_UNICODE);
            }
            die();
        }

        // Extract permissions function
        public function get() {
            if ($_GET) {
                $this->id_rol = intval($_GET['id_rol']);

                if ($this->id_rol > 0) {
                    $req_module = $this->model->getModules();
                    $req_permissions = $this->model->getPermissions($this->id_rol);
                    
                    $reqPermissions = array(
                        'r' => 0,
                        'w' => 0,
                        'u' => 0,
                        'd' => 0
                    );

                    $reqPermissionsRol = array(
                        'id_rol' => $this->id_rol
                    );

                    if (empty($req_permissions)) {
                        for ($i=0; $i < count($req_module); $i++) { 
                            $req_module[$i]['permissions'] = $reqPermissions;
                        }
                    } else {
                        for ($i=0; $i < count($req_module); $i++) { 
                            $reqPermissions = array(
                                'r' => 0,
                                'w' => 0,
                                'u' => 0,
                                'd' => 0
                            );
                            if (isset($req_permissions[$i])) {
                                $reqPermissions = array(
                                    'r' => $req_permissions[$i]['r'],
                                    'w' => $req_permissions[$i]['w'],
                                    'u' => $req_permissions[$i]['u'],
                                    'd' => $req_permissions[$i]['d'] 
                                );
                            }
                            $req_module[$i]['permissions'] = $reqPermissions;  
                        }   
                    }
                    $reqPermissionsRol['module'] = $req_module;
                    //$html = getModal('permisos_modal', $reqPermissionsRol);
                    $res = array(
                        'status' => true, 
                        'data' => $reqPermissionsRol
                    );
                }
                echo json_encode($res, JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        
    }
?>