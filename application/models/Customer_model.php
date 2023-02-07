<?php
class Customer_model extends CI_Model {
  public function __construct(){
    parent::__construct();
    $this->load->helper('api');
    $this->load->database();
  }
// get customer list
    public function manageCustomers(){  
       return $this->db->query("SELECT * FROM `customer_master` WHERE `type` NOT IN (1,2) ORDER BY id desc")->result_array();
    }

     public function pilot_list()
    {           
              $this->db->order_by('id','desc');
       return $this->db->get_where('driver_master')->result_array();
    }

      public function getstatusdata($id)
    {  
         $search =  $this->input->post('Search');
         $search1 =  $this->input->post('Search1');
        
       if (!empty($search)) 
       {           $this->db->order_by('id','desc');   
           return $this->db->get_where('online_status_log',array('month'=> $search1,'year'=>$search,'driver_id'=>$id))->result_array();
       }
       else
       {   
           $current_month = date('m');
           $current_year = date('Y');

                  $this->db->order_by('id','desc');    
           return $this->db->get_where('online_status_log',array('month'=>$current_month,'year'=>$current_year,'driver_id'=>$id))->result_array();
       }  
      
    }

// get customer list via type
    public function getCustomerViaType($type){  

       $this->db->order_by('id','desc');
       return $this->db->get_where('customer_master',array('type'=>$type))->result_array();
    }

// get Last Login Details
    public function getLastLoginDetails($userId,$type,$status){  
    	$this->db->order_by('id','desc');
        return $this->db->get_where('login_master',array('userID'=>$userId,'type'=>$type, 'loginStatus'=>$status))->row_array();
    }

// get Login Details
public function getLoginHistoryData($userId){  
	$this->db->order_by('id','desc');
    return $this->db->get_where('login_master',array('userID'=>$userId,'type'=>1, 'loginStatus'=>1))->result_array();
}  

public function getPilotLoginHistoryData($userId){  
  $this->db->order_by('id','desc');
    return $this->db->get_where('login_master',array('userID'=>$userId,'type'=>2, 'loginStatus'=>1))->result_array();
}  


}
?>