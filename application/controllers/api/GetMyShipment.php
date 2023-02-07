<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class GetMyShipment extends CI_Controller{
    public function __construct(){
      parent::__construct();
      $this->load->model('api/ApiModel');
      $this->load->helper('api');
    }
    public function index(){
    if($_SERVER['REQUEST_METHOD'] == POST){
      $this->get_my_shipment();
    } 
    if($_SERVER['REQUEST_METHOD'] == GET){ 
        $array[APP_NAME] = array("userId"=>"51","status"=>"","type"=>"1");
        
        $this->get_my_shipment($array);
    }  
    }
    // type: 1 =>customer,2=>driver

    public function get_my_shipment()
    {
      $requestData = getRequestJson(); 
      
      $check_request_keys = array('userId','status','type');
      $resultJson    =  validateJson($requestData, $check_request_keys); 
      if($resultJson == OK)
      {           
        $this->ApiModel->get_my_shipment($requestData[APP_NAME]);
      }
      else{
        generateServerResponse('0', '100');
      }
    }
 
}
