<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class GetAllPilot extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('api/ApiModel');
		    $this->load->helper('api');
    }
    public function index(){
		if($_SERVER['REQUEST_METHOD'] == POST){
			$this->get_all_pilots();
		} 
		if($_SERVER['REQUEST_METHOD'] == GET){ 
		}  
    }
    public function get_all_pilots()
    {
      $requestData = getRequestJson(); 
      $check_request_keys = array('userId','latitude','longitude');
      $resultJson    =  validateJson($requestData, $check_request_keys); 
      if($resultJson == OK)
      {           
        $this->ApiModel->get_all_pilots($requestData[APP_NAME]);
      }
      else{
        generateServerResponse('0', '100');
      }
    }
 
}
