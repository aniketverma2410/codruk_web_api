<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Dummy extends CI_Controller{
    public function __construct(){
      parent::__construct();
      $this->load->model('api/ApiModel');
      $this->load->helper('api');
    }
    public function index(){
    if($_SERVER['REQUEST_METHOD'] == POST){
      $this->accept_ride();
    } 
    if($_SERVER['REQUEST_METHOD'] == GET){ 
    }  
    }
    public function accept_ride()
    { 
      /*$update_array['status'] = 4;
      $this->db->where('status',1);
      $this->db->update('booking_ride_request_master',$update_array);*/

      $this->ApiModel->dell();
    }
 
}
