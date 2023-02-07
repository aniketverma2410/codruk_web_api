<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class SetFavouriteLocation extends CI_Controller{
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
      $check_request_keys = array('userId','favourite_location','favourite_latitude','favourite_longitude','type');
      $resultJson    =  validateJson($requestData, $check_request_keys); 
      if($resultJson == OK)
      {           
        $this->ApiModel->set_favourite_location($requestData[APP_NAME]);
      }
      else
      {
        generateServerResponse('0', '100');
      }
    }
 
}
