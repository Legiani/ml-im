<?php

/**
 * base.php
 * Hlavní třída programu
 *
 * @author Jakub Bednář
 * @copyright (c) Jakub Bendář
 * @version 1.0
 */
class base {

    private $conf;
    private $conn;

    public $road;
    
    public function __construct() {

        require __DIR__.'./../conf.php';

        $this->conf = $config;

        unset($config);

        $this->conn = $this->dbConect();
        
        // Start the session if not set 
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        
        // error_reporting(-1);
        // ini_set('display_errors', 'On');
        // set_error_handler("var_dump");
    }

    /**
     * Connect to db
     * @return obj conection
     */
    public function dbConect() {
        // Create connection
        $con = mysqli_connect($this->conf["DBserver"], $this->conf["DBuser"], $this->conf["DBpassword"], $this->conf["DBdatabase"]); 

        // Check connection
        if ( !$con ) {
            // If there is an error with the connection, stop the script and display the error.
            die ('Failed to connect to MySQL: ' . mysqli_connect_error());
        }
        
        // Set utf8 charset
        mysqli_set_charset($con, "utf8");
        return $con;
    }

    /**
     * Login
     * require mail, password
     * @return boolean
     */
    public function login($mail, $password) {
        // Prepare our SQL, preparing the SQL statement will prevent SQL injection.
        if ($stmt = $this->conn->prepare('SELECT `id`, `password` FROM `account` WHERE `active` = 1 and `mail` = ?' )) {
            // Bind parameters (s = string, i = int, b = blob, etc), in our case the mail is a string so we use "s"
            $stmt->bind_param('s', $mail);
            $stmt->execute();
            // Store the result so we can check if the account exists in the database.
            $stmt->store_result();
        }
        // Account exist
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $bpassword);
            $stmt->fetch();
            // Account exists, now we verify the password.
            // Note: remember to use password_hash in your registration file to store the hashed passwords.

            if (password_verify($password, $bpassword)) {
                // Create sessions so we know the account is logged in, they basically act like cookies but remember the data on the server.
                session_regenerate_id();

                $_COOKIE['lastActivity'] = time();
                $_SESSION['id'] = $id;
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
        $stmt->close();
    }

    /**
     * Registration
     * require mail, name, password, parameter is add to to of confirm mail
     * @return bool
     */
    public function registr($mail, $firstName, $lastName, $password, $parametr = " ") {
        // accountname doesnt exists, insert new account
        if ($stmt = $this->conn->prepare('INSERT INTO `account` (`mail`, `firstName`, `lastName`, `password`, `hash`) VALUES (?, ?, ?, ?, ?)')) {
            // We do not want to expose passwords in our database, so hash the password and use password_verify when a account logs in.
            $key = $this->generateKey();
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt->bind_param('sssss', $mail, $firstName, $lastName, $hashPassword, $key);
            if($stmt->execute()){
                $body = $this->getConf("confirmMailBody")."<a href=http://".$_SERVER['HTTP_HOST']."/login/confirm.php?confirm=".$mail."&key=".$key."&".$parameter.">Press to confirm registration</a>";

                if($this->sendMail($mail, $this->getConf("confirmMailHeader"), $body)){
                    return true;   
                }else{
                    return false;
                } 
            }else {
                return false;
            }   
        } else {
            return false;
        }
    }


    /**
     * Verification of registration
     * require mail and none expire key
     * @return bool
     */
    public function regVerification($mail, $key) {

        //is this mail registr
        if ($result = $this->conn->prepare("SELECT * FROM `account` WHERE `mail` = ? AND `hash` = ? AND `create` > NOW() - INTERVAL 30 MINUTE")){
            $result->bind_param('ss', $mail, $key);
            $result->execute();
            $result->store_result();
        }
        //if verification isn't expire
        if ($result->num_rows == 1){

            //update state to verificate
            $result = $this->conn->prepare("UPDATE `account` SET `active` = 1 WHERE `mail` = ?");
            $result->bind_param('s', $mail);

            if ($result->execute()) {
                return true;
            } else {
                return false;  
            }
        }else{
            return false;   
        }
    }    

    /**
     * Request to change password
     * require mail
     * @return bool
     */
    public function forgetPassword($mail) {

        //generate random key
        $key = $this->generateKey();

        // Prepare our SQL, preparing the SQL statement will prevent SQL injection.
        if ($stmt = $this->conn->prepare('SELECT `id` FROM `account` WHERE `mail` = ?')) {
            // Bind parameters (s = string, i = int, b = blob, etc), in our case the company is a string so we use "s"
            $stmt->bind_param('s', $mail);
            $stmt->execute();
            // Store the result so we can check if the account exists in the database.
            $stmt->store_result();
        }
        // Account exist
        if ($stmt->num_rows == 1) {

            //update account key
            $result = $this->conn->prepare("UPDATE `account` SET `hash` = ?, `create` = NOW() WHERE `mail` = ?");
            $result->bind_param('ss', $key, $mail);

            if ($result->execute()) {
                $body = $this->getConf("forgetMailBody")."<a href=http://".$_SERVER['HTTP_HOST']."/login/change.php?forget=".$mail."&key=".$key.">Press to recovery</a>";
                if($this->sendMail($mail, $this->getConf("forgetMailHeader"), $body)){
                    return true;   
                }else{
                    return false;
                }
            } else {
                return false;  
            }
        }else{
            return false;   
        }
    }

    /**
     * Change password (after "Request to change password")
     * require mail, key
     * @return bool
     */
    public function changePassword($mail, $key, $password) {
        //is this mail registr
        if ($result = $this->conn->prepare("SELECT id FROM `account` WHERE `mail` = ? AND `hash` = ? AND `create` > NOW() - INTERVAL 30 MINUTE")){
            $result->bind_param('ss', $mail, $key);
            $result->execute();
            $result->store_result();
        }
        //if verification isn't expire
        if ($result->num_rows == 1){

            $hashPassword = password_hash($password, PASSWORD_DEFAULT);

            //update state to verificate
            $result = $this->conn->prepare("UPDATE `account` SET `password` = ? WHERE `mail` = ?");
            $result->bind_param('ss', $hashPassword, $mail);

            if ($result->execute()) {
                return true;
            } else {
                return false;  
            }
        }else{
            return false;   
        }
    }  

    /**
     * Logout
     * require 
     * @return reload page
     */
    public function logout() {
        // Destroy session
        session_start();
        session_destroy();

        // Destroi cookie
        // unset cookies
        if (isset($_SERVER['HTTP_COOKIE'])) {
            $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
            foreach($cookies as $cookie) {
                $parts = explode('=', $cookie);
                $name = trim($parts[0]);
                setcookie($name, '', time()-1000);
                setcookie($name, '', time()-1000, '/');
            }
        }

        // Redirect to the login page:
        return true;

    }

        /**
     * Teacher registration
     * require mail, name, password, parameter is add to to of confirm mail
     * @return bool
     */
    public function teacherRegistr($post, $image) {


        //insert user langs
        foreach ($post["slectLang"] as $key => $lang) {
            if ($result = $this->conn->prepare('INSERT INTO `langs` (`userID`, `lang`,`levl`) VALUES (?, ?, ?)')) {
                $result->bind_param('iss', $_SESSION['id'] ,$post["slectLang"][$key], $post["slectLevl"][$key]);
                    if (!$result->execute()) {
                        //insert errpr
                        return false;  
                    }
            } else {
                //error in sql
                return false;  
            }
        }
        //insert user tags
        foreach ($post["tags"] as $tag) {
            if ($result = $this->conn->prepare('INSERT INTO `tags` (`userID`, `tag`) VALUES (?, ?)')) {
                $result->bind_param('is', $_SESSION['id'] ,$tag);
                if (!$result->execute()) {
                    //insert errpr
                    return false;  
                }
            } else {
                //error in sql
                return false;  
            }
        }

        //insert user addational information
        if ($result = $this->conn->prepare("INSERT INTO `teacher` (`userID`, `contactEmail`, `phone`, `age`, `sex`, `photo`, `price`, `city`, `about`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
            
            $result->bind_param('issississ', $_SESSION["id"], $post['contactEmail'], $post['phone'], $post['age'], $post['sex'], $image, $post['price'], $post['city'],$post['about']);
            if ($result->execute()) {
                return true;
            } else {
                echo "nop";
                var_dump($result);
                //insert errpr
                return false;  
            }
        } else {
            var_dump($result);
            //error in sql
            return false;  
        }
    }

    /**
     * isTeacher
     * require 
     * @return boolean
     */
    public function isTeacher() {
        // Prepare our SQL, preparing the SQL statement will prevent SQL injection.
        if ($stmt = $this->conn->prepare('SELECT `id` FROM `teacher` WHERE `userID` = ?')) {
            // Bind parameters (s = string, i = int, b = blob, etc), in our case the mail is a string so we use "s"
            $stmt->bind_param('i', $_SESSION["id"]);
            $stmt->execute();
            // Store the result so we can check if the account exists in the database.
            $stmt->store_result();
        }
        // Account exist
        if ($stmt->num_rows > 0) {
            return true;
        } else {
            return false;
        }
        $stmt->close();
    }

    /**
     * get all teacher if to set filter
     * require 
     * @return bool
     */
    public function getTeachers($lang = null, $city = null, $tag = null, $priceOrder = "ASC") {
        $sql = "SELECT `teacher`.`photo`, `teacher`.`city`, `teacher`.`price`, `account`.`firstName`, `account`.`lastName`, `account`.`id`
        FROM `account`
        INNER JOIN `teacher` ON `teacher`.`userID` = `account`.`id`";

        if($lang != null && $city != null){
            $sql .= " WHERE EXISTS (
                SELECT * FROM `langs`
                WHERE `langs`.`userID`=`account`.`id` AND `langs`.`lang` = '$lang' and `teacher`.`city` = '$city'
                )";
        }

        if($tag != null){
            $sql .= " WHERE EXISTS (
                SELECT * FROM `tags`
                WHERE `tags`.`userID`=`account`.`id` AND `tags`.`tag` = '$tag' 
                )";
        }

        $sql .= " ORDER BY `teacher`.`price` ".$priceOrder;

        if ($stmt = $this->conn->prepare($sql)) {
            // Bind parameters (s = string, i = int, b = blob, etc), in our case the mail is a string so we use "s"
            //$stmt->bind_param('s', $mail);
            $stmt->execute();
            // Store the result so we can check if the account exists in the database.
            $results = $stmt->get_result();
            return mysqli_fetch_all($results, MYSQLI_ASSOC);
        }else{
            return false;
        }
    }


    /**
     * getTeacher
     * require user id
     * @return teacher/bool
     */
    public function getTeacher($id) {

        if ($stmt = $this->conn->prepare('SELECT `account`.`id`,`teacher`.`photo`, `teacher`.`price`, `account`.`firstName`, `account`.`lastName`, `teacher`.`sex`, `teacher`.`city`, `teacher`.`contactEmail`, `teacher`.`phone`, `teacher`.`age`, `teacher`.`about` FROM `account`
        INNER JOIN `teacher` ON teacher.userID = account.id WHERE account.id = ?')) {
            // Bind parameters (s = string, i = int, b = blob, etc), in our case the mail is a string so we use "s"
            $stmt->bind_param('i', $id);
            $stmt->execute();
            // Store the result so we can check if the account exists in the database.
            $results = $stmt->get_result();
            return mysqli_fetch_all($results, MYSQLI_ASSOC)[0];
        }else{
            return false;
        }
    }

    /**
     * Get teacher tags
     * require id of teacher
     * @return bool
     */
    public function getTeacherTags($id) {

        if ($stmt = $this->conn->prepare('SELECT `tag` FROM `tags` WHERE userID = ?')) {
            // Bind parameters (s = string, i = int, b = blob, etc), in our case the mail is a string so we use "s"
            $stmt->bind_param('i', $id);
            $stmt->execute();
            // Store the result so we can check if the account exists in the database.
            $results = $stmt->get_result();
            return mysqli_fetch_all($results, MYSQLI_ASSOC);
        }else{
            return false;
        }
    }

    /**
     * Get teacher language
     * require id of teacher
     * @return bool
     */
    public function getTeacherLangs($id) {

        if ($stmt = $this->conn->prepare('SELECT `lang`,`levl`  FROM `langs` WHERE userID = ?')) {
            // Bind parameters (s = string, i = int, b = blob, etc), in our case the mail is a string so we use "s"
            $stmt->bind_param('i', $id);
            $stmt->execute();
            // Store the result so we can check if the account exists in the database.
            $results = $stmt->get_result();
            return mysqli_fetch_all($results, MYSQLI_ASSOC);
        }else{
            return false;
        }
    }

    /**
     * get actual week calendar
     * require 
     * @return boolean
     */
    public function getWeekCalendar() {
        $week = $this->rangeWeek();
        echo '
        <table id="calendar" class="table table-hover table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th class="timeCell">#</th>
                    <th data-id="'.$week[12].'">'.$week[11].'</th>
                    <th data-id="'.$week[22].'">'.$week[21].'</th>
                    <th data-id="'.$week[32].'">'.$week[31].'</th>
                    <th data-id="'.$week[42].'">'.$week[41].'</th>
                    <th data-id="'.$week[52].'">'.$week[51].'</th>
                    <th data-id="'.$week[62].'">'.$week[61].'</th>
                    <th data-id="'.$week[72].'">'.$week[71].'</th>
                </tr>
            </thead>
            <tbody>
            
            ';
            $y = 360;
            for ($i = 1; $i <= 32; $i++) {
            echo "<tr>";
                    echo "<td scope='row'><span class='move'>";
                    echo round($y / 60);
                    echo ":";
                    if(30-($y % 60) != 0){
                        echo 30;
                    }else{
                        echo "00";
                    }
                    echo '</span></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    ';
            echo "</tr>";
            $y = $y + 30;
            } 
        echo '
        </tbody>
    </table>
    ';
    }

    public function rangeWeek() {
        date_default_timezone_set (date_default_timezone_get());
        $dt = strtotime('today UTC');
        return array (
          "11" => date ('N', $dt) == 1 ? date ('D m-d', $dt) : date ('D m-d', strtotime ('monday this week', $dt)),
          "12" => date ('N', $dt) == 1 ? date ('y/n/j', $dt) : date ('y/n/j', strtotime ('monday this week', $dt)),

          "21" => date ('N', $dt) == 2 ? date ('D m-d', $dt) : date ('D m-d', strtotime ('tuesday this week', $dt)),
          "22" => date ('N', $dt) == 2 ? date ('y/n/j', $dt) : date ('y/n/j', strtotime ('tuesday this week', $dt)),

          "31" => date ('N', $dt) == 3 ? date ('D m-d', $dt) : date ('D m-d', strtotime ('wednesday this week', $dt)),
          "32" => date ('N', $dt) == 3 ? date ('y/n/j', $dt) : date ('y/n/j', strtotime ('wednesday this week', $dt)),

          "41" => date ('N', $dt) == 4 ? date ('D m-d', $dt) : date ('D m-d', strtotime ('thursday this week', $dt)),
          "42" => date ('N', $dt) == 4 ? date ('y/n/j', $dt) : date ('y/n/j', strtotime ('thursday this week', $dt)),

          "51" => date ('N', $dt) == 5 ? date ('D m-d', $dt) : date ('D m-d', strtotime ('friday this week', $dt)),
          "52" => date ('N', $dt) == 5 ? date ('y/n/j', $dt) : date ('y/n/j', strtotime ('friday this week', $dt)),

          "61" => date ('N', $dt) == 6 ? date ('D m-d', $dt) : date ('D m-d', strtotime ('saturday this week', $dt)),
          "62" => date ('N', $dt) == 6 ? date ('y/n/j', $dt) : date ('y/n/j', strtotime ('saturday this week', $dt)),

          "71" => date ('N', $dt) == 7 ? date ('D m-d', $dt) : date ('D m-d', strtotime ('sunday this week', $dt)),
          "72" => date ('N', $dt) == 7 ? date ('y/n/j', $dt) : date ('y/n/j', strtotime ('sunday this week', $dt))

        );
    }

        /**
     * Add action to calendar
     * require date, from, to, action
     * @return bool
     */
    public function addToCalendar($date, $from, $to, $action) {
        if ($stmt = $this->conn->prepare('INSERT INTO `calendar` (`userID`, `date`, `timeFrom`, `timeTo`, `action`) VALUES (?, ?, ?, ?, ?)')) {
            $stmt->bind_param('sssss', $_SESSION["id"] , $date, $from, $to, $action);
            if($stmt->execute()){
                return true;
            }else {
                return false;
            }   
        } else {
            return false;
        }
    }


        /**
     * Get teacher data from calendar
     * require session id of teacher
     * @return bool
     */
    public function getTeacherProgram() {
        
        $resultsArray = "var program = [";
        if ($stmt = $this->conn->prepare('SELECT `date`,`timeFrom`,`timeTo`,`action` FROM `calendar` WHERE `userID` = ?')) {
            // Bind parameters (s = string, i = int, b = blob, etc), in our case the mail is a string so we use "s"
            $stmt->bind_param('i', $_SESSION["id"]);
            $stmt->execute();
            // Store the result so we can check if the account exists in the database.
            $results = $stmt->get_result();
            $results = mysqli_fetch_all($results, MYSQLI_ASSOC);
            
            
            foreach($results as $result){
                $today = DateTime::createFromFormat('y/n/j', $result["date"]);
                $result["date"] = $today->format('N'); 

                if($resultsArray != "var program = ["){
                    $resultsArray .= ",";
                }
                
                $resultsArray .= "{day : ".$result["date"].",from : '".$result["timeFrom"]."',to : '".$result["timeTo"]."',color : '".$result["action"]."'}";
            }
            $resultsArray .= "]";
            return $resultsArray;
        }else{
            return false;
        }
    }

    /**
     * Generate random Key
     * @return string default 10 char
     */
    public function generateKey($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Send mail in define them
     * @return bool
     */
    public function sendMail($to, $subject, $content, $from = "noreply@mluv.im") {
        // Set content-type when sending HTML email
        // More headers
        $headers = 'From: '.$from . "\r\n";
        $headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: ".$from. "\r\n" .
        "Reply-To:".$from. "\r\n" .
        "X-Mailer: PHP/" . phpversion();

        $message = "
        <html>
            <head>
                <title>".$subject."</title>
            </head>
            <body>
                ".$content."
            </body>
        </html>
        ";

        return mail($to,$subject,$message,$headers);
    }

    /**
     * Load value from conf.php
     * @return auto
     */
    public function getConf($parametr) {
        return $this->conf[$parametr];
    }  
}
?>