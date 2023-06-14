<?php
    class Medicalcontrol_model extends MySQL {
        public function __construct() {
            parent::__construct();
        }

        // New register medicalcontrol function
        public function create($appointmentData) {
            $doctor = $appointmentData['doctor'];
            $patient = $appointmentData['patient'];
            $date = $appointmentData['date'];
            $hour = $appointmentData['hour'];
            $description = $appointmentData['description'];
            $status = $appointmentData['status'];

            $Query_v_calendar = "SELECT * FROM calendar 
                               WHERE date = '$date' AND start_time >= '$hour' AND 'final_time' =< '$hour' 
                               AND doctor = $doctor";
            $req_v_calendar = $this->SelectAllMySQL($Query_v_calendar);

            $Query_validate = "SELECT * FROM appointment 
                               WHERE date = '$date' AND hour = '$hour' AND status != 0";
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

        // Medicalcontrol update function
        public function update($id_appointment, $appointmentData) {
            $doctor = $appointmentData['doctor'];
            $patient = $appointmentData['patient'];
            $date = $appointmentData['date'];
            $hour = $appointmentData['hour'];
            $description = $appointmentData['description'];
            $status = $appointmentData['status'];

            $Query_v_calendar = "SELECT * FROM calendar 
                               WHERE date = '$date' AND start_time >= '$hour' AND 'final_time' =< '$hour' 
                               AND doctor = $doctor";
            $req_v_calendar = $this->SelectAllMySQL($Query_v_calendar);

            $Query_validate = "SELECT * FROM appointment 
                               WHERE date = '$date' AND hour = '$hour' AND status != 0";
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

        // Medicalcontrol delete function
        public function delete($id_recipe, $status) {
            $Query = "UPDATE recipe SET status=? WHERE id_recipe = $id_recipe";
            $Array = array($status);
            $req = $this->UpdateMySQL($Query, $Array);
            $req ?  $res = 1 : $res = 0;
            return $res;
        }

        // Medicalcontrol all get function
        public function getAll() {
            $Query = "SELECT CONCAT(us.name, ' ', us.lastname) AS doctor, 
                             CONCAT(pt.name, ' ', pt.lastname) AS patient, 
                             CONCAT(ap.date, ' ', ap.hour) AS appointment_ap, ap.description,
                             re.medication, re.indication, mc.*
                      FROM medicalcontrol mc INNER JOIN appointment ap ON (mc.appointment=ap.id_appointment)
                      INNER JOIN recipe re ON (mc.recipe=re.id_recipe)
                      INNER JOIN doctor dc ON (ap.doctor=dc.id_doctor)
                      INNER JOIN user us ON (dc.user=us.id_user)
                      INNER JOIN patient pt ON (ap.patient=pt.id_patient) 
                      WHERE ap.status != 0 OR re.status != 0"; 
            return $this->SelectAllMySQL($Query);
        }

        // Unique medicalcontrol get function
        public function get($id_medicalcontrol) {
            $Query = "SELECT CONCAT(us.name, ' ', us.lastname) AS doctor, 
                             CONCAT(pt.name, ' ', pt.lastname) AS patient, 
                             CONCAT(ap.date, ' ', ap.hour) AS appointment_ap, ap.description,
                             re.medication, re.indication, mc.*
                      FROM medicalcontrol mc INNER JOIN appointment ap ON (mc.appointment=ap.id_appointment)
                      INNER JOIN recipe re ON (mc.recipe=re.id_recipe)
                      INNER JOIN doctor dc ON (ap.doctor=dc.id_doctor)
                      INNER JOIN user us ON (dc.user=us.id_user)
                      INNER JOIN patient pt ON (ap.patient=pt.id_patient) 
                      WHERE mc.id_medicalcontrol = $id_medicalcontrol";
            return $this->SelectMySQL($Query);
        }
    }
?>