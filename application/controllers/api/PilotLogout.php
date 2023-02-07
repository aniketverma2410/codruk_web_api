<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class PilotLogout extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('api/PilotModel');
		    $this->load->helper('api');
    }
    public function index(){
		if($_SERVER['REQUEST_METHOD']==POST){
			$this->get_Logout();
		} 
		if($_SERVER['REQUEST_METHOD']==GET){ 
		}  
    }
    public function get_Logout()
    {
      $requestData = getRequestJson(); 
      $check_request_keys = array('loginID');
      $resultJson         =  validateJson($requestData, $check_request_keys); 
      if($resultJson == OK)
      {           
        $this->PilotModel->logoutAccount($requestData[APP_NAME]);
      }
      else{
        generateServerResponse('0', '100');
      }
    }
 
}
