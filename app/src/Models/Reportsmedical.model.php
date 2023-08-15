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

        // Unique medicalcontrol get function by appointment
        public function getByAppointment($id_appointment) {
            $Query = "SELECT pt.name, pt.lastname, pt.birthdate,
                             CONCAT(us.name, ' ', us.lastname, ' - ', dc.specialty) AS doctor,
                             ap.date, ap.photo, mc.*
                      FROM medicalcontrol mc
                      INNER JOIN appointment ap ON (mc.appointment=ap.id_appointment)
                      INNER JOIN patient pt ON (ap.patient=pt.id_patient)  
                      INNER JOIN doctor dc ON (ap.doctor=dc.id_doctor) 
                      INNER JOIN user us ON (dc.user=us.id_user)
                      WHERE mc.appointment = $id_appointment";
            return $this->SelectMySQL($Query);
        }
    }
?>