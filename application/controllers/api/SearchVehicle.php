<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class SearchVehicle extends CI_Controller{
    public function __construct(){
      parent::__construct();
      $this->load->model('api/ApiModel');
	    $this->load->helper('api');
    }
    public function index(){
		if($_SERVER['REQUEST_METHOD'] == POST){
			$this->search_vehicle();
		} 
		if($_SERVER['REQUEST_METHOD'] == GET){ 
		}  
    }
    public function search_vehicle()
    {
      $requestData = getRequestJson(); 
      $check_request_keys = array('uuid','search');
      $resultJson    =  validateJson($requestData, $check_request_keys); 
      if($resultJson == OK)
      {           
        $this->ApiModel->searchvehicle($requestData[APP_NAME]);
      }
      else{
        generateServerResponse('0', '100');
      }
    }
 
}