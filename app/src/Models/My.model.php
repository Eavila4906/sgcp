<?php
    class My_model extends MySQL {
        public function __construct() {
            parent::__construct();
        }

        // Appointment all get function doctor
        public function getAppointmentsDoctor($id_user) {
            $Query = "SELECT ap.id_appointment, ap.status, ap.date, ap.hour, 
                             CONCAT(pt.name, ' ', pt.lastname) AS patient
                        FROM doctor dr 
                        INNER JOIN appointment ap ON (dr.id_doctor=ap.doctor)
                        INNER JOIN patient pt ON (ap.patient=pt.id_patient) 
                        WHERE dr.user = $id_user AND ap.status != 0"; 
            return $this->SelectAllMySQL($Query);
        }

        // Appointment all get function patient
        public function getAppointmentsPatient($id_user) {
            $Query = "SELECT ap.id_appointment, ap.status, ap.date, ap.hour
                             CONCAT(pt.name, ' ', pt.lastname) AS patient
                        FROM parents ps 
                        INNER JOIN patient pt ON (ps.id_parents=pt.parents)
                        INNER JOIN appointment ap ON (pt.id_patient=ap.patient)  
                        WHERE ps.user = $id_user AND ap.status != 0"; 
            return $this->SelectAllMySQL($Query);
        }
    }
?>