<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class RideCompletionList extends CI_Controller{
    public function __construct(){
      parent::__construct();
      $this->load->model('api/ApiModel');
      $this->load->helper('api');
    }
    public function index(){
    if($_SERVER['REQUEST_METHOD'] == POST){
      $this->ride_completion_list();
    } 
    if($_SERVER['REQUEST_METHOD'] == GET){ 
    }  
    }
    public function ride_completion_list()
    {
      $requestData = getRequestJson(); 
      $check_request_keys = array('userId','from_date','to_date');
      $resultJson    =  validateJson($requestData, $check_request_keys); 
      if($resultJson == OK)
      {           
        $this->ApiModel->ride_completion_list($requestData[APP_NAME]);
      }
      else{
        generateServerResponse('0', '100');
      }
    }
 
}
