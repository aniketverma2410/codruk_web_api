<?php
class Login_model extends CI_Model {
	 public function loginAccount($request){
	 	return $this->db->get_where('admin_master',array('username' => $request['username'], 'password' => base64_encode($request['password'])))->row_array();
	 	 //echo $this->db->last_query();exit();
	 }
	 // return total active driver
	 public function manageDrivers(){
	  return $this->db->get_where('driver_master',array('status'=>1))->num_rows();
	 }
     // return total active customer
	 public function manageCustomers(){
	 	return $this->db->get_where('customer_master',array('status'=>1))->num_rows();
	 }
    // demo code
	 public function uploadManagerInformation($response){
		   $upload = array();
		   $upload['title']      = ucfirst(trim($response['title']));
			   if($response['mediaType'] == 'video'):
			   	// it is pending task
			   	  if(!empty($response['video'])):
				     $upload['video_url']  = $response['video'];
				     $upload['thumbnail']  = $response['image'];
				     $upload['file_size']  = $response['FileSize'];
				  endif;
			    else:
			    	if(!empty($response['image']['file_name'])):
			         $upload['thumbnail']  = $response['image']['file_name'];
			         $upload['file_size']  = $response['FileSize'];
			       endif;
			    endif;
		   $upload['ip_address'] = $this->input->ip_address();
		   $upload['browser']    = $this->agent->browser().' '.$this->agent->version();
		   $upload['system']     = $this->agent->platform();
		   $upload['update_date'] = time();
		   $upload['status']     = 'activate';
		   $upload['file_type']  = $response['mediaType'];
		   if(empty($response['id'])):
		       $upload['add_date']   = time();
			   return $this->db->insert(MI_INFO,$upload);
			else:
	         $this->db->where('id',$response['id']);
	         $this->db->update(MI_INFO,$upload);
	         return $this->db->affected_rows();
			endif;
	 }

    public function getDefinitionData() {
		$setting_data 	= $this->db
    						->select('*')
    						->from('notification_definition_master')
    						->get()
    						->result_array();
		return $setting_data;
    }

    public function saveData($table, $data) {
    	$qry = $this->db->insert($table, $data);
		return 1;
    }

    public function updateData($data, $id, $table) {
    	$update_data = $this->db->where('id', $id)->update($table, $data);
    	return 1;
    }

    public function getDataById($table, $id) {
    	$setting_data 	= $this ->db
	    						->select('*')
	    						->from($table)
	    						->where(array('id' => $id))
	    						->get()
	    						->row_array();
		return $setting_data;
    }

    public function getData($table="") {
    	if($table == 'notification_setting_master'){

    		$setting_data 	= $this->db
	    						->select('notification_setting_master.*, notification_definition_master.name')
	    						->from('notification_setting_master')
	    						->join('notification_definition_master', 'notification_setting_master.definition = notification_definition_master.id')
	    						
	    						->where(array('notification_setting_master.status!=' => '3'))
	    						->get()
	    						->result_array();

    	} else{
    		$setting_data 	= $this->db
	    						->select('*')
	    						->from($table)
	    						->where(array('status!=' => '3'))
	    						->get()
	    						->result_array();
    	}
    	
		return $setting_data;
    }


}
?>
