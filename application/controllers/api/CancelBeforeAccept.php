<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class CancelBeforeAccept extends CI_Controller{
    public function __construct(){
      parent::__construct();
      $this->load->model('api/ApiModel');
      $this->load->helper('api');
    }
    public function index(){
    if($_SERVER['REQUEST_METHOD'] == POST){
      $this->cancelbeforeaccept();
    } 
    if($_SERVER['REQUEST_METHOD'] == GET){ 
    }  
    }
    public function cancelbeforeaccept()
    {
      $requestData = getRequestJson(); 
      $check_request_keys = array('userId','request_id');
      $resultJson    =  validateJson($requestData, $check_request_keys); 
      if($resultJson == OK)
      {           
        $this->ApiModel->cancel_ride_before_accept($requestData[APP_NAME]);
      }
      else{
        generateServerResponse('0', '100');
      }
    }
 
}
