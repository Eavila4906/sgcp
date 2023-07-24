<?php
    class Calendar_model extends MySQL {
        public function __construct() {
            parent::__construct();
        }

        // New register calendar function
        public function create($calendarData) {
            $id_doctor = $calendarData['id_doctor'];
            $week_number = $calendarData['week_number'];
            $week_range = $calendarData['week_range'];
            $date = $calendarData['date'];
            $start_time = $calendarData['start_time'];
            $final_time = $calendarData['final_time'];
            $status = $calendarData['status'];

            $Query_validate = "SELECT * FROM calendar 
                               WHERE date = '$date' AND ('$start_time' BETWEEN start_time AND final_time) 
                               AND doctor = $id_doctor AND status != 0";
            $req_validate = $this->SelectAllMySQL($Query_validate);

            if (!empty($req_validate)) {
                $res = 'exists';
            } else {
                $Query = "INSERT INTO calendar (doctor, week_number, week_range, date, start_time, final_time, status) 
                          VALUES (?, ?, ?, ?, ?, ?, ?)";
                $Array = array(
                    $id_doctor, $week_number, $week_range, $date, $start_time, $final_time, $status
                );
                $req = $this->InsertMySQL($Query, $Array);
                $req ?  $res = $req : $res = 0;
            }

            return $res;
        }

        // Calendar update function
        public function update($id_calendar, $calendarData) {
            $id_doctor = $calendarData['id_doctor'];
            $week_number = $calendarData['week_number'];
            $week_range = $calendarData['week_range'];
            $date = $calendarData['date'];
            $start_time = $calendarData['start_time'];
            $final_time = $calendarData['final_time'];
            $status = $calendarData['status'];

            $Query_validate = "SELECT * FROM calendar 
                               WHERE date = '$date' AND ('$start_time' BETWEEN start_time AND final_time) 
                               AND id_calendar != $id_calendar AND doctor = $id_doctor AND status != 0";
            $req_validate = $this->SelectAllMySQL($Query_validate);

            if (!empty($req_validate)) {
                $res = 'exists';
            } else {
                $Query = "UPDATE calendar SET week_number=?, week_range=?, date=?, 
                                 start_time=?, final_time=?, status=? 
                          WHERE id_calendar = $id_calendar";
                $Array = array(
                    $week_number, $week_range, $date, $start_time, $final_time, $status
                );
                $req = $this->UpdateMySQL($Query, $Array);
                $req ?  $res = 1 : $res = 0;
            }
            return $res;
        }

        // Calendar delete function
        public function delete($id_calendar, $status) {
            $Query = "UPDATE calendar SET status=? WHERE id_calendar = $id_calendar";
            $Array = array($status);
            $req = $this->UpdateMySQL($Query, $Array);
            $req ?  $res = 1 : $res = 0;
            return $res;
        }

        // Clendar all get function
        public function getAll() {
            $Query = "SELECT us.name, us.lastname, cr.* 
                      FROM calendar cr INNER JOIN doctor dc ON (cr.doctor=dc.id_doctor)
                      INNER JOIN user us ON (dc.user=us.id_user) 
                      WHERE cr.status != 0"; 
            return $this->SelectAllMySQL($Query);
        }

        // Unique calendar get function
        public function get($id_calendar) {
            $Query = "SELECT us.name, us.lastname, cr.*
                      FROM calendar cr INNER JOIN doctor dc ON (cr.doctor=dc.id_doctor)
                      INNER JOIN user us ON (dc.user=us.id_user) 
                      WHERE cr.id_calendar = $id_calendar";
            return $this->SelectMySQL($Query);
        }

        // Unique calendar retrieval function according to the doctor
        public function getCalendarForDoctor($id_doctor, $week_range) {
            $Query = "SELECT * FROM calendar 
                        WHERE week_range = '$week_range' AND doctor = $id_doctor AND status != 0 ORDER BY date";
            return $this->SelectAllMySQL($Query);
        }
    }
?>