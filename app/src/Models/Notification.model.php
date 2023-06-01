<?php
    class Notification_model extends MySQL {
        public function __construct() {
            parent::__construct();
        }

        // New register notification function
        public function create($notificationData) {
            $type = $notificationData['type'];
            $description = $notificationData['description'];
            $status = $notificationData['status'];

            $Query = "INSERT INTO notification (type, description, status) 
                        VALUES (?, ?, ?)";
            $Array = array(
                $type, $description, $status
            );
            $req = $this->InsertMySQL($Query, $Array);
            $req ?  $res = $req : $res = 0;
            return $res;
        }

        public function createDetails($user, $notification) {
            $Query = "INSERT INTO details_notification (user, notification) 
                        VALUES (?, ?)";
            $Array = array(
                $user, $notification
            );
            $req = $this->InsertMySQL($Query, $Array);
            $req ?  $res = $req : $res = 0;
            return $res;
        }

        // Notification delete function
        public function delete($id_notification, $status) {
            $Query = "UPDATE notification SET status=? WHERE id_notification = $id_notification";
            $Array = array($status);
            $req = $this->UpdateMySQL($Query, $Array);
            $req ?  $res = 1 : $res = 0;
            return $res;
        }

        //Notification all get function
        public function getAll() {
            $Query = "SELECT * 
                      FROM details_notification dn INNER JOIN notification nt ON (dn.notification=nt.id_notification)
                      INNER JOIN user us ON (dn.user=us.id_user) 
                      WHERE nt.status != 0 ORDER BY dn.date ASC"; 
            return $this->SelectAllMySQL($Query);
        }
    }
?>