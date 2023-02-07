<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class CheckVehicleRequest extends CI_Controller{
    public function __construct(){
      parent::__construct();
      $this->load->model('api/ApiModel');
	    $this->load->helper('api');
    }
    public function index(){
		if($_SERVER['REQUEST_METHOD'] == POST){
			$this->check_request();
		} 
		if($_SERVER['REQUEST_METHOD'] == GET){ 
		}  
    }
    public function check_request()
    {
      $requestData = getRequestJson(); 
      $check_request_keys = array('uuid');
      $resultJson    =  validateJson($requestData, $check_request_keys); 
      if($resultJson == OK)
      {           
        $this->ApiModel->check_request($requestData[APP_NAME]);
      }
      else{
        generateServerResponse('0', '100');
      }
    }
 
}