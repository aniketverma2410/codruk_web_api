<?php
class Shipment_model extends CI_Model {
	public function __construct(){
	parent::__construct();
	$this->load->database();
}
   /* public function getPostShipmentList()
    {  
         $search =  $this->input->post('Search');
         if(!empty($search)):
                $currentDate = date('d-m-Y 00:00:00',strtotime($search));
                $endDate = date('d-m-Y 23:59:59',strtotime($search));
             else:
                $currentDate = date('d-m-Y 00:00:00',time());
                $endDate = date('d-m-Y 23:59:59',time());  
           endif;
       return $this->db->get_where('post_shipment',array('add_date >='=> strtotime($currentDate),'add_date <='=>strtotime($endDate)))->result_array();
    }*/

     public function getPostShipmentList()
    {  
         $search =  $this->input->post('Search');
         $search1 =  $this->input->post('Search1');
         $status =  $this->input->post('status');
         $type = 1;
         if (!empty($search) && empty($search1)) 
         {
            $currentDate = date('d-m-Y h:i A',strtotime($search));
            $endDate = date('d-m-Y 23:59:59',time());
         }elseif(empty($search) && !empty($search1)){
            $currentDate = date('d-m-Y 00:00:00',strtotime($search1));
            $endDate = date('d-m-Y h:i A',strtotime($search1));
         }elseif(!empty($search) && !empty($search1)){
            $currentDate  = date('d-m-Y h:i A',strtotime($search));
            $endDate     = date('d-m-Y h:i A',strtotime($search1));
         }else{
            $currentDate = date('d-m-Y 00:00:00',time());
            $endDate = date('d-m-Y 23:59:59',time());
            $type = 2;
         }

       if ($type == 1) 
       {    
            if(!empty($status)){
             $this->db->where('status',$status);
            }
            return $this->db->get_where('shipments',array('add_date >='=> strtotime($currentDate),'add_date <='=>strtotime($endDate)))->result_array();
       }
       else
       {   
            if(!empty($status)){
             $this->db->where('status',$status);
            }
           return $this->db->get_where('shipments')->result_array();
       }  
      
    }



     public function getUpdateShipmentList($getID){  
       return $this->db->get_where('shipments',array('id'=>$getID))->row_array();
    }
}
?>