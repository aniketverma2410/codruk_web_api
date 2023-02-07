<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class PostRating extends CI_Controller{
    public function __construct(){
      parent::__construct();
      $this->load->model('api/ApiModel');
      $this->load->helper('api');
    }
    public function index(){
    if($_SERVER['REQUEST_METHOD'] == POST){
      $this->post_rating();
    } 
    if($_SERVER['REQUEST_METHOD'] == GET){ 
    }  
    }

    public function post_rating()
    {
      $requestData = getRequestJson(); 
      $check_request_keys = array('customer_id','driver_id','booking_id','comment_id','rating','remark');
      $resultJson    =  validateJson($requestData, $check_request_keys); 
      if($resultJson == OK)
      {           
        $this->ApiModel->post_rating($requestData[APP_NAME]);
      }
      else
      {
        generateServerResponse('0', '100');
      }
    }
 
}
