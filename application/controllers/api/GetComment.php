<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class GetComment extends CI_Controller{
    public function __construct(){
      parent::__construct();
      $this->load->model('api/ApiModel');
      $this->load->helper('api');
    }
    public function index(){
    if($_SERVER['REQUEST_METHOD'] == POST){
      $this->get_comment();
    } 
    if($_SERVER['REQUEST_METHOD'] == GET){ 
    }  
    }
    public function get_comment()
    {
      $requestData = getRequestJson(); 
      $check_request_keys = array('userId');
      $resultJson    =  validateJson($requestData, $check_request_keys); 
      if($resultJson == OK)
      {           
         
         $data = $this->db->get_where('comment_master',array('status'=>1))->result_array();
         $responsearr['CommentData'] = $data;
         if (!empty($data)) 
         {
           generateServerResponse('1','222',$responsearr);
         }
         else
         {
           generateServerResponse('0','E');
         } 
      }
      else{
        generateServerResponse('0', '100');
      }
    }
 
}
