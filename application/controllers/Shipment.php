<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Shipment extends CI_Controller {
      public function __construct(){
      parent::__construct();
      $this->load->model('Shipment_model');
      $this->load->model('Customer_model');
       $this->load->helper('message');
       is_not_logged_in();
       //$this->load->library('Mpdf');
       global $alphas,$count;
      $count=0;
      $alphas = range('A', 'Z');
    }
  // manage list
  public function index(){
    $response['pageTitle']  = 'Manage Shipment - '.ProjectName;
    $response['pageIndex']  = 'shipment';
    $response['pageIndex1']  = 'shipment';
    $results = $this->Shipment_model->getPostShipmentList();
    
    $response['drivers']     = $this->Customer_model->pilot_list();
    
    $response['result'] = array();
    if($results){
        foreach($results as $result){
            
            if($result['driver_id']!=0 && $response['drivers']){
                foreach($response['drivers'] as $driver){
                    if($driver['id']==$result['driver_id']){
                        $result['driver_id'] = $driver['name'];
                    }
                }
            }else{
                $result['driver_id'] = "";
            }
            
            $response['result'][] = array(
                    'ID' => $result['ID'],
                    'air_waybill_number' => $result['air_waybill_number'],
                    'customer_name' => $result['customer_name'],
                    'source_address' => $result['source_address'],
                    'receiver_name' => $result['receiver_name'],
                    'receiver_mobile_number' => $result['receiver_mobile_number'],
                    'destination_address' => $result['destination_address'],
                    'destination_city' => $result['destination_city'],
                    'booking_date' => $result['booking_date'],
                    'pickup_time' => $result['pickup_time'],
                    'delivered_time' => $result['delivered_time'],
                    'out_for_delivery_time' => $result['out_for_delivery_time'],
                    'rescheduled_date' => $result['rescheduled_date'],
                    'driver_id' => $result['driver_id'],
                    'status' => $result['status']
                );
        }
    }
    
    
     $search =  $this->input->post('Search');
     $search1 =  $this->input->post('Search1');
     $status =  $this->input->post('status');
     $response['download'] = '';
     if(!empty($search) || !empty($search1) || !empty($status)):
       $response['searchDate'] = $search;
       $response['searchDate1'] = $search1;
       $response['status'] = $status;
       if (!empty($response['result'])) {
       $response['download'] = '<div class="form-group">
                                  <div class="input-group date">
                                    <a href="download_pdf?search='.$search.'&search1='.$search1.'&status='.$status.'" class="btn btn-info">Download</a>
                                  </div>
                                </div>';
     } 
     endif;

    $response['search'] = $search;
    $response['search1'] = $search1; 
    $response['status'] = $status; 
    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('shipment_list',$response);
    $this->load->view('header/footer');
  }
  
  public function uploadshipments(){
        $fileName = $_FILES['shipments']['name'];
        $uploadPath = "./uploads/csv/";
       
        $config['upload_path'] = $uploadPath; 
       
        if (!file_exists($config['upload_path'])) {
            if (!mkdir($concurrentDirectory = $config['upload_path'], 0777,
                    true) && !is_dir($concurrentDirectory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }
        }
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '1024';
        $config['encrypt_name'] = false;
        $config['file_ext_tolower'] = true;
        
        
        $config['file_name'] = $fileName;


        $this->load->library('upload', $config);
        

        if ( ! $this->upload->do_upload('shipments')){
            die($this->upload->display_errors());
        }else{
            $upload_data = $this->upload->data();
            $file_name = $upload_data['file_name'];
            $csvFile = base_url().'uploads/csv/' . $file_name;
            
            $row = 0;
            
           // $csvFile ='http://demo.devrivers.com/codrukv2/uploads/csv/Mandatory_Fields.csv';
            
            if (($handle = fopen($csvFile, "r")) !== FALSE) {
                $shipment_array = array();
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    if($row==0){
                        $num = count($data);
                        for ($c=0; $c < $num; $c++) {
                            $shipment_array[$c] = strtolower(str_replace('.','',str_replace(' ','_',$data[$c])));
                        }
                    }
                    
                    $row++;
                }
                fclose($handle);
            }
            
            if (($handle = fopen($csvFile, "r")) !== FALSE) {
                $row = 0;
                $shipment_data_main_array_item = array();
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    if($row>=1){
                    $num = count($data);
                        $shipment_data_array = array();
                        for ($c=0; $c < $num; $c++) {
                            $shipment_data_array[$shipment_array[$c]] = $data[$c];
                        }
                    $shipment_data_main_array[] = $shipment_data_array;
                    }
                    $row++;
                }
                
                fclose($handle);
                
                $data = array();
                foreach($shipment_data_main_array as $shipment_data_main_array_item){
                        $data = array(
                            'air_waybill_number'              =>$shipment_data_main_array_item['air_waybill_number'],
                            'customer_name'              =>$shipment_data_main_array_item['customer_name'],
                            'customer_code'              =>$shipment_data_main_array_item['customer_code'],
                            'shipment_type'              =>$shipment_data_main_array_item['shipment_type'],
                            'customer_reference_number'              =>$shipment_data_main_array_item['customer_reference_number'],
                            'origin_pin'              =>$shipment_data_main_array_item['origin_pin'],
                            'destination_pin'              =>$shipment_data_main_array_item['destination_pin'],
                            'service_type'              =>$shipment_data_main_array_item['service_type'],
                            'service_type_name'              =>$shipment_data_main_array_item['service_type_name'],
                            'no_of_pieces'              =>$shipment_data_main_array_item['no_of_pieces'],
                            'length'              =>$shipment_data_main_array_item['length'],
                            'width'              =>$shipment_data_main_array_item['width'],
                            'height'              =>$shipment_data_main_array_item['height'],
                            'booking_date'              =>date('Y-m-d h:i:s',strtotime($shipment_data_main_array_item['booking_date'])),
                            'source_address'              =>$shipment_data_main_array_item['source_address'],
                            'destination_address'              =>$shipment_data_main_array_item['destination_address'],
                            'is_rto'              =>$shipment_data_main_array_item['is_rto'],
                            'status'              =>$shipment_data_main_array_item['status'],
                            'receiver_name'              =>$shipment_data_main_array_item['receiver_name'],
                            'receiver_mobile_number'              =>$shipment_data_main_array_item['receiver_mobile_number'],
                            'consignment_weight'              =>$shipment_data_main_array_item['consignment_weight'],
                            'consignment_description'              =>$shipment_data_main_array_item['consignment_description'],
                            'prepaid_amount'              =>$shipment_data_main_array_item['prepaid_amount'],
                            'last_updation_time'              =>date('Y-m-d h:i:s',strtotime($shipment_data_main_array_item['last_updation_time'])),
                            'current_hub'              =>$shipment_data_main_array_item['current_hub'],
                            'pickup_attempt_count'              =>$shipment_data_main_array_item['pickup_attempt_count'],
                            'first_delivery_attempt'              =>$shipment_data_main_array_item['first_delivery_attempt'],
                            'second_delivery_attempt'              =>$shipment_data_main_array_item['second_delivery_attempt'],
                            'third_delivery_attempt'              =>$shipment_data_main_array_item['third_delivery_attempt'],
                            'delivery_attempt_count'              =>$shipment_data_main_array_item['delivery_attempt_count'],
                            'destination_city'              =>$shipment_data_main_array_item['destination_city'],
                            'movement_type'              =>$shipment_data_main_array_item['movement_type'],
                            'pickup_time'              =>date('Y-m-d h:i:s',strtotime($shipment_data_main_array_item['pickup_time'])),
                            'rto_time'              =>date('Y-m-d h:i:s',strtotime($shipment_data_main_array_item['rto_time'])),
                            'delivered_time'              =>date('Y-m-d h:i:s',strtotime($shipment_data_main_array_item['delivered_time'])),
                            'out_for_delivery_time'              =>date('Y-m-d h:i:s',strtotime($shipment_data_main_array_item['out_for_delivery_time'])),
                            'rescheduled_date'              =>date('Y-m-d h:i:s',strtotime($shipment_data_main_array_item['rescheduled_date'])),
                        );
                    
                    
                    $this->db->insert('shipments',$data);
                }
              
            }
        }
        redirect(base_url('Shipment/index'));
  }


  function download_pdf()
    { 
      error_reporting(0);
      $adminData = $this->session->userdata('adminData');
      $search = $_GET['search'];
      $search1 = $_GET['search1'];
      $status = $_GET['status'];

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
            
         }

                  
           if(!empty($status) && empty($search) && empty($search1))
           {
             $this->db->where('status',$status);
             $list =  $this->db->get_where('shipments')->result_array(); 
           }
           else
           { 
               if (!empty($status)) 
               {
                  $this->db->where('status',$status);
               }  
             $list =  $this->db->get_where('shipments',array('add_date >='=> strtotime($currentDate),'add_date <='=>strtotime($endDate)))->result_array(); 
           }
        


            $link  = time()."-invoice.pdf";
            $html  = '';
            $html .= '<h3 style="text-align:center"><u>Shipment Invoice</u></h3>';
            $html .= '<div style="float:left;font-size:12px;">Helping number : 920021105</div><div style="float:right; margin-left: 150px; position: absolute;left:390px;right: 0;font-size:12px;">DateTime : '.date('dS m Y h:i A').'</div>';

            if ($adminData['type'] == 1) 
            {
              $name = ucfirst($adminData['name']);
            }
            else
            {
              $name = ucfirst($adminData['name']).'-'.$adminData['uuid']; 
            }

            $html .= '<div style="float:left;position:absolute;top:150px;font-size:12px;">Emp Name-Code : '.$name.'</div>';

            $html .= '<div style="float:left;width:100%; margin-top:100px;"><table width="100%" style="border: 1px solid #333" ><tr>
            <th style="padding:10px;font-size:10px;">Sr.No.</th>
            <th style="padding:10px;font-size:10px;width:100px;">Shipper</th>
            <th style="padding:10px;font-size:10px;width:100px;">Consignee</th>
            <th style="padding:10px 2px;font-size:10px;">Collection Type</th>
            <th style="padding:10px;font-size:10px;">Amount</th>
            <th style="padding:10px;font-size:10px;">Signature</th>
            <th style="padding:10px;font-size:10px;">Comment</th>
            <th style="padding:10px;font-size:10px;width:125px;">AWB Barcode</th>
            </tr>';

            $i = 1;
            foreach ($list as $key => $value) 
            {   
                if (!empty($value['borcode_base'])) 
                {
                  $image = base_url('mediaFile/barcode/'.$value['borcode_base']);
                }
                else
                {
                   $image = base_url('mediaFile/vehicles/no.jpeg');
                }

                $html .= '<tr>
                <td style="font-size:10px;text-align:center">'.$i.'.</td>
                <td style="font-size:10px;text-align:center">'.ucfirst($value['shipper_name']).'<br>'.$value['shipper_address'].'<br>'.$value['shipper_city'].'</td>
                <td style="font-size:10px;text-align:center">'.ucfirst($value['consignee_name']).'<br>'.$value['consignee_address'].'<br>'.$value['consignee_city'].'<br>'.$value['consignee_mobile_number'].'</td>
                <td style="font-size:10px;text-align:center">'.strtoupper($value['collection_type']).'</td>
                <td style="font-size:10px;text-align:center">'.$value['collection_amount'].'</td>
                <td style="font-size:10px;text-align:center">'.''.'</td>
                <td style="font-size:10px;text-align:center">'.''.'</td>
                <td style="font-size:10px;text-align:center">'.'<img src="'.$image.'" width="100px" height="50px;" style="padding:10px 10px 0px 10px;">'.$value['borcode_id'].'</td>
                </tr>';

                $i++;
            } 

            $html .= '</table></div>';

            $pdfFilePath =  'SHIPMENT_INVOICE'.'['.date('d-m-Y h:i:s A').'].pdf';
            include_once APPPATH.'/third_party/mpdf/mpdf.php';
            $mpdf =  new mPDF('utf-8', 'A4-P');
            $mpdf->autoScriptToLang = true;
            $mpdf->baseScript = 1;
            $mpdf->autoVietnamese = true;
            $mpdf->autoArabic = true;
            $mpdf->autoLangToFont = true; 


            $PDFContent = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
            $mpdf->WriteHTML($PDFContent);
            $mpdf->Output($pdfFilePath, "D"); 


            return $pdfFilePath;

       

      

    }

  public function update_shipment($id){
    $response['pageTitle']  = 'Manage Shiment - '.ProjectName;
    $response['pageIndex']  = 'shipment';
    $response['pageIndex1']  = 'shipment';
    $response['result'] = $this->Shipment_model->getUpdateShipmentList($id);
    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('view-shipment',$response);
    $this->load->view('header/footer');  
  }
  public function updateStatus(){
      $data = $this->input->post();
      $this->db->where('id',$data['id']);
      $this->db->update('shipments',array('status'=>$data['status']));
      if($data['status'] == 1){
            $this->session->set_flashdata('message',generateAdminAlert('S',26));
      }else{
          $this->session->set_flashdata('message',generateAdminAlert('S',26));  
      }
      redirect(base_url('Shipment/index'));
  }
  
  
  public function assignshipment(){
      is_not_logged_in();
      if ($this->input->post()) 
        {    
            $data = $this->input->post();
    
            $this->db->where('ID',$data['shipmentId']);
            $field['driver_id']  = $data['driverId'];
            $query = $this->db->update('shipments',$field);
            
            if ($query)
            {   
                
               $booking_data = $this->db->get_where('shipments',array('ID'=>$data['shipmentId']))->row_array();

                $device_id = $this->db->select('*')
                             ->from('login_master')
                             ->where(array('userID' => $data['driverId'],'type'=>2))
                             ->get()->result_array();
                
                foreach ($device_id as $device_id_data) 
                {
                      $Device_Id = $device_id_data['device_token'];

                      // Message to be sent
                      $message = "1 New Shipment Arrived";
                      $dataMessage = array();
                      $dataMessage['Codruk']['message']  = $message;
                      $dataMessage['Codruk']['booking_details']  = json_encode($booking_data);
                      $dataMessage['Codruk']['regId']  = $Device_Id;
                      $dataMessage['Codruk']['apikey']   = "AAAAxm2v14c:APA91bEfay7Rff6TK85Ine_PDK6b90mjle_UkbKHY2-4Jpvi-qUJA_FMw9x7QVCALXR6EkaCp_IHuTXqSIGeYIimjZO-VISLeRFPR_PbXkJPPi6NiPt4gMADLXpIkPeBnmGhv_gMvZJj";
                      $dataMessage['Codruk']['notification_type']  = "01";
                      $sendMessage = json_encode($dataMessage, true);

                      $send_notification = $this->pushSurveyorNotification($sendMessage);
                }

              $send_notification = $this->pushSurveyorNotification($sendMessage);
                
                $message = '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Shipment Assigned successfully.</div>';
                $this->session->set_flashdata('message', $message);
                redirect(site_url('Shipment/index'), 'refresh'); 
            }
            else
            {
                $message = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$server_output.'Please try again.</div>';
                $this->session->set_flashdata('message', $message);
                redirect(site_url('Shipment/index'), 'refresh');
            }
    
        }    
       
  }
  
  public function pushSurveyorNotification($send_data){

        $requestJson = json_decode($send_data, true);

        if (empty($requestJson)) {
            generateServerResponse('0', '100');
        }

         $check_request_keys = array(
                    '0' => 'message',
                    '1' => 'regId',
                    '2' => 'apikey',
                    '3' => 'booking_details',
                    '4' => 'notification_type'
                );

           // $notification_type  = '01';           
            $regId = trim($requestJson['Codruk']['regId']);
            $notification_type = trim($requestJson['Codruk']['notification_type']);
            $registrationId = ''; // set variable as array

            // get all ids in while loop and insert it into $regIDS array
            $deviceIds = explode(",", $regId);
            
            foreach ($deviceIds as  $devid) { 
                $registrationId .= $devid.",";
            }

            $message  = trim($requestJson['Codruk']['message']);            
            $apikey   = trim($requestJson['Codruk']['apikey']);
            $booking_details  = trim($requestJson['Codruk']['booking_details']);
                        
            //$url = 'https://android.googleapis.com/gcm/send'; 
            $url = 'https://fcm.googleapis.com/fcm/send'; 

            $fields = array(
                            'to'  => rtrim($registrationId,","),
                            /*'notification' => array(
                                    
                            ),*/
                            'data' => array(
                                "title" => "Codruk",
                                "body"  => $message,
                                "notification_type" => $notification_type,
                                "booking_details" =>json_decode($booking_details, true)
                            ),
                            'priority' => "high"
                        ); 
           
            $headers = array( 
                                'Authorization: key=' . $apikey,
                                'Content-Type: application/json'
                            );
           
           $data = json_encode( $fields );
            // Open connection
            $ch = curl_init();

            // Set the url, number of POST vars, POST data
            curl_setopt( $ch, CURLOPT_URL, $url );
            curl_setopt( $ch, CURLOPT_POST, true );
            curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );

            // Execute post
            $result = curl_exec($ch);
            //print_r($result);die;
            // Close connection
            curl_close($ch);

            return $result;
    }
}
