<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class CustomerRunningRide extends CI_Controller{
    public function __construct(){
      parent::__construct();
      $this->load->model('api/ApiModel');
      $this->load->helper('api');
    }
    public function index(){
    if($_SERVER['REQUEST_METHOD'] == POST){
      $this->running();
    } 
    if($_SERVER['REQUEST_METHOD'] == GET){ 
    }  
    }
    public function running()
    {
      $requestData = getRequestJson(); 
      $check_request_keys = array('userId');
      $resultJson    =  validateJson($requestData, $check_request_keys); 
      if($resultJson == OK)
      {           
        $this->ApiModel->customer_running_ride($requestData[APP_NAME]);
      }
      else
      {
        generateServerResponse('0', '100');
      }
    }
 
}
