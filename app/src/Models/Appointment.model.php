<?php
    class Appointment_model extends MySQL {
        public function __construct() {
            parent::__construct();
        }

        // New register appointment function
        public function create($appointmentData) {
            $doctor = $appointmentData['doctor'];
            $patient = $appointmentData['patient'];
            $date = $appointmentData['date'];
            $hour = $appointmentData['hour'];
            $description = $appointmentData['description'];
            $status = $appointmentData['status'];

            $Query_v_calendar = "SELECT * FROM calendar 
                               WHERE date = '$date' AND ('$hour' BETWEEN start_time AND final_time) 
                               AND doctor = $doctor";
            $req_v_calendar = $this->SelectAllMySQL($Query_v_calendar);

            $Query_validate = "SELECT * FROM appointment 
                               WHERE status = 2 AND (date = '$date' AND hour = '$hour') AND patient = $patient";
            $req_validate = $this->SelectAllMySQL($Query_validate);

            if (empty($req_v_calendar)) {
                $res = '!exists';
            } else if (!empty($req_validate)) {
                $res = 'exists';
            } else {
                $Query = "INSERT INTO appointment (doctor, patient, date, hour, description, status) 
                          VALUES (?, ?, ?, ?, ?, ?)";
                $Array = array(
                    $doctor, $patient, $date, $hour, $description, $status
                );
                $req = $this->InsertMySQL($Query, $Array);
                $req ?  $res = $req : $res = 0;
            }

            return $res;
        }

        // Appointment update function
        public function update($id_appointment, $appointmentData) {
            $doctor = $appointmentData['doctor'];
            $patient = $appointmentData['patient'];
            $date = $appointmentData['date'];
            $hour = $appointmentData['hour'];
            $description = $appointmentData['description'];
            $status = $appointmentData['status'];

            $Query_v_calendar = "SELECT * FROM calendar 
                               WHERE date = '$date' AND ('$hour' BETWEEN start_time AND final_time) 
                               AND doctor = $doctor";
            $req_v_calendar = $this->SelectAllMySQL($Query_v_calendar);

            $Query_validate = "SELECT * FROM appointment 
                               WHERE date = '$date' AND hour = '$hour' AND status != 0 AND id_appointment != $id_appointment";
            $req_validate = $this->SelectAllMySQL($Query_validate);

            if (empty($req_v_calendar)) {
                $res = '!exists';
            } else if (!empty($req_validate)) {
                $res = 'exists';
            } else {
                $Query = "UPDATE appointment SET doctor=?, patient=?, date=?, hour=?, description=?, status=? 
                          WHERE id_appointment = $id_appointment";
                $Array = array(
                    $doctor, $patient, $date, $hour, $description, $status
                );
                $req = $this->UpdateMySQL($Query, $Array);
                $req ?  $res = 1 : $res = 0;
            }
            return $res;
        }

        // Appointment delete function
        public function delete($id_appointment, $status) {
            $Query = "UPDATE appointment SET status=? WHERE id_appointment = $id_appointment";
            $Array = array($status);
            $req = $this->UpdateMySQL($Query, $Array);
            $req ?  $res = 1 : $res = 0;
            return $res;
        }

        // Appointment all get function
        public function getAll() {
            $Query = "SELECT CONCAT(us.name, ' ', us.lastname) AS doctor_c, 
                             CONCAT(pt.name, ' ', pt.lastname) AS patient_c, ap.*
                      FROM appointment ap INNER JOIN doctor dc ON (ap.doctor=dc.id_doctor)
                      INNER JOIN user us ON (dc.user=us.id_user)
                      INNER JOIN patient pt ON (ap.patient=pt.id_patient) 
                      WHERE ap.status != 0"; 
            return $this->SelectAllMySQL($Query);
        }

        // Unique appointment get function
        public function get($id_appointment) {
            $Query = "SELECT CONCAT(us.name, ' ', us.lastname) AS doctor_c, 
                             CONCAT(pt.name, ' ', pt.lastname) AS patient_c, ap.*
                      FROM appointment ap INNER JOIN doctor dc ON (ap.doctor=dc.id_doctor)
                      INNER JOIN user us ON (dc.user=us.id_user)
                      INNER JOIN patient pt ON (ap.patient=pt.id_patient) 
                      WHERE ap.id_appointment = $id_appointment";
            return $this->SelectMySQL($Query);
        }
    }
?>