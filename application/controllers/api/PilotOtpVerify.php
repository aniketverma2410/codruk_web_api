<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class PilotOtpVerify extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('api/CustomerModel');
		    $this->load->helper('api');
    }
    public function index(){
		if($_SERVER['REQUEST_METHOD']==POST){
			$this->verifyNumber();
		} 
		if($_SERVER['REQUEST_METHOD']==GET){ 
		}  
    }
    public function verifyNumber()
    {
      $requestData = getRequestJson(); 
      $check_request_keys = array('mobile','otp');
      $resultJson    =  validateJson($requestData, $check_request_keys); 
      if($resultJson ==OK)
      {           
        $this->CustomerModel->pilotverifyProcess($requestData[APP_NAME]);
      }
      else{
        generateServerResponse('0', '100');
      }
    }
 
}
