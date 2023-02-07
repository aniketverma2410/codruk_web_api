<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class CancelVehicleRequest extends CI_Controller{
    public function __construct(){
      parent::__construct();
      $this->load->model('api/ApiModel');
	    $this->load->helper('api');
    }
    public function index(){
		if($_SERVER['REQUEST_METHOD'] == POST){
			$this->cancel_vehicle_request();
		} 
		if($_SERVER['REQUEST_METHOD'] == GET){ 
		}  
    }
    public function cancel_vehicle_request()
    {
      $requestData = getRequestJson(); 
      $check_request_keys = array('uuid','vehicle_id');
      $resultJson    =  validateJson($requestData, $check_request_keys); 
      if($resultJson == OK)
      {           
        $this->ApiModel->cancel_request($requestData[APP_NAME]);
      }
      else{
        generateServerResponse('0', '100');
      }
    }
 
}