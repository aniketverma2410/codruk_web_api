<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Rides extends CI_Controller {
  public function __construct(){
  parent::__construct();
  $this->load->model('Ride_model');
  $this->load->model('Common_model');
  $this->load->helper('message');
       date_default_timezone_set('Asia/Kolkata');
}
  // manage list
  public function pending_rides(){
    is_not_logged_in();
    $response['pageTitle']  = 'Pending Rides - '.ProjectName;
    $response['pageIndex']  = 'pending';
    $response['pageIndex1'] = "pending_rides";
    $data = $this->input->post();

    if ($this->input->post()) 
    {
        if ($data['vehicles'] == '') 
        {
           $list    = $this->Ride_model->get_pending_rides();
        }
        else
        {
           $list    = $this->Ride_model->get_pending_rides_vehicles($data['vehicles']); 
        }

        $response['vehicles_id'] = $data['vehicles'];  
               
    }
    else
    {
         $list    = $this->Ride_model->get_pending_rides();
         $response['vehicles_id'] = '';
    }

    //$list    = $this->Ride_model->get_pending_rides();
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
          <a href="'.base_url("Rides/pending_ride_details/".$row['id']."").'" class=""><button type="button" class="btn btn-default">View</button></a>
          </td>';
          $table .= '</tr>';
          $i++;
      }

    $response['table'] = $table;

    $response['vehicle_data'] = $this->db->get_where('vehicle_master')->result_array();

    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('pending_rides',$response);
    $this->load->view('header/footer');
  }

   public function running_rides()
   {
      is_not_logged_in();
      $response['pageTitle']  = 'Running Rides - '.ProjectName;
      $response['pageIndex']  = 'running';
      $response['pageIndex1'] = "running_rides";

      $data = $this->input->post();

      if ($this->input->post()) 
      {
          if ($data['vehicles'] == '') 
          {
                       $this->db->order_by('id','desc'); 
            $list    = $this->db->get_where('ride_master',array('status'=>4))->result_array();
          }
          else
          {
                  $this->db->order_by('id','desc'); 
            $list    = $this->db->get_where('ride_master',array('vehicle_id'=>$data['vehicles'],'status'=>4))->result_array();
          }

          $response['vehicles_id'] = $data['vehicles'];  
                 
      }
      else
      {
                      $this->db->order_by('id','desc'); 
          $list    = $this->db->get_where('ride_master',array('status'=>4))->result_array();
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
            <a href="'.base_url("Rides/running_ride_details/".$row['id']."").'" class=""><button type="button" class="btn btn-default">View</button></a>
            <a href="'.base_url("Rides/show_map/".$row['id']."").'" class=""><button type="button" class="btn btn-info">Show Location on Map</button></a>
            </td>';
            $table .= '</tr>';
            $i++;
        }

      $response['table'] = $table;

       $response['vehicle_data'] = $this->db->get_where('vehicle_master')->result_array();

      $this->load->view('header/header',$response);
      $this->load->view('header/left-menu',$response);
      $this->load->view('running_rides',$response);
      $this->load->view('header/footer');
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

      $this->load->view('header/header',$response);
      $this->load->view('header/left-menu',$response);
      $this->load->view('show_map',$response);
      $this->load->view('header/footer');
  }

   public function running_ride_details()
   {
      is_not_logged_in();
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

      $this->load->view('header/header',$response);
      $this->load->view('header/left-menu',$response);
      $this->load->view('running_ride_details',$response);
      $this->load->view('header/footer');
  }


   public function completed_rides()
   {
      is_not_logged_in();
      $response['pageTitle']  = 'Completed Rides - '.ProjectName;
      $response['pageIndex']  = 'completed';
      $response['pageIndex1'] = "completed_rides";

      $data = $this->input->post();

      if ($this->input->post()) 
      {
          if ($data['vehicles'] == '') 
          {
                       $this->db->order_by('id','desc'); 
            $list    = $this->db->get_where('ride_master',array('status'=>3))->result_array();
          }
          else
          {
                  $this->db->order_by('id','desc'); 
            $list    = $this->db->get_where('ride_master',array('vehicle_id'=>$data['vehicles'],'status'=>3))->result_array();
          }

          $response['vehicles_id'] = $data['vehicles'];  
                 
      }
      else
      {
                      $this->db->order_by('id','desc'); 
           $list    = $this->db->get_where('ride_master',array('status'=>3))->result_array();
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
            <a href="'.base_url("Rides/completed_ride_details/".$row['id']."").'" class=""><button type="button" class="btn btn-default">View</button></a>
            </td>';
            $table .= '</tr>';
            $i++;
        }

      $response['table'] = $table;

       $response['vehicle_data'] = $this->db->get_where('vehicle_master')->result_array();

      $this->load->view('header/header',$response);
      $this->load->view('header/left-menu',$response);
      $this->load->view('completed_rides',$response);
      $this->load->view('header/footer');
  }

   public function completed_ride_details()
   {
      is_not_logged_in();
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

      $this->load->view('header/header',$response);
      $this->load->view('header/left-menu',$response);
      $this->load->view('completed_ride_details',$response);
      $this->load->view('header/footer');
  }



   public function cancel_rides(){
    is_not_logged_in();
    $response['pageTitle']  = 'Cancel Rides - '.ProjectName;
    $response['pageIndex']  = 'cancel';
    $response['pageIndex1'] = "cancel_rides";

    $data = $this->input->post();

      if ($this->input->post()) 
      {
          if ($data['vehicles'] == '') 
          {
                       $this->db->order_by('id','desc'); 
            $list    = $this->db->get_where('ride_master',array('status'=>2))->result_array();
          }
          else
          {
                  $this->db->order_by('id','desc'); 
            $list    = $this->db->get_where('ride_master',array('vehicle_id'=>$data['vehicles'],'status'=>2))->result_array();
          }

          $response['vehicles_id'] = $data['vehicles'];  
                 
      }
      else
      {
                      $this->db->order_by('id','desc'); 
          $list    = $this->db->get_where('ride_master',array('status'=>2))->result_array();
           $response['vehicles_id'] = '';
      }

    //$list    = $this->Ride_model->get_cancel_rides();
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
          <a href="'.base_url("Rides/cancel_ride_details/".$row['id']."").'" class=""><button type="button" class="btn btn-default">View</button></a>
          </td>';
          $table .= '</tr>';
          $i++;
      }

    $response['table'] = $table;
     $response['vehicle_data'] = $this->db->get_where('vehicle_master')->result_array();

    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('cancel_rides',$response);
    $this->load->view('header/footer');
  }

  public function pending_ride_details(){
    is_not_logged_in();
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

    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('pending_ride_details',$response);
    $this->load->view('header/footer');
  }

   public function cancel_ride_details(){
    is_not_logged_in();
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

      $rideData = $this->db->get_where('ride_master',array('id'=>$id))->row_array();

      if (!empty($rideData['driver_id'])) 
      {
        $driverstatus = 1;
      }
      else
      {
        $driverstatus = 2;
      }

      $response['driverstatus'] = $driverstatus;

    $this->load->view('header/header',$response);
    $this->load->view('header/left-menu',$response);
    $this->load->view('cancel_ride_details',$response);
    $this->load->view('header/footer');
  }


 
/*******************END*********************/

}
