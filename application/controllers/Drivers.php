<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Drivers extends CI_Controller {
  public function __construct(){
  parent::__construct();
  $this->load->model('Driver_model');
  $this->load->helper('message');
}

 public function upload_userimg($image,$upload_path,$name) { 
      $extensions=explode('.',$image); 
      $extensions=strtolower(end($extensions));    
      $uniqueNames=$name."_".time().'.'.$extensions;

      $tmp_names=$_FILES[$name]['tmp_name']; 
      $targetlocations=$upload_path.$uniqueNames;    
         if(!empty($image)) {    
            move_uploaded_file($tmp_names,$targetlocations);           
         return $uniqueNames;               
         }  else {
         return 'false';
      } 
    }

  public function driverList(){
    is_not_logged_in();
    $response['pageTitle'] = 'Manage dashboard - '.ProjectName;
    $response['pageIndex'] = 'driver';
    $response['result']    = $this->Driver_model->manageDrivers();

    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('manageDrivers',$response);
    $this->load->view('header/footer');
  }

  public function updateDrivers(){
    is_not_logged_in();
    $id = $this->uri->segment(3);
    $response['pageTitle'] = 'Manage dashboard - '.ProjectName;
    $response['pageIndex'] = 'driver';
    $response['result']    = $this->Driver_model->getPersonalData($id);
    $response['id']        = $id;

    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('updateDrivers',$response);
    $this->load->view('header/footer');
  }

  public function updateDriverPost(){
    is_not_logged_in();
    $data             = $this->input->post();
    $array            = array();
    $array['name']    = $data['name'];
    $array['city']    = $data['city'];
    $array['status']  = $data['status'];

    $getData    = $this->db->get_where('driver_master',array('id'=>$data['id']))->row_array();
    if(!empty($_FILES['image']['name']))
    {
      $name = 'image';
      $path  = CUSTOMER_DIRECTORY.'mediaFile/drivers/';
      $image = $this->upload_userimg($_FILES['image']['name'],$path,$name);
    }else{
     $image = $getData['image'];
    }
    $array['image']  = $image;
    $this->db->where('id', $data['id']);
   $res = $this->db->update('driver_master', $array);
   if($res > 0 ){
          $this->session->set_flashdata('message',generateAdminAlert('S',3));
          redirect(base_url('Drivers/driverList'));
   }else{
         $this->session->set_flashdata('message',generateAdminAlert('D',12));
           redirect(base_url('Drivers/driverList'));
   }

  }

  public function addDriver(){
    is_not_logged_in();
    $response['pageTitle'] = 'Manage dashboard - '.ProjectName;
    $response['pageIndex'] = 'driver';
    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('addDriver',$response);
    $this->load->view('header/footer');
  }


  public function addDriverPost(){
    is_not_logged_in();
    $data              = $this->input->post();
    $array             = array();
    $array['name']     = $data['name'];
    $array['email']    = $data['email'];
    $array['mobile']   = $data['mobile'];
    $array['city']     = $data['city'];
    $array['status']     = 1;
    $array['addDate']     = time();
    $array['modifyDate']     = time();


    $checkEmailViaCustomer    = $this->checkExistMobileOrEmail('customer_master','email',$data['email']);
    $checkEmailViaDriver      = $this->checkExistMobileOrEmail('driver_master','email',$data['email']);

    $checkMobileViaCustomer   = $this->checkExistMobileOrEmail('customer_master','mobile',$data['mobile']);
    $checkMobileViaDriver     = $this->checkExistMobileOrEmail('driver_master','mobile',$data['mobile']);

     if($checkEmailViaCustomer > 0 || $checkEmailViaDriver > 0){
       $this->session->set_flashdata('message',generateAdminAlert('D',4));
         redirect(base_url('Drivers/addDriver'));
     }

     if($checkMobileViaCustomer > 0 || $checkMobileViaDriver > 0){
       $this->session->set_flashdata('message',generateAdminAlert('D',5));
         redirect(base_url('Drivers/addDriver'));
     }

       $image = "";
      if(!empty($_FILES['image']['name']))
      {
        $name = 'image';
        $path  = CUSTOMER_DIRECTORY.'mediaFile/drivers/';
        $image = $this->upload_userimg($_FILES['image']['name'],$path,$name);
      }

      $array['image']  = $image;

     $res = $this->db->insert('driver_master', $array);

     if($res > 0 ){
            $this->session->set_flashdata('message',generateAdminAlert('S',3));
            redirect(base_url('Drivers/driverList'));
     }else{
           $this->session->set_flashdata('message',generateAdminAlert('D',12));
             redirect(base_url('Drivers/addDriver'));
     }
  }


  public function checkExistMobileOrEmail($table,$colName,$colValue){  
     return $this->db->get_where($table,array($colName=>$colValue))->num_rows();
     //echo $this->db->last_query();exit();
  }

}
