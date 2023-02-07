<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class GetPreviousVehicle extends CI_Controller{
    public function __construct(){
      parent::__construct();
      $this->load->model('api/ApiModel');
	    $this->load->helper('api');
    }
    public function index(){
		if($_SERVER['REQUEST_METHOD'] == POST){
			$this->readyForWork();
		} 
		if($_SERVER['REQUEST_METHOD'] == GET){ 
		}  
    }
    
    public function get_vehicle()
    {
      $requestData = getRequestJson(); 
      $check_request_keys = array('userId');
      $resultJson    =  validateJson($requestData, $check_request_keys); 
      if($resultJson == OK)
      {           
        $this->ApiModel->get_last_vehicle($requestData[APP_NAME]);
      }
      else
      {
        generateServerResponse('0', '100');
      }
    }
 
}
