<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class GetContent extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('api/ApiModel');
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
      $check_request_keys = array('type','case'); // case 1=>vehicle,2=>loader,3=>Insurence and type use for covered and uncovered
      $resultJson    =  validateJson($requestData, $check_request_keys); 
      if($resultJson ==OK)
      {           
        $this->ApiModel->getContentData($requestData[APP_NAME]);
      }
      else{
        generateServerResponse('0', '100');
      }
    }
 
}
