<?php
    class Reportsmedical_model extends MySQL {
        public function __construct() {
            parent::__construct();
        }

        // Appointment all get function for patient
        public function getAppointmentsForPatient($id_patient) {
            $Query = "SELECT id_appointment, date FROM appointment 
                        WHERE patient = $id_patient AND status = 1"; 
            return $this->SelectAllMySQL($Query);
        }
    }
?>