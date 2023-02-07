<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class customerUpdatePassword extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('CustomerModel');
		    $this->load->helper('api');
    }
    public function index(){
		if($_SERVER['REQUEST_METHOD'] == POST){
			$this->updatePass();
		} 
		if($_SERVER['REQUEST_METHOD'] == GET){ 
		}  
    }
    public function updatePass()
    {
      $requestData = getRequestJson(); 
      $check_request_keys = array('mobile','newPassword');
      $resultJson    =  validateJson($requestData, $check_request_keys); 
      if($resultJson ==OK)
      {           
        $this->CustomerModel->customerPasswordData($requestData[APP_NAME]);
      }
      else{
        generateServerResponse('0', '100');
      }
    }
 
}
