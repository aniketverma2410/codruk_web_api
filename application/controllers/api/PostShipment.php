<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class PostShipment extends CI_Controller{
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
      $headers = apache_request_headers();
      $this->ApiModel->accessApiRequest($headers['access_token']);
      $check_request_keys = array('shipper_name','shipper_address','shipper_city','consignee_name','consignee_address','consignee_city','consignee_mobile_number','collection_type','collection_amount','borcode_url','borcode_base','borcode_id');
    
      $resultJson    =  validateJson($requestData, $check_request_keys); 
      if($resultJson ==OK)
      {     
        $this->ApiModel->postShipment($requestData[APP_NAME]);
      }
      else{
        generateServerResponse('0', '100');
      }
    }
 
}
