<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class GetMyJob extends CI_Controller{
    public function __construct(){
      parent::__construct();
      $this->load->model('api/ApiModel');
      $this->load->helper('api');
    }
    public function index(){
    if($_SERVER['REQUEST_METHOD'] == POST){
      $this->get_my_job();
    } 
    if($_SERVER['REQUEST_METHOD'] == GET){ 
    }  
    }
    // type: 1 =>customer,2=>driver

    public function get_my_job()
    {
      $requestData = getRequestJson(); 
      $check_request_keys = array('userId','status','type');
      $resultJson    =  validateJson($requestData, $check_request_keys); 
      if($resultJson == OK)
      {           
        $this->ApiModel->get_my_job($requestData[APP_NAME]);
      }
      else{
        generateServerResponse('0', '100');
      }
    }
 
}
