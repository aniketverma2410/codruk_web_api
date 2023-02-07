<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class DeleteRideCron extends CI_Controller{
    public function __construct(){
      parent::__construct();
      $this->load->model('api/ApiModel');
      $this->load->helper('api');
    }
    /*public function index() { 

       $list = $this->db->get_where('delete_ride_master')->result_array();
       $curdate = date('Y-m-d H:i:s');
       foreach ($list as $key => $value) 
       {
          $addmin =  date('Y-m-d H:i:s',strtotime('+2 minutes',strtotime($value['time_date'])));
          if ($curdate > $addmin) 
          {  
             $getuser = $this->db->get_where('ride_master',array('id'=>$value['booking_id']))->row_array();
             $this->ApiModel->sendnote($getuser['userId']);

             $this->db->where('id',$value['booking_id']);
             $this->db->delete('ride_master');

             $this->db->where('id',$value['id']);
             $this->db->delete('delete_ride_master');
          }
       }
    }*/

     public function index()
    {   

     /* $requestMobile = "7084614556";
      $message = 'hello';
         $url = "http://www.wiztechsms.com/http-api.php?username=ubaid&password=ubaid&senderid=OXPLUS&route=1&number=".$requestMobile."&message=".urlencode($message);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_exec($ch);*/


       $rides = $this->db->get_where('ride_master',array('status'=>1))->result_array();
       $setting = $this->db->get_where('settings')->row_array();
       $curdate = date('Y-m-d H:i:s');
       foreach ($rides as $key => $value) 
       {
          $addmin =  date('Y-m-d H:i:s',strtotime('+'.$setting['acceptance_time'].' minutes',$value['addDate']));
           if (($curdate > $addmin) && ($value['status'] == 1)) 
          {  
             $getuser = $this->db->get_where('ride_master',array('id'=>$value['id']))->row_array();
             $this->ApiModel->sendnote($getuser['userId']);

             $this->db->where('id',$value['id']);
             $this->db->delete('ride_master');
          }
       }
    }
 
}
