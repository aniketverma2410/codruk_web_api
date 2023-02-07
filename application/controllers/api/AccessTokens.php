<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class AccessTokens extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('api/ApiModel');
		    $this->load->helper('api');
    }
    public function index(){
		if($_SERVER['REQUEST_METHOD'] == POST){
			
		} 
		if($_SERVER['REQUEST_METHOD'] == GET){ 
		    $this->accessToken();
		}  
    }
    public function accessToken(){
       $this->ApiModel->getAccessTokens();
    }
 
}
