<?php
    class Reportsmedical_model extends MySQL {
        public function __construct() {
            parent::__construct();
        }

        // Appointment all get function for patient
        public function getAppointmentsForPatient($id_patient) {
            $Query = "SELECT ap.id_appointment, ap.date, mc.observation 
                        FROM appointment ap
                        INNER JOIN medicalcontrol mc ON (mc.appointment=ap.id_appointment)
                        WHERE patient = $id_patient
                        AND status = 1"; 
            return $this->SelectAllMySQL($Query);
        }

        // Unique medicalcontrol get function by appointment
        public function getByAppointment($id_appointment) {
            $Query = "SELECT pt.name, pt.lastname, pt.birthdate, pt.sex,
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

        // Unique medicalcontrol get function by charts
        public function getRecordsByCharts($id_patient) {
            $Query = "SELECT pt.sex, mc.weight_kg, mc.height_cm, mc.months_age
                      FROM medicalcontrol mc
                      INNER JOIN appointment ap ON (mc.appointment=ap.id_appointment)
                      INNER JOIN patient pt ON (ap.patient=pt.id_patient) 
                      WHERE ap.patient = $id_patient AND ap.status = 1 GROUP BY mc.months_age";
            return $this->SelectAllMySQL($Query);
        }
    }
?>