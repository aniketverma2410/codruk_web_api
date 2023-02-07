<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin extends CI_Controller {
  public function __construct(){
  parent::__construct();
  $this->load->model('Common_model');
  $this->load->helper('message');
  date_default_timezone_set('Asia/Kolkata');
}

  // manage vehicle list
  public function manageVehicle(){
    is_not_logged_in();
    $response['pageTitle'] = 'Manage vehicle - '.ProjectName;
    $response['pageIndex'] = 'vehicle';
    $response['pageIndex1'] = "";
    $response['result']    = $this->Common_model->getVehicleData();

    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('vehicleList',$response);
    $this->load->view('header/footer');
  }
// manage terms and condition
  public function termsCondition(){
    $response['pageTitle'] = 'Terms & Conditions - '.ProjectName;
    $this->load->view('termsCondition',$response);
  }

// manage terms and condition
  public function privacyPolicy(){
    $response['pageTitle'] = 'PRIVACY POLICY - '.ProjectName;
    $this->load->view('privacyPolicy',$response);
  }

  public function manage_request(){
    is_not_logged_in();
    $response['pageTitle'] = 'Manage vehicle Request - '.ProjectName;
    $response['pageIndex'] = 'driver_request';
    $response['pageIndex1'] = "";

                             $this->db->order_by('vehicle_request_master.id','desc'); 
                             $this->db->select('owner_vehicle_master.*,vehicle_request_master.id as request_id,vehicle_request_master.driver_id,vehicle_request_master.vehicle_id,vehicle_request_master.add_date as register_at,vehicle_request_master.status as register_status');
                             $this->db->join('owner_vehicle_master','owner_vehicle_master.id = vehicle_request_master.vehicle_id');
                            // $this->db->where(array('owner_vehicle_master.owner_id'=>$owner_detail['id'])); 
    $response['result']    = $this->db->get_where('vehicle_request_master')->result_array();
    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('manage_request',$response);
    $this->load->view('header/footer');
  }

   public function managecomment()
  {
    is_not_logged_in();
    $response['pageTitle']  = 'Manage Comments - '.ProjectName;
    $response['pageIndex']  = 'setting';
    $response['pageIndex1'] = "comment";
                             $this->db->order_by('id','desc');
    $response['result']    = $this->db->get_where('comment_master')->result_array();
    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('managecomment',$response);
    $this->load->view('header/footer');
  }

  public function addcomment(){
    is_not_logged_in();

    if ($this->input->post()) 
    {
        $data                     = $this->input->post();
        $array                    = array();
        $array['comment']         = $data['comment'];
        $array['add_date']        = time();
        $array['modify_date']     = time();
        $array['status']          = 1;

       $res = $this->db->insert('comment_master', $array);

         if($res > 0 ){
                $this->session->set_flashdata('message',generateAdminAlert('S',25));
                redirect(base_url('Admin/managecomment'));
         }else{
               $this->session->set_flashdata('message',generateAdminAlert('D',12));
                 redirect(base_url('Admin/addcomment'));
         }
    }
    else
    {
        $response['pageTitle']  = 'Add Comment - '.ProjectName;
        $response['pageIndex']  = 'setting';
        $response['pageIndex1'] = "comment";
        $this->load->view('header/header',$response);
        $this->load->view('header/left-menu',$response);
        $this->load->view('addcomment',$response);
        $this->load->view('header/footer');
    }
  }

   public function updatecomment(){
    is_not_logged_in();
    $id = $this->uri->segment(3,0);

    if ($this->input->post()) 
    {
        $data                     = $this->input->post();
        $array                    = array();
        $array['comment']         = $data['comment'];
        $array['modify_date']     = time();
        $array['status']          = $data['status'];

              $this->db->where('id',$id);
       $res = $this->db->update('comment_master', $array);

         if($res > 0 ){
                $this->session->set_flashdata('message',generateAdminAlert('S',26));
                redirect(base_url('Admin/managecomment'));
         }else{
               $this->session->set_flashdata('message',generateAdminAlert('D',12));
                 redirect(base_url('Admin/updatecomment/'.$id));
         }
    }
    else
    {   

        $response['comment_data'] = $this->db->get_where('comment_master',array('id'=>$id))->row_array();
        $response['id'] = $id;
        $response['pageTitle']  = 'Update Comment - '.ProjectName;
        $response['pageIndex']  = 'setting';
        $response['pageIndex1'] = "comment";
        $this->load->view('header/header',$response);
        $this->load->view('header/left-menu',$response);
        $this->load->view('updatecomment',$response);
        $this->load->view('header/footer');
    }
  }


   public function update_request(){
    is_not_logged_in();
    $request_id = $this->uri->segment(3,0);

    if ($this->input->post()) 
    { 
       $data = $this->input->post();
       $status = $data['status'];
       $id = $data['id'];
       $update_arr['status'] = $data['status'];
       $update_arr['modify_date'] = time();

        $check_data = $this->db->get_where('vehicle_request_master',array('id'=>$id))->row_array();
        if (empty($check_data)) 
        {
          $this->session->set_flashdata('message',generateAdminAlert('D',31));
          redirect(base_url('Admin/manage_request'), 'refresh');
        }

       if ($status == 3) 
       {
          $this->db->where('id',$id);
          $this->db->delete('vehicle_request_master');

          $this->session->set_flashdata('message',generateAdminAlert('S',30));
          redirect(base_url('Admin/manage_request'));
       }
        elseif($status == 2) 
       { 
          $this->db->where('id',$id);
          $this->db->update('vehicle_request_master',$update_arr);

          $this->session->set_flashdata('message',generateAdminAlert('S',30));
          redirect(base_url('Admin/manage_request'));
       }
       else
       {  
          $this->db->where('id',$id);
          $this->db->update('vehicle_request_master',$update_arr);

          /*******************change ride status for search vehicle**********************/

          $UpdateArr['vehicle_status'] = $data['status'];
          $this->db->where('id',$check_data['vehicle_id']);
          $this->db->update('owner_vehicle_master',$UpdateArr);

         /*************************************END**************************************/

          /*******************************new implementation**********************************/
          $getdata = $this->db->get_where('vehicle_request_master',array('id'=>$id))->row_array();

          $this->db->where(array('driver_id'=>$getdata['driver_id'],'status'=>2));
          $this->db->delete('vehicle_request_master');

          $this->db->where(array('vehicle_id'=>$getdata['vehicle_id'],'status'=>2));
          $this->db->delete('vehicle_request_master');

        /***********************************************************************************/  

          $this->session->set_flashdata('message',generateAdminAlert('S',30));
          redirect(base_url('Admin/manage_request'));
       }
    }
    else
    {   
        $check_data = $this->db->get_where('vehicle_request_master',array('id'=>$request_id))->row_array();
        if (empty($check_data)) 
        {
          $this->session->set_flashdata('message',generateAdminAlert('D',31));
          redirect(base_url('Admin/manage_request'), 'refresh');
        }
        
        $response['pageTitle'] = 'Manage vehicle Request - '.ProjectName;
        $response['pageIndex'] = 'driver_request';
        $response['pageIndex1'] = "";
        $response['result']    = $this->db->get_where('vehicle_request_master',array('id'=>$request_id))->row_array();
        $this->load->view('header/header',$response);
        $this->load->view('header/left-menu',$response);
        $this->load->view('update_request',$response);
        $this->load->view('header/footer');
    }
    
  }

   // Add vehicle data
  public function add_owner_vehicle(){
    is_not_logged_in();

    if ($this->input->post()) 
    {
      $data = $this->input->post();
      $array  = array();
      $array['owner_id']            = $data['owner'];
      $array['vehicle_number']      = $data['vehicle_number'];
      $array['vehicle_master_id']   = $data['vehicle_master_id'];
      $array['vehicle_type']        = $data['vehicle_type'];
      $array['vehicle_left']        = $data['vehicle_left'];
      $array['vehicle_right']       = $data['vehicle_right'];
      $array['vehicle_front']       = $data['vehicle_front'];
      $array['add_date']            = time();
      $array['modify_date']         = time();
      $array['status']              = 1;
      $array['admin_approval']      = 1;
      
        $res = $this->db->insert('owner_vehicle_master', $array);
        $last_id = $this->db->insert_id();

       if($res > 0 ){
              $this->session->set_flashdata('message',generateAdminAlert('S',17));
              redirect(base_url('Admin/registration_doc?id='.$last_id));
       }else{
             $this->session->set_flashdata('message',generateAdminAlert('D',12));
               redirect(base_url('Admin/add_owner_vehicle'));
       }
    }
    else
    {
        $response['pageTitle']  = 'Add Owner Vehicle - '.ProjectName;
        $response['pageIndex']  = 'ownervehicle';
        $response['pageIndex1'] = "";
        $response['result']     = $this->Common_model->getVehicleData();
        $response['capacity']   = $this->Common_model->getDataViaType('unit_master','1');
        $response['duration']   = $this->Common_model->getDataViaType('unit_master','2');

                                $this->db->order_by('name','asc');
        $response['owners']   = $this->db->get_where('owner_master',array('status'=>1))->result_array();

        $this->load->view('header/header',$response);
        $this->load->view('header/left-menu',$response);
        $this->load->view('add_owner_vehicle',$response);
        $this->load->view('header/footer');
    }
  }

  private function set_upload_options($types) {   
        //upload an image options
        $config = array();

        $fileTypes = array('jpg', 'jpeg', 'png');
        
        $config['upload_path']   = 'mediaFile/vehicles/';
        $config['allowed_types'] = $fileTypes;
        $config['max_size']      = '0';
        $config['overwrite']     = false;
        $config['remove_spaces'] = true;
        $config['encrypt_name']  = true;

        return $config;
    }


        /* upload multiple images by jquery */
      public function uoload_img() {
        ini_set('post_max_size', '64M');
      ini_set('upload_max_filesize', '64M');

        $main_arr = $_FILES;
        $filesCount = count($_FILES);
        
          $dataInfo = array();
          $uploadImgData = array();
          $files = $_FILES;
          $curr_date = date('Y-m-d H:i:s');
          
          $i = 0;
          $id = $this->input->post('id');
          $table = $this->input->post('table');
          $type = $this->input->post('type');


          // create directory 
          $in_foler = 'mediaFile/vehicles/'; // FOLDER PATH

          $set_html = '';
            foreach ($main_arr as $key => $value) {
              $file_name = $key;
              if (!empty($value)) {
                if ($id == 'libraries') { 
                  $types = 1;
                } else {
                  $types = '';
                }
                $_FILES['file']['name']     = $value['name'];
                  $_FILES['file']['type']     = $value['type'];
                  $_FILES['file']['tmp_name'] = $value['tmp_name'];
                  $_FILES['file']['error']    = $value['error'];
                  $_FILES['file']['size']     = $value['size'];

                  $this->load->library('upload', $this->set_upload_options($types));
                $this->upload->initialize($this->set_upload_options($types));
              
              if($this->upload->do_upload('file')) {
                    $fileData = $this->upload->data();
                    $file_names = $fileData['file_name'];

                    
                  if(!empty($file_names)){
                    $img = $file_names;
                    
                      $set_html .='<div class="col-xs-12 set_w_admin " id="img_preview_1"><img src="'.base_url().'mediaFile/vehicles/'.$img.'" class="set_image" alt="'.$img.'" id="set_image_'.$type.'"><div class="col-xs-12 set_success"><span class="success">Success</span></div><div class="progress col-xs-12 divPadding" style="margin: 0;"><div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%"></div></div></div>';
                }
              } else {
                  $upload_error = array('error' => $this->upload->display_errors());
                print_r($upload_error);
                $set_html = 2;
                }
              }
              $i++;
            }

            echo json_encode($set_html);
            exit;
      }

  public function registration_doc()
  {
    is_not_logged_in();
    if ($this->input->post()) 
    {   
       $id = $this->input->post('id');

      $array['vehicle_reg_front']   = $this->input->post('vehicle_reg_front');
      $array['vehicle_reg_back']    = $this->input->post('vehicle_reg_back');
     
             $this->db->where('id',$id);     
      $res = $this->db->update('owner_vehicle_master', $array);

     if($res > 0 ){
            $this->session->set_flashdata('message',generateAdminAlert('S',17));
            redirect(base_url('Admin/route_permit_doc?id='.$id));
     }else{
           $this->session->set_flashdata('message',generateAdminAlert('D',12));
             redirect(base_url('Admin/registration_doc?id='.$id));
     }

    }
    else
    {
        $response['pageTitle'] = 'Add Vehicle - '.ProjectName;
        $response['pageIndex'] = 'ownervehicle';
        $response['pageIndex1'] = "";
        $response['result']    = $this->Common_model->getVehicleData();
        $response['capacity']  = $this->Common_model->getDataViaType('unit_master','1');
        $response['duration']  = $this->Common_model->getDataViaType('unit_master','2');

        $this->load->view('header/header',$response);
        $this->load->view('header/left-menu',$response);
        $this->load->view('registration_doc',$response);
        $this->load->view('header/footer');
    }
    
  }

    public function route_permit_doc()
  {
    is_not_logged_in();
    if ($this->input->post()) 
    {   
       $id = $this->input->post('id');

      $array['route_permit_front']  = $this->input->post('route_permit_front');
      $array['route_permit_back']   = $this->input->post('route_permit_back');
     
             $this->db->where('id',$id);     
      $res = $this->db->update('owner_vehicle_master', $array);

     if($res > 0 ){
            $this->session->set_flashdata('message',generateAdminAlert('S',17));
            redirect(base_url('Admin/containment_doc?id='.$id));
     }else{
           $this->session->set_flashdata('message',generateAdminAlert('D',12));
             redirect(base_url('Admin/route_permit_doc?id='.$id));
     }

    }
    else
    {
        $response['pageTitle'] = 'Add Vehicle - '.ProjectName;
        $response['pageIndex'] = 'ownervehicle';
        $response['pageIndex1'] = "";
        $response['result']    = $this->Common_model->getVehicleData();
        $response['capacity']  = $this->Common_model->getDataViaType('unit_master','1');
        $response['duration']  = $this->Common_model->getDataViaType('unit_master','2');

        $this->load->view('header/header',$response);
        $this->load->view('header/left-menu',$response);
        $this->load->view('route_permit_doc',$response);
        $this->load->view('header/footer');
    }
    
  }


   public function containment_doc()
  {
    is_not_logged_in();
    if ($this->input->post()) 
    {   
       $id = $this->input->post('id');
      $array['containment_front']   = $this->input->post('containment_front');
      $array['containment_back']    = $this->input->post('containment_back');
     
             $this->db->where('id',$id);     
      $res = $this->db->update('owner_vehicle_master', $array);

     if($res > 0 ){
            $this->session->set_flashdata('message',generateAdminAlert('S',17));
            redirect(base_url('Admin/manageownervehicle'));
     }else{
           $this->session->set_flashdata('message',generateAdminAlert('D',12));
             redirect(base_url('Admin/containment_doc?id='.$id));
     }

    }
    else
    {
        $response['pageTitle'] = 'Add Vehicle - '.ProjectName;
        $response['pageIndex'] = 'ownervehicle';
        $response['pageIndex1'] = "";
        $response['result']    = $this->Common_model->getVehicleData();
        $response['capacity']  = $this->Common_model->getDataViaType('unit_master','1');
        $response['duration']  = $this->Common_model->getDataViaType('unit_master','2');

        $this->load->view('header/header',$response);
        $this->load->view('header/left-menu',$response);
        $this->load->view('containment_doc',$response);
        $this->load->view('header/footer');
    }
    
  }




  // Add vehicle data
  public function addVehicle(){
    is_not_logged_in();
    $response['pageTitle'] = 'Add Vehicle - '.ProjectName;
    $response['pageIndex'] = 'vehicle';
    $response['pageIndex1'] = "";
    $response['result']    = $this->Common_model->getVehicleData();
    $response['capacity']  = $this->Common_model->getDataViaType('unit_master','1');
    $response['duration']  = $this->Common_model->getDataViaType('unit_master','2');
    $response['currency']  = $this->db->get_where('settings')->row_array();

    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('addVehicle',$response);
    $this->load->view('header/footer');
  }
// vehicle post 
  public function addVehiclePost(){
    is_not_logged_in();
    $data                     = $this->input->post();
    $array                    = array();
    $array['type']            = $data['type'];
    $array['name']            = $data['name'];
    $array['capacity']        = $data['capacity'];
    //$array['loadingTime']     = $data['loadingTime'];
    $array['unitId']          = $data['unitId'];
    $array['durationId']      = $data['durationId'];

    $array['initial_charges']             = $data['initial_charges'];
    $array['charges_per_km']              = $data['charges_per_km'];
    $array['free_loading_time']           = $data['free_loading_time'];
    $array['waiting_charges_loading']     = $data['waiting_charges_loading'];
    $array['free_unloading_time']         = $data['free_unloading_time'];
    $array['waiting_charges_unloading']   = $data['waiting_charges_unloading'];

    $array['status']          = 1;
    $array['addDate']         = time();
    $array['modifyDate']      = time();

       $image = "";
      if(!empty($_FILES['image']['name']))
      {
        $name = 'image';
        $path  = CUSTOMER_DIRECTORY.'mediaFile/vehicles/';
        $image = $this->Common_model->upload_userimg($_FILES['image']['name'],$path,$name);
      }

      $array['image']  = $image;

      $res = $this->db->insert('vehicle_master', $array);

     if($res > 0 ){
            $this->session->set_flashdata('message',generateAdminAlert('S',17));
            redirect(base_url('Admin/manageVehicle'));
     }else{
           $this->session->set_flashdata('message',generateAdminAlert('D',12));
             redirect(base_url('Admin/addVehicle'));
     }
  }

  // Add vehicle data
  public function updateVehicle(){
    is_not_logged_in();
    $userId = $this->uri->segment(3);
    $response['pageTitle'] = 'Update Vehicle - '.ProjectName;
    $response['pageIndex'] = 'vehicle';
    $response['pageIndex1'] = "";
    $response['vehicleData']    = $this->Common_model->getDataViaId('vehicle_master',$userId);
    $response['capacity']  = $this->Common_model->getDataViaType('unit_master','1');
    $response['duration']  = $this->Common_model->getDataViaType('unit_master','2');
    $response['currency']  = $this->db->get_where('settings')->row_array();

    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('updateVehicle',$response);
    $this->load->view('header/footer');
  }

// vehicle post 
  public function updateVehiclePost(){
    is_not_logged_in();
    $data                     = $this->input->post();
    $array                    = array();
    $array['type']            = $data['type'];
    $array['name']            = $data['name'];
    $array['capacity']        = $data['capacity'];
    //$array['loadingTime']     = $data['loadingTime'];
    $array['unitId']          = $data['unitId'];
    //$array['durationId']      = $data['durationId'];

    $array['initial_charges']             = $data['initial_charges'];
    $array['charges_per_km']              = $data['charges_per_km'];
    $array['free_loading_time']           = $data['free_loading_time'];
    $array['waiting_charges_loading']     = $data['waiting_charges_loading'];
    $array['free_unloading_time']         = $data['free_unloading_time'];
    $array['waiting_charges_unloading']   = $data['waiting_charges_unloading'];

    $array['status']          = $data['status'];;
    $array['addDate']         = time();
    $array['modifyDate']      = time();

      $getData    = $this->db->get_where('vehicle_master',array('id'=>$data['id']))->row_array();
      if(!empty($_FILES['image']['name']))
      {
        $name = 'image';
        $path  = CUSTOMER_DIRECTORY.'mediaFile/vehicles/';
        $image = $this->Common_model->upload_userimg($_FILES['image']['name'],$path,$name);
      }else{
       $image = $getData['image'];
      }
      $array['image']  = $image;

     $this->db->where('id',$data['id']);
      $res = $this->db->update('vehicle_master', $array);

     if($res > 0 ){
            $this->session->set_flashdata('message',generateAdminAlert('S',18));
            redirect(base_url('Admin/manageVehicle'));
     }else{
           $this->session->set_flashdata('message',generateAdminAlert('D',12));
             redirect(base_url('Admin/manageVehicle'));
     }
  }


// admin profile
  
  public function adminProfile(){
    is_not_logged_in();
    $response['pageTitle'] = 'Update Admin Profile - '.ProjectName;
    $response['pageIndex'] = '';
    $response['pageIndex1'] = "";
    $response['reg']    = $this->Common_model->getDataViaId('admin_master',1);

    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('updateProfile',$response);
    $this->load->view('header/footer');
  }

   public function staff_profile(){
    $admindata = is_not_logged_in();
    if ($this->input->post()) 
    {
      $data                     = $this->input->post();
      $array                    = array();
      $array['name']            = $data['name'];
      $array['password']        = $data['password'];
     
        $getData    = $this->db->get_where('staff_master',array('id'=>$admindata['id']))->row_array();
        if(!empty($_FILES['image']['name']))
        {
          $name = 'image';
          $path  = CUSTOMER_DIRECTORY.'mediaFile/staff/';
          $image = $this->Common_model->upload_userimg($_FILES['image']['name'],$path,$name);
        }else{
         $image = $getData['profile_pic'];
        }
        $array['profile_pic']  = $image;

       $this->db->where('id',$admindata['id']);
        $res = $this->db->update('staff_master', $array);

       if($res > 0 ){
              $this->session->set_flashdata('message',generateAdminAlert('S',30));
              redirect(base_url('Admin/staff_profile'));
       }else{
             $this->session->set_flashdata('message',generateAdminAlert('D',12));
               redirect(base_url('Admin/staff_profile'));
       }
    }
    else
    {
        $response['pageTitle'] = 'Update Staff Profile - '.ProjectName;
        $response['pageIndex'] = '';
        $response['pageIndex1'] = "";
        $response['reg']    = $this->db->get_where('staff_master',array('id'=>$admindata['id']))->row_array();

        $this->load->view('header/header',$response);
        $this->load->view('header/left-menu',$response);
        $this->load->view('staff_profile',$response);
        $this->load->view('header/footer');
    }
    
  }

// vehicle post 
  public function updateAdminPost(){
    is_not_logged_in();
    $data                     = $this->input->post();
    $array                    = array();
    $array['name']            = $data['name'];
    $array['username']        = $data['username'];
    if(!empty($data['password'])){
      $array['password']        = base64_encode($data['password']);
    }


      $getData    = $this->db->get_where('admin_master',array('id'=>1))->row_array();
      if(!empty($_FILES['image']['name']))
      {
        $name = 'image';
        $path  = CUSTOMER_DIRECTORY.'mediaFile/';
        $image = $this->Common_model->upload_userimg($_FILES['image']['name'],$path,$name);
      }else{
       $image = $getData['image'];
      }
      $array['image']  = $image;

     $this->db->where('id',1);
      $res = $this->db->update('admin_master', $array);

     if($res > 0 ){
            $this->session->set_flashdata('message',generateAdminAlert('S',19));
            redirect(base_url('Admin/adminProfile'));
     }else{
           $this->session->set_flashdata('message',generateAdminAlert('D',12));
             redirect(base_url('Admin/adminProfile'));
     }
  }

  public function manageLoader(){
    is_not_logged_in();
    $response['pageTitle'] = 'Manage Loaders - '.ProjectName;
    $response['pageIndex'] = 'loader';
    $response['pageIndex1'] = "";
                             $this->db->order_by('id','desc');         
    $response['result']    = $this->db->get_where('loader_master')->result_array();
    $response['currency']  = $this->Common_model->getDataViaId('settings','1');

    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('loaderList',$response);
    $this->load->view('header/footer');
  }


  public function addLoader(){
    is_not_logged_in();
    $response['pageTitle'] = 'Manage Loaders - '.ProjectName;
    $response['pageIndex'] = 'loader';
    $response['pageIndex1'] = "";
    $response['currency']  = $this->Common_model->getDataViaId('settings','1');
    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('addLoader',$response);
    $this->load->view('header/footer');
  }

// Loader post 
  public function addLoaderPost(){
    is_not_logged_in();
    $data                     = $this->input->post();
    $array                    = array();
    $array['name']            = $data['name'];
    $array['loaderCount']     = $data['loaderCount'];
    $array['rate']            = $data['rate'];
    $array['status']          = 1;
    $array['addDate']         = time();
    $array['modifyDate']      = time();

       $image = "";
      if(!empty($_FILES['image']['name']))
      {
        $name = 'image';
        $path  = CUSTOMER_DIRECTORY.'mediaFile/loaders/';
        $image = $this->Common_model->upload_userimg($_FILES['image']['name'],$path,$name);
      }

      $array['image']  = $image;

      $res = $this->db->insert('loader_master', $array);

     if($res > 0 ){
            $this->session->set_flashdata('message',generateAdminAlert('S',20));
            redirect(base_url('Admin/manageLoader'));
     }else{
           $this->session->set_flashdata('message',generateAdminAlert('D',12));
             redirect(base_url('Admin/manageLoader'));
     }
  }
  // manage list
  public function updateLoader(){
    is_not_logged_in();
    $id = $this->uri->segment(3);
    $response['pageTitle']  = 'Update Loader - '.ProjectName;
    $response['pageIndex']  = 'loader';
    $response['pageIndex1'] = "";
    $response['result']     = $this->Common_model->getDataViaId('loader_master',$id);
    $response['currency']  = $this->Common_model->getDataViaId('settings','1');

    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('updateLoader',$response);
    $this->load->view('header/footer');
  }

// loader post 
  public function updateLoaderPost(){
    is_not_logged_in();
    $data                     = $this->input->post();
    $array                    = array();

    $array['name']            = $data['name'];
    $array['loaderCount']     = $data['loaderCount'];
    $array['rate']            = $data['rate'];
    $array['status']            = $data['status'];
    $array['modifyDate']      = time();

      $getData    = $this->Common_model->getDataViaId('loader_master',$data['id']);
      if(!empty($_FILES['image']['name']))
      {
        $name = 'image';
        $path  = CUSTOMER_DIRECTORY.'mediaFile/loaders/';
        $image = $this->Common_model->upload_userimg($_FILES['image']['name'],$path,$name);
      }else{
       $image = $getData['image'];
      }
      $array['image']  = $image;

     $this->db->where('id',$data['id']);
      $res = $this->db->update('loader_master', $array);

     if($res > 0 ){
            $this->session->set_flashdata('message',generateAdminAlert('S',21));
            redirect(base_url('Admin/manageLoader'));
     }else{
           $this->session->set_flashdata('message',generateAdminAlert('D',12));
             redirect(base_url('Admin/manageLoader'));
     }
  }


  public function manageInsurance(){
    is_not_logged_in();
    $response['pageTitle'] = 'Manage Items - '.ProjectName;
    $response['pageIndex'] = 'insurance';
    $response['pageIndex1'] = "";
                              $this->db->order_by('id','desc');  
    $response['result']    = $this->db->get_where('insurance_master')->result_array();
    $response['currency']  = $this->Common_model->getDataViaId('settings','1');

    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('manageInsurance',$response);
    $this->load->view('header/footer');
  }

  public function addInsurance(){
    is_not_logged_in();
    $response['pageTitle'] = 'Add Item - '.ProjectName;
    $response['pageIndex'] = 'insurance';
    $response['pageIndex1'] = "";
    $response['capacity']  = $this->Common_model->getDataViaType('unit_master','1');
    $response['currency']  = $this->Common_model->getDataViaId('settings','1');
    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('addInsurance',$response);
    $this->load->view('header/footer');
  }

  public function addInsurancePost(){
    is_not_logged_in();
    $data                     = $this->input->post();
    $array                    = array();
    $array['name']            = $data['name'];
    //$array['rate']            = $data['rate'];
    //$array['unitId']          = $data['unitId'];
    $array['status']          = 1;
    $array['addDate']         = time();
    $array['modifyDate']      = time();

       $image = "";
      if(!empty($_FILES['image']['name']))
      {
        $name = 'image';
        $path  = CUSTOMER_DIRECTORY.'mediaFile/insurance/';
        $image = $this->Common_model->upload_userimg($_FILES['image']['name'],$path,$name);
      }

      $array['image']  = $image;

      $res = $this->db->insert('insurance_master', $array);

     if($res > 0 ){
            $this->session->set_flashdata('message',generateAdminAlert('S',22));
            redirect(base_url('Admin/manageInsurance'));
     }else{
           $this->session->set_flashdata('message',generateAdminAlert('D',12));
             redirect(base_url('Admin/manageInsurance'));
     }
  }

  public function updateInsurance(){
    is_not_logged_in();
    $id = $this->uri->segment(3);
    $response['pageTitle']  = 'Update Item - '.ProjectName;
    $response['pageIndex']  = 'insurance';
    $response['pageIndex1'] = "";
    $response['result']     = $this->Common_model->getDataViaId('insurance_master',$id);
    $response['capacity']   = $this->Common_model->getDataViaType('unit_master','1');
    $response['currency']   = $this->Common_model->getDataViaId('settings','1');
    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('updateInsurance',$response);
    $this->load->view('header/footer');
  }


  public function updateInsurancePost(){
    is_not_logged_in();
    $data                     = $this->input->post();
    $array                    = array();

    $array['name']            = $data['name'];
    $array['status']            = $data['status'];

    //$array['rate']            = $data['rate'];
    //$array['unitId']          = $data['unitId'];
    $array['modifyDate']      = time();

      $getData    = $this->Common_model->getDataViaId('insurance_master',$data['id']);
      if(!empty($_FILES['image']['name']))
      {
        $name = 'image';
        $path  = CUSTOMER_DIRECTORY.'mediaFile/insurance/';
        $image = $this->Common_model->upload_userimg($_FILES['image']['name'],$path,$name);
      }else{
       $image = $getData['image'];
      }
      $array['image']  = $image;

      $this->db->where('id',$data['id']);
      $res = $this->db->update('insurance_master', $array);

     if($res > 0 ){
            $this->session->set_flashdata('message',generateAdminAlert('S',23));
            redirect(base_url('Admin/manageInsurance'));
     }else{
           $this->session->set_flashdata('message',generateAdminAlert('D',12));
             redirect(base_url('Admin/manageInsurance'));
     }
  }

  public function updateSetting(){
    is_not_logged_in();
    $response['pageTitle']  = 'Update Setting - '.ProjectName;
    $response['pageIndex']  = 'setting';
    $response['pageIndex1'] = "general";
    $response['result']     = $this->Common_model->getDataViaId('settings',1);

    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('generalSetting',$response);
    $this->load->view('header/footer');
  }

  public function updateSettingPost(){
    is_not_logged_in();
    $data                     = $this->input->post();
    $array                    = array();

    $array['currency']            = $data['currency'];
    $array['helpline']            = $data['helpline'];
    $array['ride_range']          = $data['ride_range'];
    $array['acceptance_time']     = $data['acceptance_time'];
    $array['tax']                 = $data['tax'];
    $array['favourite_count']     = $data['favourite_count'];
    $array['customer_app_version']     = $data['customer_app_version'];
    $array['pilot_app_version']     = $data['pilot_app_version'];

  
     $this->db->where('id',1);
      $res = $this->db->update('settings', $array);

     if($res > 0 ){
            $this->session->set_flashdata('message',generateAdminAlert('S',24));
            redirect(base_url('Admin/updateSetting'));
     }else{
           $this->session->set_flashdata('message',generateAdminAlert('D',12));
             redirect(base_url('Admin/updateSetting'));
     }
  }


  public function manageUnits(){
    is_not_logged_in();
    $response['pageTitle']  = 'Manage Unit - '.ProjectName;
    $response['pageIndex']  = 'setting';
    $response['pageIndex1'] = "unit";

                              $this->db->order_by('id','desc');  
    $response['result']    = $this->db->get_where('unit_master')->result_array();
    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('manageUnits',$response);
    $this->load->view('header/footer');
  }

  public function addUnitData(){
    is_not_logged_in();
    $response['pageTitle']  = 'Manage Unit - '.ProjectName;
    $response['pageIndex']  = 'setting';
    $response['pageIndex1'] = "unit";

                              $this->db->order_by('id','desc');  
    $response['result']    = $this->db->get_where('unit_type_master')->result_array();
    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('addUnit',$response);
    $this->load->view('header/footer');
  }


  public function addUnitPost(){
    is_not_logged_in();
    $data                     = $this->input->post();
    $array                    = array();
    $array['unit_type']       = $data['unit_type'];
    $array['name']            = $data['name'];
    $array['status']          = 1;
    $array['addDate']         = time();
    $array['modifyDate']      = time();

   $res = $this->db->insert('unit_master', $array);

     if($res > 0 ){
            $this->session->set_flashdata('message',generateAdminAlert('S',25));
            redirect(base_url('Admin/manageUnits'));
     }else{
           $this->session->set_flashdata('message',generateAdminAlert('D',12));
             redirect(base_url('Admin/manageUnits'));
     }
  }

  public function updateUnitData(){
    $id = $this->uri->segment(3);
    is_not_logged_in();
    $response['pageTitle']  = 'Manage Unit - '.ProjectName;
    $response['pageIndex']  = 'setting';
    $response['pageIndex1'] = "unit";

                              $this->db->order_by('id','desc');  
    $response['result']    = $this->db->get_where('unit_type_master')->result_array();
    $response['data']    = $this->Common_model->getDataViaId('unit_master',$id);
    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('updateUnitPage',$response);
    $this->load->view('header/footer');
  }

  public function updateUnitPost(){
    is_not_logged_in();
    $data                     = $this->input->post();
    $array                    = array();
    $array['unit_type']       = $data['unit_type'];
    $array['name']            = $data['name'];
    $array['status']          = $data['status'];
    $array['modifyDate']      = time();

    $this->db->where('id',$data['id']);
    $res = $this->db->update('unit_master', $array);

     if($res > 0 ){
            $this->session->set_flashdata('message',generateAdminAlert('S',26));
            redirect(base_url('Admin/manageUnits'));
     }else{
           $this->session->set_flashdata('message',generateAdminAlert('D',12));
             redirect(base_url('Admin/manageUnits'));
     }
  }


  public function manageUnitType(){
    is_not_logged_in();
    $response['pageTitle']  = 'Manage Unit Type - '.ProjectName;
    $response['pageIndex']  = 'setting';
    $response['pageIndex1'] = "unit";

                              $this->db->order_by('id','desc');  
    $response['result']    = $this->db->get_where('unit_type_master')->result_array();
    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('manageUnitTypeList',$response);
    $this->load->view('header/footer');
  }

  public function addUnitType(){
    is_not_logged_in();
    $response['pageTitle']  = 'Add Unit - '.ProjectName;
    $response['pageIndex']  = 'setting';
    $response['pageIndex1'] = "unit";
    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('addUnitType',$response);
    $this->load->view('header/footer');
  }

  public function addUnitTypePost(){
    is_not_logged_in();
    $data                     = $this->input->post();
    $array                    = array();
    $array['name']            = $data['name'];
    $array['status']          = 1;
    $array['addDate']         = time();


   $res = $this->db->insert('unit_type_master', $array);

     if($res > 0 ){
            $this->session->set_flashdata('message',generateAdminAlert('S',25));
            redirect(base_url('Admin/manageUnitType'));
     }else{
           $this->session->set_flashdata('message',generateAdminAlert('D',12));
             redirect(base_url('Admin/manageUnitType'));
     }
  }

  public function updateUnitTypeData(){
    $id = $this->uri->segment(3);
    is_not_logged_in();
    $response['pageTitle']  = 'Manage Unit Type - '.ProjectName;
    $response['pageIndex']  = 'setting';
    $response['pageIndex1'] = "unit";

    $response['data']    = $this->Common_model->getDataViaId('unit_type_master',$id);
    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('updateUnitTypePage',$response);
    $this->load->view('header/footer');
  }
  
  public function updateUnitTypePost(){
    is_not_logged_in();
    $data                     = $this->input->post();
    $array                    = array();

    $array['name']            = $data['name'];
    $array['status']          = $data['status'];

    $this->db->where('id',$data['id']);
    $res = $this->db->update('unit_type_master', $array);

     if($res > 0 ){
            $this->session->set_flashdata('message',generateAdminAlert('S',26));
            redirect(base_url('Admin/manageUnitType'));
     }else{
           $this->session->set_flashdata('message',generateAdminAlert('D',12));
             redirect(base_url('Admin/manageUnitType'));
     }
  }
  
  public function manageCancelReason(){
    is_not_logged_in();
    $response['pageTitle']  = 'Manage Reasons - '.ProjectName;
    $response['pageIndex']  = 'setting';
    $response['pageIndex1'] = "reason";

                              $this->db->order_by('id','desc');  
    $response['result']    = $this->db->get_where('reason_master')->result_array();
    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('reasonList',$response);
    $this->load->view('header/footer');
  }

  public function addReason(){
    is_not_logged_in();
    $response['pageTitle']  = 'Add Reason - '.ProjectName;
    $response['pageIndex']  = 'setting';
    $response['pageIndex1'] = "reason";
    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('addReason',$response);
    $this->load->view('header/footer');
  }

   public function addReasonPost(){
    is_not_logged_in();
    $data                     = $this->input->post();
    $array                    = array();
    $array['name']            = $data['name'];
    $array['type']            = $data['type'];
    $array['status']          = 1;
    $array['addDate']         = time();


   $res = $this->db->insert('reason_master', $array);

     if($res > 0 ){
            $this->session->set_flashdata('message',generateAdminAlert('S',25));
            redirect(base_url('Admin/manageCancelReason'));
     }else{
           $this->session->set_flashdata('message',generateAdminAlert('D',12));
             redirect(base_url('Admin/manageCancelReason'));
     }
  }

  public function updateReasonData(){
    $id = $this->uri->segment(3);
    is_not_logged_in();
    $response['pageTitle']  = 'Manage Reason Data - '.ProjectName;
    $response['pageIndex']  = 'setting';
    $response['pageIndex1'] = "reason";

    $response['data']    = $this->Common_model->getDataViaId('reason_master',$id);
    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('updateReason',$response);
    $this->load->view('header/footer');
  }
  
  public function updateReasonPost(){
    is_not_logged_in();
    $data                     = $this->input->post();
    $array                    = array();

    $array['name']            = $data['name'];
     $array['type']            = $data['type'];
    $array['status']          = $data['status'];

    $this->db->where('id',$data['id']);
    $res = $this->db->update('reason_master', $array);

     if($res > 0 ){
            $this->session->set_flashdata('message',generateAdminAlert('S',26));
            redirect(base_url('Admin/manageCancelReason'));
     }else{
           $this->session->set_flashdata('message',generateAdminAlert('D',12));
             redirect(base_url('Admin/manageCancelReason'));
     }
  }


   // manage vehicle list
  public function manageownervehicle(){
    is_not_logged_in();
    $owner_detail = is_not_logged_in();
    $response['pageTitle'] = 'Manage owner vehicles - '.ProjectName;
    $response['pageIndex'] = 'ownervehicle';
    $response['pageIndex1'] = "";

                              $this->db->order_by('id','desc');  
    $response['result']    = $this->db->get_where('owner_vehicle_master')->result_array();
    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('manageownervehicle',$response);
    $this->load->view('header/footer');
  }

    public function updateownervehicle(){
    is_not_logged_in();
    $id = $this->uri->segment(3);

    if($this->input->post())
    {
            $data = $this->input->post();
    $id = $data['id'];
    $array  = array();
    $array['vehicle_number']      = $data['vehicle_number'];
    $array['vehicle_master_id']   = $data['vehicle_master_id'];
    $array['vehicle_type']        = $data['vehicle_type'];
    $array['admin_approval']      = $data['status'];
    $array['modify_date']         = time();
   // $array['status']              = $data['status'];
 
    $oldvehicle_data = $this->db->get_where('owner_vehicle_master',array('id'=>$id))->row_array();

      $image6 = "";
      if(!empty($data['vehicle_left']))
      {
        $image6 = $data['vehicle_left'];
      }
       else
      {
         $image6 = $oldvehicle_data['vehicle_left'];
      }

      $image7 = "";
      if(!empty($data['vehicle_right']))
      {
        $image7 = $data['vehicle_right'];
      }
       else
      {
         $image7 = $oldvehicle_data['vehicle_right'];
      }

      $image8 = "";
      if(!empty($data['vehicle_front']))
      {
        $image8 = $data['vehicle_front'];
      }
      else
      {
         $image8 = $oldvehicle_data['vehicle_front'];
      }

      $array['vehicle_left']        = $image6;
      $array['vehicle_right']       = $image7;
      $array['vehicle_front']       = $image8;


              $this->db->where('id',$id);
      $res = $this->db->update('owner_vehicle_master', $array);

     if($res > 0 ){
            $this->session->set_flashdata('message',generateAdminAlert('S',17));
            redirect(base_url('Admin/update_registration_doc/'.$id));
     }else{
           $this->session->set_flashdata('message',generateAdminAlert('D',12));
             redirect(base_url('Admin/updateownervehicle/'.$id));
     }
    }
    else
    {

    $response['pageTitle']    = 'Update Vehicle - '.ProjectName;
    $response['pageIndex']    = 'ownervehicle';
    $response['pageIndex1']   = "";
    $response['vehicleData']  = $this->db->get_where('owner_vehicle_master',array('id'=>$id))->row_array();
    $response['capacity']     = $this->Common_model->getDataViaType('unit_master','1');
    $response['duration']     = $this->Common_model->getDataViaType('unit_master','2');

                                $this->db->order_by('name','asc');
    $response['owners']       = $this->db->get_where('owner_master',array('status'=>1))->result_array();


    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('updateownervehicle',$response);
    $this->load->view('header/footer');

    }
  }


   public function update_registration_doc()
   {
      is_not_logged_in();
      $owner_detail = is_not_logged_in();
      $id = $this->uri->segment(3);

      if ($this->input->post()) 
      {
        $data = $this->input->post();
        $id = $data['id'];
        $array  = array();
        $array['modify_date']   = time();
     
        $oldvehicle_data = $this->db->get_where('owner_vehicle_master',array('id'=>$id))->row_array();

          $image = "";
          if(!empty($data['vehicle_reg_front']))
          {
           
            $image = $data['vehicle_reg_front'];
          }
          else
          {
             $image = $oldvehicle_data['vehicle_reg_front'];
          }

          $image1 = "";
          if(!empty($data['vehicle_reg_back']))
          {
            $image1 = $data['vehicle_reg_back'];
          }
          else
          {
             $image1 = $oldvehicle_data['vehicle_reg_back'];
          }

          

          $array['vehicle_reg_front']   = $image;
          $array['vehicle_reg_back']    = $image1;
         


                  $this->db->where('id',$id);
          $res = $this->db->update('owner_vehicle_master', $array);

         if($res > 0 ){
                $this->session->set_flashdata('message',generateAdminAlert('S',17));
                redirect(base_url('Admin/update_route_permit/'.$id));
         }else{
               $this->session->set_flashdata('message',generateAdminAlert('D',12));
                 redirect(base_url('Admin/update_registration_doc/'.$id));
         }
      }
      else
      {
          $response['pageTitle']    = 'Update Vehicle - '.ProjectName;
          $response['pageIndex']    = 'ownervehicle';
          $response['pageIndex1']   = "";
          $response['vehicleData']  = $this->db->get_where('owner_vehicle_master',array('id'=>$id))->row_array();
          $response['capacity']     = $this->Common_model->getDataViaType('unit_master','1');
          $response['duration']     = $this->Common_model->getDataViaType('unit_master','2');

          $this->load->view('header/header',$response);
          $this->load->view('header/left-menu',$response);
          $this->load->view('update_registration_doc',$response);
          $this->load->view('header/footer');
      }
  }

   public function update_route_permit()
   {
      is_not_logged_in();
      $owner_detail = is_not_logged_in();
      $id = $this->uri->segment(3);

      if ($this->input->post()) 
      {
        $data = $this->input->post();
        $id = $data['id'];
        $array  = array();
        $array['modify_date']   = time();
     
        $oldvehicle_data = $this->db->get_where('owner_vehicle_master',array('id'=>$id))->row_array();

          $image2 = "";
          if(!empty($data['route_permit_front']))
          {
           
            $image2 = $data['route_permit_front'];
          }
          else
          {
             $image2 = $oldvehicle_data['route_permit_front'];
          }

          $image3 = "";
          if(!empty($data['route_permit_back']))
          {
            $image3 = $data['route_permit_back'];
          }
          else
          {
             $image3 = $oldvehicle_data['route_permit_back'];
          }

          $array['route_permit_front']  = $image2;
          $array['route_permit_back']   = $image3;
         

                  $this->db->where('id',$id);
          $res = $this->db->update('owner_vehicle_master', $array);

         if($res > 0 ){
                $this->session->set_flashdata('message',generateAdminAlert('S',17));
                redirect(base_url('Admin/update_containment/'.$id));
         }else{
               $this->session->set_flashdata('message',generateAdminAlert('D',12));
                 redirect(base_url('Admin/update_route_permit/'.$id));
         }
      }
      else
      {
          $response['pageTitle']    = 'Update Vehicle - '.ProjectName;
          $response['pageIndex']    = 'ownervehicle';
          $response['pageIndex1']   = "";
          $response['vehicleData']  = $this->db->get_where('owner_vehicle_master',array('id'=>$id))->row_array();
          $response['capacity']     = $this->Common_model->getDataViaType('unit_master','1');
          $response['duration']     = $this->Common_model->getDataViaType('unit_master','2');

          $this->load->view('header/header',$response);
          $this->load->view('header/left-menu',$response);
          $this->load->view('update_route_permit',$response);
          $this->load->view('header/footer');
      }
  }

   public function update_containment()
   {
      is_not_logged_in();
      $owner_detail = is_not_logged_in();
      $id = $this->uri->segment(3);

      if ($this->input->post()) 
      {
        $data = $this->input->post();
        $id = $data['id'];
        $array  = array();
        $array['modify_date']   = time();
     
        $oldvehicle_data = $this->db->get_where('owner_vehicle_master',array('id'=>$id))->row_array();

          $image4 = "";
          if(!empty($data['containment_front']))
          {
            
            $image4 = $data['containment_front'];
          }
          else
          {
             $image4 = $oldvehicle_data['containment_front'];
          }

          $image5 = "";
          if(!empty($data['containment_back']))
          {
            
            $image5 = $data['containment_back'];
          }
          else
          {
             $image5 = $oldvehicle_data['containment_back'];
          }

          $array['containment_front']   = $image4;
          $array['containment_back']    = $image5;
         
                  $this->db->where('id',$id);
          $res = $this->db->update('owner_vehicle_master', $array);

         if($res > 0 ){
                $this->session->set_flashdata('message',generateAdminAlert('S',17));
                redirect(base_url('Admin/manageownervehicle'));
         }else{
               $this->session->set_flashdata('message',generateAdminAlert('D',12));
                 redirect(base_url('Admin/update_containment/'.$id));
         }
      }
      else
      {
          $response['pageTitle']    = 'Update Vehicle - '.ProjectName;
          $response['pageIndex']    = 'ownervehicle';
          $response['pageIndex1']   = "";
          $response['vehicleData']  = $this->db->get_where('owner_vehicle_master',array('id'=>$id))->row_array();
          $response['capacity']     = $this->Common_model->getDataViaType('unit_master','1');
          $response['duration']     = $this->Common_model->getDataViaType('unit_master','2');

          $this->load->view('header/header',$response);
          $this->load->view('header/left-menu',$response);
          $this->load->view('update_containment',$response);
          $this->load->view('header/footer');
      }
  }



/************************************************************************************/

}
