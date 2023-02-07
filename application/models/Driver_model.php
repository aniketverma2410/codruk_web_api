<?php
class Driver_model extends CI_Model {
	public function __construct(){
	parent::__construct();
	$this->load->helper('api');
	$this->load->database();

}
 
    public function manageDrivers(){  
              $this->db->order_by('id','desc');  
       return $this->db->get_where('driver_master')->result_array();
    }

    public function getPersonalData($id){  
       return $this->db->get_where('driver_master',array('id'=>$id))->row_array();
    }

}
?>