<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class AvailableCron extends CI_Controller{
    public function __construct(){
      parent::__construct();
      $this->load->model('api/ApiModel');
      $this->load->helper('api');
    }

    public function index()
    {
       $drivers = $this->db->get_where('driver_master',array('status'=>1))->result_array();
       $currdate = date('Y-m-d');
       foreach ($drivers as $key => $value) 
       {  
          $check = $this->db->get_where('on_off_master',array('driver_id'=>$value['id'],'offline_time'=>NULL))->row_array();

          if (!empty($check)) 
          {
               $updatearray['offline_time'] = time();

               $this->db->where('id',$check['id']);
               $this->db->update('on_off_master',$updatearray);

              $insert_array['driver_id']   = $value['id'];
              $insert_array['online_time'] = time();
              $insert_array['add_date']    = date('Y-m-d');

              $this->db->insert('on_off_master',$insert_array);
          }
          else
          {
             $insert_array['driver_id']    = $value['id'];
             $insert_array['online_time']  = time();
             $insert_array['offline_time'] = time();
             $insert_array['add_date']     = date('Y-m-d');

             $this->db->insert('on_off_master',$insert_array);
          }

       }
    }
 
}
