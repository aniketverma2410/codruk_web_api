<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class SetDefaultLocation extends CI_Controller{
    public function __construct(){
      parent::__construct();
      $this->load->model('api/ApiModel');
	    $this->load->helper('api');
    }
    public function index(){
		if($_SERVER['REQUEST_METHOD'] == POST){
			$this->set_location();
		} 
		if($_SERVER['REQUEST_METHOD'] == GET){ 
		}  
    }
    
    public function set_location()
    {
      $requestData = getRequestJson(); 
      $check_request_keys = array('userId','location','location_latitude','location_longitude');
      $resultJson    =  validateJson($requestData, $check_request_keys); 
      if($resultJson == OK)
      {           
        $this->ApiModel->set_location($requestData[APP_NAME]);
      }
      else
      {
        generateServerResponse('0', '100');
      }
    }
 
}
