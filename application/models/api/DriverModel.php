<?php
class DriverModel extends CI_Model {
  public function __construct(){
    parent::__construct();
    $this->load->helper('api');
    $this->load->database();
  
  }

 // Driver Data Post Here
    public function DriverSignup($requestData){  
        isBlank($requestData['name'],NOT_EXISTS,102); 
        isBlank($requestData['email'],NOT_EXISTS,104); 
        isBlank($requestData['mobile'],NOT_EXISTS,103); 
        phoneLength($requestData['mobile'],NOT_EXISTS,109); 
        isBlank($requestData['password'],NOT_EXISTS,105); 
        isBlank($requestData['city'],NOT_EXISTS,120); 

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

        $param                 = array();
        $param['name']         = $requestData['name'];
        $param['email']        = $requestData['email'];
        $param['mobile']       = $requestData['mobile'];
        $param['city']         = $requestData['city'];
        $param['password']     = base64_encode($requestData['password']);
        $param['status']       = 1;
        $param['addDate']      = time();
        $param['modifyDate']   = time();



        $excuteQuery = $this->db->insert('driver_master',$param);

        if($excuteQuery > 0){
            generateServerResponse(S,SUCCESS);
        }else{
            generateServerResponse(F,'W');
        }
    }
 
    public function checkExistMobileOrEmail($table,$colName,$colValue){  
       return $this->db->get_where($table,array($colName=>$colValue))->num_rows();
       //echo $this->db->last_query();exit();
    }

  // Driver Login Process
    public function loginProcess($requestData){  
        isBlank($requestData['username'],NOT_EXISTS,110); 
        isBlank($requestData['password'],NOT_EXISTS,105); 
        isBlank($requestData['deviceID'],NOT_EXISTS,111); 

        $existUser = $this->db->get_where('driver_master',array('email'=>$requestData['username'],'password'=>base64_encode($requestData['password']),'status'=>1))->num_rows();
        if($existUser > 0){
          $userData = $this->db->get_where('driver_master',array('email'=>$requestData['username'],'password'=>base64_encode($requestData['password'])))->row_array();
          $param                 = array();
          $param['id']           = $userData['id'];
          $param['name']         = $userData['name'];
          $param['email']        = $userData['email'];
          $param['mobile']       = $userData['mobile'];
          $param['city']         = $userData['city'];
          $param['image']        = $userData['image'];
          $param['addDate']      = time();
            // type 1 for customer and 2 is driver
          $field                 = array();
          $field['type']         = 2;   
          $field['userID']       = $userData['id'];
          $field['deviceID']     = $requestData['deviceID'];
          $field['loginStatus']  = 1;
          $field['addDate']      = time();
          $field['modifyDate']   = time();


          $this->db->insert('login_master',$field);
          $loginID = $this->db->insert_id();
          $param['loginID'] = $loginID;

          generateServerResponse(S,'113',$param);
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
      $query     = $this->db->get_where('driver_master',array('id'=>$requestData['id']));
      $existData = $query->num_rows();
      $userData  = $query->row_array();
      if($existData > 0){
        $message = "Your new password is ".base64_decode($userData['password']).".";
       SendOtpSMS($userData['mobile'], $message);
          generateServerResponse(S,'115');
        }
      else{

            generateServerResponse(F,'W');
        }
    }
// update profile code here
    public function UpdateDriverProfile($requestData){  
      $query     = $this->db->get_where('driver_master',array('id'=>$requestData['id']));
      $existData = $query->num_rows();
      $userData  = $query->row_array();
      if($existData > 0){


          if(!empty($requestData['image'])){
            $image          = $requestData['image'];
            $get_http = explode(':',$image);
            if($get_http[0] == 'http' || $get_http[0] == 'https') {
              $pic      =   $userData['ProfilePic'];
            }else {
               $nickname = 'DRVR';
               $path  = CUSTOMER_DIRECTORY.'mediaFile/drivers/';
               $pic   = ($requestData['image']!='') ? saveProfilesImage($requestData['image'],$path,$nickname) :'';
            }
          }else {
            $pic="";
          }

          $field                 = array();
          $field['name']         = $requestData['name'];   
          $field['city']         = $requestData['city'];   
          $field['image']        = $pic;

          $this->db->where('id',$requestData['id']);
          $logoutStatus = $this->db->update('driver_master',$field);

          $getUpdatedData        = $this->db->get_where('driver_master',array('id'=>$requestData['id']))->row_array();
         
          $param                 = array();
          $param['name']         = $getUpdatedData['name'];
          $param['email']        = $getUpdatedData['email'];
          $param['mobile']       = $getUpdatedData['mobile'];
          $param['city']         = $getUpdatedData['city'];
          $param['image']        = !empty($getUpdatedData['image']) ? base_url().'mediaFile/customers/'.$getUpdatedData['image'] : '';
          $param['password']     = base64_decode($getUpdatedData['password']);
          $param['status']       = 1;
          $param['addDate']      = time();
          generateServerResponse(S,'116',$param);
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
          generateServerResponse(S,'117');
        }if($newPassword != $rePassword){
          generateServerResponse(S,'118');
        }

        $this->db->where('id',$id);
        $this->db->update('customer_master',array('password'=>base64_encode($newPassword)));
        generateServerResponse(S,'119');
      }else{
        $getdata    = $this->db->get_where('driver_master',array('id'=>$id))->row_array();
        if(base64_decode($getdata['password']) != $oldPassword){
          generateServerResponse(S,'117');
        }if($newPassword != $rePassword){
          generateServerResponse(S,'118');
        }

        $this->db->where('id',$id);
        $this->db->update('driver_master',array('password'=>base64_encode($newPassword)));
        generateServerResponse(S,'119');
      }
        generateServerResponse(F,'W');
    }



}
?>