<?php
    require_once "Date.php";

    function redirect($location) {
        header("Location: ".$location);
    }

    if (!function_exists("str_contains")) {
        function str_contains(string $haystack, string $needle): bool {
            return "" === $needle || false !== strpos($haystack, $needle);
        }
    }

    function randomWord($len = 5) {
        $result = array_merge(range("0", "9"), range("A", "Z"));
        shuffle($result);
        return substr(implode($result), 0, $len);
    }

    function isValidEmail($email_address) {
        return filter_var($email_address, FILTER_VALIDATE_EMAIL);
    }

    function isValidMobileNumber($mobile_number) {
        return preg_match("/^[0-9]{10}+$/", $mobile_number);
    }

    function isValidPassword($password) {
        return preg_match("/^[A-Za-z0-9]*$/", $password);
    }

    function fullTrim($string) {
        $splitted_string = explode(" ", $string);
        $trimmed_string = array();
        
        foreach ($splitted_string as $string) {
            if (!empty(trim($string))) {
                array_push($trimmed_string, trim($string));
            }
        }
        return implode(" ", $trimmed_string);
    }

    function toProper($string) {
        return ucwords(strtolower($string));
    }

    function atMorningShift($time_out) {
        $date = new Date();

        if (empty($time_out)) {
            $time_out = $date->getDateTimeValue();
        } else {
            $time_out = strtotime($time_out);
        }
        
        return $time_out < $date->morning_shift_end();
    }

    function atAfternoonShift($time_out) {
        $date = new Date();

        if (empty($time_out)) {
            $time_out = $date->getDateTimeValue();
        } else {
            $time_out = strtotime($time_out);
        }
        
        return $time_out >= $date->afternoon_shift_start() && $time_out < $date->time_out_start();
    }

    function atOvertime($time_out) {
        $date = new Date();

        if (empty($time_out)) {
            $time_out = $date->getDateTimeValue();
        } else {
            $time_out = strtotime($time_out);
        }
        
        return $time_out >= $date->time_out_end() && $time_out < $date->time_out_overtime_start();
    }

    function atEndOfDay($time_out) {
        $date = new Date();

        if (empty($time_out)) {
            $time_out = $date->getDateTimeValue();
        } else {
            $time_out = strtotime($time_out);
        }
        
        return $time_out >= $date->time_out_overtime_end();
    }

    function atAfternoonTimeIn($time_in, $time_out) {
        $date = new Date();

        if (empty($time_out)) {
            $time_out = $date->getDateTimeValue();
        } else {
            $time_out = strtotime($time_out);
        }

        return strtotime($time_in) >= $date->morning_shift_end() && strtotime($time_in) < $date->afternoon_shift_start() &&
            $time_out >= $date->morning_shift_end() && $time_out < $date->afternoon_shift_start();
    }

    function isTimeInEnabled($att_date) {
        $date = new Date();
        return $att_date != $date->getDate() && date("N", strtotime($date->getDate())) != 7 &&
            (($date->getDateTimeValue() >= $date->time_in_start() &&  $date->getDateTimeValue() < $date->time_in_end()) ||
            ($date->getDateTimeValue() >= $date->morning_shift_end() && $date->getDateTimeValue() < $date->afternoon_shift_start()));
    }

    function isTimeOutEnabled($time_in, $time_out) {
        $date = new Date();

        return !(!empty($time_out) || atMorningShift($time_out) || atAfternoonShift($time_out) ||
            atOvertime($time_out) || atEndOfDay($time_out) || atAfternoonTimeIn($time_in, $time_out));
    }

    function isTimeOutInSchedule($time_in, $time_out) {
        $date = new Date();

        return !(atMorningShift($time_out) || atAfternoonShift($time_out) ||  atOvertime($time_out) || atEndOfDay($time_out) || atAfternoonTimeIn($time_in, $time_out));
    }

    function isMorningShift($time_in, $time_out) {
        $date = new Date();
        return strtotime($time_in) >= $date->time_in_start() && strtotime($time_in) < $date->afternoon_shift_start() &&
            strtotime($time_out) >= $date->time_in_start() && strtotime($time_out) < $date->afternoon_shift_start();
    }

    function isAfternoonShift($time_in, $time_out) {
        $date = new Date();
        return strtotime($time_in) >= $date->morning_shift_end() && strtotime($time_in) < $date->time_out_overtime_end() &&
            strtotime($time_out) >= $date->morning_shift_end() && strtotime($time_out) < $date->time_out_overtime_end();
    }

    function isOvertime($time_out) {
        $date = new Date();
        return strtotime($time_out) >= $date->time_out_overtime_start() &&
            strtotime($time_out) < $date->time_out_overtime_end();
    }

    function isActiveIntern($onboard_date, $offboard_date, $att_date) {
        return strtotime($onboard_date) <= strtotime($att_date) &&
            (empty($offboard_date) || strtotime($offboard_date) >= strtotime($att_date));
    }

    function getMonths() {
        return array("January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December");
    }

    function regularTimeInSchedule() {
        $date = new Date();
        return date("g:i a", $date->time_in_start())." to ".
            date("g:i a", strtotime(date("g:i a", $date->morning_briefing())." - 1 minutes"));
    }

    function lateTimeInSchedule() {
        $date = new Date();
        return date("g:i a", $date->morning_briefing())." to ".
            date("g:i a", strtotime(date("g:i a", $date->time_in_end())." - 1 minutes"));
    }

    function morningShiftTimeOutSchedule() {
        $date = new Date();
        return date("g:i a", $date->morning_shift_end())." to ".
            date("g:i a", strtotime(date("g:i a", $date->afternoon_shift_start())." - 1 minutes"));
    }

    function afternoonShiftTimeInSchedule() {
        $date = new Date();
        return date("g:i a", $date->morning_shift_end())." to ".
            date("g:i a", strtotime(date("g:i a", $date->afternoon_shift_start())." - 1 minutes"));
    }

    function regularTimeOutSchedule() {
        $date = new Date();
        return date("g:i a", $date->time_out_start())." to ".
            date("g:i a", strtotime(date("g:i a", $date->time_out_end())." - 1 minutes"));
    }

    function overTimeTimeOutSchedule() {
        $date = new Date();
        return date("g:i a", $date->time_out_overtime_start())." to ".
            date("g:i a", strtotime(date("g:i a", $date->time_out_overtime_end())." - 1 minutes"));
    }

    function isDATEnabled() {
        $date = new Date();
        return $date->getDateTimeValue() >= $date->dat_start() &&
            $date->getDateTimeValue() < $date->dat_end();
    }

    function ordinalValue($number) {
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        if ((($number % 100) >= 11) && (($number%100) <= 13))
            return $number. 'th';
        else
            return $number. $ends[$number % 10];
    }


    // Functions for Uploading an Image to Database 
    function extract_name($fileName){
        $name = $fileName['name'];
        return $name;
    }
    
    function extract_tmp_name($fileName){
        $tmpName = $fileName['tmp_name'];
        return $tmpName; 
    }
    
    function extract_size($fileName){
        $size =  $fileName['size'];
        return $size;
    }
    
    function extract_error($fileName){
        $error = $fileName['error'];
        return $error;
    }
    
    function extract_ext($fileName){
        $partialExt = explode(".", $fileName);
        $extension = strtolower(end($partialExt));
        return $extension;
    }
    
    // End of Extraction function
    
    function file_destination($directory ,$renamedFile){
        $fileUploadDestination = $directory.$renamedFile;
        return $fileUploadDestination;
    }
    
    function check_file_extension($fileActualExtention, $allowedExtension) {
        if (in_array($fileActualExtention, $allowedExtension)){
            return true;
        } else {
            return false;
        }
    }
    function check_upload_error($fileError){
        if ($fileError === 0){
            return true;
        } else {
            return false;
        }
    }
    
    function check_file_size($fileSize){
        if ($fileSize < 1000000){
            return true;
        } else {
            return false;
        }
    }
    
    function rename_file($extractedExt){
        $renamedFile = uniqid('', true).".".$extractedExt;
        return $renamedFile;
    }

    // Function for login system
    function unset_logged_in_session(){
        $redirect_path = "../../index.php"; 
        unset($_SESSION['logged_in_id']);
        unset($_SESSION['logged_in_full_name']);
        unset($_SESSION['logged_in_profile_file_name']);
        unset($_SESSION['logged_in_user_type']);
        unset($_SESSION['logged_in_password']);
        header('Location: ' . $redirect_path);
    }

    function allow_anonymous_only($redirect_path = "../dashboard"){
        if(isset($_SESSION['logged_in_id'])){
            redirect($redirect_path);
        }
    }

    // Authenticated means that the user have
    // id

    function allow_all_authenticated_only(){
        if(!isset($_SESSION['logged_in_id'])){
            unset_logged_in_session();
        }
    }
    // Fully authenticated means that the user have
    // id, password, and date activated 
    function allow_all_fully_authenticated(){
        if(!isset($_SESSION['logged_in_id']) || empty($_SESSION['logged_in_password']) 
        || empty($_SESSION['logged_in_date_activated'])){
            unset_logged_in_session();
        } 
    }
 
    function allow_specific_user_only($allowed_users = []){
        allow_all_fully_authenticated();
        for ($i=0; $i < sizeof($allowed_users); $i++) { 
            if($_SESSION['logged_in_user_type'] === $allowed_users[$i])return;
        }
        unset_logged_in_session();
    }

    function allow_specific_department_only($allowed_department = []){
        allow_all_fully_authenticated();
        for ($i=0; $i < sizeof($allowed_department); $i++) { 
            if($_SESSION['logged_in_user_department'] === $allowed_department[$i])return;
        }
        unset_logged_in_session();
    }


    function allow_specific_designation_only($allowed_designation = []){
        allow_all_fully_authenticated();
        for ($i=0; $i < sizeof($allowed_designation); $i++) { 
            if($_SESSION['logged_in_user_designation'] === $allowed_designation[$i])return;
        }
        unset_logged_in_session();
    }
?>