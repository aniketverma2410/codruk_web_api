<?php
class CustomerModel extends CI_Model {
  public function __construct(){
    parent::__construct();
    $this->load->helper('api');
    $this->load->database();
  
  }

 // Customer Data Post Here
    public function customerSignup($requestData){  
      isBlank($requestData['name'],NOT_EXISTS,102); 
      isBlank($requestData['email'],NOT_EXISTS,104); 
      isBlank($requestData['countryCode'],NOT_EXISTS,125); 
      isBlank($requestData['mobile'],NOT_EXISTS,103); 
      //phoneLength($requestData['mobile'],NOT_EXISTS,109); 
      isBlank($requestData['password'],NOT_EXISTS,105); 

      $checkEmailViaCustomer    = $this->checkExistMobileOrEmail('customer_master','email',$requestData['email']);
      $checkEmailViaDriver      = $this->checkExistMobileOrEmail('driver_master','email',$requestData['email']);

      $checkMobileViaCustomer   = $this->checkExistMobileOrEmail('customer_master','mobile',$requestData['mobile']);
      $checkMobileViaDriver     = $this->checkExistMobileOrEmail('driver_master','mobile',$requestData['mobile']);

       if($checkEmailViaCustomer > 0 || $checkEmailViaDriver > 0){
        generateServerResponse(F,'106');
       }

       if($checkMobileViaCustomer > 0 || $checkMobileViaDriver > 0){
        generateServerResponse(F,'108');
       }

        $getEmailData = $this->getTableData('notification_setting_master','1');
        $getsmsData   = $this->getTableData('notification_setting_master','2');

        $param                 = array();
        $param['name']         = $requestData['name'];
        $param['email']        = $requestData['email'];
        $param['mobile']       = $requestData['mobile'];
        $param['countryCode']  = $requestData['countryCode'];
        $completeMobileNumber  = $requestData['countryCode'].$requestData['mobile'];
        $param['otp']          = rand(111111,999999);
        $param['password']     = base64_encode($requestData['password']);
        $param['status']       = 1;
        $param['addDate']      = time();
        $param['modifyDate']   = time();
        
        $message               = str_replace('[$code]',$param['otp'],$getsmsData['body']);
        $emailMessage          = str_replace('[$code]',$param['otp'],$getEmailData['body']);
        // email function
        sentEmailInfo($getEmailData['subject'],$requestData['email'],$emailMessage,$getEmailData['content'],$getEmailData['send_to']);
       // sms function
        SendOtpSMS($completeMobileNumber,$message);
        $excuteQuery = $this->db->insert('customer_master',$param);
        if($excuteQuery > 0){
            generateServerResponse(S,SUCCESS);
        }else{
            generateServerResponse(F,'W');
        }
    }

  // get Any table single data id basis
  public function getTableData($table,$id){  
    return $this->db->get_where($table,array('id'=>$id))->row_array();
  }
   
  public function checkExistMobileOrEmail($table,$colName,$colValue){  
     return $this->db->get_where($table,array($colName=>$colValue))->num_rows();
     //echo $this->db->last_query();exit();
  }

  // Customer Login Process
    public function loginProcess($requestData){  
        isBlank($requestData['mobile'],NOT_EXISTS,103); 
        isBlank($requestData['password'],NOT_EXISTS,105); 
        isBlank($requestData['deviceID'],NOT_EXISTS,111); 

        $existUser = $this->db->get_where('customer_master',array('mobile'=>$requestData['mobile'],'password'=>base64_encode($requestData['password']),'status'=>1))->num_rows();
        if($existUser > 0){
          $userData = $this->db->get_where('customer_master',array('mobile'=>$requestData['mobile'],'password'=>base64_encode($requestData['password'])))->row_array();
             if($userData['otpVerifyStatus'] == 1){
              $param                 = array();
               $param['type']           =$userData['type'];
              $param['id']              = $userData['id'];
              $param['name']            = $userData['name'];
              $param['email']           = $userData['email'];
              $param['mobile']          = $userData['mobile'];
              $param['gender']          = $userData['gender'];
              $param['dob']             = $userData['dob'];
              $param['image']           = !empty($userData['image']) ? base_url().'mediaFile/customers/'.$userData['image'] : '';
              $param['companyName']     = $userData['companyName'];
              $param['companyRegNumber']= $userData['companyRegNumber'];
              $param['companyVatNumber']= $userData['companyVatNumber'];
              $param['regCopy']         = !empty($userData['regCopy']) ? base_url().'mediaFile/customers/document/'.$userData['regCopy'] : '';
              $param['vatCopy']         = !empty($userData['vatCopy']) ? base_url().'mediaFile/customers/document/'.$userData['vatCopy'] : '';
              $param['status']          = $userData['status'];;
              $param['profileStatus']   = $userData['profileStatus'];
              $param['otpVerifyStatus'] = $userData['otpVerifyStatus'];
              $param['addDate']         = $userData['addDate'];
              $param['modifyDate']      = $userData['modifyDate'];
                // type 1 for customer and 2 is driver
              $field                 = array();
              $field['type']         = 1;   
              $field['userID']       = $userData['id'];
              $field['deviceID']     = $requestData['deviceID'];
              $field['device_token'] = $requestData['device_token'];
              $field['loginStatus']  = 1;
              $field['plateform']    = 2; // for app login
              $field['addDate']      = time();
              $field['modifyDate']   = time();

              $checklogin = $this->db->get_where('login_master',array('deviceID'=>$requestData['deviceID']))->row_array();
              if (!empty($checklogin)) 
              { 
                $this->db->where('deviceID',$requestData['deviceID']);  
                $this->db->update('login_master',$field);
                $loginID = $checklogin['id'];
              }
              else
              {
                 $this->db->insert('login_master',$field);
                 $loginID = $this->db->insert_id();
              }

              
              $param['loginID'] = $loginID;

              generateServerResponse(S,'113',$param);
            }else{
              $otp = rand(111111,999999);
              $this->db->where('mobile',$requestData['mobile']);
              $this->db->update('customer_master',array('otp'=>$otp));
              $message = "Your verification code is: ".$otp.".";
              SendOtpSMS($userData['mobile'], $message);
              $param1 = array();
              $param1['otpVerifyStatus']   = $userData['otpVerifyStatus'];
              generateServerResponse(S,'123',$param1);
            }
        }else{
            generateServerResponse(F,'112');
        }
    }
    // logout function here
    public function logoutAccount($requestData){  
      $this->db->where('id',$requestData['loginID']);
      $logoutStatus = $this->db->update('login_master',array('loginStatus'=>2,'modifyDate'=>time()));
      if($logoutStatus > 0){
          generateServerResponse(S,'114');
        }
      else{

            generateServerResponse(F,'W');
        }
    }

    // logout function here
    public function forgotAccount($requestData){  
      isBlank($requestData['mobile'],NOT_EXISTS,103); 
      phoneLength($requestData['mobile'],NOT_EXISTS,109); 
      $query     = $this->db->get_where('customer_master',array('mobile'=>$requestData['mobile']));
      $existData = $query->num_rows();
      $userData  = $query->row_array();
      if($existData > 0){
        $otp = rand(111111,999999);
        $this->db->where('mobile',$requestData['mobile']);
        $this->db->update('customer_master',array('otp'=>$otp));
        $message = "Your verification code is: ".$otp.".";
        SendOtpSMS($userData['mobile'], $message);
        generateServerResponse(S,SUCCESS);
      }
      else{
            generateServerResponse(F,'122');
          }
    }

      // logout function here
    public function pilotforgotAccount($requestData){  
      isBlank($requestData['mobile'],NOT_EXISTS,103); 
      phoneLength($requestData['mobile'],NOT_EXISTS,109); 
      $query     = $this->db->get_where('driver_master',array('mobile'=>$requestData['mobile']));
      $existData = $query->num_rows();
      $userData  = $query->row_array();
      if($existData > 0){
        $otp = rand(1111,9999);
        $this->db->where('mobile',$requestData['mobile']);
        $this->db->update('driver_master',array('otp'=>$otp));
        $message = "Your verification code is: ".$otp.".";
        SendOtpSMS($userData['mobile'], $message);
        generateServerResponse(S,SUCCESS);
      }
      else{
            generateServerResponse(F,'122');
          }
    }

// update profile code here afer login
    public function UpdateProfile($requestData){  
      $query     = $this->db->get_where('customer_master',array('id'=>$requestData['id']));
      $existData = $query->num_rows();
      $userData  = $query->row_array();

      if($existData > 0){
        $field                 = array();
        if($requestData['type'] == 1){ // for business
          $field['name']         = $requestData['name'];   

        }else{
          $field['name']         = $requestData['name'];  
          $field['gender']       = $requestData['gender'];  
          $field['dob']          = $requestData['dob'];  

          if(!empty($requestData['image'])){
            $image          = $requestData['image'];
            $get_http = explode(':',$image);
            if($get_http[0] == 'http' || $get_http[0] == 'https') {
              $pic      =   $userData['image'];
            }else {
               $nickname = 'CUST';
               $path  = CUSTOMER_DIRECTORY.'mediaFile/customers/';
               $pic   = ($requestData['image']!='') ? saveProfilesImage($requestData['image'],$path,$nickname) :'';
            }
          }else {
            $pic="";
          }

          $field['image']        = $pic; 
          
        }


          $this->db->where('id',$requestData['id']);
          $logoutStatus = $this->db->update('customer_master',$field);

          $getUpdatedData        = $this->db->get_where('customer_master',array('id'=>$requestData['id']))->row_array();
         
            $updatedData                    = array();
            $updatedData['type']            = $getUpdatedData['type'];
            $updatedData['id']              = $getUpdatedData['id'];
            $updatedData['name']            = $getUpdatedData['name'];
            $updatedData['email']           = $getUpdatedData['email'];
            $updatedData['mobile']          = $getUpdatedData['mobile'];
            $updatedData['gender']          = $getUpdatedData['gender'];
            $updatedData['dob']             = $getUpdatedData['dob'];
            $updatedData['image']           = !empty($getUpdatedData['image']) ? base_url().'mediaFile/customers/'.$getUpdatedData['image'] : '';
            $updatedData['companyName']     = $getUpdatedData['companyName'];
            $updatedData['companyRegNumber']= $getUpdatedData['companyRegNumber'];
            $updatedData['companyVatNumber']= $getUpdatedData['companyVatNumber'];
            $updatedData['regCopy']         = !empty($getUpdatedData['regCopy']) ? base_url().'mediaFile/customers/document/'.$getUpdatedData['regCopy'] : '';
            $updatedData['vatCopy']         = !empty($getUpdatedData['vatCopy']) ? base_url().'mediaFile/customers/document/'.$getUpdatedData['vatCopy'] : '';
            $updatedData['status']          = $getUpdatedData['status'];;
            $updatedData['profileStatus']   = $getUpdatedData['profileStatus'];
            $updatedData['addDate']         = $getUpdatedData['addDate'];
            $updatedData['modifyDate']      = $getUpdatedData['modifyDate'];
          generateServerResponse(S,'116',$updatedData);
        }
      else{
            generateServerResponse(F,'W');
          }
    } 

    // changePass here
    public function changePasswordData($requestData){  
      $id          = $requestData['id'];
      $oldPassword = $requestData['oldPassword'];
      $newPassword = $requestData['newPassword'];
      $rePassword  = $requestData['rePassword'];
      $type        = $requestData['type'];
      // type 1 for custome and 2 is driver
      if($type == 1){
        $getdata    = $this->db->get_where('customer_master',array('id'=>$id))->row_array();
        if(base64_decode($getdata['password']) != $oldPassword){
          generateServerResponse(F,'117');
        }if($newPassword != $rePassword){
          generateServerResponse(F,'118');
        }

        $this->db->where('id',$id);
        $this->db->update('customer_master',array('password'=>base64_encode($newPassword)));
        generateServerResponse(S,'119');
      }else{
        $getdata    = $this->db->get_where('driver_master',array('id'=>$id))->row_array();
        if(base64_decode($getdata['password']) != $oldPassword){
          generateServerResponse(F,'117');
        }if($newPassword != $rePassword){
          generateServerResponse(F,'118');
        }

        $this->db->where('id',$id);
        $this->db->update('driver_master',array('password'=>base64_encode($newPassword)));
        generateServerResponse(S,'119');
      }
        generateServerResponse(F,'W');
    }


 // verify Here
    public function verifyProcess($requestData){  
        $excuteQuery = $this->db->get_where('customer_master',array('mobile'=>$requestData['mobile'],'otp'=>$requestData['otp']))->num_rows();

       // if($excuteQuery > 0){
          $this->db->where('mobile',$requestData['mobile']);
          $this->db->update('customer_master',array('otpVerifyStatus'=>1));
          $userData = $this->db->get_where('customer_master',array('mobile'=>$requestData['mobile']))->row_array();
          $param                 = array();
          $param['id']           = $userData['id'];
          $param['name']         = $userData['name'];
          $param['email']        = $userData['email'];
          $param['mobile']       = $userData['mobile'];
          $param['image']        = !empty($userData['image']) ? base_url().'mediaFile/customers/'.$userData['image'] : '';
          $param['addDate']      = $userData['addDate'];

           generateServerResponse(S,SUCCESS,$param);

       /* }else{
            generateServerResponse(F,'121');
        }*/
    }

     // verify Here
    public function pilotverifyProcess($requestData){  
        $excuteQuery = $this->db->get_where('driver_master',array('mobile'=>$requestData['mobile'],'otp'=>$requestData['otp']))->num_rows();

       // if($excuteQuery > 0){
          $this->db->where('mobile',$requestData['mobile']);
          $this->db->update('driver_master',array('otpVerifyStatus'=>1));
          $userData = $this->db->get_where('driver_master',array('mobile'=>$requestData['mobile']))->row_array();
          $param                 = array();
          $param['id']           = $userData['id'];
          $param['name']         = $userData['name'];
          $param['email']        = $userData['email'];
          $param['mobile']       = $userData['mobile'];
          $param['image']        = !empty($userData['image']) ? base_url().'mediaFile/drivers/'.$userData['image'] : '';
          $param['addDate']      = $userData['addDate'];
          $param['status']      = $userData['status'];
           generateServerResponse(S,SUCCESS,$param);

       /* }else{
            generateServerResponse(F,'121');
        }*/
    }


  public function resendOTP($requestData){  
    // type 1 for customer and 2 is driver
    if($requestData['type'] == 1){
      $otp = rand(111111,999999);
      $this->db->where('mobile',$requestData['mobile']);
      $this->db->update('customer_master',array('otp'=>$otp));
      $message = "Your verification code is: ".$otp.".";
      SendOtpSMS($requestData['mobile'], $message);
      generateServerResponse(S,'124');
    }else{
      $otp = rand(111111,999999);
      $this->db->where('mobile',$requestData['mobile']);
      $this->db->update('driver_master',array('otp'=>$otp));
      $message = "Your verification code is: ".$otp.".";
      SendOtpSMS($requestData['mobile'], $message);
      generateServerResponse(S,'124');
      }
  }
// password forgot via customer
  public function customerPasswordData($requestData){  
    $newPassword  = $requestData['newPassword'];

    $this->db->where('mobile',$requestData['mobile']);
    $res = $this->db->update('customer_master',array('password'=>base64_encode($newPassword)));

    if($res > 0){
      generateServerResponse(S,'119');
    }else{
      generateServerResponse(F,'W');
    }
  }

  public function pilotPasswordData($requestData){  
    $newPassword  = $requestData['newPassword'];

    $this->db->where('mobile',$requestData['mobile']);
    $res = $this->db->update('driver_master',array('password'=>base64_encode($newPassword)));

    if($res > 0){
      generateServerResponse(S,'119');
    }else{
      generateServerResponse(F,'W');
    }
  }

  public function customerUpdateProfile($requestData){  
    // type 1=>bussiness,2=>individual
      $param                 = array();
   if($requestData['type'] == '1'){
      $param['type']               = $requestData['type'];
      $param['companyName']        = $requestData['companyName'];
      $param['companyRegNumber']   = $requestData['companyRegNumber'];
      $param['companyVatNumber']   = $requestData['companyVatNumber'];
      $nickname                    = 'regCopy';
      $path                        = CUSTOMER_DIRECTORY.'mediaFile/customers/document/';
      $regCopy                     = ($requestData['regCopy']!='') ? saveProfilesImage($requestData['regCopy'],$path,$nickname) :'';
      $nickname                    = 'vatCopy';
      $vatCopy                     = ($requestData['vatCopy']!='') ? saveProfilesImage($requestData['vatCopy'],$path,$nickname) :'';
      $param['regCopy']            = $regCopy;
      $param['vatCopy']            = $vatCopy;
      $param['modifyDate']         = time();
      $param['profileStatus']      = 1; // profile update

      $this->db->where('id',$requestData['id']);
      $res = $this->db->update('customer_master',$param);

   }else if($requestData['type'] == '2'){
     $param['type']                = $requestData['type'];
      $param['gender']             = $requestData['gender'];
      $param['dob']                = $requestData['dob'];
      $nickname                    = 'CUST';
      $path                        = CUSTOMER_DIRECTORY.'mediaFile/customers/';
      $customerImage               = ($requestData['image']!='') ? saveProfilesImage($requestData['image'],$path,$nickname) :'';
      $param['image']              = $customerImage;
      $param['modifyDate']         = time();
      $param['profileStatus']      = 1; // profile update

      $this->db->where('id',$requestData['id']);
      $res = $this->db->update('customer_master',$param);
   }

      $getUpdatedData        = $this->db->get_where('customer_master',array('id'=>$requestData['id']))->row_array();
     
      $updatedData                    = array();
      $updatedData['type']            = $getUpdatedData['type'];
      $updatedData['id']              = $getUpdatedData['id'];
      $updatedData['name']            = $getUpdatedData['name'];
      $updatedData['email']           = $getUpdatedData['email'];
      $updatedData['mobile']          = $getUpdatedData['mobile'];
      $updatedData['gender']          = $getUpdatedData['gender'];
      $updatedData['dob']             = $getUpdatedData['dob'];
      $updatedData['image']           = !empty($getUpdatedData['image']) ? base_url().'mediaFile/customers/'.$getUpdatedData['image'] : '';
      $updatedData['companyName']     = $getUpdatedData['companyName'];
      $updatedData['companyRegNumber']= $getUpdatedData['companyRegNumber'];
      $updatedData['companyVatNumber']= $getUpdatedData['companyVatNumber'];
      $updatedData['regCopy']         = !empty($getUpdatedData['regCopy']) ? base_url().'mediaFile/customers/document/'.$getUpdatedData['regCopy'] : '';
      $updatedData['vatCopy']         = !empty($getUpdatedData['vatCopy']) ? base_url().'mediaFile/customers/document/'.$getUpdatedData['vatCopy'] : '';
      $updatedData['status']          = $getUpdatedData['status'];;
      $updatedData['profileStatus']   = $getUpdatedData['profileStatus'];
      $updatedData['addDate']         = $getUpdatedData['addDate'];
      $updatedData['modifyDate']      = $getUpdatedData['modifyDate'];

    if($res > 0){
      generateServerResponse(S,'116',$updatedData);
    }else{
      generateServerResponse(F,'W');
    }
  }

}
?>