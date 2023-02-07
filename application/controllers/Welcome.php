<?php
defined('BASEPATH') OR exit('No direct script access allowed');
  class Welcome extends CI_Controller {
      public function __construct(){
      parent::__construct();
      $this->load->model('Login_model','login');
    }
  
  public function index(){
    is_logged_in();
    $this->load->view('login');
  }

  // Post admin login data 
  public function loginPost(){
    $this->form_validation->set_rules('username', 'username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $field =array();
        $field['username'] = $this->input->post('username');
        $field['password'] =$this->input->post('password');

/*        if ($this->form_validation->run() == FALSE):
          $this->index();
        else:
          $response = $this->login->loginAccount($field);
          if(!empty($response)):
            $this->session->set_userdata('adminData',array('id'=>$response['id'],'name'=>$response['name'],'image'=>$response['image']
            ));
            redirect('admin-dashboard');
          else:
            $this->session->set_flashdata('message',generateAdminAlert('D',1));
            redirect('admin-login');
          endif;
          
        endif;*/
   

        if ($this->form_validation->run() == FALSE) 
        {
          $this->index();
        }
        else
        {
          $response = $this->login->loginAccount($field);
          if (!empty($response)) 
          {
            $this->session->set_userdata('adminData',array('id'=>$response['id'],'name'=>$response['name'],'image'=>$response['image'],'type'=>1
            ));
            redirect('admin-dashboard');
          }
          else
          { 
             $response1 = $this->db->get_where('staff_master',array('email'=>$field['username'],'password'=>$field['password'],'status'=>1))->row_array();
             if (!empty($response1)) 
             {
                $this->session->set_userdata('adminData',array('id'=>$response1['id'],'name'=>$response1['name'],'image'=>$response1['profile_pic'],'uuid'=>$response1['uuid'],'type'=>2
                ));
                redirect('admin-dashboard');
             }
             else
             {
                $this->session->set_flashdata('message',generateAdminAlert('D',1));
                redirect('admin-login');
             }
          }

        }
  }

  // admin dashboard
  public function dashboard(){
    is_not_logged_in();
    $response['pageTitle']     = 'Manage dashboard - '.ProjectName;
    $response['pageIndex']     = 'dashboard';
    $response['pageIndex1']    = '';
    $response['totalDriver']   = $this->login->manageDrivers();
    $response['totalCustomer'] = $this->login->manageCustomers();

    /****************************Payment graph data**************************************/

        $latestMonth=date('m-Y');
        $array1[0]=$latestMonth;
       for ($i = 1; $i < 6; $i++) 
        {
            $array1[$i] = date("m-Y", strtotime( date( 'Y-m-01' )." -$i months"));
        }

        $month_data1 = array();
        $created = 0;
        $completed = 0;
        foreach ($array1 as $key => $value) 
        {   
            $getdata = array();
            $q = "SELECT * FROM `ride_master` WHERE DATE_FORMAT(FROM_UNIXTIME(`addDate`), '%m-%Y') ='".$value."' ORDER BY `id` DESC ";
           $getdata = $this->db->query($q)->num_rows(); 
           $ma1['month'] = $value;
           $ma1['first1'] = (!empty($getdata) ? $getdata : 0);

           $created = $created+$ma1['first1'];

           $q1 = "SELECT * FROM `ride_master` WHERE DATE_FORMAT(FROM_UNIXTIME(`addDate`), '%m-%Y') ='".$value."' AND status = '3' ORDER BY `id` DESC ";
           $getdata1 = $this->db->query($q1)->num_rows(); 

           $ma1['second1'] = (!empty($getdata1) ? $getdata1 : 0);
           $month_data1[] = $ma1;

           $completed = $completed+$ma1['second1'];

           /******************line graph data**********************/
           $qu = "SELECT sum(totalCharge) as Amount FROM `ride_master` WHERE DATE_FORMAT(FROM_UNIXTIME(`addDate`), '%m-%Y') ='".$value."' AND status = '3' ORDER BY `id` DESC ";
           $getdetails = $this->db->query($qu)->row_array(); 
           $line['month'] = $value;
           $line['Amount'] = (!empty($getdetails['Amount']) ? $getdetails['Amount'] : 0);
           $lineData[] = $line;
           /*******************************************************/
        }

      
        $reverse_data1 = array_reverse($month_data1);
          
        $response['request_month_details'] = $reverse_data1;
        $response['created']          = $created;
        $response['completed']        = $completed;
        $response['Line_details'] = array_reverse($lineData);
       /*************************************END***************************************/

    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('dashboard',$response);
    $this->load->view('header/footer');
  }

  // manage Template service sms/email
  public function manageDefinition(){
    is_not_logged_in();
    $response['pageTitle']     = 'Manage Definition - '.ProjectName;
    $response['pageIndex']     = 'template';
    $response['pageIndex1']    = 'smsEmail';
    $response['res']           = $this->login->getDefinitionData();
    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('view_definition_list',$response);
    $this->load->view('header/footer');
  }
  
  public function addSetting() {
    is_not_logged_in();
    $response['pageTitle']     = 'Add Definition Data - '.ProjectName;
    $response['pageIndex']     = 'template';
    $response['pageIndex1']    = 'smsEmail';
    if($this->input->post()){
      $definition       = $this->input->post('definition');
      $date_time        = date('Y-m-d H:i:s');
      $table = 'notification_definition_master';
      $data = array(
                'name'        => $definition,
                'status'      => '1',
                'addDate'     => $date_time,
                'modifyDate'  => $date_time
            );
      $save_data = $this->login->saveData($table, $data);
      $this->session->set_flashdata('message',generateAdminAlert('S',13));
      redirect(base_url('welcome/manageDefinition'), 'refresh');
    }
    
    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('add_setting',$response);
    $this->load->view('header/footer');
  }

  public function editSetting() {
    is_not_logged_in();
    $response['pageTitle']     = 'Edit Definition Data - '.ProjectName;
    $response['pageIndex']     = 'template';
    $response['pageIndex1']    = 'smsEmail';
    $definition_id = base64_decode($this->uri->segment(3, 0));
    $table = 'notification_definition_master';
    $get_data = $this->login->getDataById($table, $definition_id);
    $response['res'] = $get_data;
    $response['definition_id'] = $definition_id;
    if($this->input->post()){

      $definition       = $this->input->post('definition');
      $definition_id    = $this->input->post('definition_id');
      $status           = $this->input->post('status');
      
      $date_time = date('Y-m-d H:i:s');
      $table     = 'notification_definition_master';
      $data      = array(
                    'name'       => $definition,
                    'status'     => $status,
                    'modifyDate' => $date_time
                 );
      $save_data = $this->login->updateData($data, $definition_id, $table);
      $this->session->set_flashdata('message',generateAdminAlert('S',14));
      redirect(base_url('welcome/manageDefinition'), 'refresh');
      }
    
    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('edit_setting',$response);
    $this->load->view('header/footer');
  }


  /* view notofication setting list */
  public function viewNotificationSetting() {
    is_not_logged_in();
    $response['pageTitle']     = 'Manage Template - '.ProjectName;
    $response['pageIndex']     = 'template';
    $response['pageIndex1']    = 'smsEmail';
    $table = 'notification_setting_master';
    $response['res']           = $this->login->getData($table);
    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('view_notification_list',$response);
    $this->load->view('header/footer');
  }


  public function addNotificationSetting() {
    is_not_logged_in();
    $response['pageTitle']     = 'Manage Template - '.ProjectName;
    $response['pageIndex']     = 'template';
    $response['pageIndex1']    = 'smsEmail';
    $table = 'notification_setting_master';
    $response['definition_list'] = $this->login->getDefinitionData('1');
    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('add_notification',$response);
    $this->load->view('header/footer');
  }

  /* save notofication setting */
  public function addNotificationSettingData() { 
    $type       = $this->input->post('type');
    if($type == '1'){
      $subject    = $this->input->post('subject');
    } else {
      $subject = '';
    }
    if($this->input->post('body')){
      $body       = $this->input->post('body');
    } else {
      $body       = $this->input->post('sms_body');
    }  
    $definition   = $this->input->post('definition');
    $content    = $this->input->post('content');
    $send_to    = $this->input->post('send_to');

    $date_time = date('Y-m-d H:i:s');  

    $save_data = array(
              'type'      => $type,
              'subject'   => $subject,
              'body'      => $body,
              'definition'  => $definition,
              'content'   => $content,
              'send_to'   => $send_to,
              'status'    => 1,
              'addDate'     => $date_time,
              'modifyDate'  => $date_time
            );
    
      $table = 'notification_setting_master';
      $save_data = $this->login->saveData($table, $save_data);
      $this->session->set_flashdata('message',generateAdminAlert('S',15));
      redirect(base_url('welcome/viewNotificationSetting'), 'refresh');
  }

  public function editNotificationSetting() {
    is_not_logged_in();
    $response['pageTitle']     = 'Update Template - '.ProjectName;
    $response['pageIndex']     = 'template';
    $response['pageIndex1']    = 'smsEmail';
    $setting_id = base64_decode($this->uri->segment(3, 0));
    $table = 'notification_setting_master';

    $get_data = $this->login->getDataById($table, $setting_id);
    $get_definition = $this->login->getDefinitionData();

    $response['definition_list'] = $get_definition;
    $response['res']             = $get_data;
    $response['setting_id']      = $setting_id;
    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('edit_notification',$response);
    $this->load->view('header/footer');

  }

  /* update notofication setting */
  public function updateNotificationSettingData() { 
    $id       = $this->input->post('setting_id');
    $type       = $this->input->post('type');
    if($type == '1'){
      $subject    = $this->input->post('subject');
    } else {
      $subject = '';
    }
    if($this->input->post('body')){ 
      $body       = $this->input->post('body');
    } else { 
      $body       = $this->input->post('sms_body');
    } 
    $definition   = $this->input->post('definition');
    $content      = $this->input->post('content');
    $send_to      = $this->input->post('send_to');
    $status       = $this->input->post('status');

    $date_time = date('Y-m-d H:i:s');

    $save_data = array(
              'type'      => $type,
              'subject'   => $subject,
              'body'      => $body,
              'definition'  => $definition,
              'content'   => $content,
              'send_to'   => $send_to,
              'status'    => $status,
              'modifyDate'  => $date_time
            );
    
       $table = 'notification_setting_master';
      $save_data = $this->login->updateData($save_data, $id, $table);
      $this->session->set_flashdata('message',generateAdminAlert('S',16));
      redirect(base_url('welcome/viewNotificationSetting'), 'refresh');
  }


  // logout user account
  public function logoutAccount(){
    $this->session->unset_userdata('adminData');
    $this->session->set_flashdata('message',generateAdminAlert('S',10));
    redirect('admin-login');
  }
}
