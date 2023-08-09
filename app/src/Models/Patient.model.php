<?php
    class Patient_model extends MySQL {
        public function __construct() {
            parent::__construct();
        }

        // New register patient function
        public function create($patientData) {
            $parents = $patientData['parents'];
            $dni = $patientData['dni'];
            $name = $patientData['name'];
            $lastname = $patientData['lastname'];
            $birthdate = $patientData['birthdate'];
            $sex = $patientData['sex'];
            $weight_kg = $patientData['weight_kg'];
            $weight_pounds = $patientData['weight_pounds'];
            $height = $patientData['height'];
            $blood_type = $patientData['blood_type'];
            $family_obs = $patientData['family_obs'];
            $personal_obs = $patientData['personal_obs'];
            $general_obs = $patientData['general_obs'];
            $status = $patientData['status'];

            $Query_validate = "SELECT * FROM patient WHERE dni = $dni AND id_patient != 0";
            $req_validate = $this->SelectAllMySQL($Query_validate);

            if (!empty($req_validate)) {
                $res = 'exists';
            } else {
                $Query = "INSERT INTO patient (parents, dni, name, lastname, birthdate, sex, weight_kg, weight_pounds, height, blood_type, family_obs, personal_obs, general_obs, status) 
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $Array = array(
                    $parents, $dni, $name, $lastname, $birthdate, $sex, $weight_kg, $weight_pounds,
                    $height, $blood_type, $family_obs, $personal_obs, 
                    $general_obs, $status
                );
                $req = $this->InsertMySQL($Query, $Array);
                $req ?  $res = $req : $res = 0;
            }
            return $res;
        }

        // Patient update function
        public function update($id_patient, $patientData) {
            $dni = $patientData['dni'];
            $name = $patientData['name'];
            $lastname = $patientData['lastname'];
            $birthdate = $patientData['birthdate'];
            $sex = $patientData['sex'];
            $weight_kg = $patientData['weight_kg'];
            $weight_pounds = $patientData['weight_pounds'];
            $height = $patientData['height'];
            $blood_type = $patientData['blood_type'];
            $family_obs = $patientData['family_obs'];
            $personal_obs = $patientData['personal_obs'];
            $general_obs = $patientData['general_obs'];
            $status = $patientData['status'];

            $Query_validate = "SELECT * FROM patient 
                                        WHERE name = '$name' AND lastname = '$lastname' 
                                        AND dni != $dni AND id_patient != $id_patient";
            $req_validate = $this->SelectAllMySQL($Query_validate);

            if (!empty($req_validate)) {
                $res = 'exists';
            } else {
                $Query = "UPDATE patient SET dni=?, name=?, lastname=?, birthdate=?, sex=?, 
                                 weight_kg=?, weight_pounds=?, height=?, blood_type=?, family_obs=?, 
                                 personal_obs=?, general_obs=?, status=? 
                          WHERE id_patient = $id_patient";
                $Array = array(
                    $dni, $name, $lastname, $birthdate, $sex, $weight_kg, $weight_pounds,
                    $height, $blood_type, $family_obs, $personal_obs, $general_obs, $status
                );
                $req = $this->UpdateMySQL($Query, $Array);
                $req ?  $res = 1 : $res = 0;
            }
            return $res;
        }

        // Patient delete function
        public function delete($id_patient, $status) {
            $Query_validate = "SELECT * FROM appointment WHERE patient = '$id_patient' AND status != 0";
            $req_validate = $this->SelectAllMySQL($Query_validate);

            if (!empty($req_validate)) {
                $res = "exists";
            } else {
                $Query = "UPDATE patient SET status=? WHERE id_patient = $id_patient";
                $Array = array($status);
                $req = $this->UpdateMySQL($Query, $Array);
                $req ?  $res = 1 : $res = 0;
            }
            return $res;
        }

        // Patient all get function
        public function getAll() {
            $Query = "SELECT CONCAT(ps.father_name, ' ', ps.father_lastname) AS father, 
                             CONCAT(ps.mother_name, ' ', ps.mother_lastname) AS mother,
                             CONCAT(us.name, ' ', us.lastname) AS representative,
                             CONCAT(pt.name, ' ', pt.lastname) AS patient, pt.* 
                      FROM patient pt 
                      INNER JOIN parents ps ON (pt.parents=ps.id_parents) 
                      INNER JOIN user us ON (ps.user=us.id_user) 
                      WHERE pt.status != 0 ORDER BY pt.id_patient DESC"; 
            return $this->SelectAllMySQL($Query);
        }

        // Unique patient get function
        public function get($id_patient) {
            $Query = "SELECT CONCAT(ps.father_name, ' ', ps.father_lastname) AS father, 
                             CONCAT(ps.mother_name, ' ', ps.mother_lastname) AS mother, 
                             CONCAT(us.name, ' ', us.lastname) AS representative,
                             CONCAT(pt.name, ' ', pt.lastname) AS patient, pt.* 
                      FROM patient pt 
                      INNER JOIN parents ps ON (pt.parents=ps.id_parents) 
                      INNER JOIN user us ON (ps.user=us.id_user) 
                      WHERE pt.id_patient = $id_patient";
            return $this->SelectMySQL($Query);
        }

        // Patient all get function for parents
        public function getPatientsForParents($id_user) {
            $Query = "SELECT pt.id_patient, CONCAT(pt.name, ' ', pt.lastname) AS patient 
                        FROM parents pr INNER JOIN patient pt ON (pt.parents=pr.id_parents) 
                        WHERE pr.user = $id_user AND pt.status = 1"; 
            return $this->SelectAllMySQL($Query);
        }

        // Appointment get function for patient
        public function getAppointmentsForPatient($id_patient) {
            $Query = "SELECT pt.id_patient, CONCAT(pt.name, ' ', pt.lastname) AS patient, ap.* 
                        FROM patient pt INNER JOIN appointment ap ON (ap.patient=pt.id_patient)
                        WHERE pt.id_patient = $id_patient AND ap.status != 0 ORDER BY ap.date DESC"; 
            return $this->SelectAllMySQL($Query);
        }
    }
?>