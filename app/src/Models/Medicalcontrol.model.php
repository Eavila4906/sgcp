<?php
    class Medicalcontrol_model extends MySQL {
        public function __construct() {
            parent::__construct();
        }

        // New register medicalcontrol function
        public function createRecipe($recipeData) {
            $medication = $recipeData['medication'];
            $indication = $recipeData['indication'];
            $status = 1;

            $Query = "INSERT INTO recipe (medication, indication, status) VALUES (?, ?, ?)";
            $Array = array($medication, $indication, $status);
            $req = $this->InsertMySQL($Query, $Array);
            $req ?  $res = $req : $res = 0;

            return $res;
        }

        public function create($medicalcontrolData) {
            $appointment = $medicalcontrolData['appointment'];
            $recipe = $medicalcontrolData['recipe'];
            $age_days = $medicalcontrolData['age_days'];
            $weight_kg = $medicalcontrolData['weight_kg'];
            $weight_pounds = $medicalcontrolData['weight_pounds'];
            $height_cm = $medicalcontrolData['height_cm'];
            $bmi_quant = $medicalcontrolData['bmi_quant'];
            $bmi_quali = $medicalcontrolData['bmi_quali'];
            $temperature = $medicalcontrolData['temperature'];
            $observation = $medicalcontrolData['observation'];

            $Query = "INSERT INTO medicalcontrol (appointment, recipe, age_days, weight_kg, weight_pounds, height_cm, bmi_quant, bmi_quali, temperature, observation) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $Array = array(
                $appointment, $recipe, $age_days, $weight_kg, $weight_pounds, $height_cm, $bmi_quant,
                $bmi_quali, $temperature, $observation
            );
            $req = $this->InsertMySQL($Query, $Array);
            $req ?  $res = $req : $res = 0;

            return $res;
        }

        // Medicalcontrol update function
        public function update($medicalcontrolData) {
            $appointment = $medicalcontrolData['appointment'];
            $recipe = $medicalcontrolData['recipe'];
            $age_days = $medicalcontrolData['age_days'];
            $weight_kg = $medicalcontrolData['weight_kg'];
            $weight_pounds = $medicalcontrolData['weight_pounds'];
            $height_cm = $medicalcontrolData['height_cm'];
            $bmi_quant = $medicalcontrolData['bmi_quant'];
            $bmi_quali = $medicalcontrolData['bmi_quali'];
            $temperature = $medicalcontrolData['temperature'];
            $observation = $medicalcontrolData['observation'];
            $medication = $medicalcontrolData['medication'];
            $indication = $medicalcontrolData['indication'];

            $Query = "UPDATE medicalcontrol mc INNER JOIN recipe re ON (mc.recipe=re.id_recipe) 
                      SET mc.appointment=?, mc.recipe=?, mc.age_days=?, mc.weight_kg=?, mc.weight_pounds=?, 
                          mc.height_cm=?, mc.bmi_quant=?, mc.bmi_quali=?, mc.temperature=?, mc.observation=?, 
                          re.medication=?, re.indication=?
                      WHERE mc.appointment = $appointment";
            $Array = array(
                $appointment, $recipe, $age_days, $weight_kg, $height_cm, $bmi_quant, $bmi_quali,
                $temperature, $observation, $medication, $indication
            );
            $req = $this->UpdateMySQL($Query, $Array);
            $req ?  $res = 1 : $res = 0;

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