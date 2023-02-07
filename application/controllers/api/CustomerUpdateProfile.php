<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class CustomerUpdateProfile extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('api/CustomerModel');
		    $this->load->helper('api');
    }
    public function index(){
		if($_SERVER['REQUEST_METHOD']==POST){
			$this->readyForWorking();
		} 
		if($_SERVER['REQUEST_METHOD']==GET){ 
		}  
    }
    public function readyForWorking()
    {
      $requestData = getRequestJson(); 
      $check_request_keys = array('id','type','companyName','companyRegNumber','companyVatNumber','regCopy','vatCopy','image','gender','dob');
      $resultJson    =  validateJson($requestData, $check_request_keys); 
      if($resultJson == OK)
      {           
        $this->CustomerModel->customerUpdateProfile($requestData[APP_NAME]);
      }
      else{
        generateServerResponse('0', '100');
      }
    }
 
}
