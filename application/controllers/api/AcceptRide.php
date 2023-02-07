<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class AcceptRide extends CI_Controller{
    public function __construct(){
      parent::__construct();
      $this->load->model('api/ApiModel');
      $this->load->helper('api');
    }
    public function index(){
    if($_SERVER['REQUEST_METHOD'] == POST){
      $this->accept_ride();
    } 
    if($_SERVER['REQUEST_METHOD'] == GET){ 
    }  
    }
    public function accept_ride()
    {
      $requestData = getRequestJson(); 
      $check_request_keys = array('userId','request_id','status');
      $resultJson    =  validateJson($requestData, $check_request_keys); 
      if($resultJson == OK)
      {           
        $this->ApiModel->change_ride_status($requestData[APP_NAME]);
      }
      else{
        generateServerResponse('0', '100');
      }
    }
 
}
