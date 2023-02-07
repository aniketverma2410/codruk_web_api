<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class GetSettings extends CI_Controller{
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
       $getsettingData = $this->ApiModel->getDataViaTable('settings','1');
       $array = array();
       $array['currency'] = $getsettingData['currency'];
       $array['tollFree'] = $getsettingData['helpline'];

      if($array > 0)
      {           
        generateServerResponse('1','S',$array);
      }
    }
 
}
