<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class PostDestination extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('api/ApiModel');
		    $this->load->helper('api');
    }
    public function index(){
		if($_SERVER['REQUEST_METHOD'] == POST){
			$this->startPoints();
		} 
		if($_SERVER['REQUEST_METHOD'] == GET){ 
		}  
    }
    public function startPoints()
    {
      $requestData = getRequestJson(); 
      $check_request_keys = array('contactPerson','contactNumber','payLocationType');
      $resultJson    =  validateJson($requestData, $check_request_keys); 
      if($resultJson == OK)
      {           
        $this->ApiModel->destinationDataPost($requestData[APP_NAME]);
      }
      else{
        generateServerResponse('0', '100');
      }
    }
 
}
