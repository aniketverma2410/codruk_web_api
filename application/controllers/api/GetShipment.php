<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class GetShipment extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('api/ApiModel');
		    $this->load->helper('api');
    }
    public function index(){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$this->Shipment(); 
        
		} 
		if($_SERVER['REQUEST_METHOD'] == GET){ 
		}  
    }
    public function Shipment()
    {
      $requestData = getRequestJson(); 
      $check_request_keys = array('barcode_id');
    
      $resultJson    =  validateJson($requestData, $check_request_keys); 
      if($resultJson ==OK)
      {           
        $this->ApiModel->getshipmentstatus($requestData[APP_NAME]);
      }
      else{
        generateServerResponse('0', '100');
      }
    }
 
}
