<?php
    class Settings_model extends MySQL {
        public function __construct() {
            parent::__construct();
        }

        // Settings update function
        public function updateSystem($dataSystem) {
            $system_name = $dataSystem['system_name'];
            $session_time = $dataSystem['session_time'];
            $generate_reports = $dataSystem['generate_reports'];

            $Query = "UPDATE settings SET system_name=?, session_time=?, generate_reports=?";
            $Array = array($system_name, $session_time, $generate_reports);
            $req = $this->UpdateMySQL($Query, $Array);
            $req ? $res = 1 : $res = 0;

            return $res;
        }

        public function updateConsultingroom($dataConsultingroom) {
            $scheduling_time = $dataConsultingroom['scheduling_time'];
            $generate_certificate = $dataConsultingroom['generate_certificate'];
            $print_recipe = $dataConsultingroom['print_recipe'];

            $Query = "UPDATE settings SET scheduling_time=?, generate_certificate=?, print_recipe=?";
            $Array = array($scheduling_time, $generate_certificate, $print_recipe);
            $req = $this->UpdateMySQL($Query, $Array);
            $req ? $res = 1 : $res = 0;

            return $res;
        }

        // Unique settings get function
        public function get($id_settings) {
            $Query = "SELECT * FROM settings WHERE id_settings = '$id_settings'";
            return $this->SelectMySQL($Query);
        }
    }
?>