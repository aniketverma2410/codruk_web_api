<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class DriverForgotPassword extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('api/DriverModel');
		    $this->load->helper('api');
    }
    public function index(){
		if($_SERVER['REQUEST_METHOD']==POST){
			$this->forgetPass();
		} 
		if($_SERVER['REQUEST_METHOD']==GET){ 
		}  
    }
    public function forgetPass()
    {
      $requestData = getRequestJson(); 
      $check_request_keys = array('id');
      $resultJson         =  validateJson($requestData, $check_request_keys); 
      if($resultJson == OK)
      {           
        $this->DriverModel->forgotAccount($requestData[APP_NAME]);
      }
      else{
        generateServerResponse('0', '100');
      }
    }
 
}
