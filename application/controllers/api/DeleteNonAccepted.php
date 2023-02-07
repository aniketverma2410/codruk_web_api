<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class DeleteNonAccepted extends CI_Controller{
    public function __construct(){
      parent::__construct();
      $this->load->model('api/ApiModel');
      $this->load->helper('api');
    }
    public function index(){
    if($_SERVER['REQUEST_METHOD'] == POST){
      $this->delete_non_accepted();
    } 
    if($_SERVER['REQUEST_METHOD'] == GET){ 
    }  
    }
    public function delete_non_accepted()
    {
      $requestData = getRequestJson(); 
      $check_request_keys = array('userId','booking_id');
      $resultJson    =  validateJson($requestData, $check_request_keys); 
      if($resultJson == OK)
      {           
        $this->ApiModel->delete_non_accepted($requestData[APP_NAME]);
      }
      else
      {
        generateServerResponse('0', '100');
      }
    }
 
}
