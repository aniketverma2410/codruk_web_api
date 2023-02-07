<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class DriverRegistration extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('api/DriverModel');
		    $this->load->helper('api');
    }
    public function index(){
		if($_SERVER['REQUEST_METHOD']==POST){
			$this->regDriver();
		} 
		if($_SERVER['REQUEST_METHOD']==GET){ 
		}  
    }
    public function regDriver()
    {
      $requestData = getRequestJson(); 
      $check_request_keys = array('name','email','mobile','city','password');
      $resultJson    =  validateJson($requestData, $check_request_keys); 
      if($resultJson ==OK)
      {           
        $this->DriverModel->DriverSignup($requestData[APP_NAME]);
      }
      else{
        generateServerResponse('0', '100');
      }
    }
 
}
