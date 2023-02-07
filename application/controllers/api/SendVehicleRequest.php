<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class SendVehicleRequest extends CI_Controller{
    public function __construct(){
      parent::__construct();
      $this->load->model('api/ApiModel');
	    $this->load->helper('api');
    }
    public function index(){
		if($_SERVER['REQUEST_METHOD'] == POST){
			$this->send_vehicle_request();
		} 
		if($_SERVER['REQUEST_METHOD'] == GET){ 
		}  
    }
    public function send_vehicle_request()
    {
      $requestData = getRequestJson(); 
      $check_request_keys = array('uuid','vehicle_id');
      $resultJson    =  validateJson($requestData, $check_request_keys); 
      if($resultJson == OK)
      {           
        $this->ApiModel->send_request($requestData[APP_NAME]);
      }
      else{
        generateServerResponse('0', '100');
      }
    }
 
}