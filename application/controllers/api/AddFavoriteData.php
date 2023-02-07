<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class AddFavoriteData extends CI_Controller{
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
    public function readyForWork()
    {
      $requestData = getRequestJson(); 
      $check_request_keys = array('userType','uid','lat','long','subAddress','address','deviceId');
      $resultJson    =  validateJson($requestData, $check_request_keys); 
      if($resultJson == OK)
      {           
        $this->ApiModel->favoriteDataPost($requestData[APP_NAME]);
      }
      else{
        generateServerResponse('0', '100');
      }
    }
 
}
