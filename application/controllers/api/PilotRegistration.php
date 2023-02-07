<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class PilotRegistration extends CI_Controller{
    public function __construct(){
      parent::__construct();
      $this->load->model('api/PilotModel');
	    $this->load->helper('api');
    }
    public function index(){
		if($_SERVER['REQUEST_METHOD'] == POST){
			$this->regPilot();
		} 
		if($_SERVER['REQUEST_METHOD'] == GET){ }  
    }
    public function regPilot()
    {
      $requestData = getRequestJson(); 
      $check_request_keys = array('name','mobile','email','easyPaisa','password','licenceCopy','cnicCopy');
      $resultJson    =  validateJson($requestData, $check_request_keys); 
      if($resultJson == OK)
      {           
        $this->PilotModel->pilotSignup($requestData[APP_NAME]);
      }
      else{
        generateServerResponse('0', '100');
      }
    }
 
}
