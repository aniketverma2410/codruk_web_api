<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class ResendOTP extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('CustomerModel');
		    $this->load->helper('api');
    }
    public function index(){
		if($_SERVER['REQUEST_METHOD']==POST){
			$this->readyForExcute();
		} 
		if($_SERVER['REQUEST_METHOD']==GET){ 
		}  
    }
    public function readyForExcute()
    {
      $requestData = getRequestJson(); 
      $check_request_keys = array('type','mobile');
      $resultJson    =  validateJson($requestData, $check_request_keys); 
      if($resultJson == OK)
      {           
        $this->CustomerModel->resendOTP($requestData[APP_NAME]);
      }
      else{
        generateServerResponse('0', '100');
      }
    }
 
}
