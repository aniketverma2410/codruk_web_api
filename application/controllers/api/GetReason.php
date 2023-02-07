<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class GetReason extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('api/ApiModel');
		    $this->load->helper('api');
    }
    public function index(){
  		if($_SERVER['REQUEST_METHOD'] == POST){
  			
  		} 
  		if($_SERVER['REQUEST_METHOD'] == GET){ 
        $this->readyForWork();
  		}  
    }
    public function readyForWork()
    {
       $getsettingData = $this->db->get_where('reason_master',array('status'=>1))->result_array();
       $arr = array();
       foreach ($getsettingData as $key => $value) {
         $array['id']     = $value['id'];
         $array['type']   = $value['type'];
         $array['reason'] = $value['name'];
         $arr[]           = $array;
       }
       $param['dataList']  = $arr;
      if(count($getsettingData) > 0)
      {           
        generateServerResponse('1',SUCCESS,$param);
      }
    }
 
}
