<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class CustomerLogin extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('CustomerModel');
		    $this->load->helper('api');
    }
    public function index(){
		if($_SERVER['REQUEST_METHOD']==POST){
			$this->excuteLogin();
		} 
		if($_SERVER['REQUEST_METHOD']==GET){ 
		}  
    }
    public function excuteLogin()
    {
      $requestData = getRequestJson(); 
      $check_request_keys = array('mobile','password','deviceID');
      $resultJson    =  validateJson($requestData, $check_request_keys); 
      if($resultJson == OK)
      {           
        $this->CustomerModel->loginProcess($requestData[APP_NAME]);
      }
      else{
        generateServerResponse('0', '100');
      }
    }
 
}
