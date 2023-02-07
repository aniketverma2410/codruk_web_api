<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class UpdateProfile extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('api/CustomerModel');
		    $this->load->helper('api');
    }
    public function index(){
		if($_SERVER['REQUEST_METHOD'] == 
      POST){
			$this->updateProfile();
		} 
		if($_SERVER['REQUEST_METHOD'] == GET){ 
		}  
    }
    public function updateProfile()
    {
      $requestData = getRequestJson(); 
      $check_request_keys = array('id','type','name','companyName','companyRegNumber','companyVatNumber','regCopy','vatCopy','email','mobile','gender','image','dob');
      $resultJson    =  validateJson($requestData, $check_request_keys); 
      if($resultJson ==OK)
      {           
        $this->CustomerModel->UpdateProfile($requestData[APP_NAME]);
      }
      else{
        generateServerResponse('0', '100');
      }
    }
 
}
