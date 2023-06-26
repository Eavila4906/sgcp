<?php
    /*
    ####################################################################################
    ############################### URL BASE ###########################################
    ####################################################################################
    */
    function BASE_URL() {
        return BASE_URL;
    }

    /*
    ####################################################################################
    ############################ CORS ORIGENS VALIDATION ###############################
    ####################################################################################
    */
    function Cors() {
        // Allow from any origin
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            // should do a check here to match $_SERVER['HTTP_ORIGIN'] to a
            // whitelist of safe domains
            //header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header("Access-Control-Allow-Origin: *");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');    // cache for 1 day
        }
        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");         

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        }
    }  

    /*
    ####################################################################################
    ############################ HTTP METHOD VALIDATION ################################
    ####################################################################################
    */
    function Http_GET() {
        return $_SERVER['REQUEST_METHOD'] == 'GET';
    }
    function Http_POST() {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }
    function Http_PUT() {
        return $_SERVER['REQUEST_METHOD'] == 'PUT';
    }
    function Http_DELETE() {
        return $_SERVER['REQUEST_METHOD'] == 'DELETE';
    }
    function Http_type_request($type_request) {
        return $_SERVER['REQUEST_METHOD'] == $type_request;
    }
    function Http_Method() {
        return file_get_contents("php://input");
    } 

    /*
    ####################################################################################
    ############################ CLEAR TEXT STRING #####################################
    ####################################################################################
    */
    function strClean($cadena) {
        $cadena = str_replace("'", "\'", $cadena);
        return $cadena;
    }

    /*
    ####################################################################################
    ##################### DISPLAY INFORMATION FORMATTED IN JSON ########################
    ####################################################################################
    */
	function dep($data) {
        $format  = print_r('<pre>');
        $format .= print_r($data);
        $format .= print_r('</pre>');
        return $format;
    }

    /*
    ####################################################################################
    ################################# TOKEN GENERATOR ##################################
    ####################################################################################
    */
    function token() {
        $t1 = bin2hex(random_bytes(10));
        $t2 = bin2hex(random_bytes(10));
        $t3 = bin2hex(random_bytes(10));
        $t4 = bin2hex(random_bytes(10));
        $token = $t1.'-'.$t2.'-'.$t3.'-'.$t4;
        return $token;
    }

    /*
    ####################################################################################
    ################################# SEND EMAIL #######################################
    ####################################################################################
    */
    function sendEmail($data, $template) {
        $affair = $data['affair'];
        $email = $data['email'];
        $business = COMPANY_NAME;
        $sender = SENDER_EMAIL;
        $from = "MIME-Version: 1.0\r\n";
        $from .= "Content-type: text/html; charset=UTF-8\r\n";
        $from .= "From: {$business} <{$sender}>\r\n";
        ob_start();
        require_once("./app/src/Views/Templates/Emails/".$template.".email.php");
        $message = ob_get_clean();
        $send = mail($email, $affair, $message, $from);
        return $send;
    }

    // Random Password Generator
    function passGenerator($length = 10) {
        $pass = "";
        $lengthPass = $length;
        $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $lengthCadena = strlen($cadena);

        for ($i=1; $i <= $lengthPass; $i++) { 
            $pos = rand(0, $lengthCadena-1);
            $pass .= substr($cadena, $pos, 1);
        }
        return $pass;
    }

    // Username Generator
    function usernameGenerator(String $name, String $lastname, String $time) {
        $lengthlastname = strlen($lastname);
        $string = substr($name, 0, 1).substr($lastname, 0, $lengthlastname).substr($time, 6, 4);
        $username = strtolower($string);
        return $username;
    }

    //Sesiones
    function session() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    //Verify api key
    function verifyApiKey() {
        $headers = getallheaders();
        $apiKey = str_replace('Bearer ', '', $headers['Api-Key'] ?? null);
        return $apiKey == API_KEY ? true : false;
    }

    // Generate range of days per week
    function generateWeekNumber($current_date) {
        $numberWeek = date('W', strtotime($current_date));
        $year = date('Y', strtotime($current_date));
        $firstDay = date('Y-m-d', strtotime($current_date . " -" . (date('N', strtotime($current_date)) - 1) . " days"));
        $lastDay = date('Y-m-d', strtotime($current_date . " +" . (7 - date('N', strtotime($current_date))) . " days"));
        return "Week " . $numberWeek . " year " . $year;
    }

    // Generate range of days per week
    function generateWeekRange($current_date) {
        $numberWeek = date('W', strtotime($current_date));
        $year = date('YYYY', strtotime($current_date));
        $firstDay = date('Y-m-d', strtotime($current_date . " -" . (date('N', strtotime($current_date)) - 1) . " days"));
        $lastDay = date('Y-m-d', strtotime($current_date . " +" . (7 - date('N', strtotime($current_date))) . " days"));
        return $firstDay . " - " . $lastDay;
    }
?>