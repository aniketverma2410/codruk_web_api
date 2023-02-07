<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class CustomerRegistration extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('CustomerModel');
		$this->load->helper('api');
    }
    public function index(){
		if($_SERVER['REQUEST_METHOD']==POST){
			$this->regCustomer();
		} 
		if($_SERVER['REQUEST_METHOD']==GET){ 
		}  
    }
    public function regCustomer()
    {
      $requestData = getRequestJson(); 
      $check_request_keys = array('name','email','countryCode','mobile','password');
      $resultJson    =  validateJson($requestData, $check_request_keys); 
      if($resultJson == OK)
      {           
        $this->CustomerModel->customerSignup($requestData[APP_NAME]);
      }
      else{
        generateServerResponse('0', '100');
      }
    }
 
}
