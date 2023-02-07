<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class PilotUpdateProfile extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('api/PilotModel');
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
      $check_request_keys = array('id','name','email','image');
      $resultJson    =  validateJson($requestData, $check_request_keys); 
      if($resultJson ==OK)
      {           
        $this->PilotModel->updatePilotProfile($requestData[APP_NAME]);
      }
      else{
        generateServerResponse('0', '100');
      }
    }
 
}
