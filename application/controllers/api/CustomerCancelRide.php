<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class CustomerCancelRide extends CI_Controller{
    public function __construct(){
      parent::__construct();
      $this->load->model('api/ApiModel');
      $this->load->helper('api');
    }
    public function index(){
    if($_SERVER['REQUEST_METHOD'] == POST){
      $this->cancelride();
    } 
    if($_SERVER['REQUEST_METHOD'] == GET){ 
    }  
    }
    public function cancelride()
    {
      $requestData = getRequestJson(); 
      $check_request_keys = array('userId','booking_id','reason_id');
      $resultJson    =  validateJson($requestData, $check_request_keys); 
      if($resultJson == OK)
      {           
        $this->ApiModel->customer_cancel_ride($requestData[APP_NAME]);
      }
      else{
        generateServerResponse('0', '100');
      }
    }
 
}
