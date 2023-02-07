<?php
defined('BASEPATH') OR exit('No direct script access allowed');
  class Owner extends CI_Controller {
      public function __construct(){
      parent::__construct();
      $this->load->model('Login_model','login');
      $this->load->model('Common_model');
      $this->load->model('Ride_model');
      $this->load->helper('message');
    }
  
  public function index()
  {
    is_logged_in_owner();
    $this->load->view('owner/owner_login');
  }

  public function forgot_password()
  {
    $this->load->view('owner/forgot_password');
  }

   public function owner_signup()
   {
     $this->load->view('owner/owner_signup');
   }

    public function terms_condition()
   {  
     $response['pageTitle']  = 'Terms & Conditions - '.ProjectName;
     $this->load->view('owner/terms_condition',$response);
   }

   public function post_signup()
   {
      $data = $this->input->post();
      
      $insert_array['uuid']               = 'Own'.rand('99999','10000');
      $insert_array['name']               = $data['name'];
      $insert_array['email']              = $data['email'];
      $insert_array['mobile']             = $data['mobile'];
      $insert_array['password']           = $data['password'];
      $insert_array['otp']                = rand('999999','100000');
      $insert_array['otp_verify_status']  = 2;
      $insert_array['add_date']           = time(); 
      $insert_array['modify_date']        = time(); 
      $insert_array['status']             = 2; 

      $this->db->insert('owner_master',$insert_array);
      $last_id = $this->db->insert_id();

      redirect('owner/owner_otp_verification'.'?owner_id='.$last_id);

   }

     public function deletevehicle()
        {     
            $id = $this->uri->segment(3,0);
                    $this->db->where('id',$id);
            $data = $this->db->delete('owner_vehicle_master');
            redirect('owner/manageVehicle');
        }

       public function check_mail()
    {   
        $email = $this->input->post('email');
        $check_email = $this->db->get_where('owner_master',array('email'=>$email,'status!='=>3))->row_array();
        
        if (!empty($check_email) || ($email == "admin@admin.com"))
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

        $check_email = $this->db->get_where('owner_master',array('email'=>$email,'email!='=>$old_email,'status!='=>3))->row_array();
        
        if (!empty($check_email) || ($email == "admin@admin.com"))
        {
            echo "0";
        }
        else
        {
            echo "1";
        }
    }


    public function ownerprofile()
    {
      is_not_logged_in_owner();
      $owner = is_not_logged_in_owner();
      $response['pageTitle']  = 'Update Owner Profile - '.ProjectName;
      $response['pageIndex']  = '';
      $response['pageIndex1'] = "";
      $response['reg']        = $this->db->get_where('owner_master',array('id'=>$owner['id']))->row_array();

      $this->load->view('owner/header/header',$response);
      $this->load->view('owner/header/left-menu',$response);
      $this->load->view('owner/ownerprofile',$response);
      $this->load->view('owner/header/footer');
    } 

    // vehicle post 
  public function updateownerprofile(){
    is_not_logged_in_owner();
    $owner_detail = is_not_logged_in_owner();
    $data                     = $this->input->post();
    $array                    = array();
    $array['name']            = $data['name'];
    $array['email']           = $data['email'];
    $array['mobile']           = $data['mobile'];
    if(!empty($data['password'])){
      $array['password']        = $data['password'];
    }

      $getData    = $this->db->get_where('owner_master',array('id'=>$owner_detail['id']))->row_array();
      if(!empty($_FILES['image']['name']))
      {
        $name = 'image';
        $path  = CUSTOMER_DIRECTORY.'mediaFile/';
        $image = $this->Common_model->upload_userimg($_FILES['image']['name'],$path,$name);
      }else{
       $image = $getData['profile_pic'];
      }
      $array['profile_pic']  = $image;

     $this->db->where('id',$owner_detail['id']);
      $res = $this->db->update('owner_master', $array);

     if($res > 0 )
     {
            $this->session->set_flashdata('message',generateAdminAlert('S',29));
            redirect(base_url('owner/ownerprofile'));
     }
     else
     {
           $this->session->set_flashdata('message',generateAdminAlert('D',12));
            redirect(base_url('owner/ownerprofile'));
     }
  }

         public function check_mobile()
    {   
        $mobile = $this->input->post('mobile');
        $check_email = $this->db->get_where('owner_master',array('mobile'=>$mobile,'status!='=>3))->row_array();
        
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

        $check_email = $this->db->get_where('owner_master',array('mobile'=>$mobile,'mobile!='=>$old_mobile,'status!='=>3))->row_array();
        
        if (!empty($check_email))
        {
            echo "0";
        }
        else
        {
            echo "1";
        }
    }

    public function owner_otp_verification()
   { 
     $owner_id = $_GET['owner_id'];
     $owner_detail = $this->db->get_where('owner_master',array('id'=>$owner_id))->row_array();
     $data['ownerData'] = $owner_detail;
     $this->load->view('owner/owner_otp_verification',$data);
   }

   public function setInputs() {
      if ($this->input->post()) {
        $str = $this->input->post('in_values');
        //$ex_val = substr($str, 0, 1);
        $chars = str_split($str, 1);
        //print_r($chars);
        $set_in = '';
        $i = 1;
        foreach ($chars as $key => $value) {
          $set_in .= '<input type="text" class="set_input_otp set_m" name="otp_'.$i.'" placeholder="" id="otp_'.$i.'" data-id="'.$i.'" maxlength="1" value="'.$value.'">';
          $i++;
        }
        echo json_encode($set_in);
        die();
      }
    }

    public function resend_otp()
    {
       $owner_id = $_POST['owner_id'];

       $updatearray['otp'] = rand('999999','100000');
       $this->db->where('id',$owner_id);
       $this->db->update('owner_master',$updatearray);

       echo 1;
    }

   public function check_otp()
   {
      $data = $this->input->post();
      $owner_id = $data['owner_id'];
        $otp1     = trim($this->input->post('otp_1'));
        $otp2     = trim($this->input->post('otp_2'));
        $otp3     = trim($this->input->post('otp_3'));
        $otp4     = trim($this->input->post('otp_4'));
        $otp5     = trim($this->input->post('otp_5'));
        $otp6     = trim($this->input->post('otp_6'));

        $otp = $otp1.$otp2.$otp3.$otp4.$otp5.$otp6;
     // $otp = $data['otp'];

      $check = $this->db->get_where('owner_master',array('id'=>$owner_id,'otp'=>$otp))->row_array();

      if (!empty($check)) 
      {   
          $updatedata['otp_verify_status'] = 1;
          $this->db->where('id',$owner_id);
          $this->db->update('owner_master',$updatedata);

          $this->session->set_flashdata('message',generateAdminAlert('S',28));
          redirect(base_url(''));
      }
      else
      {
          $this->session->set_flashdata('message',generateAdminAlert('D',27));
          redirect(base_url('owner/owner_otp_verification'.'?owner_id='.$owner_id));
      }

     
   }

  // Post admin login data 
  public function loginPost(){
    $this->form_validation->set_rules('username', 'username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $field =array();
        $field['username'] = $this->input->post('username');
        $field['password'] =$this->input->post('password');

        if ($this->form_validation->run() == FALSE):
          $this->index();
        else:
          $response = $this->db->get_where('owner_master',array('mobile'=>$field['username'],'password'=>$field['password'],'status'=>1))->row_array();
          if(!empty($response)):
            $this->session->set_userdata('OwnerData',array('id'=>$response['id'],'name'=>$response['name'],'email'=>$response['email'],'image'=>$response['profile_pic']
            ));

            $log_array['owner_id']   = $response['id'];
            $log_array['login_time'] = time();
            $log_array['ip_address'] = $_SERVER['REMOTE_ADDR'];
            $browserName             = $this->getBrowser();
            $log_array['browser']    = $browserName;
            $osName                  = $this->getOS();
            $log_array['os']         = $osName;

            $this->db->insert('owner_login_history',$log_array);

            redirect('owner/dashboard');
          else:
            $this->session->set_flashdata('message',generateAdminAlert('D',1));
            redirect('');
          endif;
          // close account login 
        endif;
        // close 
  }

   function getBrowser() 
    {

        $user_agent = $_SERVER['HTTP_USER_AGENT'];;

        $browser        =   "Unknown Browser";

        $browser_array  =   array(
                '/msie/i'       =>  'Internet Explorer',
                '/firefox/i'    =>  'Firefox',
                '/safari/i'     =>  'Safari',
                '/chrome/i'     =>  'Chrome',
                '/opera/i'      =>  'Opera',
                '/netscape/i'   =>  'Netscape',
                '/maxthon/i'    =>  'Maxthon',
                '/konqueror/i'  =>  'Konqueror',
                '/mobile/i'     =>  'Handheld Browser'
                            );

        foreach ($browser_array as $regex => $value) { 

            if (preg_match($regex, $user_agent)) {
                $browser    =   $value;
            }

        }

        return $browser;

    }

    function getOS() 
    { 

        $user_agent     =   $_SERVER['HTTP_USER_AGENT'];

        $os_platform    =   "Unknown OS Platform";

        $os_array       =   array(
                '/windows nt 6.2/i'     =>  'Windows 8',
                '/windows nt 6.1/i'     =>  'Windows 7',
                '/windows nt 6.0/i'     =>  'Windows Vista',
                '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                '/windows nt 5.1/i'     =>  'Windows XP',
                '/windows xp/i'         =>  'Windows XP',
                '/windows nt 5.0/i'     =>  'Windows 2000',
                '/windows me/i'         =>  'Windows ME',
                '/win98/i'              =>  'Windows 98',
                '/win95/i'              =>  'Windows 95',
                '/win16/i'              =>  'Windows 3.11',
                '/macintosh|mac os x/i' =>  'Mac OS X',
                '/mac_powerpc/i'        =>  'Mac OS 9',
                '/linux/i'              =>  'Linux',
                '/ubuntu/i'             =>  'Ubuntu',
                '/iphone/i'             =>  'iPhone',
                '/ipod/i'               =>  'iPod',
                '/ipad/i'               =>  'iPad',
                '/android/i'            =>  'Android',
                '/blackberry/i'         =>  'BlackBerry',
                '/webos/i'              =>  'Mobile'
                );

            foreach ($os_array as $regex => $value) 
            { 

                if (preg_match($regex, $user_agent)) {
                    $os_platform    =   $value;
                }

            }   

        return $os_platform;

    }

  // admin dashboard
  public function dashboard(){
    is_not_logged_in_owner();
    $owner_detail = is_not_logged_in_owner();
    $response['pageTitle']     = 'Manage dashboard - '.ProjectName;
    $response['pageIndex']     = 'dashboard';
    $response['pageIndex1']    = '';
    $response['totalDriver']   = $this->login->manageDrivers();
    $response['totalCustomer'] = $this->login->manageCustomers();
    $response['owner_detail']  = $owner_detail;

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
            $q = "SELECT * FROM `ride_master` WHERE DATE_FORMAT(FROM_UNIXTIME(`addDate`), '%m-%Y') ='".$value."' AND vehicle_owner_id = ".$owner_detail['id']." ORDER BY `id` DESC ";
           $getdata = $this->db->query($q)->num_rows(); 
           $ma1['month'] = $value;
           $ma1['first1'] = (!empty($getdata) ? $getdata : 0);

           $created = $created+$ma1['first1'];

           $q1 = "SELECT * FROM `ride_master` WHERE DATE_FORMAT(FROM_UNIXTIME(`addDate`), '%m-%Y') ='".$value."' AND status = '3' AND vehicle_owner_id = ".$owner_detail['id']." ORDER BY `id` DESC ";
           $getdata1 = $this->db->query($q1)->num_rows(); 

           $ma1['second1'] = (!empty($getdata1) ? $getdata1 : 0);
           $month_data1[] = $ma1;

           $completed = $completed+$ma1['second1'];

           /******************line graph data**********************/
           $qu = "SELECT sum(totalCharge) as Amount FROM `ride_master` WHERE DATE_FORMAT(FROM_UNIXTIME(`addDate`), '%m-%Y') ='".$value."' AND status = '3' AND vehicle_owner_id = ".$owner_detail['id']." ORDER BY `id` DESC ";
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

    $this->load->view('owner/header/header',$response);
    $this->load->view('owner/header/left-menu',$response);
    $this->load->view('owner/dashboard',$response);
    $this->load->view('owner/header/footer');
  }

  // manage Template service sms/email
  public function manageDefinition(){
    is_not_logged_in_owner();
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
    is_not_logged_in_owner();
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
    is_not_logged_in_owner();
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
    is_not_logged_in_owner();
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
    is_not_logged_in_owner();
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
    is_not_logged_in_owner();
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
              'type'        => $type,
              'subject'     => $subject,
              'body'        => $body,
              'definition'  => $definition,
              'content'     => $content,
              'send_to'     => $send_to,
              'status'      => $status,
              'modifyDate'  => $date_time
            );
    
       $table = 'notification_setting_master';
      $save_data = $this->login->updateData($save_data, $id, $table);
      $this->session->set_flashdata('message',generateAdminAlert('S',16));
      redirect(base_url('welcome/viewNotificationSetting'), 'refresh');
  }

  // manage vehicle list
  public function manageVehicle(){
    is_not_logged_in_owner();
    $owner_detail = is_not_logged_in_owner();
    $response['pageTitle'] = 'Manage vehicle - '.ProjectName;
    $response['pageIndex'] = 'vehicle';
    $response['pageIndex1'] = "";
    $response['result']    = $this->db->get_where('owner_vehicle_master',array('owner_id'=>$owner_detail['id']))->result_array();
    $this->load->view('owner/header/header',$response);
    $this->load->view('owner/header/left-menu',$response);
    $this->load->view('owner/vehicleList',$response);
    $this->load->view('owner/header/footer');
  }

  public function manage_request(){
    is_not_logged_in_owner();
    $owner_detail = is_not_logged_in_owner();
    $response['pageTitle'] = 'Manage vehicle Request - '.ProjectName;
    $response['pageIndex'] = 'driver_request';
    $response['pageIndex1'] = "";

                             $this->db->order_by('vehicle_request_master.id','desc');  
                             $this->db->select('owner_vehicle_master.*,vehicle_request_master.id as request_id,vehicle_request_master.driver_id,vehicle_request_master.vehicle_id,vehicle_request_master.add_date as register_at,vehicle_request_master.status as register_status');
                             $this->db->join('owner_vehicle_master','owner_vehicle_master.id = vehicle_request_master.vehicle_id');
                             $this->db->where(array('owner_vehicle_master.owner_id'=>$owner_detail['id'])); 
    $response['result']    = $this->db->get_where('vehicle_request_master')->result_array();
    $this->load->view('owner/header/header',$response);
    $this->load->view('owner/header/left-menu',$response);
    $this->load->view('owner/manage_request',$response);
    $this->load->view('owner/header/footer');
  }

  public function update_request(){
    is_not_logged_in_owner();
    $owner_detail = is_not_logged_in_owner();
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
          redirect(base_url('owner/manage_request'), 'refresh');
        }

       if ($status == 3) 
       {
          $this->db->where('id',$id);
          $this->db->delete('vehicle_request_master');
          $this->session->set_flashdata('message',generateAdminAlert('S',30));
          redirect(base_url('owner/manage_request'));
       }
       elseif($status == 2) 
       {  
          $this->db->where('id',$id);
          $this->db->update('vehicle_request_master',$update_arr);
          $this->session->set_flashdata('message',generateAdminAlert('S',30));
          redirect(base_url('owner/manage_request'));
       }
       else
       {  
          $this->db->where('id',$id);
          $this->db->update('vehicle_request_master',$update_arr);

          /*******************************new implementation**********************************/
          $getdata = $this->db->get_where('vehicle_request_master',array('id'=>$id))->row_array();

          $this->db->where(array('driver_id'=>$getdata['driver_id'],'status'=>2));
          $this->db->delete('vehicle_request_master');

          $this->db->where(array('vehicle_id'=>$getdata['vehicle_id'],'status'=>2));
          $this->db->delete('vehicle_request_master');

        /***********************************************************************************/  

          $this->session->set_flashdata('message',generateAdminAlert('S',30));
          redirect(base_url('owner/manage_request'));
       }
    }
    else
    {   
        $check_data = $this->db->get_where('vehicle_request_master',array('id'=>$request_id))->row_array();
        if (empty($check_data)) 
        {
          $this->session->set_flashdata('message',generateAdminAlert('D',31));
          redirect(base_url('owner/manage_request'), 'refresh');
        }

        $response['pageTitle'] = 'Manage vehicle Request - '.ProjectName;
        $response['pageIndex'] = 'driver_request';
        $response['pageIndex1'] = "";
        $response['result']    = $this->db->get_where('vehicle_request_master',array('id'=>$request_id))->row_array();
        $this->load->view('owner/header/header',$response);
        $this->load->view('owner/header/left-menu',$response);
        $this->load->view('owner/update_request',$response);
        $this->load->view('owner/header/footer');
    }
    
  }
  
  // Add vehicle data
  public function addVehicle(){
    is_not_logged_in_owner();
    $response['pageTitle'] = 'Add Vehicle - '.ProjectName;
    $response['pageIndex'] = 'vehicle';
    $response['pageIndex1'] = "";
    $response['result']    = $this->Common_model->getVehicleData();
    $response['capacity']  = $this->Common_model->getDataViaType('unit_master','1');
    $response['duration']  = $this->Common_model->getDataViaType('unit_master','2');

    $this->load->view('owner/header/header',$response);
    $this->load->view('owner/header/left-menu',$response);
    $this->load->view('owner/addVehicle',$response);
    $this->load->view('owner/header/footer');
  }

// vehicle post 
  public function addVehiclePost(){
    is_not_logged_in_owner();
    $owner_detail = is_not_logged_in_owner();
    $data = $this->input->post();
    $array  = array();
    $array['owner_id']            = $owner_detail['id'];
    $array['vehicle_number']      = $data['vehicle_number'];
    $array['vehicle_master_id']   = $data['vehicle_master_id'];
    $array['vehicle_type']        = $data['vehicle_type'];
    $array['vehicle_left']        = $data['vehicle_left'];
    $array['vehicle_right']        = $data['vehicle_right'];
    $array['vehicle_front']        = $data['vehicle_front'];
    $array['add_date']            = time();
    $array['modify_date']         = time();
    $array['status']              = 1;
    
     /* $image6 = "";
      if(!empty($_FILES['vehicle_left']['name']))
      {
        $name = 'vehicle_left';
        $path  = CUSTOMER_DIRECTORY.'mediaFile/vehicles/';
        $image6 = $this->Common_model->upload_userimg($_FILES['vehicle_left']['name'],$path,$name);
      }

      $image7 = "";
      if(!empty($_FILES['vehicle_right']['name']))
      {
        $name = 'vehicle_right';
        $path  = CUSTOMER_DIRECTORY.'mediaFile/vehicles/';
        $image7 = $this->Common_model->upload_userimg($_FILES['vehicle_right']['name'],$path,$name);
      }

      $image8 = "";
      if(!empty($_FILES['vehicle_front']['name']))
      {
        $name = 'vehicle_front';
        $path  = CUSTOMER_DIRECTORY.'mediaFile/vehicles/';
        $image8 = $this->Common_model->upload_userimg($_FILES['vehicle_front']['name'],$path,$name);
      }

      $array['vehicle_left']        = $image6;
      $array['vehicle_right']       = $image7;
      $array['vehicle_front']       = $image8;*/

      $res = $this->db->insert('owner_vehicle_master', $array);
      $last_id = $this->db->insert_id();

     if($res > 0 ){
            $this->session->set_flashdata('message',generateAdminAlert('S',17));
            redirect(base_url('owner/registration_doc?id='.$last_id));
     }else{
           $this->session->set_flashdata('message',generateAdminAlert('D',12));
             redirect(base_url('owner/addVehicle'));
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
    is_not_logged_in_owner();
    if ($this->input->post()) 
    {   
       $id = $this->input->post('id');
/*
       $image = "";
      if(!empty($_FILES['vehicle_reg_front']['name']))
      {
        $name = 'vehicle_reg_front';
        $path  = CUSTOMER_DIRECTORY.'mediaFile/vehicles/';
        $image = $this->Common_model->upload_userimg($_FILES['vehicle_reg_front']['name'],$path,$name);
      }

      $image1 = "";
      if(!empty($_FILES['vehicle_reg_back']['name']))
      {
        $name = 'vehicle_reg_back';
        $path  = CUSTOMER_DIRECTORY.'mediaFile/vehicles/';
        $image1 = $this->Common_model->upload_userimg($_FILES['vehicle_reg_back']['name'],$path,$name);
      }*/

      $array['vehicle_reg_front']   = $this->input->post('vehicle_reg_front');
      $array['vehicle_reg_back']    = $this->input->post('vehicle_reg_back');
     
             $this->db->where('id',$id);     
      $res = $this->db->update('owner_vehicle_master', $array);

     if($res > 0 ){
            $this->session->set_flashdata('message',generateAdminAlert('S',17));
            redirect(base_url('owner/route_permit_doc?id='.$id));
     }else{
           $this->session->set_flashdata('message',generateAdminAlert('D',12));
             redirect(base_url('owner/registration_doc?id='.$id));
     }

    }
    else
    {
        $response['pageTitle'] = 'Add Vehicle - '.ProjectName;
        $response['pageIndex'] = 'vehicle';
        $response['pageIndex1'] = "";
        $response['result']    = $this->Common_model->getVehicleData();
        $response['capacity']  = $this->Common_model->getDataViaType('unit_master','1');
        $response['duration']  = $this->Common_model->getDataViaType('unit_master','2');

        $this->load->view('owner/header/header',$response);
        $this->load->view('owner/header/left-menu',$response);
        $this->load->view('owner/registration_doc',$response);
        $this->load->view('owner/header/footer');
    }
    
  }

    public function route_permit_doc()
  {
    is_not_logged_in_owner();
    if ($this->input->post()) 
    {   
       $id = $this->input->post('id');
       /* $image2 = "";
      if(!empty($_FILES['route_permit_front']['name']))
      {
        $name = 'route_permit_front';
        $path  = CUSTOMER_DIRECTORY.'mediaFile/vehicles/';
        $image2 = $this->Common_model->upload_userimg($_FILES['route_permit_front']['name'],$path,$name);
      }

      $image3 = "";
      if(!empty($_FILES['route_permit_back']['name']))
      {
        $name = 'route_permit_back';
        $path  = CUSTOMER_DIRECTORY.'mediaFile/vehicles/';
        $image3 = $this->Common_model->upload_userimg($_FILES['route_permit_back']['name'],$path,$name);
      }*/

      $array['route_permit_front']  = $this->input->post('route_permit_front');
      $array['route_permit_back']   = $this->input->post('route_permit_back');
     
             $this->db->where('id',$id);     
      $res = $this->db->update('owner_vehicle_master', $array);

     if($res > 0 ){
            $this->session->set_flashdata('message',generateAdminAlert('S',17));
            redirect(base_url('owner/containment_doc?id='.$id));
     }else{
           $this->session->set_flashdata('message',generateAdminAlert('D',12));
             redirect(base_url('owner/route_permit_doc?id='.$id));
     }

    }
    else
    {
        $response['pageTitle'] = 'Add Vehicle - '.ProjectName;
        $response['pageIndex'] = 'vehicle';
        $response['pageIndex1'] = "";
        $response['result']    = $this->Common_model->getVehicleData();
        $response['capacity']  = $this->Common_model->getDataViaType('unit_master','1');
        $response['duration']  = $this->Common_model->getDataViaType('unit_master','2');

        $this->load->view('owner/header/header',$response);
        $this->load->view('owner/header/left-menu',$response);
        $this->load->view('owner/route_permit_doc',$response);
        $this->load->view('owner/header/footer');
    }
    
  }


   public function containment_doc()
  {
    is_not_logged_in_owner();
    if ($this->input->post()) 
    {   
       $id = $this->input->post('id');
       /* $image4 = "";
      if(!empty($_FILES['containment_front']['name']))
      {
        $name = 'containment_front';
        $path  = CUSTOMER_DIRECTORY.'mediaFile/vehicles/';
        $image4 = $this->Common_model->upload_userimg($_FILES['containment_front']['name'],$path,$name);
      }

      $image5 = "";
      if(!empty($_FILES['containment_back']['name']))
      {
        $name = 'containment_back';
        $path  = CUSTOMER_DIRECTORY.'mediaFile/vehicles/';
        $image5 = $this->Common_model->upload_userimg($_FILES['containment_back']['name'],$path,$name);
      }*/

      $array['containment_front']   = $this->input->post('containment_front');
      $array['containment_back']    = $this->input->post('containment_back');
     
             $this->db->where('id',$id);     
      $res = $this->db->update('owner_vehicle_master', $array);

     if($res > 0 ){
            $this->session->set_flashdata('message',generateAdminAlert('S',17));
            redirect(base_url('owner/manageVehicle'));
     }else{
           $this->session->set_flashdata('message',generateAdminAlert('D',12));
             redirect(base_url('owner/containment_doc?id='.$id));
     }

    }
    else
    {
        $response['pageTitle'] = 'Add Vehicle - '.ProjectName;
        $response['pageIndex'] = 'vehicle';
        $response['pageIndex1'] = "";
        $response['result']    = $this->Common_model->getVehicleData();
        $response['capacity']  = $this->Common_model->getDataViaType('unit_master','1');
        $response['duration']  = $this->Common_model->getDataViaType('unit_master','2');

        $this->load->view('owner/header/header',$response);
        $this->load->view('owner/header/left-menu',$response);
        $this->load->view('owner/containment_doc',$response);
        $this->load->view('owner/header/footer');
    }
    
  }

  // Add vehicle data
  public function updateVehicle(){
    is_not_logged_in_owner();
    $id = $this->uri->segment(3);
    $response['pageTitle']    = 'Update Vehicle - '.ProjectName;
    $response['pageIndex']    = 'vehicle';
    $response['pageIndex1']   = "";
    $response['vehicleData']  = $this->db->get_where('owner_vehicle_master',array('id'=>$id))->row_array();
    $response['capacity']     = $this->Common_model->getDataViaType('unit_master','1');
    $response['duration']     = $this->Common_model->getDataViaType('unit_master','2');

    $this->load->view('owner/header/header',$response);
    $this->load->view('owner/header/left-menu',$response);
    $this->load->view('owner/updateVehicle',$response);
    $this->load->view('owner/header/footer');
  }

    // Add vehicle data
  public function updateVehicledisable(){
    is_not_logged_in_owner();
    $id = $this->uri->segment(3);
    $response['pageTitle']    = 'Update Vehicle - '.ProjectName;
    $response['pageIndex']    = 'vehicle';
    $response['pageIndex1']   = "";
    $response['vehicleData']  = $this->db->get_where('owner_vehicle_master',array('id'=>$id))->row_array();
    $response['capacity']     = $this->Common_model->getDataViaType('unit_master','1');
    $response['duration']     = $this->Common_model->getDataViaType('unit_master','2');

    $this->load->view('owner/header/header',$response);
    $this->load->view('owner/header/left-menu',$response);
    $this->load->view('owner/updateVehicledisable',$response);
    $this->load->view('owner/header/footer');
  }


  public function get_vehicles()
  {
     $type = $_POST['type'];
     $vehicle_data = $this->db->get_where('vehicle_master',array('type'=>$type,'status'=>1))->result_array();
     $vech = "";
     $vech .= '<option value="">-Select Vehicle-</option>';
     foreach ($vehicle_data as $key => $value) 
     {
        $vech .= '<option value="'.$value['id'].'">'.ucfirst($value['name']).'</option>';
     }

     echo $vech;

  }

  public function get_vehicles_new()
  {
     $type = $_POST['type'];
     $vehicle = $_POST['vehicle'];
     $vehicle_data = $this->db->get_where('vehicle_master',array('type'=>$type,'status'=>1))->result_array();
     $vech = "";
     $vech .= '<option value="">-Select Vehicle-</option>';
     foreach ($vehicle_data as $key => $value) 
     {  
        if($vehicle==$value['id']){ $select="selected"; }else{ $select=""; }
        $vech .= '<option value="'.$value['id'].'" '.$select.'>'.ucfirst($value['name']).'</option>';
     }

     echo $vech;

  }

// vehicle post 
  public function updateVehiclePost(){
    is_not_logged_in_owner();
    $owner_detail = is_not_logged_in_owner();
    $data = $this->input->post();
    $id = $data['id'];
    $array  = array();
    $array['vehicle_number']      = $data['vehicle_number'];
    $array['vehicle_master_id']   = $data['vehicle_master_id'];
    $array['vehicle_type']        = $data['vehicle_type'];
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
            redirect(base_url('owner/update_registration_doc/'.$id));
     }else{
           $this->session->set_flashdata('message',generateAdminAlert('D',12));
             redirect(base_url('owner/updateVehicle/'.$id));
     }
  }


   public function update_registration_doc()
   {
      is_not_logged_in_owner();
      $owner_detail = is_not_logged_in_owner();
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
                redirect(base_url('owner/update_route_permit/'.$id));
         }else{
               $this->session->set_flashdata('message',generateAdminAlert('D',12));
                 redirect(base_url('owner/update_registration_doc/'.$id));
         }
      }
      else
      {
          $response['pageTitle']    = 'Update Vehicle - '.ProjectName;
          $response['pageIndex']    = 'vehicle';
          $response['pageIndex1']   = "";
          $response['vehicleData']  = $this->db->get_where('owner_vehicle_master',array('id'=>$id))->row_array();
          $response['capacity']     = $this->Common_model->getDataViaType('unit_master','1');
          $response['duration']     = $this->Common_model->getDataViaType('unit_master','2');

          $this->load->view('owner/header/header',$response);
          $this->load->view('owner/header/left-menu',$response);
          $this->load->view('owner/update_registration_doc',$response);
          $this->load->view('owner/header/footer');
      }
  }

   public function update_route_permit()
   {
      is_not_logged_in_owner();
      $owner_detail = is_not_logged_in_owner();
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
                redirect(base_url('owner/update_containment/'.$id));
         }else{
               $this->session->set_flashdata('message',generateAdminAlert('D',12));
                 redirect(base_url('owner/update_route_permit/'.$id));
         }
      }
      else
      {
          $response['pageTitle']    = 'Update Vehicle - '.ProjectName;
          $response['pageIndex']    = 'vehicle';
          $response['pageIndex1']   = "";
          $response['vehicleData']  = $this->db->get_where('owner_vehicle_master',array('id'=>$id))->row_array();
          $response['capacity']     = $this->Common_model->getDataViaType('unit_master','1');
          $response['duration']     = $this->Common_model->getDataViaType('unit_master','2');

          $this->load->view('owner/header/header',$response);
          $this->load->view('owner/header/left-menu',$response);
          $this->load->view('owner/update_route_permit',$response);
          $this->load->view('owner/header/footer');
      }
  }

   public function update_containment()
   {
      is_not_logged_in_owner();
      $owner_detail = is_not_logged_in_owner();
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
                redirect(base_url('owner/manageVehicle'));
         }else{
               $this->session->set_flashdata('message',generateAdminAlert('D',12));
                 redirect(base_url('owner/update_containment/'.$id));
         }
      }
      else
      {
          $response['pageTitle']    = 'Update Vehicle - '.ProjectName;
          $response['pageIndex']    = 'vehicle';
          $response['pageIndex1']   = "";
          $response['vehicleData']  = $this->db->get_where('owner_vehicle_master',array('id'=>$id))->row_array();
          $response['capacity']     = $this->Common_model->getDataViaType('unit_master','1');
          $response['duration']     = $this->Common_model->getDataViaType('unit_master','2');

          $this->load->view('owner/header/header',$response);
          $this->load->view('owner/header/left-menu',$response);
          $this->load->view('owner/update_containment',$response);
          $this->load->view('owner/header/footer');
      }
  }


  // logout user account
  public function logoutAccount(){
    $this->session->unset_userdata('OwnerData');
    $this->session->set_flashdata('message',generateAdminAlert('S',10));
    redirect('');
  }

  /*************************************Ride management***************************/

  public function pending_rides(){
    is_not_logged_in_owner();
    $owner_detail = is_not_logged_in_owner();
    $response['pageTitle']  = 'Pending Rides - '.ProjectName;
    $response['pageIndex']  = 'pending';
    $response['pageIndex1'] = "pending_rides";
    $data = $this->input->post();
     if ($this->input->post()) 
    {
        if ($data['vehicles'] == '') 
        {
           $this->db->order_by('id','desc');  
    $list    = $this->db->get_where('ride_master',array('vehicle_owner_id'=>$owner_detail['id'],'status'=>1))->result_array();
        }
        else
        {
           $this->db->order_by('id','desc');  
    $list    = $this->db->get_where('ride_master',array('vehicle_id'=>$data['vehicles'],'vehicle_owner_id'=>$owner_detail['id'],'status'=>1))->result_array();
        }

        $response['vehicles_id'] = $data['vehicles'];  
               
    }
    else
    {
         $this->db->order_by('id','desc');  
    $list    = $this->db->get_where('ride_master',array('vehicle_owner_id'=>$owner_detail['id'],'status'=>1))->result_array();
         $response['vehicles_id'] = '';
    }


                  
    $table = ""; 

      $i = 1;
      foreach($list as $row)
      {
          $table .= '<tr id="row_'.$row['id'].'">';
          $table .= '<td>'.$i.'</td>';
          $table .= '<td>'.$row['bookingId'].'</td>';

          $customer = $this->db->get_where('customer_master',array('id'=>$row['userId']))->row_array();

          $table .= '<td>'.(!empty($customer['name'])?ucfirst($customer['name']):"N/A").'</td>';
          $table .= '<td>'.(!empty($customer['mobile'])?$customer['mobile']:"N/A").'</td>';
          $table .= '<td>'.date('dS M Y h:i A',$row['addDate']).'</td>';
          $vehicle = $this->db->get_where('vehicle_master',array('id'=>$row['vehicle_id']))->row_array();
          $table .= '<td>'.ucfirst($vehicle['name']).'</td>';
          $table .= '<td>'.$row['totalCharge'].'</td>';
          $table .= '<td class="action">
          <a href="'.base_url("Owner/pending_ride_details/".$row['id']."").'" class=""><button type="button" class="btn btn-default">View</button></a>
          </td>';
          $table .= '</tr>';
          $i++;
      }

    $response['table'] = $table;
    $response['vehicle_data'] = $this->db->get_where('vehicle_master')->result_array();

    $this->load->view('owner/header/header',$response);
    $this->load->view('owner/header/left-menu',$response);
    $this->load->view('owner/pending_rides',$response);
    $this->load->view('owner/header/footer');
  }

   public function running_rides()
   {
      is_not_logged_in_owner();
      $owner_detail = is_not_logged_in_owner();
      $response['pageTitle']  = 'Running Rides - '.ProjectName;
      $response['pageIndex']  = 'running';
      $response['pageIndex1'] = "running_rides";

      $data = $this->input->post();
     if ($this->input->post()) 
    {
        if ($data['vehicles'] == '') 
        {
           $this->db->order_by('id','desc');  
    $list    = $this->db->get_where('ride_master',array('vehicle_owner_id'=>$owner_detail['id'],'status'=>4))->result_array();
        }
        else
        {
           $this->db->order_by('id','desc');  
    $list    = $this->db->get_where('ride_master',array('vehicle_id'=>$data['vehicles'],'vehicle_owner_id'=>$owner_detail['id'],'status'=>4))->result_array();
        }

        $response['vehicles_id'] = $data['vehicles'];  
               
    }
    else
    {
         $this->db->order_by('id','desc');  
    $list    = $this->db->get_where('ride_master',array('vehicle_owner_id'=>$owner_detail['id'],'status'=>4))->result_array();
         $response['vehicles_id'] = '';
    }

                 /*$this->db->order_by('id','desc'); 
      $list    = $this->db->get_where('ride_master',array('vehicle_owner_id'=>$owner_detail['id'],'status'=>4))->result_array();*/
      $table = ""; 

        $i = 1;
        foreach($list as $row)
        {
            $table .= '<tr id="row_'.$row['id'].'">';
            $table .= '<td>'.$i.'</td>';
            $table .= '<td>'.$row['bookingId'].'</td>';

            $customer = $this->db->get_where('customer_master',array('id'=>$row['userId']))->row_array();

            $table .= '<td>'.(!empty($customer['name'])?ucfirst($customer['name']):"N/A").'</td>';
            $table .= '<td>'.(!empty($customer['mobile'])?$customer['mobile']:"N/A").'</td>';
            $table .= '<td>'.date('dS M Y h:i A',$row['addDate']).'</td>';

            $bookingData = $this->db->get_where('booking_ride_request_master',array('booking_id'=>$row['id']))->row_array();

            if (!empty($bookingData['accept_date'])) 
            {
              $acceptDate = date('dS M Y h:i A',$bookingData['accept_date']);
            }
            else
            {
              $acceptDate = "N/A";
            }

            $table .= '<td>'.$acceptDate.'</td>';

            $vehicle = $this->db->get_where('vehicle_master',array('id'=>$row['vehicle_id']))->row_array();
            $table .= '<td>'.ucfirst($vehicle['name']).'</td>';
            $table .= '<td>'.$row['totalCharge'].'</td>';

            if ($bookingData['accept_status'] == 1 && $bookingData['navigation_status'] == 0) 
            {
               $status_div = '<div class="label label-default lbl" type="button">Created</div>'; 
            }
            elseif ($bookingData['navigation_status'] == 1 && $bookingData['arrive_status'] == 0) 
            {
               
               $status_div = '<div class="label label-primary lbl" type="button">Start Navigation</div>'; 
            }
            elseif ($bookingData['arrive_status'] == 1 && $bookingData['start_destination'] == 0) 
            {
               $status_div = '<div class="label label-info lbl" type="button">Arrived</div>'; 
            }
            elseif ($bookingData['start_destination'] == 1 && $bookingData['arrived_destination'] == 0) 
            {
               
               $status_div = '<div class="label label-warning lbl" type="button">Start to destination</div>'; 
            }
            else
            {
               $status_div = '<div class="label label-success lbl" type="button">Destination Arrived</div>'; 
            }

            $table .= '<td>'.$status_div.'</td>';

            $table .= '<td class="action">
            <a href="'.base_url("Owner/running_ride_details/".$row['id']."").'" class=""><button type="button" class="btn btn-default">View</button></a>
              <a href="'.base_url("Owner/show_map/".$row['id']."").'" class=""><button type="button" class="btn btn-info">Show Location on Map</button></a>
            </td>';
            $table .= '</tr>';
            $i++;
        }

      $response['table'] = $table;
       $response['vehicle_data'] = $this->db->get_where('vehicle_master')->result_array();

      $this->load->view('owner/header/header',$response);
      $this->load->view('owner/header/left-menu',$response);
      $this->load->view('owner/running_rides',$response);
      $this->load->view('owner/header/footer');
  }

    public function show_map()
  {  
      is_not_logged_in();
      $response['pageTitle']  = 'Running Rides - '.ProjectName;
      $response['pageIndex']  = 'running';
      $response['pageIndex1'] = "running_rides";

      $id = $this->uri->segment(3,0);
      $ridedata = $this->db->get_where('ride_master',array('id'=>$id))->row_array();
      $driverdata = $this->db->get_where('driver_master',array('id'=>$ridedata['driver_id']))->row_array();

      $response['driver_data'] = $driverdata;

      $this->load->view('owner/header/header',$response);
      $this->load->view('owner/header/left-menu',$response);
      $this->load->view('owner/show_map',$response);
      $this->load->view('owner/header/footer');
  }

    public function running_ride_details()
  {
        is_not_logged_in_owner();
        $owner_detail = is_not_logged_in_owner();
        $id = $this->uri->segment(3,0);
        $response['pageTitle']  = 'Running Rides Details - '.ProjectName;
        $response['pageIndex']  = 'running';
        $response['pageIndex1'] = "running_rides";
        $response['ridedata']   = $this->Ride_model->get_ride_details($id);
        $response['customerdata'] = $this->db->get_where('customer_master',array('id'=>$response['ridedata']['userId']))->row_array();

        $response['insuranceData'] = $this->db->get_where('insurance_master',array('id'=>$response['ridedata']['insuranceType']))->row_array();
        $response['currency'] = $this->db->get_where('settings')->row_array();

        $response['bookingData'] = $this->db->get_where('booking_ride_request_master',array('booking_id'=>$id))->row_array();

        $response['driverData'] = $this->db->get_where('driver_master',array('id'=>$response['ridedata']['driver_id']))->row_array();

      $driver = $this->db->get_where('driver_master',array('id'=>$response['ridedata']['driver_id']))->row_array();

                $this->db->order_by('id','desc');  
        $list = $this->db->get_where('ride_log_history',array('booking_id'=>$id))->result_array();
        $table = "";
        $i = 1;
        foreach($list as $row)
        {
            $table .= '<tr id="row_'.$row['id'].'">';
            $table .= '<td>'.$i.'</td>';
            if ($row['type'] == 1) 
            { 
              $activity = $response['customerdata']['name'].' has created a new ride';
              $status = "Created";
            }
            elseif ($row['type'] == 2) 
            { 
              $activity = ucfirst($driver['name']).' has accepted the ride'; 
              $status = "Accepted";
            }
            elseif ($row['type'] == 3) 
            { 
              $activity = ucfirst($driver['name']).' has started the navigation to correspond location'; 
              $status = "Navigated";
            }
            elseif ($row['type'] == 4) 
            { 
              $activity = ucfirst($driver['name']).' has arrived at the location'; 
              $status = "Arrived";
            }
            elseif ($row['type'] == 5) 
            { 
              $activity = ucfirst($driver['name']).' has started ride to destination'; 
              $status = "Start to Destination";
            }
            elseif ($row['type'] == 6) 
            { 
              $activity = ucfirst($driver['name']).' has arrived to destination'; 
              $status = "Arrived at Destination";
            }
            elseif ($row['type'] == 7) 
            { 
              $activity = 'Ride completed'; 
              $status = "Completed";
            }
            elseif ($row['type'] == 8) 
            { 
              if ($row['cancel_by_type'] == 1) 
              {
                 $canceldata = $this->db->get_where('customer_master',array('id'=>$row['cancel_by_id']))->row_array();
                 $message = 'Ride cancelled by '.ucfirst($canceldata['name']). '(Customer)'; 
              }
              else
              {
                 $canceldata = $this->db->get_where('driver_master',array('id'=>$row['cancel_by_id']))->row_array();
                 $message = 'Ride cancelled by '.ucfirst($canceldata['name']). '(Pilot)'; 
              }

              $activity = $message; 
              $status = "Cancelled";
            }

            $table .= '<td>'.$activity.'</td>';
            $table .= '<td>'.$status.'</td>';
            $table .= '<td>'.date('dS M Y h:i A',$row['add_date']).'</td>';
            
            $table .= '</tr>';
            $i++;
        }

          $response['table'] = $table;

        $this->load->view('owner/header/header',$response);
        $this->load->view('owner/header/left-menu',$response);
        $this->load->view('owner/running_ride_details',$response);
        $this->load->view('owner/header/footer');
  }


   public function completed_rides()
   {
      is_not_logged_in_owner();
      $owner_detail = is_not_logged_in_owner();
      $response['pageTitle']  = 'Completed Rides - '.ProjectName;
      $response['pageIndex']  = 'completed';
      $response['pageIndex1'] = "completed_rides";

          $data = $this->input->post();
     if ($this->input->post()) 
    {
        if ($data['vehicles'] == '') 
        {
           $this->db->order_by('id','desc');  
    $list    = $this->db->get_where('ride_master',array('vehicle_owner_id'=>$owner_detail['id'],'status'=>3))->result_array();
        }
        else
        {
           $this->db->order_by('id','desc');  
    $list    = $this->db->get_where('ride_master',array('vehicle_id'=>$data['vehicles'],'vehicle_owner_id'=>$owner_detail['id'],'status'=>3))->result_array();
        }

        $response['vehicles_id'] = $data['vehicles'];  
               
    }
    else
    {
         $this->db->order_by('id','desc');  
    $list    = $this->db->get_where('ride_master',array('vehicle_owner_id'=>$owner_detail['id'],'status'=>3))->result_array();
         $response['vehicles_id'] = '';
    }



                /* $this->db->order_by('id','desc'); 
      $list    = $this->db->get_where('ride_master',array('vehicle_owner_id'=>$owner_detail['id'],'status'=>3))->result_array();*/
      $table = ""; 

        $i = 1;
        foreach($list as $row)
        {
            $table .= '<tr id="row_'.$row['id'].'">';
            $table .= '<td>'.$i.'</td>';
            $table .= '<td>'.$row['bookingId'].'</td>';

            $customer = $this->db->get_where('customer_master',array('id'=>$row['userId']))->row_array();

            $table .= '<td>'.(!empty($customer['name'])?ucfirst($customer['name']):"N/A").'<br> <i class="fa fa-mobile" aria-hidden="true"></i> '. (!empty($customer['mobile'])?$customer['mobile']:"N/A").'</td>';

            $pilot_data = $this->db->get_where('driver_master',array('id'=>$row['driver_id']))->row_array();

             $table .= '<td>'.(!empty($pilot_data['name'])?ucfirst($pilot_data['name']):"N/A").'<br> <i class="fa fa-mobile" aria-hidden="true"></i> '. (!empty($pilot_data['mobile'])?$pilot_data['mobile']:"N/A").'</td>';

            $table .= '<td>'.date('dS M Y h:i A',$row['addDate']).'</td>';

            if (!empty($row['completed_date'])) 
            {
              $table .= '<td>'.date('dS M Y h:i A',$row['completed_date']).'</td>';
            }
            else
            {
              $table .= '<td>N/A</td>';
            }
            

            $vehicle = $this->db->get_where('vehicle_master',array('id'=>$row['vehicle_id']))->row_array();
            $table .= '<td>'.ucfirst($vehicle['name']).'</td>';
            $table .= '<td>'.$row['totalCharge'].'</td>';
            $table .= '<td class="action">
            <a href="'.base_url("Owner/completed_ride_details/".$row['id']."").'" class=""><button type="button" class="btn btn-default">View</button></a>
            </td>';
            $table .= '</tr>';
            $i++;
        }

      $response['table'] = $table;
       $response['vehicle_data'] = $this->db->get_where('vehicle_master')->result_array();

      $this->load->view('owner/header/header',$response);
      $this->load->view('owner/header/left-menu',$response);
      $this->load->view('owner/completed_rides',$response);
      $this->load->view('owner/header/footer');
  }

   public function completed_ride_details()
   {
      is_not_logged_in_owner();
      $owner_detail = is_not_logged_in_owner();
      $id = $this->uri->segment(3,0);
      $response['pageTitle']  = 'Completed Rides Details - '.ProjectName;
      $response['pageIndex']  = 'completed';
      $response['pageIndex1'] = "completed_rides";
      $response['ridedata']   = $this->Ride_model->get_ride_details($id);
      $response['customerdata'] = $this->db->get_where('customer_master',array('id'=>$response['ridedata']['userId']))->row_array();

      $response['insuranceData'] = $this->db->get_where('insurance_master',array('id'=>$response['ridedata']['insuranceType']))->row_array();
      $response['currency'] = $this->db->get_where('settings')->row_array();

      $response['bookingData'] = $this->db->get_where('booking_ride_request_master',array('booking_id'=>$id))->row_array();

      $response['driverData'] = $this->db->get_where('driver_master',array('id'=>$response['ridedata']['driver_id']))->row_array();

        $driver = $this->db->get_where('driver_master',array('id'=>$response['ridedata']['driver_id']))->row_array();

              $this->db->order_by('id','desc');  
      $list = $this->db->get_where('ride_log_history',array('booking_id'=>$id))->result_array();
      $table = "";
      $i = 1;
      foreach($list as $row)
      {
          $table .= '<tr id="row_'.$row['id'].'">';
          $table .= '<td>'.$i.'</td>';
          if ($row['type'] == 1) 
          { 
            $activity = $response['customerdata']['name'].' has created a new ride';
            $status = "Created";
          }
          elseif ($row['type'] == 2) 
          { 
            $activity = ucfirst($driver['name']).' has accepted the ride'; 
            $status = "Accepted";
          }
          elseif ($row['type'] == 3) 
          { 
            $activity = ucfirst($driver['name']).' has started the navigation to correspond location'; 
            $status = "Navigated";
          }
          elseif ($row['type'] == 4) 
          { 
            $activity = ucfirst($driver['name']).' has arrived at the location'; 
            $status = "Arrived";
          }
          elseif ($row['type'] == 5) 
          { 
            $activity = ucfirst($driver['name']).' has started ride to destination'; 
            $status = "Start to Destination";
          }
          elseif ($row['type'] == 6) 
          { 
            $activity = ucfirst($driver['name']).' has arrived to destination'; 
            $status = "Arrived at Destination";
          }
          elseif ($row['type'] == 7) 
          { 
            $activity = 'Ride completed'; 
            $status = "Completed";
          }
          elseif ($row['type'] == 8) 
          { 
            if ($row['cancel_by_type'] == 1) 
            {
               $canceldata = $this->db->get_where('customer_master',array('id'=>$row['cancel_by_id']))->row_array();
               $message = 'Ride cancelled by '.ucfirst($canceldata['name']). '(Customer)'; 
            }
            else
            {
               $canceldata = $this->db->get_where('driver_master',array('id'=>$row['cancel_by_id']))->row_array();
               $message = 'Ride cancelled by '.ucfirst($canceldata['name']). '(Pilot)'; 
            }

            $activity = $message; 
            $status = "Cancelled";
          }

          $table .= '<td>'.$activity.'</td>';
          $table .= '<td>'.$status.'</td>';
          $table .= '<td>'.date('dS M Y h:i A',$row['add_date']).'</td>';
          
          $table .= '</tr>';
          $i++;
      }
        $response['table'] = $table;

         $response['rating'] = $this->db->get_where('rating_master',array('booking_id'=>$id))->row_array(); 

      $this->load->view('owner/header/header',$response);
      $this->load->view('owner/header/left-menu',$response);
      $this->load->view('owner/completed_ride_details',$response);
      $this->load->view('owner/header/footer');
  }



   public function cancel_rides()
  {
    is_not_logged_in_owner();
    $owner_detail = is_not_logged_in_owner();
    $response['pageTitle']  = 'Cancel Rides - '.ProjectName;
    $response['pageIndex']  = 'cancel';
    $response['pageIndex1'] = "cancel_rides";

    $data = $this->input->post();
     if ($this->input->post()) 
    {
        if ($data['vehicles'] == '') 
        {
           $this->db->order_by('id','desc');  
    $list    = $this->db->get_where('ride_master',array('vehicle_owner_id'=>$owner_detail['id'],'status'=>2))->result_array();
        }
        else
        {
           $this->db->order_by('id','desc');  
    $list    = $this->db->get_where('ride_master',array('vehicle_id'=>$data['vehicles'],'vehicle_owner_id'=>$owner_detail['id'],'status'=>2))->result_array();
        }

        $response['vehicles_id'] = $data['vehicles'];  
               
    }
    else
    {
         $this->db->order_by('id','desc');  
    $list    = $this->db->get_where('ride_master',array('vehicle_owner_id'=>$owner_detail['id'],'status'=>2))->result_array();
         $response['vehicles_id'] = '';
    }


               /* $this->db->order_by('id','desc');  
    $list    =  $this->db->get_where('ride_master',array('vehicle_owner_id'=>$owner_detail['id'],'status'=>2))->result_array();*/

    $table = ""; 

      $i = 1;
      foreach($list as $row)
      {
          $table .= '<tr id="row_'.$row['id'].'">';
          $table .= '<td>'.$i.'</td>';
          $table .= '<td>'.$row['bookingId'].'</td>';

          $customer = $this->db->get_where('customer_master',array('id'=>$row['userId']))->row_array();

           $table .= '<td>'.(!empty($customer['name'])?ucfirst($customer['name']):"N/A").'</td>';
          $table .= '<td>'.(!empty($customer['mobile'])?$customer['mobile']:"N/A").'</td>';
           $table .= '<td>'.date('dS M Y h:i A',$row['modifyDate']).'</td>';
           $vehicle = $this->db->get_where('vehicle_master',array('id'=>$row['vehicle_id']))->row_array();
          $table .= '<td>'.ucfirst($vehicle['name']).'</td>';
          $table .= '<td>'.$row['totalCharge'].'</td>';

          $table .= '<td class="action">
          <a href="'.base_url("Owner/cancel_ride_details/".$row['id']."").'" class=""><button type="button" class="btn btn-default">View</button></a>
          </td>';
          $table .= '</tr>';
          $i++;
      }

    $response['table'] = $table;
       $response['vehicle_data'] = $this->db->get_where('vehicle_master')->result_array();

    $this->load->view('owner/header/header',$response);
    $this->load->view('owner/header/left-menu',$response);
    $this->load->view('owner/cancel_rides',$response);
    $this->load->view('owner/header/footer');
  }

  public function pending_ride_details()
{
    is_not_logged_in_owner();
$owner_detail = is_not_logged_in_owner();
    $id = $this->uri->segment(3,0);
    $response['pageTitle']  = 'Pending Rides Details - '.ProjectName;
    $response['pageIndex']  = 'pending';
    $response['pageIndex1'] = "pending_rides";
    $response['ridedata']   = $this->Ride_model->get_ride_details($id);
    $response['customerdata'] = $this->db->get_where('customer_master',array('id'=>$response['ridedata']['userId']))->row_array();

    $response['insuranceData'] = $this->db->get_where('insurance_master',array('id'=>$response['ridedata']['insuranceType']))->row_array();
    $response['currency'] = $this->db->get_where('settings')->row_array();

    $driver = $this->db->get_where('driver_master',array('id'=>$response['ridedata']['driver_id']))->row_array();

            $this->db->order_by('id','desc');  
    $list = $this->db->get_where('ride_log_history',array('booking_id'=>$id))->result_array();
      $table = "";
      $i = 1;
      foreach($list as $row)
      {
          $table .= '<tr id="row_'.$row['id'].'">';
          $table .= '<td>'.$i.'</td>';
          if ($row['type'] == 1) 
          { 
            $activity = $response['customerdata']['name'].' has created a new ride';
            $status = "Created";
          }
          elseif ($row['type'] == 2) 
          { 
            $activity = ucfirst($driver['name']).' has accepted the ride'; 
            $status = "Accepted";
          }
          elseif ($row['type'] == 3) 
          { 
            $activity = ucfirst($driver['name']).' has started the navigation to correspond location'; 
            $status = "Navigated";
          }
          elseif ($row['type'] == 4) 
          { 
            $activity = ucfirst($driver['name']).' has arrived at the location'; 
            $status = "Arrived";
          }
          elseif ($row['type'] == 5) 
          { 
            $activity = ucfirst($driver['name']).' has started ride to destination'; 
            $status = "Start to Destination";
          }
          elseif ($row['type'] == 6) 
          { 
            $activity = ucfirst($driver['name']).' has arrived to destination'; 
            $status = "Arrived at Destination";
          }
          elseif ($row['type'] == 7) 
          { 
            $activity = 'Ride completed'; 
            $status = "Completed";
          }
          elseif ($row['type'] == 8) 
          { 
            if ($row['cancel_by_type'] == 1) 
            {
               $canceldata = $this->db->get_where('customer_master',array('id'=>$row['cancel_by_id']))->row_array();
               $message = 'Ride cancelled by '.ucfirst($canceldata['name']). '(Customer)'; 
            }
            else
            {
               $canceldata = $this->db->get_where('driver_master',array('id'=>$row['cancel_by_id']))->row_array();
               $message = 'Ride cancelled by '.ucfirst($canceldata['name']). '(Pilot)'; 
            }

            $activity = $message; 
            $status = "Cancelled";
          }

          $table .= '<td>'.$activity.'</td>';
          $table .= '<td>'.$status.'</td>';
          $table .= '<td>'.date('dS M Y h:i A',$row['add_date']).'</td>';
          
          $table .= '</tr>';
          $i++;
      }

      $response['table'] = $table;

    $this->load->view('owner/header/header',$response);
    $this->load->view('owner/header/left-menu',$response);
    $this->load->view('owner/pending_ride_details',$response);
    $this->load->view('owner/header/footer');
  }

   public function cancel_ride_details()
  {
    is_not_logged_in_owner();
$owner_detail = is_not_logged_in_owner();
    $id = $this->uri->segment(3,0);

    $response['pageTitle']  = 'Cancel Rides Details - '.ProjectName;
    $response['pageIndex']  = 'pending';
    $response['pageIndex1'] = "cancel_rides";
    $response['ridedata']   = $this->Ride_model->get_ride_details($id);
    $response['customerdata'] = $this->db->get_where('customer_master',array('id'=>$response['ridedata']['userId']))->row_array();
     $response['insuranceData'] = $this->db->get_where('insurance_master',array('id'=>$response['ridedata']['insuranceType']))->row_array();
     $response['reasondata'] = $this->db->get_where('reason_master',array('id'=>$response['ridedata']['reasonId']))->row_array();

     $response['currency'] = $this->db->get_where('settings')->row_array();


    $response['bookingData'] = $this->db->get_where('booking_ride_request_master',array('booking_id'=>$id))->row_array();

    $response['driverData'] = $this->db->get_where('driver_master',array('id'=>$response['ridedata']['driver_id']))->row_array();

    $driver = $this->db->get_where('driver_master',array('id'=>$response['ridedata']['driver_id']))->row_array();

            $this->db->order_by('id','desc');  
    $list = $this->db->get_where('ride_log_history',array('booking_id'=>$id))->result_array();
      $table = "";
      $i = 1;
      foreach($list as $row)
      {
          $table .= '<tr id="row_'.$row['id'].'">';
          $table .= '<td>'.$i.'</td>';
          if ($row['type'] == 1) 
          { 
            $activity = $response['customerdata']['name'].' has created a new ride';
            $status = "Created";
          }
          elseif ($row['type'] == 2) 
          { 
            $activity = ucfirst($driver['name']).' has accepted the ride'; 
            $status = "Accepted";
          }
          elseif ($row['type'] == 3) 
          { 
            $activity = ucfirst($driver['name']).' has started the navigation to correspond location'; 
            $status = "Navigated";
          }
          elseif ($row['type'] == 4) 
          { 
            $activity = ucfirst($driver['name']).' has arrived at the location'; 
            $status = "Arrived";
          }
          elseif ($row['type'] == 5) 
          { 
            $activity = ucfirst($driver['name']).' has started ride to destination'; 
            $status = "Start to Destination";
          }
          elseif ($row['type'] == 6) 
          { 
            $activity = ucfirst($driver['name']).' has arrived to destination'; 
            $status = "Arrived at Destination";
          }
          elseif ($row['type'] == 7) 
          { 
            $activity = 'Ride completed'; 
            $status = "Completed";
          }
          elseif ($row['type'] == 8) 
          { 
            if ($row['cancel_by_type'] == 1) 
            {
               $canceldata = $this->db->get_where('customer_master',array('id'=>$row['cancel_by_id']))->row_array();
               $message = 'Ride cancelled by '.ucfirst($canceldata['name']). '(Customer)'; 
            }
            else
            {
               $canceldata = $this->db->get_where('driver_master',array('id'=>$row['cancel_by_id']))->row_array();
               $message = 'Ride cancelled by '.ucfirst($canceldata['name']). '(Pilot)'; 
            }

            $activity = $message; 
            $status = "Cancelled";
          }

          $table .= '<td>'.$activity.'</td>';
          $table .= '<td>'.$status.'</td>';
          $table .= '<td>'.date('dS M Y h:i A',$row['add_date']).'</td>';
          
          $table .= '</tr>';
          $i++;
      }

      $response['table'] = $table;

    $this->load->view('owner/header/header',$response);
    $this->load->view('owner/header/left-menu',$response);
    $this->load->view('owner/cancel_ride_details',$response);
    $this->load->view('owner/header/footer');
  }


  /**************************************END**************************************/



}
