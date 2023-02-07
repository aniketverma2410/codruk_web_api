<?php
function getAlertMessage($code){
    $codes = Array(
                '1' => 'Invalid Username/Email or Password.',
                '2' => 'Customer data has been updated successfully.',
                '3' => 'Driver data has been updated successfully.',
                '4' => 'Email id already exist.',
                '5' => 'Mobile number already exist.',
                '10' => 'Account has been logout successfully.',
                '11' => 'Record has been updated successfully.',
                '12' => '!Oops something went wrong.',
                '13' => 'Definition data has been added successfully.',
                '14' => 'Definition data has been updated successfully.',
                '15' => 'Template data has been added successfully.',
                '16' => 'Template data has been updated successfully.',
                '17' => 'Vehicle data has been added successfully.',
                '18' => 'Vehicle data has been updated successfully.',
                '19' => 'Admin Profile has been updated successfully.',
                '20' => 'Loader data has been added successfully.',
                '21' => 'Loader data has been updated successfully.',
                '22' => 'Insurance data has been updated successfully.',
                '23' => 'Insurance data has been updated successfully.',
                '24' => 'Settings data has been updated successfully.',
                '25' => 'Record has been added successfully.',
                '26' => 'Record has been updated successfully.',
                '27' => 'OTP is incorrect,plz try again!',
                '28' => 'OTP verified successfully,Pending for admin Approval',
                '29' => 'Owner Profile has been updated successfully.',
                '30' => 'Profile updated successfully.',
                '31' => 'This record is no longer exist.'
            );

    return (isset($codes[$code])) ? $codes[$code] : '';
}
function getAlertBody($class, $message){
    $alert  =   '<div class="alert alert-'.$class.'">
                    '.$message.'
                </div>';

    return $alert;
}
function generateAdminAlert($type, $messageCode){
    if($type == 'S'){
        $flash_msg = getAlertBody("success", getAlertMessage($messageCode));
    }elseif($type == 'I'){
        $flash_msg = getAlertBody("info", getAlertMessage($messageCode));
    }elseif($type == 'W'){
        $flash_msg = getAlertBody("warning", getAlertMessage($messageCode));
    }elseif($type == 'D'){
        $flash_msg = getAlertBody("danger", getAlertMessage($messageCode));
    }

    return $flash_msg;
}
function getCustomAlert($type, $message){
    if($type == 'S'){
        $flash_msg = getAlertBody("success", $message);
    }elseif($type == 'I'){
        $flash_msg = getAlertBody("info", $message);
    }elseif($type == 'W'){
        $flash_msg = getAlertBody("warning", $message);
    }elseif($type == 'D'){
        $flash_msg = getAlertBody("danger", $message);
    }

    return $flash_msg;
}

/* login/session methods */
// Check login status if already login redirect it to dashboard
function is_logged_in() {
    $obj =& get_instance();
    $adminData = $obj->session->userdata('adminData');
    if (!empty($adminData)) {
        redirect('admin-dashboard');
    }
}
// Check login status if not login redirect it to login page
function is_not_logged_in() {
    $obj =& get_instance();
    $adminData = $obj->session->userdata('adminData');
    if (empty($adminData)) {
      redirect('admin-login');
    }
    return $adminData;
}

function is_logged_in_owner() {
    $obj =& get_instance();
    $OwnerData = $obj->session->userdata('OwnerData');
    if (!empty($OwnerData)) {
        redirect('owner/dashboard');
    }
}

function is_not_logged_in_owner() {
    $obj =& get_instance();
    $OwnerData = $obj->session->userdata('OwnerData');
    if (empty($OwnerData)) {
      redirect('owner/index');
    }

    return $OwnerData;
}

 function secondsToTime($inputSeconds) 
    {

    $secondsInAMinute = 60;
    $secondsInAnHour  = 60 * $secondsInAMinute;
    $secondsInADay    = 24 * $secondsInAnHour;

    // extract days
    $days = floor($inputSeconds / $secondsInADay);

    // extract hours
    $hourSeconds = $inputSeconds % $secondsInADay;
    $hours = floor($hourSeconds / $secondsInAnHour);

    // extract minutes
    $minuteSeconds = $hourSeconds % $secondsInAnHour;
    $minutes = floor($minuteSeconds / $secondsInAMinute);

    // extract the remaining seconds
    $remainingSeconds = $minuteSeconds % $secondsInAMinute;
    $seconds = ceil($remainingSeconds);

    // return the final array
    $obj = array(
        'd' => (int) $days,
        'h' => (int) $hours,
        'm' => (int) $minutes,
        's' => (int) $seconds,
    );
    return $obj;

    }