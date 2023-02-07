<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class GetFareCharges extends CI_Controller{
    public function __construct(){
      parent::__construct();
      $this->load->model('api/ApiModel');
      $this->load->helper('api');
    }
    public function index(){
    if($_SERVER['REQUEST_METHOD'] == POST){
      $this->get_charges();
    } 
    if($_SERVER['REQUEST_METHOD'] == GET){ 
    }  
    }
    public function get_charges()
    {
      $requestData = getRequestJson(); 
      $check_request_keys = array('userId','vehicle_id','source_lat','source_long','destination_lat','destination_long','insurance_id','loader_id');
      $resultJson    =  validateJson($requestData, $check_request_keys); 
      if($resultJson == OK)
      {           
        $this->ApiModel->getfare_charges($requestData[APP_NAME]);
      }
      else{
        generateServerResponse('0', '100');
      }
    }
 
}
