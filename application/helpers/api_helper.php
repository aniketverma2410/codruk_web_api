<?php 
  function saveProfilesImage($base64,$path,$nickName)
    {
        $img = imagecreatefromstring(base64_decode($base64)); 
        if($img != false)
        { 
            $imageName = $nickName.generate_unique_code().'.jpg';
            if(imagejpeg($img,$path.$imageName)) 
                return $imageName;
            else
                return '';
        }
    }
    function user_last_seen_format($request_time){
        $time_middle = new DateTime($request_time, new DateTimeZone(date_default_timezone_get()));
        $time_middle->setTimeZone(new DateTimeZone($_COOKIE['bl_timezone']));
        return $time_middle->format('Y-m-d H:i:s');
    }

    function generate_unique_code(){
        return substr(str_shuffle("1234567890"),'0','4');   
    }
    
    function rideCode(){
      return 'CRK'.substr(str_shuffle("1234567890"),'0','6');   
    }


function SendOtpSMS($requestMobile,$message){
    $url = "http://www.wiztechsms.com/http-api.php?username=ubaid&password=ubaid&senderid=OXPLUS&route=1&number=".$requestMobile."&message=".urlencode($message);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_exec($ch);
    return 1;
} 

function sentEmailInfo($subject,$email,$smsmessage,$sign,$from){
    // ++++++++++++++
    $to      = $email;
    $subject = $subject;
    $message = $smsmessage;
    $message .= "\r\n".$sign;
    $headers = "From:".$from."\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";
    mail($to,$subject,'<pre style="font-size:14px;">'.$message.'</pre>',$headers);
    return 1;
  }

   function generateServerResponse($msg_code, $res_msg, $data = null){
        
        $getDateTime = getDateAndIp();
        $array[APP_NAME] = array();
        $resultMsg = Messages($res_msg);
        $array[APP_NAME]["res_code"] = $msg_code;
        $array[APP_NAME]["res_msg"]  = $resultMsg;  
        
        if(!empty($data)){
            foreach($data as $key=>$val){
                $array[APP_NAME][$key]  = $val;
            }
        }
        $str = json_encode($array, true);
        echo str_replace("null",'""', $str);
        exit;
    }
    function getDateAndIp(){
        $result = array();  
        $result['ip'] = $_SERVER['REMOTE_ADDR'];
        $result['date'] = time();
        $result['datetime'] = date('Y-m-d h:i:s');
        return $result ; 
    }
    function validateJson($requestJson, $check_request_keys){
        
        if($requestJson){
            $validate_keys      = array();
            
            foreach($requestJson[APP_NAME] as $key=>$val){
                if($key!='driverId'){
                    $validate_keys[] = $key;
                }
            }
            
            $result = array_diff($validate_keys,$check_request_keys);

            if($result){ 
                return "0";
            }else{
                return  "1";
            } 
        }else{
            return  "0";
        }          
    }
    
    function validateEmail($email_a){
        if (!filter_var($email_a, FILTER_VALIDATE_EMAIL)) {
            return 0;
        }
    }
    
    function isBlank($fieldName, $msgCode, $msgType){
        if($fieldName == ''){
            generateServerResponse($msgCode, $msgType);
        }
    }
    
    function checkLength($fieldName, $fieldLength,$msgCode, $msgType){
        $length =  strlen($fieldName);
        if($length > $fieldLength){
           generateServerResponse($msgCode, $msgType);
        }
    }
    
    function isPhone($fieldName, $msgCode, $msgType){
        if(!ctype_digit($fieldName)){
          generateServerResponse($msgCode, $msgType);
        } 
    }
    
    function isDobBlank($fieldName, $msgCode, $msgType){
        if($fieldName == '' || $fieldName == '0000-00-00'){
            generateServerResponse($msgCode, $msgType);
        }
    }
    function isDobFormat($fieldName, $msgCode, $msgType){
        if(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$fieldName)){
            generateServerResponse($msgCode, $msgType);
        }
    }
    
    function isFutureDate($fieldName, $msgCode, $msgType){
        if($fieldName < mktime()){
            generateServerResponse($msgCode, $msgType);
        }
    }
    
    function phoneLength($fieldName, $msgCode, $msgType){
        if(strlen($fieldName) != 10){
             generateServerResponse($msgCode, $msgType);
        }
    }
    
    function phoneMinLength($fieldName, $msgCode, $msgType){
        if(strlen($fieldName) < 9){
             generateServerResponse($msgCode, $msgType);
        }
    }
    function phoneMaxLength($fieldName, $msgCode, $msgType){
        if(strlen($fieldName) >= 15){
             generateServerResponse($msgCode, $msgType);
        }
    }
    
    function Messages($res_msg){
        $codes = Array(
                    '100' => 'Input json is not valid.',
                    '101' => 'Json Used is not valid.',
                    '102' => 'Please enter your name.',
                    '103' => 'Please enter your mobile number.',
                    '104' => 'Please enter your email.',
                    '105' => 'Please enter your password.',
                    '106' => 'Email entered already exists.',
                    '107' => 'Please enter your city.',
                    '108' => 'Mobile number already exists.',
                    '109' => 'Mobile number must be 10 digit.',
                    '110' => 'Please enter your username.',
                    '111' => 'Please enter your device id.',
                    '112' => 'Invalid username or password.',
                    '113' => 'Login successfully done.',
                    '114' => 'Logout successfully done.',
                    '115' => 'New password sent to the registered mobile number.',
                    '116' => 'Profile Updated successfully.',
                    '117' => 'Old password does not match.',
                    '118' => 'Both password must be same.',
                    '119' => 'Password Updated successfully',
                    '120' => 'Please enter your city.',
                    '121' => 'Wrong OTP',
                    '122' => 'Invalid mobile number',
                    '123' => 'You are not verified.',
                    '124' => 'OTP sent to the registered mobile number.',
                    '125' => 'Please enter country code.',
                    '126' => 'Favorite data added successfully.',
                    '127' => 'Already added in favorite.',
                    '128' => 'Unfavorite successfully.',

                    '129' => 'Invalid login id.',
                    '130' => 'User already logged out.', 
                    '131' => 'Login id can not be empty.', 
                    '132' => 'Invalid credentials.', 
                    '133' => 'Device Id can not be empty.',
                    '134' => 'Observation id cannot be empty.',
                    '135' => 'Mobile number alredy registered.',
                    '136' => 'File can not be empty.',
                    '137' => 'base64 string is not valid.',
                    '138' => 'Invalid mobile number',
                    '139' => 'otp can not be empty.',
                    '140' => 'Auth token can not be empty.',
                    '141' => 'Invalid user ID and device Id.',
                    '142' => 'Invalid your password',
                    '143' => 'Invalid user type.',
                    '144' => 'Profile picture not exists.',
                    '145' => 'product Id can not be empty.',
                    '146' => 'Invalid event Id.',
                    '147' => 'Invalid user Id.',
                    '148' => 'Invalid mobile number',
                    '149' => 'Image type can not be empty.',
                    '150' => 'User already registered',
                    '201' => 'Logged out successfully Done.',
                    '205' => 'Staff Id cannot be empty',
                    'W'   => 'Something went wrong.',
                    '202' => 'company name is empty', 
                    '203' => 'city can not empty', 
                    '204' => 'Insufficient balance',
                    '205' => 'Shipper name cannot be empty',
                    '206' => 'Shipper address cannot be empty',
                    '207' => 'Consignee name cannot be empty',
                    '208' => 'Consignee address cannot be empty',
                    '209' => 'Consignee Mobile number cannot be empty',
                    '210' => 'Collection type cannot be empty',
                    '211' => 'Collection Amount cannot be empty',
                    '212' => 'Borcode id cannot be empty',
                    '213' => 'Shipment has been posted successfully.',
                    '214' => 'Invalid api request token.',
                    '215' => 'Status cannot be empty',
                    '216' => 'Record updated successfully',
                    '217' => 'Barcode Id is incorrect',
                    'Success'   => 'Success',
                    'otp'   => 'otp',
                    'Fail'   => 'Fail',
                    'E'   => 'Data Not Found.',
                    '404' => '404'   ,                               
                    '151' => 'User Id not found' ,
                    'WRONG' => "Order Could not be placed",
                    'S' => 'Records Found',
                    '218' => 'Barcode Id is already Used',
                    'Send_request'=>'Request sent successfully',
                    'Cancel_request' => 'Request cancel successfully',
                    '219' => 'Your Vehicle Request is already been approved',
                    '220' => 'You are not allowed to cancel this request, because your vehicle request is approved',
                    '221' => 'Pending for Admin Approval',
                    '222' => 'Record Found',
                    '223' => 'Record Not Found',
                    '224' => 'You have already Logged In some other device,please logout first!',
                    '225' => 'Request accepted successfully',
                    '226' => 'Request has already accepted by some other driver',
                    '227' => 'Your ride acceptance timed out',
                    '228' => 'Ride cancelled successfully',
                    '229' => 'Your set favourite location quota is over for the DAY, try it tommorrow',
                    '230' => 'Ride has already cancelled by customer',
                    '231' => 'Rating saved successfully',
                    '232' => 'Your ride has already been generated'                                               
                );
        return (isset($codes[$res_msg])) ? $codes[$res_msg] : '';        
    }

    function getRequestJson()
    {
        $request_data  = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : file_get_contents('php://input');
        
        return json_decode($request_data,true);
    }


    function get_coin_points($attempt){

        $coin = 0;

        switch ($attempt) {
            case '1':
                $coin = 5;
                break;
            
            default:
                $coin = 0;
            break;
        }

        return $coin;
    }

    function get_last_active($interval){

        if($interval->s):
            $return =$interval->s . " seconds ago";
        endif;

        if($interval->i):
            $return =$interval->i . " minutes ago";
        endif;

        if($interval->h):
            $return =$interval->h . " hours ago";
        endif;

        if($interval->d):
            $return =$interval->d . " days ago";
        endif;

        if($interval->m):
            $return =$interval->m . " months ago";
        endif;

        return $return;

    }