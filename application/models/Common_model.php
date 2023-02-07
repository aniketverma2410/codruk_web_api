<?php
class Common_model extends CI_Model {
	public function __construct(){
	parent::__construct();
	$this->load->helper('api');
	$this->load->database();
}
    public function getVehicleData(){  
       return $this->db->get_where('vehicle_master')->result_array();
    }
//get table data by id
    public function getDataViaId($table,$id){  
       return $this->db->get_where($table,array('id'=>$id))->row_array();
    }

// get differ type unit
    public function getDataViaType($table,$type){  
       return $this->db->get_where($table,array('unit_type'=>$type))->result_array();
    }
// image upload code here
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
}
?>