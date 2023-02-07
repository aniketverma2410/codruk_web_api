<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class GetVehicleList extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('ApiModel');
		    $this->load->helper('api');
    }
    public function index(){
		if($_SERVER['REQUEST_METHOD'] == POST){
			$this->readytoUse();
		} 
		if($_SERVER['REQUEST_METHOD'] == GET){ 
		}  
    }
    public function readytoUse()
    {
      $requestData = getRequestJson(); 
      $check_request_keys = array('type','offset');
      $resultJson    =  validateJson($requestData, $check_request_keys); 
      if($resultJson ==OK)
      {           
        $this->ApiModel->getVehicleData($requestData[APP_NAME]);
      }
      else{
        generateServerResponse('0', '100');
      }
    }
 
}
