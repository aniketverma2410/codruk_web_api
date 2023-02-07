<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Customers extends CI_Controller {
  public function __construct(){
  parent::__construct();
  $this->load->model('Customer_model');
  $this->load->model('Common_model');
  $this->load->helper('message');
  date_default_timezone_set('Asia/Kolkata');
}


/*****************************13-05-2019*********************************/

    public function status_history()
    { 
      $id = $this->uri->segment(3,0);
      $response['pageTitle']  = 'Pilot Online Status History - '.ProjectName;
      $response['pageIndex']  = 'pilot_list';
      $response['pageIndex1']  = 'pilot_list';
      $response['result'] = $this->Customer_model->getstatusdata($id);
       $search =  $this->input->post('Search');
       $search1 =  $this->input->post('Search1');
         $response['searchDate'] = date('Y');
         $response['searchDate1'] = date('m');
       if(!empty($search) || !empty($search1)):
         $response['searchDate'] = $search;
         $response['searchDate1'] = $search1;
          endif;
         $response['id'] = $id; 
      //$response['status'] = $status; 
      $this->load->view('header/header',$response);
      $this->load->view('header/left-menu',$response);
      $this->load->view('status_history',$response);
      $this->load->view('header/footer');
   }

   public function pilot_list(){
    is_not_logged_in();
    $response['pageTitle']  = 'Manage Pilots - '.ProjectName;
    $response['pageIndex']  = 'pilot_list';
    $response['pageIndex1'] = "pilot_list";
    $response['result']     = $this->Customer_model->pilot_list();

    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('pilot_list',$response);
    $this->load->view('header/footer');
  }

    public function rating_list(){
    is_not_logged_in();
    $id = $this->uri->segment(3,0);

    $response['pageTitle']  = 'Pilot Ratings - '.ProjectName;
    $response['pageIndex']  = 'pilot_list';
    $response['pageIndex1'] = "pilot_list";
    $response['result']     = $this->db->get_where('rating_master',array('driver_id'=>$id))->result_array();
    $response['driver']     = $this->db->get_where('driver_master',array('id'=>$id))->row_array();

    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('rating_list',$response);
    $this->load->view('header/footer');
  }

   // manage login History
  public function pilotloginHistory(){
    is_not_logged_in();
    $userId = $this->uri->segment(3);
    $checkUrl = $this->uri->segment(4);
    $response['pageTitle']  = 'Manage History - '.ProjectName;
    $response['pageIndex']  = 'pilot_list';
    $response['pageIndex1'] = "pilot_list";
    // for business profile list
    $response['userData']   = $this->db->get_where('driver_master',array('id'=>$userId))->row_array();
    $response['result']     = $this->Customer_model->getPilotLoginHistoryData($userId);

    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('pilotloginHistory',$response);
    $this->load->view('header/footer');
  }

    // Add vehicle data
  public function riderate(){
    is_not_logged_in();
    $userId = $this->uri->segment(3);
    $page = $_GET['page'];

    if ($this->input->post()) 
    {
        $vehicle_id = $this->input->post('vehicle_id');
        $data = $this->input->post();

        $this->db->where('user_id',$userId);
        $this->db->delete('customer_vehicle_rate');

        foreach ($vehicle_id as $key => $value) 
        {
           $insert_array['user_id']                     = $userId;
           $insert_array['vehicle_id']                  = $value;
           $insert_array['initial_charges']             = $data['initial_charges'][$key];
           $insert_array['charges_per_km']              = $data['charges_per_km'][$key];
           $insert_array['free_loading_time']           = $data['free_loading_time'][$key];
           $insert_array['waiting_charges_loading']     = $data['waiting_charges_loading'][$key];
           $insert_array['free_unloading_time']         = $data['free_unloading_time'][$key];
           $insert_array['waiting_charges_unloading']   = $data['waiting_charges_unloading'][$key];
           $insert_array['apply']                       = $data['apply'][$key];
           $insert_array['status']                      = 1;
           $insert_array['addDate']                     = time();
           $insert_array['modifyDate']                  = time();

           $res = $this->db->insert('customer_vehicle_rate',$insert_array);

        }

        if($res)
        {
            $this->session->set_flashdata('message',generateAdminAlert('S',18));
            redirect(base_url('Customers/riderate/'.$userId.'?page='.$data['page']));
        }
        else
        {
           $this->session->set_flashdata('message',generateAdminAlert('D',12));
             redirect(base_url('Customers/riderate/'.$userId.'?page='.$data['page']));
        }
       
    }
    else
    {   
        $page = $_GET['page'];
        $response['pageTitle'] = 'Update Vehicle - '.ProjectName;
        $response['pageIndex']  = 'customer';
        if ($page == 1) 
        {
          $response['pageIndex1'] = "businessList";
        }
        else
        {
           $response['pageIndex1'] = "individualList";
        }
                                    //$this->db->order_by('id','desc');  
        $response['vehicleData']  = $this->db->get_where('customer_vehicle_rate',array('user_id'=>$userId))->result_array(); 

        $response['currency']  = $this->db->get_where('settings')->row_array();
        $response['customer'] = $this->db->get_where('customer_master',array('id'=>$userId))->row_array();

                                //$this->db->order_by('id','desc');  
        $response['vehicles'] = $this->db->get_where('vehicle_master',array('status'=>1))->result_array();
        $response['user_id'] = $userId;
        $response['page'] = $page;

        $this->load->view('header/header',$response);
        $this->load->view('header/left-menu',$response);
        $this->load->view('riderate',$response);
        $this->load->view('header/footer');
    }

   
  }



    // manage login History
  public function request_history(){
    is_not_logged_in();
    $userId = $this->uri->segment(3);
    $response['pageTitle']  = 'Vehicle Request History - '.ProjectName;
    $response['pageIndex']  = 'pilot_list';
    $response['pageIndex1'] = "pilot_list";
    // for business profile list
    $response['userData']   = $this->db->get_where('driver_master',array('id'=>$userId))->row_array();
                            $this->db->order_by('id','desc');
    $response['result']   = $this->db->get_where('vehicle_request_master',array('driver_id'=>$userId))->result_array();
   
    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('request_history',$response);
    $this->load->view('header/footer');
  }

    public function updatepilot(){
    is_not_logged_in();
    $id   = $this->uri->segment(3);

    if ($this->input->post()) 
    {   
        $data = $this->input->post();

        $update_array['name']         = $data['name'];
        $update_array['email']        = $data['email'];

        $olddata = $this->db->get_where('driver_master',array('id'=>$data['id']))->row_array();

        if (!empty($data['image'])) 
        {
          $update_array['image']        = $data['image'];
        }
        else
        {
           $update_array['image']        = $olddata['image'];
        }

        if (!empty($data['licenceCopy'])) 
        {
          $update_array['licenceCopy']  = $data['licenceCopy'];
        }
        else
        {
           $update_array['licenceCopy']  = $olddata['licenceCopy'];
        }


        if (!empty($data['cnicCopy'])) 
        {
           $update_array['cnicCopy']     = $data['cnicCopy'];
        }
        else
        {
           $update_array['cnicCopy']  = $olddata['cnicCopy'];
        }

        $update_array['modifyDate']   = time();
        $update_array['status']       = $data['status'];
        $update_array['reason']       = $data['reason'];

         if ((!empty($data['reason'])) && ($data['status'] == 3)) 
        {
           $userdetails = $this->db->get_where('driver_master',array('id'=>$id))->row_array();
           $message = "Your Codruk Driver approval is rejected Reason: ".$data['reason'];
           $this->SendOtpSMS($userdetails['mobile'],$message);
        }

        $this->db->where('id',$data['id']);
        $checkdata = $this->db->update('driver_master',$update_array);

        if ($checkdata)
        {   
            $message = '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Pilot updated successfully.</div>';
            $this->session->set_flashdata('message', $message);
            redirect(site_url('Customers/pilot_list'), 'refresh'); 
        }
        else
        {
            $message = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Please try again.</div>';
            $this->session->set_flashdata('message', $message);
            redirect(site_url('Customers/updatepilot/'.$id), 'refresh');
        }   

    }    
    else
    {
        $response['pageTitle']  = 'Update Pilot - '.ProjectName;
        $response['pageIndex']  = 'pilot_list';
        $response['pageIndex1'] = "pilot_list";
       
        $response['result']     = $this->db->get_where('driver_master',array('id'=>$id))->row_array();
        $response['id']         = $id;

        $this->load->view('header/header',$response);
        $this->load->view('header/left-menu',$response);
        $this->load->view('updatepilot',$response);
        $this->load->view('header/footer');
    }
    
  }


  public function SendOtpSMS($requestMobile,$message){
    $url = "http://www.wiztechsms.com/http-api.php?username=ubaid&password=ubaid&senderid=OXPLUS&route=1&number=".$requestMobile."&message=".urlencode($message);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_exec($ch);
    return 1;
} 

  private function set_upload_options($types) {   
        //upload an image options
        $config = array();

        $fileTypes = array('jpg', 'jpeg', 'png');
        
        $config['upload_path']   = 'mediaFile/drivers/';
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
          $in_foler = 'mediaFile/drivers/'; // FOLDER PATH

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
                    
                    $set_html .='<div class="col-xs-12 set_w_admin " id="img_preview_1"><img src="'.base_url().'mediaFile/drivers/'.$img.'" class="set_image" alt="'.$img.'" id="set_image_'.$type.'"><div class="col-xs-12 set_success"><span class="success">Success</span></div><div class="progress col-xs-12 divPadding" style="margin: 0;"><div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%"></div></div></div>';
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

  /*************************************End*******************************************/
  
  // manage list
  public function customerList(){
    is_not_logged_in();
    $response['pageTitle']  = 'Manage dashboard - '.ProjectName;
    $response['pageIndex']  = 'customer';
    $response['pageIndex1'] = "customerWithoutLogin";
    $response['result']     = $this->Customer_model->manageCustomers();

    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('manageCustomers',$response);
    $this->load->view('header/footer');
  }

    public function manageownerloginhistory(){
    is_not_logged_in();
    $id = $this->uri->segment(3,0);
    $response['pageTitle']  = 'Owner Login History - '.ProjectName;
    $response['pageIndex']  = 'owner';
    $response['pageIndex1'] = "owner";
                              $this->db->order_by('id','desc');  
    $response['result']     = $this->db->get_where('owner_login_history',array('owner_id'=>$id))->result_array();
    $response['userData'] = $this->db->get_where('owner_master',array('id'=>$id))->row_array();

    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('manageownerloginhistory',$response);
    $this->load->view('header/footer');
  }

    public function ownerlist(){
    is_not_logged_in();
    $response['pageTitle']  = 'Manage Owner - '.ProjectName;
    $response['pageIndex']  = 'owner';
    $response['pageIndex1'] = "owner";
                              $this->db->order_by('id','desc');  
    $response['result']     = $this->db->get_where('owner_master',array('status!='=>3))->result_array();

    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('ownerlist',$response);
    $this->load->view('header/footer');
  }

   public function staff_list(){
    is_not_logged_in();
    $response['pageTitle']  = 'Manage Staff - '.ProjectName;
    $response['pageIndex']  = 'staff';
    $response['pageIndex1'] = "staff";
                              $this->db->order_by('id','desc');  
    $response['result']     = $this->db->get_where('staff_master',array('status!='=>3))->result_array();

    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('staff_list',$response);
    $this->load->view('header/footer');
  }

  public function add_staff(){
    is_not_logged_in();

    if ($this->input->post()) 
    {   
        $dataArray['uuid']             = rand('999999','100000');
        $dataArray['name']        = $this->input->post('name');
        $dataArray['email']       = $this->input->post('email');
        $dataArray['mobile']      = $this->input->post('mobile');
        $dataArray['password']    = $this->input->post('password');
        $dataArray['add_date']    = time();
        $dataArray['modify_date'] = time();
        $dataArray['status']      = 1;

        $data = $this->db->insert('staff_master',$dataArray);
        if ($data)
        {   
            $message = '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Staff added successfully.</div>';
            $this->session->set_flashdata('message', $message);
            redirect(site_url('Customers/staff_list'), 'refresh'); 
        }
        else
        {
            $message = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Please try again.</div>';
            $this->session->set_flashdata('message', $message);
            redirect(site_url('Customers/add_staff'), 'refresh');
        }   

    }
    else
    {
        $response['pageTitle']  = 'Manage Staff - '.ProjectName;
        $response['pageIndex']  = 'staff';
        $response['pageIndex1'] = "staff";
                                  $this->db->order_by('id','desc');  
        $response['result']     = $this->db->get_where('staff_master',array('status!='=>3))->result_array();

        $this->load->view('header/header',$response);
        $this->load->view('header/left-menu',$response);
        $this->load->view('add_staff',$response);
        $this->load->view('header/footer');
    }
    
  }

      public function edit_staff(){
    is_not_logged_in();
    $staff_id = $this->uri->segment(3,0);
    if ($this->input->post()) 
    {   
        $id = $this->input->post('id');
        $dataArray['name']        = $this->input->post('name');
        $dataArray['email']       = $this->input->post('email');
        $dataArray['mobile']      = $this->input->post('mobile');
        $dataArray['password']    = $this->input->post('password');
        $dataArray['modify_date'] = time();
        $dataArray['status']      = $this->input->post('status');

                $this->db->where('id',$id);
        $data = $this->db->update('staff_master',$dataArray);
        if ($data)
        {   
            $message = '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Staff updated successfully.</div>';
            $this->session->set_flashdata('message', $message);
            redirect(site_url('Customers/staff_list'), 'refresh'); 
        }
        else
        {
            $message = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Please try again.</div>';
            $this->session->set_flashdata('message', $message);
            redirect(site_url('Customers/edit_staff/'.$staff_id), 'refresh');
        }   

    }
    else
    {
        $response['pageTitle']  = 'Manage Staff - '.ProjectName;
        $response['pageIndex']  = 'staff';
        $response['pageIndex1'] = "staff";
        $response['result']     = $this->db->get_where('staff_master',array('id'=>$staff_id))->row_array();

        $this->load->view('header/header',$response);
        $this->load->view('header/left-menu',$response);
        $this->load->view('edit_staff',$response);
        $this->load->view('header/footer');
    }
    
  }

     public function check_mail()
    {   
        $email = $this->input->post('email');
        $check_email = $this->db->get_where('staff_master',array('email'=>$email,'status!='=>3))->row_array();
        $admin_email = $this->db->get_where('admin_master')->row_array();
        
        if (!empty($check_email) || ($email == $admin_email['username']))
        {
            echo "0";
        }
        else
        {
            echo "1";
        }
    }

        public function check_mail_new()
    {   
        $email     = $this->input->post('email');
        $old_email = $this->input->post('old_email');

        $check_email = $this->db->get_where('staff_master',array('email'=>$email,'email!='=>$old_email,'status!='=>3))->row_array();
        $admin_email = $this->db->get_where('admin_master')->row_array();
        
        if (!empty($check_email) || ($email == $admin_email['username']))
        {
            echo "0";
        }
        else
        {
            echo "1";
        }
    }

         public function check_mobile()
    {   
        $mobile = $this->input->post('mobile');
        $check_email = $this->db->get_where('staff_master',array('mobile'=>$mobile,'status!='=>3))->row_array();
        if (!empty($check_email))
        {
            echo "0";
        }
        else
        {
            echo "1";
        }
    }

         public function check_mobile_new()
    {   
        $mobile = $this->input->post('mobile');
        $old_mobile = $this->input->post('old_mobile');

        $check_email = $this->db->get_where('staff_master',array('mobile'=>$mobile,'mobile!='=>$old_mobile,'status!='=>3))->row_array();
        
        if (!empty($check_email))
        {
            echo "0";
        }
        else
        {
            echo "1";
        }
    }

    public function check_mobile_number()
    {   
        $mobile = $this->input->post('mobile');
        $checkmobile = $this->db->get_where('owner_master',array('mobile'=>$mobile,'status!='=>3))->row_array();
        if (!empty($checkmobile))
        {
            echo "0";
        }
        else
        {
            echo "1";
        }
    }

     public function add_owner()
    {   
        is_not_logged_in();
        $logindata = is_not_logged_in();

         $postData['name']              = $this->input->post('name');
        
        $this->form_validation->set_rules('name', 'Name', 'trim|required');

        if ($this->form_validation->run() == TRUE)
        {   
            $postData['email']              = $this->input->post('email');
            $postData['mobile']             = $this->input->post('mobile');
            $postData['password']           = $this->input->post('password');
            $postData['uuid']               = 'Own'.rand('99999','10000');
            $postData['otp']                = rand('999999','100000');
            $postData['otp_verify_status']  = 1;
            $postData['add_date']           = time();
            $postData['modify_date']        = time();
            $postData['status']             = 1;

            $data = $this->db->insert('owner_master',$postData);    

            if ($data)
            {   
                $message = '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Owner added successfully.</div>';
                $this->session->set_flashdata('message', $message);
                redirect(site_url('Customers/ownerlist'), 'refresh'); 
            }
            else
            {
                $message = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Please try again.</div>';
                $this->session->set_flashdata('message', $message);
                redirect(site_url('Customers/add_owner'), 'refresh');
            }   
        }
        else
        {   
            $data['logindata'] = $logindata;
            $data['pageTitle']  = 'Add Owner - '.ProjectName;
            $data['pageIndex']  = 'owner';
            $data['pageIndex1'] = "owner";
            $this->load->view('header/header',$data);
            $this->load->view('header/left-menu',$data);
            $this->load->view('add_owner',$data);
            $this->load->view('header/footer');
        }
    }


   public function updateowner()
    {   
        is_not_logged_in();
        $logindata = is_not_logged_in();
        $id = $this->uri->segment(3,0);

         $postData['name']              = $this->input->post('name');
        
        $this->form_validation->set_rules('name', 'Name', 'trim|required');

        if ($this->form_validation->run() == TRUE)
        {   
            
            $postData['email']        = $this->input->post('email');
            $postData['mobile']       = $this->input->post('mobile');
            $postData['modify_date']  = time();
            $postData['status']       = $this->input->post('status');


                    $this->db->where('id',$id);
            $data = $this->db->update('owner_master',$postData);    

            if ($data)
            {   
                $message = '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Owner updated successfully.</div>';
                $this->session->set_flashdata('message', $message);
                redirect(site_url('Customers/ownerlist'), 'refresh'); 
            }
            else
            {
                $message = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Please try again.</div>';
                $this->session->set_flashdata('message', $message);
                redirect(site_url('Customers/updateowner/'.$id), 'refresh');
            }   
        }
        else
        {   
            $data['result'] = $this->db->get_where('owner_master',array('id'=>$id))->row_array();
            $data['logindata'] = $logindata;
            $data['id'] = $id;
            $data['pageTitle']  = 'Update Owner - '.ProjectName;
            $data['pageIndex']  = 'owner';
            $data['pageIndex1'] = "owner";
            $this->load->view('header/header',$data);
            $this->load->view('header/left-menu',$data);
            $this->load->view('updateowner',$data);
            $this->load->view('header/footer');
        }
    }


  public function updateCustomers(){
    is_not_logged_in();
    $id   = $this->uri->segment(3);
    $case = $this->uri->segment(4);
    $response['pageTitle']  = 'Manage dashboard - '.ProjectName;
    $response['pageIndex']  = 'customer';
    if ($case == 1) {
      $response['pageIndex1'] = "customerWithoutLogin";
    }else{
      $response['pageIndex1'] = "individualList";
    }
    $response['result']     = $this->db->get_where('customer_master',array('id'=>$id))->row_array();
    $response['id']         = $id;
    $response['case']       = $case;

    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('updateCustomers',$response);
    $this->load->view('header/footer');
  }

  public function updateCustomerPost(){
    is_not_logged_in();
    $data             = $this->input->post();
    $array            = array();
    $array['name']    = $data['name'];
    $array['status']  = $data['status'];
    $array['dob']     = $data['dob'];
    $array['gender']  = $data['gender'];

    $getData    = $this->db->get_where('customer_master',array('id'=>$data['id']))->row_array();
    if(!empty($_FILES['image']['name']))
    {
      $name = 'image';
      $path  = CUSTOMER_DIRECTORY.'mediaFile/customers/';
      $image = $this->Common_model->upload_userimg($_FILES['image']['name'],$path,$name);
    }else{
     $image = $getData['image'];
    }
    $array['image']  = $image;
    
    $this->db->where('id', $data['id']);
   $res = $this->db->update('customer_master', $array);
   if ($data['case'] == 1) {
     if($res > 0 ){
            $this->session->set_flashdata('message',generateAdminAlert('S',2));
            redirect(base_url('Customers/customerList'));
     }else{
           $this->session->set_flashdata('message',generateAdminAlert('D',12));
             redirect(base_url('Customers/customerList'));
     }
  }else{
     if($res > 0 ){
            $this->session->set_flashdata('message',generateAdminAlert('S',2));
            redirect(base_url('Customers/manageIndividual'));
     }else{
           $this->session->set_flashdata('message',generateAdminAlert('D',12));
             redirect(base_url('Customers/manageIndividual'));
     }
   }

  }

  // manage business list
  public function manageBusiness(){
    is_not_logged_in();
    $response['pageTitle']  = 'Manage dashboard - '.ProjectName;
    $response['pageIndex']  = 'customer';
    $response['pageIndex1'] = "businessList";
    // for business profile list
    $response['result']     = $this->Customer_model->getCustomerViaType('1');

    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('manageBusinessList',$response);
    $this->load->view('header/footer');
  }

  // manage login History
  public function manageloginHistory(){
    is_not_logged_in();
    $userId = $this->uri->segment(3);
    $checkUrl = $this->uri->segment(4);
    $response['pageTitle']  = 'Manage History - '.ProjectName;
    $response['pageIndex']  = 'customer';
    if ($checkUrl == 1) {
      $response['pageIndex1'] = "businessList";
    }else{
      $response['pageIndex1'] = "individualList";
    }

    // for business profile list
    $response['userData']   = $this->db->get_where('customer_master',array('id'=>$userId))->row_array();
    $response['result']     = $this->Customer_model->getLoginHistoryData($userId);

    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('loginHistory',$response);
    $this->load->view('header/footer');
  }

  // manage business list
  public function manageIndividual(){
    is_not_logged_in();
    $response['pageTitle']  = 'Manage dashboard - '.ProjectName;
    $response['pageIndex']  = 'customer';
    $response['pageIndex1'] = "individualList";
    // for business profile list
    $response['result']     = $this->Customer_model->getCustomerViaType('2');

    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('manageIndividualList',$response);
    $this->load->view('header/footer');
  }



  public function updateBusinessCustomers(){
    is_not_logged_in();
    $id   = $this->uri->segment(3);
    $response['pageTitle']  = 'Manage dashboard - '.ProjectName;
    $response['pageIndex']  = 'customer';
    $response['pageIndex1'] = "businessList";
    $response['result']     = $this->db->get_where('customer_master',array('id'=>$id))->row_array();
    $response['id']         = $id;


    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('updateBusinessCustomers',$response);
    $this->load->view('header/footer');
  }


  public function updateBusinessCustomerPost(){
    is_not_logged_in();
    $data             = $this->input->post();
    $array            = array();
    $array['name']    = $data['name'];
    $array['status']  = $data['status'];
    $array['companyName']     = $data['companyName'];
    $array['companyRegNumber']  = $data['companyRegNumber'];
    $array['companyVatNumber']  = $data['companyVatNumber'];

    $getData    = $this->db->get_where('customer_master',array('id'=>$data['id']))->row_array();
    if(!empty($_FILES['image']['regCopy']))
    {
      $name = 'image';
      $path  = CUSTOMER_DIRECTORY.'mediaFile/customers/document/';
      $regImage = $this->Common_model->upload_userimg($_FILES['image']['regCopy'],$path,$name);
    }else{
     $regImage = $getData['regCopy'];
    }
    $array['regCopy']  = $regImage;
//19265

    if(!empty($_FILES['image']['vatCopy']))
    {
      $name = 'image';
      $path  = CUSTOMER_DIRECTORY.'mediaFile/customers/document/';
      $vatCopy = $this->Common_model->upload_userimg($_FILES['image']['vatCopy'],$path,$name);
    }else{
     $vatCopy = $getData['vatCopy'];
    }
    $array['vatCopy']  = $vatCopy;


    $this->db->where('id', $data['id']);
    $res = $this->db->update('customer_master', $array);
     if($res > 0 ){
            $this->session->set_flashdata('message',generateAdminAlert('S',2));
            redirect(base_url('Customers/manageBusiness'));
     }else{
           $this->session->set_flashdata('message',generateAdminAlert('D',12));
             redirect(base_url('Customers/manageBusiness'));
     }

  }


  public function pilot_cancel_rides()
  {
    is_not_logged_in();
    $first = $_GET['first'];
    $userId = $this->uri->segment(3,0);
    $response['pageTitle']  = 'Cancelled Rides - '.ProjectName;
    $response['pageIndex']  = '';
    $response['pageIndex1'] = "";

               $this->db->order_by('id','desc'); 
    $list    = $this->db->get_where('ride_master',array('driver_id'=>$userId,'status'=>2))->result_array();
    $table   = ""; 

      $i = 1;
      foreach($list as $row)
      {
          $table .= '<tr id="row_'.$row['id'].'">';
          $table .= '<td>'.$i.'</td>';
          $table .= '<td>'.$row['bookingId'].'</td>';
          $table .= '<td>'.date('dS M Y h:i A',$row['addDate']).'</td>';
          $table .= '<td>'.date('dS M Y h:i A',$row['modifyDate']).'</td>';
          $table .= '<td>'.$row['vehicle_number'].'</td>';
          $table .= '<td>'.$row['totalCharge'].'</td>';
          if ($first == 1) 
          {
             $table .= '<td class="action">
              <a href="'.base_url("Rides/cancel_ride_details/".$row['id']."?first=1&tr=1").'" class=""><button type="button" class="btn btn-default">View</button></a>
              </td>';
          }
          else
          {
             $table .= '<td class="action">
              <a href="'.base_url("Rides/cancel_ride_details/".$row['id']."?first=2&tr=2").'" class=""><button type="button" class="btn btn-default">View</button></a>
              </td>';
          }
          $table .= '</tr>';
          $i++;
      }

     $response['driver'] = $this->db->get_where('driver_master',array('id'=>$userId))->row_array();

    $response['table'] = $table;

    if ($first == 1) 
    {
       $response['cancel']     = "Customers/pilot_cancel_rides/".$userId."?first=1";
       $response['running']    = "Customers/pilot_running_rides/".$userId."?first=1";
       $response['completed']  = "Customers/pilot_completed_rides/".$userId."?first=1";
    }
    else
    {
       $response['cancel']  = "Customers/pilot_cancel_rides/".$userId."?first=2";
       $response['running']  = "Customers/pilot_running_rides/".$userId."?first=2";
       $response['completed']  = "Customers/pilot_completed_rides/".$userId."?first=2";
    }



    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('pilot_cancel_rides',$response);
    $this->load->view('header/footer');
  }


    public function pilot_completed_rides()
  {
    is_not_logged_in();

    $first = $_GET['first'];
    $userId = $this->uri->segment(3,0);
    $response['pageTitle']  = 'Completed Rides - '.ProjectName;
    $response['pageIndex']  = '';
    $response['pageIndex1'] = "";

                $this->db->order_by('id','desc');
     $list    = $this->db->get_where('ride_master',array('driver_id'=>$userId,'status'=>3))->result_array();
     $table = ""; 

      $i = 1;
      foreach($list as $row)
      {
          $table .= '<tr id="row_'.$row['id'].'">';
          $table .= '<td>'.$i.'</td>';
          $table .= '<td>'.$row['bookingId'].'</td>';
          $table .= '<td>'.date('dS M Y h:i A',$row['completed_date']).'</td>';
          $table .= '<td>'.$row['vehicle_number'].'</td>';
          $table .= '<td>'.$row['totalCharge'].'</td>';

          if ($first == 1) 
          {
             $table .= '<td class="action">
              <a href="'.base_url("Rides/completed_ride_details/".$row['id']."?first=1&tr=1").'" class=""><button type="button" class="btn btn-default">View</button></a>
              </td>';
          }
          else
          {
             $table .= '<td class="action">
              <a href="'.base_url("Rides/completed_ride_details/".$row['id']."?first=2&tr=2").'" class=""><button type="button" class="btn btn-default">View</button></a>
              </td>';
          }
         
          $table .= '</tr>';
          $i++;
      }

       if ($first == 1) 
    {
       $response['cancel']     = "Customers/pilot_cancel_rides/".$userId."?first=1";
       $response['running']    = "Customers/pilot_running_rides/".$userId."?first=1";
       $response['completed']  = "Customers/pilot_completed_rides/".$userId."?first=1";
    }
    else
    {
       $response['cancel']  = "Customers/pilot_cancel_rides/".$userId."?first=2";
       $response['running']  = "Customers/pilot_running_rides/".$userId."?first=2";
       $response['completed']  = "Customers/pilot_completed_rides/".$userId."?first=2";
    }

     $response['driver'] = $this->db->get_where('driver_master',array('id'=>$userId))->row_array();

    $response['table'] = $table;

    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('pilot_completed_rides',$response);
    $this->load->view('header/footer');
  }

        // manage list
  public function pilot_running_rides(){
    is_not_logged_in();
    $first = $_GET['first'];
    $userId = $this->uri->segment(3,0);
    $response['pageTitle']  = 'Running Rides - '.ProjectName;
    $response['pageIndex']  = '';
    $response['pageIndex1'] = "";

                $this->db->order_by('id','desc');
     $list    = $this->db->get_where('ride_master',array('driver_id'=>$userId,'status'=>4))->result_array();
    $table = ""; 

      $i = 1;
      foreach($list as $row)
      {
          $table .= '<tr id="row_'.$row['id'].'">';
          $table .= '<td>'.$i.'</td>';
          $table .= '<td>'.$row['bookingId'].'</td>';
          $table .= '<td>'.date('dS M Y h:i A',$row['addDate']).'</td>';
          $table .= '<td>'.$row['vehicle_number'].'</td>';
          $table .= '<td>'.$row['totalCharge'].'</td>';
          if ($first == 1) 
          {
             $table .= '<td class="action">
              <a href="'.base_url("Rides/running_ride_details/".$row['id']."?first=1&tr=1").'" class=""><button type="button" class="btn btn-default">View</button></a>
              </td>';
          }
          else
          {
             $table .= '<td class="action">
              <a href="'.base_url("Rides/running_ride_details/".$row['id']."?first=2&tr=2").'" class=""><button type="button" class="btn btn-default">View</button></a>
              </td>';
          }
         
          $table .= '</tr>';
          $i++;
      }

       if ($first == 1) 
    {
       $response['cancel']     = "Customers/pilot_cancel_rides/".$userId."?first=1";
       $response['running']    = "Customers/pilot_running_rides/".$userId."?first=1";
       $response['completed']  = "Customers/pilot_completed_rides/".$userId."?first=1";
    }
    else
    {
       $response['cancel']  = "Customers/pilot_cancel_rides/".$userId."?first=2";
       $response['running']  = "Customers/pilot_running_rides/".$userId."?first=2";
       $response['completed']  = "Customers/pilot_completed_rides/".$userId."?first=2";
    }

     $response['driver'] = $this->db->get_where('driver_master',array('id'=>$userId))->row_array();

    $response['table'] = $table;

    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('pilot_running_rides',$response);
    $this->load->view('header/footer');
  }



    // manage list
  public function customer_pending_rides(){
    is_not_logged_in();

    $first = $_GET['first'];
    $userId = $this->uri->segment(3,0);
    $response['pageTitle']  = 'Pending Rides - '.ProjectName;
    $response['pageIndex']  = '';
    $response['pageIndex1'] = "";

                $this->db->order_by('id','desc');
     $list    = $this->db->get_where('ride_master',array('userId'=>$userId,'status'=>1))->result_array();
    $table = ""; 

      $i = 1;
      foreach($list as $row)
      {
          $table .= '<tr id="row_'.$row['id'].'">';
          $table .= '<td>'.$i.'</td>';
          $table .= '<td>'.$row['bookingId'].'</td>';

          $customer = $this->db->get_where('customer_master',array('id'=>$row['userId']))->row_array();

         /* $table .= '<td>'.(!empty($customer['name'])?ucfirst($customer['name']):"N/A").'</td>';
          $table .= '<td>'.(!empty($customer['email'])?$customer['email']:"N/A").'</td>';
          $table .= '<td>'.(!empty($customer['mobile'])?$customer['mobile']:"N/A").'</td>';*/

          $table .= '<td>'.date('dS M Y h:i A',$row['addDate']).'</td>';

         // $vehicle = $this->db->get_where('owner_vehicle_master',array('id'=>$row['vehicle_id']))->row_array();
          $table .= '<td>'.$row['vehicle_number'].'</td>';

          $table .= '<td>'.$row['totalCharge'].'</td>';

          if ($first == 1) 
          {
             $table .= '<td class="action">
              <a href="'.base_url("Rides/pending_ride_details/".$row['id']."?first=1&tr=1").'" class=""><button type="button" class="btn btn-default">View</button></a>
              </td>';
          }
          else
          {
             $table .= '<td class="action">
              <a href="'.base_url("Rides/pending_ride_details/".$row['id']."?first=2&tr=1").'" class=""><button type="button" class="btn btn-default">View</button></a>
              </td>';
          }
         
          $table .= '</tr>';
          $i++;
      }

       if ($first == 1) 
    {
       $response['pending'] = "Customers/customer_pending_rides/".$userId."?first=1";
       $response['cancel']  = "Customers/customer_cancel_rides/".$userId."?first=1";
       $response['running']  = "Customers/customer_running_rides/".$userId."?first=1";
       $response['completed']  = "Customers/customer_completed_rides/".$userId."?first=1";
    }
    else
    {
       $response['pending'] = "Customers/customer_pending_rides/".$userId."?first=2";
       $response['cancel']  = "Customers/customer_cancel_rides/".$userId."?first=2";
       $response['running']  = "Customers/customer_running_rides/".$userId."?first=2";
       $response['completed']  = "Customers/customer_completed_rides/".$userId."?first=2";
    }


    $response['customer'] = $this->db->get_where('customer_master',array('id'=>$userId))->row_array();

    $response['table'] = $table;

    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('customer_pending_rides',$response);
    $this->load->view('header/footer');
  }

 
  public function customer_cancel_rides(){
    is_not_logged_in();
    $first = $_GET['first'];
    $userId = $this->uri->segment(3,0);
    $response['pageTitle']  = 'Cancelled Rides - '.ProjectName;
    $response['pageIndex']  = '';
    $response['pageIndex1'] = "";

               $this->db->order_by('id','desc'); 
    $list    = $this->db->get_where('ride_master',array('userId'=>$userId,'status'=>2))->result_array();
    $table   = ""; 

      $i = 1;
      foreach($list as $row)
      {
          $table .= '<tr id="row_'.$row['id'].'">';
          $table .= '<td>'.$i.'</td>';
          $table .= '<td>'.$row['bookingId'].'</td>';

          $customer = $this->db->get_where('customer_master',array('id'=>$row['userId']))->row_array();

          /* $table .= '<td>'.(!empty($customer['name'])?ucfirst($customer['name']):"N/A").'</td>';
          $table .= '<td>'.(!empty($customer['email'])?$customer['email']:"N/A").'</td>';
          $table .= '<td>'.(!empty($customer['mobile'])?$customer['mobile']:"N/A").'</td>';*/
          $table .= '<td>'.date('dS M Y h:i A',$row['addDate']).'</td>';
           $table .= '<td>'.date('dS M Y h:i A',$row['modifyDate']).'</td>';
            // $vehicle = $this->db->get_where('owner_vehicle_master',array('id'=>$row['vehicle_id']))->row_array();
          $table .= '<td>'.$row['vehicle_number'].'</td>';

          $table .= '<td>'.$row['totalCharge'].'</td>';
          if ($first == 1) 
          {
             $table .= '<td class="action">
              <a href="'.base_url("Rides/cancel_ride_details/".$row['id']."?first=1&tr=1").'" class=""><button type="button" class="btn btn-default">View</button></a>
              </td>';
          }
          else
          {
             $table .= '<td class="action">
              <a href="'.base_url("Rides/cancel_ride_details/".$row['id']."?first=2&tr=1").'" class=""><button type="button" class="btn btn-default">View</button></a>
              </td>';
          }
          $table .= '</tr>';
          $i++;
      }

     $response['customer'] = $this->db->get_where('customer_master',array('id'=>$userId))->row_array();

    $response['table'] = $table;

    if ($first == 1) 
    {
       $response['pending'] = "Customers/customer_pending_rides/".$userId."?first=1";
       $response['cancel']  = "Customers/customer_cancel_rides/".$userId."?first=1";
       $response['running']  = "Customers/customer_running_rides/".$userId."?first=1";
       $response['completed']  = "Customers/customer_completed_rides/".$userId."?first=1";
    }
    else
    {
       $response['pending'] = "Customers/customer_pending_rides/".$userId."?first=2";
       $response['cancel']  = "Customers/customer_cancel_rides/".$userId."?first=2";
       $response['running']  = "Customers/customer_running_rides/".$userId."?first=2";
       $response['completed']  = "Customers/customer_completed_rides/".$userId."?first=2";
    }



    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('customer_cancel_rides',$response);
    $this->load->view('header/footer');
  }


     // manage list
  public function customer_completed_rides(){
    is_not_logged_in();

    $first = $_GET['first'];
    $userId = $this->uri->segment(3,0);
    $response['pageTitle']  = 'Completed Rides - '.ProjectName;
    $response['pageIndex']  = '';
    $response['pageIndex1'] = "";

                $this->db->order_by('id','desc');
     $list    = $this->db->get_where('ride_master',array('userId'=>$userId,'status'=>3))->result_array();
     $table = ""; 

      $i = 1;
      foreach($list as $row)
      {
          $table .= '<tr id="row_'.$row['id'].'">';
          $table .= '<td>'.$i.'</td>';
          $table .= '<td>'.$row['bookingId'].'</td>';

          $customer = $this->db->get_where('customer_master',array('id'=>$row['userId']))->row_array();

         /* $table .= '<td>'.(!empty($customer['name'])?ucfirst($customer['name']):"N/A").'</td>';
          $table .= '<td>'.(!empty($customer['email'])?$customer['email']:"N/A").'</td>';
          $table .= '<td>'.(!empty($customer['mobile'])?$customer['mobile']:"N/A").'</td>';*/

          $table .= '<td>'.date('dS M Y h:i A',$row['completed_date']).'</td>';
           // $vehicle = $this->db->get_where('owner_vehicle_master',array('id'=>$row['vehicle_id']))->row_array();
          $table .= '<td>'.$row['vehicle_number'].'</td>';

          $table .= '<td>'.$row['totalCharge'].'</td>';

          if ($first == 1) 
          {
             $table .= '<td class="action">
              <a href="'.base_url("Rides/completed_ride_details/".$row['id']."?first=1&tr=1").'" class=""><button type="button" class="btn btn-default">View</button></a>
              </td>';
          }
          else
          {
             $table .= '<td class="action">
              <a href="'.base_url("Rides/completed_ride_details/".$row['id']."?first=2&tr=1").'" class=""><button type="button" class="btn btn-default">View</button></a>
              </td>';
          }
         
          $table .= '</tr>';
          $i++;
      }

       if ($first == 1) 
    {
       $response['pending'] = "Customers/customer_pending_rides/".$userId."?first=1";
       $response['cancel']  = "Customers/customer_cancel_rides/".$userId."?first=1";
       $response['running']  = "Customers/customer_running_rides/".$userId."?first=1";
       $response['completed']  = "Customers/customer_completed_rides/".$userId."?first=1";
    }
    else
    {
       $response['pending'] = "Customers/customer_pending_rides/".$userId."?first=2";
       $response['cancel']  = "Customers/customer_cancel_rides/".$userId."?first=2";
       $response['running']  = "Customers/customer_running_rides/".$userId."?first=2";
       $response['completed']  = "Customers/customer_completed_rides/".$userId."?first=2";
    }

    $response['customer'] = $this->db->get_where('customer_master',array('id'=>$userId))->row_array();

    $response['table'] = $table;

    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('customer_completed_rides',$response);
    $this->load->view('header/footer');
  }


      // manage list
  public function customer_running_rides(){
    is_not_logged_in();
    $first = $_GET['first'];
    $userId = $this->uri->segment(3,0);
    $response['pageTitle']  = 'Running Rides - '.ProjectName;
    $response['pageIndex']  = '';
    $response['pageIndex1'] = "";

                $this->db->order_by('id','desc');
     $list    = $this->db->get_where('ride_master',array('userId'=>$userId,'status'=>4))->result_array();
    $table = ""; 

      $i = 1;
      foreach($list as $row)
      {
          $table .= '<tr id="row_'.$row['id'].'">';
          $table .= '<td>'.$i.'</td>';
          $table .= '<td>'.$row['bookingId'].'</td>';

          $customer = $this->db->get_where('customer_master',array('id'=>$row['userId']))->row_array();

         /* $table .= '<td>'.(!empty($customer['name'])?ucfirst($customer['name']):"N/A").'</td>';
          $table .= '<td>'.(!empty($customer['email'])?$customer['email']:"N/A").'</td>';
          $table .= '<td>'.(!empty($customer['mobile'])?$customer['mobile']:"N/A").'</td>';*/

          $table .= '<td>'.date('dS M Y h:i A',$row['addDate']).'</td>';
           // $vehicle = $this->db->get_where('owner_vehicle_master',array('id'=>$row['vehicle_id']))->row_array();
          $table .= '<td>'.$row['vehicle_number'].'</td>';

          $table .= '<td>'.$row['totalCharge'].'</td>';

          if ($first == 1) 
          {
             $table .= '<td class="action">
              <a href="'.base_url("Rides/running_ride_details/".$row['id']."?first=1&tr=1").'" class=""><button type="button" class="btn btn-default">View</button></a>
              </td>';
          }
          else
          {
             $table .= '<td class="action">
              <a href="'.base_url("Rides/running_ride_details/".$row['id']."?first=2&tr=1").'" class=""><button type="button" class="btn btn-default">View</button></a>
              </td>';
          }
         
          $table .= '</tr>';
          $i++;
      }

       if ($first == 1) 
    {
       $response['pending'] = "Customers/customer_pending_rides/".$userId."?first=1";
       $response['cancel']  = "Customers/customer_cancel_rides/".$userId."?first=1";
       $response['running']  = "Customers/customer_running_rides/".$userId."?first=1";
       $response['completed']  = "Customers/customer_completed_rides/".$userId."?first=1";
    }
    else
    {
       $response['pending'] = "Customers/customer_pending_rides/".$userId."?first=2";
       $response['cancel']  = "Customers/customer_cancel_rides/".$userId."?first=2";
       $response['running']  = "Customers/customer_running_rides/".$userId."?first=2";
       $response['completed']  = "Customers/customer_completed_rides/".$userId."?first=2";
    }


    $response['customer'] = $this->db->get_where('customer_master',array('id'=>$userId))->row_array();

    $response['table'] = $table;

    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('customer_running_rides',$response);
    $this->load->view('header/footer');
  }





     // manage list
  public function owner_pending_rides(){
    is_not_logged_in();

    $first = $_GET['first'];
    $userId = $this->uri->segment(3,0);
    $response['pageTitle']  = 'Pending Rides - '.ProjectName;
    $response['pageIndex']  = '';
    $response['pageIndex1'] = "";

                $this->db->order_by('id','desc');
     $list    = $this->db->get_where('ride_master',array('vehicle_owner_id'=>$userId,'status'=>1))->result_array();
    $table = ""; 

      $i = 1;
      foreach($list as $row)
      {
          $table .= '<tr id="row_'.$row['id'].'">';
          $table .= '<td>'.$i.'</td>';
          $table .= '<td>'.$row['bookingId'].'</td>';

          $customer = $this->db->get_where('customer_master',array('id'=>$row['userId']))->row_array();

         /* $table .= '<td>'.(!empty($customer['name'])?ucfirst($customer['name']):"N/A").'</td>';
          $table .= '<td>'.(!empty($customer['email'])?$customer['email']:"N/A").'</td>';
          $table .= '<td>'.(!empty($customer['mobile'])?$customer['mobile']:"N/A").'</td>';*/

          $table .= '<td>'.date('dS M Y h:i A',$row['addDate']).'</td>';

         // $vehicle = $this->db->get_where('owner_vehicle_master',array('id'=>$row['vehicle_id']))->row_array();
          $table .= '<td>'.$row['vehicle_number'].'</td>';

          $table .= '<td>'.$row['totalCharge'].'</td>';

          if ($first == 1) 
          {
             $table .= '<td class="action">
              <a href="'.base_url("Rides/pending_ride_details/".$row['id']."?first=1&tr=1").'" class=""><button type="button" class="btn btn-default">View</button></a>
              </td>';
          }
          else
          {
             $table .= '<td class="action">
              <a href="'.base_url("Rides/pending_ride_details/".$row['id']."?first=2&tr=3").'" class=""><button type="button" class="btn btn-default">View</button></a>
              </td>';
          }
         
          $table .= '</tr>';
          $i++;
      }

       if ($first == 1) 
      {
         $response['pending'] = "Customers/owner_pending_rides/".$userId."?first=1";
         $response['cancel']  = "Customers/owner_cancel_rides/".$userId."?first=1";
         $response['running']  = "Customers/owner_running_rides/".$userId."?first=1";
         $response['completed']  = "Customers/owner_completed_rides/".$userId."?first=1";
      }
      else
      {
         $response['pending'] = "Customers/owner_pending_rides/".$userId."?first=2";
         $response['cancel']  = "Customers/owner_cancel_rides/".$userId."?first=2";
         $response['running']  = "Customers/owner_running_rides/".$userId."?first=2";
         $response['completed']  = "Customers/owner_completed_rides/".$userId."?first=2";
      }


    $response['customer'] = $this->db->get_where('owner_master',array('id'=>$userId))->row_array();

    $response['table'] = $table;

    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('owner_pending_rides',$response);
    $this->load->view('header/footer');
  }

 
  public function owner_cancel_rides(){
    is_not_logged_in();
    $first = $_GET['first'];
    $userId = $this->uri->segment(3,0);
    $response['pageTitle']  = 'Cancelled Rides - '.ProjectName;
    $response['pageIndex']  = '';
    $response['pageIndex1'] = "";

               $this->db->order_by('id','desc'); 
    $list    = $this->db->get_where('ride_master',array('vehicle_owner_id'=>$userId,'status'=>2))->result_array();
    $table   = ""; 

      $i = 1;
      foreach($list as $row)
      {
          $table .= '<tr id="row_'.$row['id'].'">';
          $table .= '<td>'.$i.'</td>';
          $table .= '<td>'.$row['bookingId'].'</td>';

          $customer = $this->db->get_where('customer_master',array('id'=>$row['userId']))->row_array();

          /* $table .= '<td>'.(!empty($customer['name'])?ucfirst($customer['name']):"N/A").'</td>';
          $table .= '<td>'.(!empty($customer['email'])?$customer['email']:"N/A").'</td>';
          $table .= '<td>'.(!empty($customer['mobile'])?$customer['mobile']:"N/A").'</td>';*/
          $table .= '<td>'.date('dS M Y h:i A',$row['addDate']).'</td>';
           $table .= '<td>'.date('dS M Y h:i A',$row['modifyDate']).'</td>';
            // $vehicle = $this->db->get_where('owner_vehicle_master',array('id'=>$row['vehicle_id']))->row_array();
          $table .= '<td>'.$row['vehicle_number'].'</td>';

          $table .= '<td>'.$row['totalCharge'].'</td>';
          if ($first == 1) 
          {
             $table .= '<td class="action">
              <a href="'.base_url("Rides/cancel_ride_details/".$row['id']."?first=1&tr=1").'" class=""><button type="button" class="btn btn-default">View</button></a>
              </td>';
          }
          else
          {
             $table .= '<td class="action">
              <a href="'.base_url("Rides/cancel_ride_details/".$row['id']."?first=2&tr=3").'" class=""><button type="button" class="btn btn-default">View</button></a>
              </td>';
          }
          $table .= '</tr>';
          $i++;
      }

     $response['customer'] = $this->db->get_where('owner_master',array('id'=>$userId))->row_array();

    $response['table'] = $table;

    if ($first == 1) 
      {
         $response['pending'] = "Customers/owner_pending_rides/".$userId."?first=1";
         $response['cancel']  = "Customers/owner_cancel_rides/".$userId."?first=1";
         $response['running']  = "Customers/owner_running_rides/".$userId."?first=1";
         $response['completed']  = "Customers/owner_completed_rides/".$userId."?first=1";
      }
      else
      {
         $response['pending'] = "Customers/owner_pending_rides/".$userId."?first=2";
         $response['cancel']  = "Customers/owner_cancel_rides/".$userId."?first=2";
         $response['running']  = "Customers/owner_running_rides/".$userId."?first=2";
         $response['completed']  = "Customers/owner_completed_rides/".$userId."?first=2";
      }



    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('owner_cancel_rides',$response);
    $this->load->view('header/footer');
  }


     // manage list
  public function owner_completed_rides(){
    is_not_logged_in();

    $first = $_GET['first'];
    $userId = $this->uri->segment(3,0);
    $response['pageTitle']  = 'Completed Rides - '.ProjectName;
    $response['pageIndex']  = '';
    $response['pageIndex1'] = "";

                $this->db->order_by('id','desc');
     $list    = $this->db->get_where('ride_master',array('vehicle_owner_id'=>$userId,'status'=>3))->result_array();
     $table = ""; 

      $i = 1;
      foreach($list as $row)
      {
          $table .= '<tr id="row_'.$row['id'].'">';
          $table .= '<td>'.$i.'</td>';
          $table .= '<td>'.$row['bookingId'].'</td>';

          $customer = $this->db->get_where('customer_master',array('id'=>$row['userId']))->row_array();

         /* $table .= '<td>'.(!empty($customer['name'])?ucfirst($customer['name']):"N/A").'</td>';
          $table .= '<td>'.(!empty($customer['email'])?$customer['email']:"N/A").'</td>';
          $table .= '<td>'.(!empty($customer['mobile'])?$customer['mobile']:"N/A").'</td>';*/

          $table .= '<td>'.date('dS M Y h:i A',$row['completed_date']).'</td>';
           // $vehicle = $this->db->get_where('owner_vehicle_master',array('id'=>$row['vehicle_id']))->row_array();
          $table .= '<td>'.$row['vehicle_number'].'</td>';

          $table .= '<td>'.$row['totalCharge'].'</td>';

          if ($first == 1) 
          {
             $table .= '<td class="action">
              <a href="'.base_url("Rides/completed_ride_details/".$row['id']."?first=1&tr=1").'" class=""><button type="button" class="btn btn-default">View</button></a>
              </td>';
          }
          else
          {
             $table .= '<td class="action">
              <a href="'.base_url("Rides/completed_ride_details/".$row['id']."?first=2&tr=3").'" class=""><button type="button" class="btn btn-default">View</button></a>
              </td>';
          }
         
          $table .= '</tr>';
          $i++;
      }

     if ($first == 1) 
      {
         $response['pending'] = "Customers/owner_pending_rides/".$userId."?first=1";
         $response['cancel']  = "Customers/owner_cancel_rides/".$userId."?first=1";
         $response['running']  = "Customers/owner_running_rides/".$userId."?first=1";
         $response['completed']  = "Customers/owner_completed_rides/".$userId."?first=1";
      }
      else
      {
         $response['pending'] = "Customers/owner_pending_rides/".$userId."?first=2";
         $response['cancel']  = "Customers/owner_cancel_rides/".$userId."?first=2";
         $response['running']  = "Customers/owner_running_rides/".$userId."?first=2";
         $response['completed']  = "Customers/owner_completed_rides/".$userId."?first=2";
      }

    $response['customer'] = $this->db->get_where('owner_master',array('id'=>$userId))->row_array();

    $response['table'] = $table;

    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('owner_completed_rides',$response);
    $this->load->view('header/footer');
  }


      // manage list
  public function owner_running_rides(){
    is_not_logged_in();
    $first = $_GET['first'];
    $userId = $this->uri->segment(3,0);
    $response['pageTitle']  = 'Running Rides - '.ProjectName;
    $response['pageIndex']  = '';
    $response['pageIndex1'] = "";

                $this->db->order_by('id','desc');
     $list    = $this->db->get_where('ride_master',array('vehicle_owner_id'=>$userId,'status'=>4))->result_array();
    $table = ""; 

      $i = 1;
      foreach($list as $row)
      {
          $table .= '<tr id="row_'.$row['id'].'">';
          $table .= '<td>'.$i.'</td>';
          $table .= '<td>'.$row['bookingId'].'</td>';

          $customer = $this->db->get_where('customer_master',array('id'=>$row['userId']))->row_array();

         /* $table .= '<td>'.(!empty($customer['name'])?ucfirst($customer['name']):"N/A").'</td>';
          $table .= '<td>'.(!empty($customer['email'])?$customer['email']:"N/A").'</td>';
          $table .= '<td>'.(!empty($customer['mobile'])?$customer['mobile']:"N/A").'</td>';*/

          $table .= '<td>'.date('dS M Y h:i A',$row['addDate']).'</td>';
           // $vehicle = $this->db->get_where('owner_vehicle_master',array('id'=>$row['vehicle_id']))->row_array();
          $table .= '<td>'.$row['vehicle_number'].'</td>';

          $table .= '<td>'.$row['totalCharge'].'</td>';

          if ($first == 1) 
          {
             $table .= '<td class="action">
              <a href="'.base_url("Rides/running_ride_details/".$row['id']."?first=1&tr=1").'" class=""><button type="button" class="btn btn-default">View</button></a>
              </td>';
          }
          else
          {
             $table .= '<td class="action">
              <a href="'.base_url("Rides/running_ride_details/".$row['id']."?first=2&tr=3").'" class=""><button type="button" class="btn btn-default">View</button></a>
              </td>';
          }
         
          $table .= '</tr>';
          $i++;
      }

       if ($first == 1) 
      {
         $response['pending'] = "Customers/owner_pending_rides/".$userId."?first=1";
         $response['cancel']  = "Customers/owner_cancel_rides/".$userId."?first=1";
         $response['running']  = "Customers/owner_running_rides/".$userId."?first=1";
         $response['completed']  = "Customers/owner_completed_rides/".$userId."?first=1";
      }
      else
      {
         $response['pending'] = "Customers/owner_pending_rides/".$userId."?first=2";
         $response['cancel']  = "Customers/owner_cancel_rides/".$userId."?first=2";
         $response['running']  = "Customers/owner_running_rides/".$userId."?first=2";
         $response['completed']  = "Customers/owner_completed_rides/".$userId."?first=2";
      }


    $response['customer'] = $this->db->get_where('owner_master',array('id'=>$userId))->row_array();

    $response['table'] = $table;

    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('owner_running_rides',$response);
    $this->load->view('header/footer');
  }



  /*************************END**********************/
  
  


}
