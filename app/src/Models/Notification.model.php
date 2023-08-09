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

        public function createDetails($notificationDetailsData) {
            $sending_user = $notificationDetailsData['sending_user'];
            $recipient_user = $notificationDetailsData['recipient_user'];
            $notification = $notificationDetailsData['notification'];
            $appointment = $notificationDetailsData['appointment'];

            $Query = "INSERT INTO notification_details (sending_user, recipient_user, notification, appointment) 
                        VALUES (?, ?, ?, ?)";
            $Array = array(
                $sending_user, $recipient_user, $notification, $appointment
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
            $Query = "SELECT nd.*, nt.*, CONCAT(us1.name, ' ', us1.lastname) AS sending_user
                      FROM notification_details nd INNER JOIN notification nt ON (nd.notification=nt.id_notification)
                      INNER JOIN user us1 ON (nd.sending_user=us1.id_user) 
                      INNER JOIN user us2 ON (nd.recipient_user=us2.id_user) 
                      WHERE nt.status != 0 ORDER BY nd.date DESC"; 
            return $this->SelectAllMySQL($Query);
        }

        // Unique notification get function
        public function get($id_notification) {
            $Query = "SELECT nt.id_notification, ap.id_appointment, ap.date AS date_appointment, ap.hour AS hour_appointment,
                             CONCAT(us1.name, ' ', us1.lastname) AS sending_user,
                             pr.cell_phone, pr.home_phone, us1.email,
                             CONCAT(pt.name, ' ', pt.lastname) AS patient,
                             CONCAT(us2.name, ' ', us2.lastname) AS recipient_user,
                             CONCAT(us3.name, ' ', us3.lastname, ' - ', dc.specialty) AS doctor,
                             nt.type, nt.description, nt.status, nd.date AS date_notification
                        FROM notification_details nd INNER JOIN notification nt ON (nd.notification=nt.id_notification) 
                        INNER JOIN user us1 ON (nd.sending_user=us1.id_user) 
                        INNER JOIN parents pr ON (pr.user=us1.id_user) 
                        INNER JOIN user us2 ON (nd.recipient_user=us2.id_user)
                        INNER JOIN appointment ap ON (nd.appointment=ap.id_appointment) 
                        INNER JOIN patient pt ON (ap.patient=pt.id_patient)
                        INNER JOIN doctor dc ON (ap.doctor=dc.id_doctor)
                        INNER JOIN user us3 ON (dc.user=us3.id_user)
                        WHERE nt.id_notification = $id_notification";

            $Query_validate = "SELECT status FROM notification WHERE id_notification = $id_notification";
            $req_validate = $this->SelectMySQL($Query_validate);
            if ($req_validate['status'] == 3 || $req_validate['status'] == 2) {
                $Query_seen_notification = "UPDATE notification SET status=? WHERE id_notification = $id_notification";
                $Array_seen_notification = array(2);
                $this->UpdateMySQL($Query_seen_notification, $Array_seen_notification);
            }
            return $this->SelectMySQL($Query);
        }

        // Unique notifications user get function
        public function getNotificationsUser($id_user) {
            $Query = "SELECT nd.id_notification_details, nt.id_notification, nt.type, nt.description, nt.status, nd.date
                        FROM notification_details nd INNER JOIN notification nt ON (nd.notification=nt.id_notification) 
                        WHERE nd.recipient_user = $id_user AND nt.status !=0 ORDER BY nd.date DESC";
            return $this->SelectAllMySQL($Query);
        }

        // Secretary all get function
        public function getSecretary() {
            $Query = "SELECT us.id_user 
                        FROM user_roles ur 
                        INNER JOIN user us 
                        ON (ur.user=us.id_user) 
                        WHERE ur.rol = 3 AND ur.status = 1"; 
            return $this->SelectAllMySQL($Query);
        }
    }
?>