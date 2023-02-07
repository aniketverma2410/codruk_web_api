<?php
class ApiModel extends CI_Model {
  public function __construct(){
    parent::__construct();
    $this->load->helper('api');
    $this->load->database();
  }

// Favorite Data Post Here
  public function favoriteDataPost($requestData){  
    $param                 = array();
    $param['userType']     = $requestData['userType'];
    $param['userId']       = $requestData['uid'];
    $param['lat']          = $requestData['lat'];
    $param['long']         = $requestData['long'];
    $param['subAddress']   = $requestData['subAddress'];
    $param['address']      = $requestData['address'];
    $param['deviceId']     = $requestData['deviceId'];
    $param['status']       = 1;
    $param['addDate']      = time();
    $param['modifyDate']   = time();
    $checkDuplicat = $this->db->get_where('favorite_master',array('userId'=>$requestData['uid'],'status'=>1,'address'=>$requestData['address'],'userType'=>$requestData['userType']))->num_rows();

    if($checkDuplicat > 0){
      generateServerResponse(S,'127');
    }else{
        $excuteQuery = $this->db->insert('favorite_master',$param);
    }
    
    if($excuteQuery > 0){
        generateServerResponse(S,'126');
    }else{
        generateServerResponse(F,'W');
    }
  }

   public function set_favourite_location($requestData)
  {  
     if ($requestData['type'] == 1) 
     {
       $updateArray['favourite_location']  = $requestData['favourite_location'];
       $updateArray['favourite_latitude']  = $requestData['favourite_latitude'];
       $updateArray['favourite_longitude'] = $requestData['favourite_longitude'];

       $setting = $this->db->get_where('settings')->row_array();
       $check = $this->db->get_where('driver_master',array('id'=>$requestData['userId']))->row_array();
       $currentdate = date('Y-m-d');
       if ($check['favourite_date'] == $currentdate && $check['favourite_count'] == $setting['favourite_count'])
        {
          generateServerResponse(F,'229');
        }
        else
        {
           $count = $check['favourite_count']+1;
           $updateArray['favourite_count']     = $count;
           $updateArray['favourite_date']      = $currentdate;

           $this->db->where('id',$requestData['userId']);
           $this->db->update('driver_master',$updateArray);

           generateServerResponse(S,'Success',$updateArray);
        }
     }
     else
     {
        $updateArray['favourite_location']  = $requestData['favourite_location'];
        $updateArray['favourite_latitude']  = $requestData['favourite_latitude'];
        $updateArray['favourite_longitude'] = $requestData['favourite_longitude'];
        $this->db->where('id',$requestData['userId']);
        $this->db->update('driver_master',$updateArray);

        generateServerResponse(S,'Success',$updateArray);
     }
     
  }

     public  function get_available_hours($requestData)
   {   
      //$date = date('Y-m-d');     
      //$current_date = date('Y-m-d', strtotime($date. ' - 7 days'));

                    $this->db->order_by('id','desc'); 
                    $this->db->group_by('on_off_master.add_date');
      $data_hours = $this->db->get_where('on_off_master',array('driver_id'=>$requestData['userId'],'add_date <='=>$requestData['from_date'],'add_date >='=>$requestData['to_date']))->result_array();

      $data_array = array();
      $totaltime = 0;
      $getLastDate = '';
      $t_new = "";
      $t_new1 = "";
      foreach ($data_hours as $key => $value) 
      {               
         $checkdate = $this->db->get_where('on_off_master',array('driver_id'=>$requestData['userId'],'add_date'=>$value['add_date']))->result_array();

         $time_data = "";
         foreach ($checkdate as  $value1) 
         {
            if (!empty($value1['offline_time'])) 
           {
              $offline_time = $value1['offline_time'];
           }  
           else
           {
              $offline_time = time();
           }

           $total_hours = $offline_time-$value1['online_time'];
           $time_data = $time_data + $total_hours;
         }

          /***********************************New Time Duration Implementation********************/    

            $tm = $time_data;
            $time_data = $this->secondsToTime($tm);
            if ($time_data['d'] > 1) 
            {
                $D = 'd';
            }
            else
            {
                $D = 'd';
            }

            if ($time_data['h'] > 1) 
            {
                $H = 'h';
            }
            else
            {
                $H = 'h';
            }

            if ($time_data['m'] > 1) 
            {
                $M = 'm';
            }
            else
            {
                $M = 'm';
            }

             if ($time_data['s'] > 1) 
            {
                $S = 's';
            }
            else
            {
                $S = 's';
            }

            if ($time_data['d'] > 0) 
            {   
                $t = $time_data['d'].''.$D.' '.$time_data['h'].''.$H.' '.$time_data['m'].''.$M;
            }
            else
            {
                if ($time_data['h'] > 0) 
                {   
                    $t = $time_data['h'].''.$H.' '.$time_data['m'].''.$M;
                }
                else
                {
                    if ($time_data['m'] > 0) 
                    {   
                        $t = $time_data['m'].''.$M;
                    }
                    else
                    {
                        $t = $time_data['m'].''.$M;
                    }
                }
            }

            /*************************************End************************************************/

           
            $totaltime = $totaltime+$tm;
            $time_data_new = $this->secondsToTime($totaltime);
            if ($time_data_new['d'] > 1) 
            {
                $D_new = 'd';
            }
            else
            {
                $D_new  = 'd';
            }

            if ($time_data_new['h'] > 1) 
            {
                $H_new  = 'h';
            }
            else
            {
                $H_new  = 'h';
            }

            if ($time_data_new['m'] > 1) 
            {
                $M_new  = 'm';
            }
            else
            {
                $M_new  = 'm';
            }

             if ($time_data_new['s'] > 1) 
            {
                $S_new  = 's';
            }
            else
            {
                $S_new  = 's';
            }

            if ($time_data_new['d'] > 0) 
            {   
                $t_new  = $time_data_new['d'].''.$D_new .' '.$time_data_new['h'].''.$H_new .' '.$time_data_new['m'].''.$M_new ;
            }
            else
            {
                if ($time_data_new['h'] > 0) 
                {   
                    $t_new  = $time_data_new['h'].''.$H_new .' '.$time_data_new['m'].''.$M_new ;
                }
                else
                {
                    if ($time_data_new['m'] > 0) 
                    {   
                        $t_new  = $time_data_new['m'].''.$M_new ;
                    }
                    else
                    {
                        $t_new  = $time_data_new['m'].''.$M_new ;
                    }
                }
            }

        

         $data_array['Avail_hours'][$key]['day'] = date('D',$value['online_time']);   
         $data_array['Avail_hours'][$key]['Date'] = date('M d,Y',$value['online_time']);
         $data_array['Avail_hours'][$key]['Duration'] = $t;
         $getLastDate = date('M d Y',$value['online_time']);
      }

      $data_array['Total_hours'] = $t_new;

      /***********************all hours************************/

                    $this->db->order_by('id','desc'); 
                    $this->db->group_by('on_off_master.add_date');
      $all_hours = $this->db->get_where('on_off_master',array('driver_id'=>$requestData['userId']))->result_array();
      $totaltime = 0;
      foreach ($all_hours as $key => $value) 
      {
           $checkdate1 = $this->db->get_where('on_off_master',array('driver_id'=>$requestData['userId'],'add_date'=>$value['add_date']))->result_array();

           $time_data = "";
           foreach ($checkdate1 as  $value1) 
           {
              if (!empty($value1['offline_time'])) 
             {
                $offline_time = $value1['offline_time'];
             }  
             else
             {
                $offline_time = time();
             }

             $total_hours = $offline_time-$value1['online_time'];
             $time_data = $time_data + $total_hours;
           }

            $totaltime = $totaltime+$time_data;
         
            $time_data_new = $this->secondsToTime($totaltime);
            if ($time_data_new['d'] > 1) 
            {
                $D_new = 'd';
            }
            else
            {
                $D_new  = 'd';
            }

            if ($time_data_new['h'] > 1) 
            {
                $H_new  = 'h';
            }
            else
            {
                $H_new  = 'h';
            }

            if ($time_data_new['m'] > 1) 
            {
                $M_new  = 'm';
            }
            else
            {
                $M_new  = 'm';
            }

             if ($time_data_new['s'] > 1) 
            {
                $S_new  = 's';
            }
            else
            {
                $S_new  = 's';
            }

            if ($time_data_new['d'] > 0) 
            {   
                $t_new1  = $time_data_new['d'].''.$D_new .' '.$time_data_new['h'].''.$H_new .' '.$time_data_new['m'].''.$M_new ;
            }
            else
            {
                if ($time_data_new['h'] > 0) 
                {   
                    $t_new1  = $time_data_new['h'].''.$H_new .' '.$time_data_new['m'].''.$M_new ;
                }
                else
                {
                    if ($time_data_new['m'] > 0) 
                    {   
                        $t_new1  = $time_data_new['m'].''.$M_new ;
                    }
                    else
                    {
                        $t_new1  = $time_data_new['m'].''.$M_new ;
                    }
                }
            }
      }

        $data_array['All_total_hours'] = $t_new1;
          /* If not empty avail hours array data*/
       if(!empty($data_array['Avail_hours'])):
            $count = count($data_array['Avail_hours']);
            for($i = $count; $i < 7; $i++){
                $nextdate = strtotime(date('Y-m-d', strtotime($getLastDate. ' - '.$i.' days')));
                $data_array['Avail_hours'][$i]['day']  = date('D',$nextdate);   
                $data_array['Avail_hours'][$i]['Date'] = date('M d,Y',$nextdate);
                $data_array['Avail_hours'][$i]['Duration'] = '0h 0m'; 
            }
       else:
        $getLastDate = $requestData['from_date'];
         for($i = 0; $i < 7; $i++){
            $nextdate = strtotime(date('Y-m-d', strtotime($getLastDate. ' - '.$i.' days')));
            $data_array['Avail_hours'][$i]['day']  = date('D',$nextdate);   
            $data_array['Avail_hours'][$i]['Date'] = date('M d,Y',$nextdate);
            $data_array['Avail_hours'][$i]['Duration'] = '0h 0m'; 
        }
       endif;
       /* Close */

      /***************************END**************************/
          generateServerResponse(S,'222',$data_array);
      // if (!empty($data_hours)) 
      // {
          // generateServerResponse(S,'222',$data_array);
      // }
      // else
      // {
      //    generateServerResponse(F,'223');
      // }

   }


    public function get_my_job($requestData)
   {    
      if ($requestData['type'] == 1) 
      {
                $this->db->order_by('id','desc');
        $list = $this->db->get_where('ride_master',array('userId'=>$requestData['userId'],'status'=>$requestData['status']))->result_array();

        $data_array = array();
        foreach ($list as $key => $value) 
        {
          $vehicledata = $this->db->get_where('vehicle_master',array('id'=>$value['vehicle_id']))->row_array();

          $data_array['RideData'][$key]['id'] = $value['id'];
          $data_array['RideData'][$key]['pickupAddress'] = $value['pickupAddress'];
          $data_array['RideData'][$key]['dropoffAddress'] = $value['dropoffAddress'];
          $data_array['RideData'][$key]['dropoffName'] = $value['dropoffName'];
          $data_array['RideData'][$key]['dropoffNumber'] = $value['dropoffNumber'];
          $data_array['RideData'][$key]['loaderCount'] = $value['loaderCount'];
          $data_array['RideData'][$key]['payAt'] = $value['payAt'];
          $data_array['RideData'][$key]['payType'] = $value['payType'];
          $data_array['RideData'][$key]['waiting_loading'] = $value['waiting_loading'];
          $data_array['RideData'][$key]['waiting_unloading'] = $value['waiting_unloading'];
          $data_array['RideData'][$key]['deliveFare'] = $value['deliveFare'];
          $data_array['RideData'][$key]['loaderCharge'] = $value['loaderCharge'];
          $data_array['RideData'][$key]['delayCharge'] = $value['delayCharge'];
          $data_array['RideData'][$key]['tax'] = $value['tax'];
          $data_array['RideData'][$key]['totalCharge'] = $value['totalCharge'];
          $data_array['RideData'][$key]['km'] = $value['km'];
          $data_array['RideData'][$key]['rate_per_km'] = $value['rate_per_km'];
          $data_array['RideData'][$key]['addDate'] = $value['addDate'];
          $data_array['RideData'][$key]['vehicle_name'] = $vehicledata['name'];


          $Insurance = explode(',', $value['insuranceType']);
          $insuranceArray = array();
          foreach ($Insurance as $value1) 
          {
             $insurance_data = $this->db->get_where('insurance_master',array('id'=>$value1))->row_array();

             array_push($insuranceArray, $insurance_data['name']);
          }

          $finalInsurance = implode(',', $insuranceArray);
          
          $data_array['RideData'][$key]['Insurance'] = $finalInsurance;


          /*******************************check rating*****************************/

            $checkrating = $this->db->get_where('rating_master',array('customer_id'=>$value['userId'],'booking_id'=>$value['id']))->row_array();

            if (!empty($checkrating)) 
            {
              $data_array['RideData'][$key]['rating_status'] = 1;
              $data_array['RideData'][$key]['rating'] = $checkrating['rating'];

            }
            else
            {
              $data_array['RideData'][$key]['rating_status'] = 0; 
              $data_array['RideData'][$key]['rating'] = '';
            }

          /**********************************driver data**************************************/

            $driver_data = $this->db->get_where('driver_master',array('id'=>$value['driver_id']))->row_array();

            $data_array['RideData'][$key]['driver_id'] = $driver_data['id'];
            $data_array['RideData'][$key]['driver_name'] = $driver_data['name'];
            $data_array['RideData'][$key]['driver_email'] = $driver_data['email'];
            $data_array['RideData'][$key]['driver_mobile'] = $driver_data['mobile'];
            $data_array['RideData'][$key]['driver_image'] = $driver_data['image'];

          /***********************************************************************************/


        }
        
      }
      else
      {
         $this->db->order_by('id','desc');
        $list = $this->db->get_where('ride_master',array('driver_id'=>$requestData['userId'],'status'=>$requestData['status']))->result_array();

                $data_array = array();
        foreach ($list as $key => $value) 
        {
          $vehicledata = $this->db->get_where('vehicle_master',array('id'=>$value['vehicle_id']))->row_array();

          $data_array['RideData'][$key]['id'] = $value['id'];
          $data_array['RideData'][$key]['pickupAddress'] = $value['pickupAddress'];
          $data_array['RideData'][$key]['dropoffAddress'] = $value['dropoffAddress'];
          $data_array['RideData'][$key]['dropoffName'] = $value['dropoffName'];
          $data_array['RideData'][$key]['dropoffNumber'] = $value['dropoffNumber'];
          $data_array['RideData'][$key]['loaderCount'] = $value['loaderCount'];
          $data_array['RideData'][$key]['payAt'] = $value['payAt'];
          $data_array['RideData'][$key]['payType'] = $value['payType'];
          $data_array['RideData'][$key]['waiting_loading'] = $value['waiting_loading'];
          $data_array['RideData'][$key]['waiting_unloading'] = $value['waiting_unloading'];
          $data_array['RideData'][$key]['deliveFare'] = $value['deliveFare'];
          $data_array['RideData'][$key]['loaderCharge'] = $value['loaderCharge'];
          $data_array['RideData'][$key]['delayCharge'] = $value['delayCharge'];
          $data_array['RideData'][$key]['tax'] = $value['tax'];
          $data_array['RideData'][$key]['totalCharge'] = $value['totalCharge'];
          $data_array['RideData'][$key]['km'] = $value['km'];
          $data_array['RideData'][$key]['rate_per_km'] = $value['rate_per_km'];
          $data_array['RideData'][$key]['addDate'] = $value['addDate'];
          $data_array['RideData'][$key]['vehicle_name'] = $vehicledata['name'];


          $Insurance = explode(',', $value['insuranceType']);
          $insuranceArray = array();
          foreach ($Insurance as $value1) 
          {
             $insurance_data = $this->db->get_where('insurance_master',array('id'=>$value1))->row_array();

             array_push($insuranceArray, $insurance_data['name']);
          }

          $finalInsurance = implode(',', $insuranceArray);
          
          $data_array['RideData'][$key]['Insurance'] = $finalInsurance;

        }
      }        
               

       //$data_array['RideData'] = $list;

       if (!empty($list)) 
       {
         generateServerResponse(S,'222',$data_array);
       }
       else
       {
         generateServerResponse(F,'223');
       }
   }
   
    public function get_my_shipment($requestData)
   {    
      
         $this->db->order_by('ID','desc');
        $list = $this->db->get_where('shipments',array('driver_id'=>$requestData['userId'],'status'=>$requestData['status']))->result_array();

         $data_array = array();
        
         $data_array['RideData']= $list;

       if (!empty($list)) 
       {
         generateServerResponse(S,'222',$data_array);
       }
       else
       {
         generateServerResponse(F,'223');
       }
   }


    public function get_rating_list($requestData)
    {   
       //$date = date('Y-m-d');     
       //$current_date = date('Y-m-d', strtotime($date. ' - 7 days'));

               $this->db->order_by('id','desc');  
       $list = $this->db->get_where('ride_rating_master',array('driver_id'=>$requestData['userId'],'add_date <='=>$requestData['from_date'],'add_date >='=>$requestData['to_date']))->result_array();
       $dataArray = array();
       $weekrating = 0;
       $weekride = 0;
       $getLastDate = '';
       foreach ($list as $key => $value) 
       {  
         $averageRate = $value['rating']/$value['ride'];
         $dataArray['RatingList'][$key]['day'] = date('D',$value['time_date']);   
         $dataArray['RatingList'][$key]['Date']   = date('M d,Y',$value['time_date']);
         $dataArray['RatingList'][$key]['Rides'] = $value['ride'];
         $dataArray['RatingList'][$key]['Rating'] = round($averageRate,1);

         $weekride = $weekride+$value['ride'];
         $weekrating = $weekrating+$value['rating'];
         $getLastDate = date('M d Y',$value['time_date']);
       }

         if ($weekride == 0) 
         {
           $dataArray['WeeklyRide'] = 0;
           $dataArray['WeeklyRating'] = 0;
         }
         else
         {
           $dataArray['WeeklyRide'] = $weekride;
           $weekRate = $weekrating/$weekride;
           $dataArray['WeeklyRating'] = round($weekRate,1);
         }
         

         /******************************all rides and ratings******************************/

           $list1 = $this->db->get_where('ride_rating_master',array('driver_id'=>$requestData['userId']))->result_array();
           $allrating = 0;
           $allride = 0;
           foreach ($list1 as $key1 => $value1) 
           {  
             $averageRate1 = $value1['rating']/$value1['ride'];
             $allride = $allride+$value['ride'];
             $allrating = $allrating+$value1['rating'];
           }

         if ($allride == 0) 
         {
             $dataArray['AllRide'] = 0;
             $dataArray['AllRating'] = 0;
         }
         else
         {
           $dataArray['AllRide'] = $allride;
           $allRate = $allrating/$allride;
           $dataArray['AllRating'] = round($allRate,1);
         }  

         /*********************************************************************************/

          /* If not empty avail hours array data*/
       if(!empty($dataArray['RatingList'])):
            $count = count($dataArray['RatingList']);
            for($i = $count; $i < 7; $i++){
                $nextdate = strtotime(date('Y-m-d', strtotime($getLastDate. ' - '.$i.' days')));
                $dataArray['RatingList'][$i]['day'] = date('D',$nextdate);   
                $dataArray['RatingList'][$i]['Date']   = date('M d,Y',$nextdate);
                $dataArray['RatingList'][$i]['Rides'] = 0;
                $dataArray['RatingList'][$i]['Rating'] = 0;

            }
       else:
        $getLastDate = $requestData['from_date'];
         for($i = 0; $i < 7; $i++){
            $nextdate = strtotime(date('Y-m-d', strtotime($getLastDate. ' - '.$i.' days')));
            $dataArray['RatingList'][$i]['day'] = date('D',$nextdate);   
            $dataArray['RatingList'][$i]['Date']   = date('M d,Y',$nextdate);
            $dataArray['RatingList'][$i]['Rides'] = 0;
            $dataArray['RatingList'][$i]['Rating'] = 0;
        }
       endif;
       /* Close */

       generateServerResponse(S,'222',$dataArray);

        /*if (!empty($list)) 
        {
          generateServerResponse(S,'222',$dataArray);
        }
        else
        {
           generateServerResponse(F,'223');
        }*/
    }

     public function get_acceptance_rate($requestData)
    {   
       //$date = date('Y-m-d');     
       //$current_date = date('Y-m-d', strtotime($date. ' - 7 days'));
               $this->db->order_by('id','desc');  
       $list = $this->db->get_where('acceptance_rate_master',array('driver_id'=>$requestData['userId'],'add_date <='=>$requestData['from_date'],'add_date >='=>$requestData['to_date']))->result_array();
       $dataArray = array();
       $weekoffered = 0;
       $weekaccepted = 0;
       $getLastDate = '';
       foreach ($list as $key => $value) 
       {  
         $average = ($value['accepted']/$value['offered'])*100;
         $dataArray['AcceptanceList'][$key]['day']        = date('D',$value['time_date']);
         $dataArray['AcceptanceList'][$key]['Date']       = date('M d,Y',$value['time_date']);
         $dataArray['AcceptanceList'][$key]['offered']    = $value['offered'];
         $dataArray['AcceptanceList'][$key]['accepted']   = $value['accepted'];
         $dataArray['AcceptanceList'][$key]['Average']    = round($average,1);

         $weekoffered = $weekoffered + $value['offered'];
         $weekaccepted = $weekaccepted + $value['accepted'];
         $getLastDate = date('M d Y',$value['time_date']);
       }

        if ($weekoffered == 0) 
        {
          $weekaverage = 0;
        }
        else
        {
           $weekaverage = ($weekaccepted/$weekoffered)*100;
        }
        

        $dataArray['WeekOffered']  = $weekoffered;
        $dataArray['WeekAccepted'] = $weekaccepted;
        $dataArray['WeekAverage']  = round($weekaverage,1);

        /**********************all average***************************/

         $list1 = $this->db->get_where('acceptance_rate_master',array('driver_id'=>$requestData['userId']))->result_array();
        
         $alloffered = 0;
         $allaccepted = 0;

         foreach ($list1 as $key1 => $value1) 
         {  
           $alloffered = $alloffered + $value1['offered'];
           $allaccepted = $allaccepted + $value1['accepted'];
         }

         if ($alloffered == 0) 
        {
          $allaverage = 0;
        }
        else
        {
           $allaverage = ($allaccepted/$alloffered)*100;
        }

          

          $dataArray['AllOffered']  = $alloffered;
          $dataArray['AllAccepted'] = $allaccepted;
          $dataArray['AllAverage']  = round($allaverage,1);

        /****************************END*****************************/


           /* If not empty avail hours array data*/
       if(!empty($dataArray['AcceptanceList'])):
            $count = count($dataArray['AcceptanceList']);
            for($i = $count; $i < 7; $i++){
                $nextdate = strtotime(date('Y-m-d', strtotime($getLastDate. ' - '.$i.' days')));
                $dataArray['AcceptanceList'][$i]['day']        = date('D',$nextdate);
                $dataArray['AcceptanceList'][$i]['Date']       = date('M d,Y',$nextdate);
                $dataArray['AcceptanceList'][$i]['offered']    = 0;
                $dataArray['AcceptanceList'][$i]['accepted']   = 0;
                $dataArray['AcceptanceList'][$i]['Average']    = 0;

            }
       else:
        $getLastDate = $requestData['from_date'];
         for($i = 0; $i < 7; $i++){
            $nextdate = strtotime(date('Y-m-d', strtotime($getLastDate. ' - '.$i.' days')));
            $dataArray['AcceptanceList'][$i]['day']        = date('D',$nextdate);
            $dataArray['AcceptanceList'][$i]['Date']       = date('M d,Y',$nextdate);
            $dataArray['AcceptanceList'][$i]['offered']    = 0;
            $dataArray['AcceptanceList'][$i]['accepted']   = 0;
            $dataArray['AcceptanceList'][$i]['Average']    = 0;
        }
       endif;
       /* Close */

       generateServerResponse(S,'222',$dataArray);

        /*if (!empty($list)) 
        {
          generateServerResponse(S,'222',$dataArray);
        }
        else
        {
           generateServerResponse(F,'223');
        }*/
    }

     public function ride_completion_list($requestData)
    {   

        $driverdata = $this->db->get_where('driver_master',array('id'=>$requestData['userId']))->row_array();

                            $this->db->select_sum('offered');
                            $this->db->select_sum('accepted');
          $acceptedData = $this->db->get_where('acceptance_rate_master',array('driver_id'=>$requestData['userId'],'add_date <='=>$requestData['from_date'],'add_date >='=>$requestData['to_date']))->row_array();

                       $this->db->select_sum('rides');
          $comData = $this->db->get_where('ride_complete_master',array('driver_id'=>$requestData['userId'],'add_date <='=>$requestData['from_date'],'add_date >='=>$requestData['to_date']))->row_array();

           $dataArray = array();
           $dataArray['CompletionData']['completed'] = $comData['rides'];
           $dataArray['CompletionData']['uncompleted'] = $acceptedData['offered']-$comData['rides'];

           $current_date = date('Y-m-d');
           $end_time = strtotime($requestData['to_date'].'00:00:00');
           $start_time = strtotime($requestData['from_date'].'23:59:59');

                   $this->db->where("addDate BETWEEN $end_time AND $start_time"); 
           $list = $this->db->get_where('ride_master',array('driver_id'=>$requestData['userId']))->result_array();

/*           $dd = $this->db->last_query();

           print_r($dd);die;*/
           
           foreach ($list as $key => $value) 
           {  
             $dataArray['Completion_List'][$key]['day']            = date('D',$value['addDate']);
             $dataArray['Completion_List'][$key]['Date']           = date('M d,Y',$value['addDate']);
             $dataArray['Completion_List'][$key]['Time']           = date('h:i A',$value['addDate']);
             $dataArray['Completion_List'][$key]['pickupAddress']  = $value['pickupAddress'];

             if ($value['status'] == 2) 
             {
               $status     = "Cancelled";
             }
             elseif ($value['status'] == 3) 
             {
               $status     = "Completed";
             }
             elseif($value['status'] == 4)
             {
               $status     = "Running";
             } 
             
              $dataArray['Completion_List'][$key]['status']     = $status;
           }

            if (!empty($list)) 
            {
              generateServerResponse(S,'222',$dataArray);
            }
            else
            {
               generateServerResponse(F,'223');
            }
    }

  public function customer_running_ride($requestData)
  {          
             $this->db->order_by('ride_master.id','desc');
             $this->db->select('driver_master.*,ride_master.*');
             $this->db->join('driver_master','driver_master.id = ride_master.driver_id');  
     $data = $this->db->get_where('ride_master',array('ride_master.userId'=>$requestData['userId'],'ride_master.status'=>4))->row_array();

                   $this->db->select_sum('rating'); 
     $ratingdata = $this->db->get_where('rating_master',array('driver_id'=> $data['driver_id']))->row_array();
     $ratingdatanum = $this->db->get_where('rating_master',array('driver_id'=> $data['driver_id']))->num_rows();

     $rating = $ratingdata['rating']/$ratingdatanum;

     $response['RatingData'] =  round($rating,1); 

     $response['DriverDetail'] = $data;

     $ridecurrent_data = $this->db->get_where('booking_ride_request_master',array('booking_id'=>$data['id']))->row_array();

     $response['ride_status_data'] = $ridecurrent_data;

     if (!empty($data)) 
     {
       generateServerResponse(S,'Success',$response);
     }
     else
     {
       generateServerResponse(F,'E');
     }

  }


  public function check_request($requestData)
  {
     $data = $this->db->get_where('vehicle_request_master',array('driver_id'=>$requestData['uuid'],'status'=>1))->row_array();
     if (!empty($data)) 
     {
        generateServerResponse(S,'222');
     }
     else
     {
        generateServerResponse(F,'223');
     }
  }


  public function getshipmentstatus($requestData)
  {
     $getData = $this->db->get_where('post_shipment',array('borcode_id'=>$requestData['barcode_id']))->row_array();
     $response['ShipmentData'] = $getData;
      if(!empty($getData))
      {
       generateServerResponse(S,SUCCESS,$response); 
      }else{
       generateServerResponse(F,'E');
      }
     
  }


// Favorite List Data
  public function getFavoriteData($requestData){  
    $this->db->order_by('id','desc');
    $getData = $this->db->get_where('favorite_master',array('userId'=>$requestData['uid'],'userType'=>$requestData['userType']))->result_array();
      $arr                 = array();
    foreach ($getData as $key => $value) {
        $param['id']           = $value['id'];
        $param['userType']     = $value['userType'];
        $param['userId']       = $value['userId'];
        $param['lat']          = $value['lat'];
        $param['long']         = $value['long'];
        $param['subAddress']   = $value['subAddress'];
        $param['address']      = $value['address'];
        $param['deviceId']     = $value['deviceId'];
        $param['status']       = $value['status'];
        $param['addDate']      = $value['addDate'];
        $param['modifyDate']   = $value['modifyDate'];
        $arr[]                 = $param;
    }
       $response['DataList'] = $arr;
       (count($response['DataList']) > 0) ? generateServerResponse('1','S',$response) : generateServerResponse('0','E');
  }

// Favorite List Data
  public function UnFavorite($requestData){  
    $this->db->where(array('userId'=>$requestData['uid'],'userType'=>$requestData['userType'],'address'=>$requestData['address']));
    $getData=$this->db->delete('favorite_master');
       ($getData > 0) ? generateServerResponse('1','128') : generateServerResponse(F,'W');
  }



// Favorite Data Post Here
  public function getContentData($requestData){  
        $data                 = array();
        $currency = $this->getDataViaTable('settings',1);
        if($requestData['case'] == 1){
            $res = $this->db->get_where('vehicle_master',array('status'=>1))->result_array();
            foreach ($res as $key => $allData) {
                $getUnit     = $this->getDataViaTable('unit_master',$allData['unitId']);
                $getDuration = $this->getDataViaTable('unit_master',$allData['durationId']);
                $param['id']           = $allData['id'];
                $param['type']         = $allData['type'];
                $param['name']         = $allData['name'];
                $param['image']        = !empty($allData['image']) ? base_url().'mediaFile/vehicles/'.$allData['image'] : '';
                $param['capacity']     = $allData['capacity'];
                $param['loadingTime']  = $allData['loadingTime'];
                $param['unit']         = $getUnit['name'];
                $param['duration']     = $getDuration['name'];

                $param['status']       = 1;
                $param['addDate']      = $allData['addDate'];
                $data[]                = $param;
            }

            $response['DataList'] = $data;
            (count($response['DataList']) > 0) ? generateServerResponse('1','S',$response) : generateServerResponse('0','E');
        }else if($requestData['case'] == 2){  // for loader
            $res = $this->db->get_where('loader_master',array('status'=>1))->result_array();
            foreach ($res as $key => $allData) {
                $param['id']           = $allData['id'];
                $param['name']         = $allData['name'];
                $param['image']        = !empty($allData['image']) ? base_url().'mediaFile/loaders/'.$allData['image'] : '';
                $param['loaderCount']  = $allData['loaderCount'];
                $param['rate']         = $allData['rate'];
                $param['currency']     = $currency['currency'];

                $param['status']       = 1;
                $param['addDate']      = $allData['addDate'];
                $data[]                = $param;
            }

            $response['DataList'] = $data;
            (count($response['DataList']) > 0) ? generateServerResponse('1','S',$response) : generateServerResponse('0','E');
        }else if($requestData['case'] == 3){ //for insurence
            $res = $this->db->get_where('insurance_master',array('status'=>1))->result_array();
            foreach ($res as $key => $allData) {
                $getUnit     = $this->getDataViaTable('unit_master',$allData['unitId']);
                $param['id']           = $allData['id'];
                $param['name']         = $allData['name'];
                $param['image']        = !empty($allData['image']) ? base_url().'mediaFile/insurance/'.$allData['image'] : '';
                $param['rate']         = $allData['rate'];
                $param['unit']         = $getUnit['name'];
                $param['currency']     = $currency['currency'];

                $param['status']       = 1;
                $param['addDate']      = $allData['addDate'];
                $data[]                = $param;
            }

            $response['DataList'] = $data;
            (count($response['DataList']) > 0) ? generateServerResponse('1','S',$response) : generateServerResponse('0','E');
        }else{
            generateServerResponse('0','E');
        }
  }

    public function getDataViaTable($table,$id){  
        return $this->db->get_where($table,array('id'=>$id))->row_array();
    }


 public function get_all_pilots($requestData)
 {  
    $latitude = $requestData['latitude'];
    $longitude = $requestData['longitude'];

    $driver_array = array();
    $final_array = array();
    $distance_data = $this->db->get_where('settings')->row_array();
    $drivers = $this->db->get_where('driver_master',array('status'=>1,'online_status'=>1))->result_array();
    foreach ($drivers as $key => $value) 
    {
       $distance = $this->calculateDistance($value['location_latitude'],$value['location_longitude'],$latitude,$longitude);

        $final_array['id'] = $value['id'];
        $final_array['distance'] = round($distance,1);

        if ($distance <= $distance_data['ride_range']) 
        {
          array_push($driver_array, $value['id']);
        }
    }

    if (!empty($driver_array)) 
    {
      $driverIds = $driver_array;
    }
    else
    {
      $driverIds = 0;
    }

                       $this->db->where_in('driver_master.id', $driverIds);
    $All_drivers = $this->db->get_where('driver_master',array('online_status'=>1,'status'=>1))->result_array();

    $response_array = array();
    foreach ($All_drivers as $key1 => $value1) 
    {
      $response_array['DriverData'][$key1]['id'] = $value1['id'];
      $response_array['DriverData'][$key1]['location_latitude'] = $value1['location_latitude'];
      $response_array['DriverData'][$key1]['location_longitude'] = $value1['location_longitude'];
    }

    if (!empty($All_drivers)) 
    {
        generateServerResponse('1','222',$response_array);
    }
    else
    {
       generateServerResponse('0','223');
    }

 }   

  public function saveimage($base64)
      {  
        $image_parts = explode(";base64,",$base64 );
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[0];
        // print_r($image_type);die;
        $image_base64 = base64_decode($image_parts[0]);
        $filename = 'img_'.uniqid(). '.png';
        $file = $_SERVER['DOCUMENT_ROOT'].'/codruk/mediaFile/snapshot/'.$filename;
        file_put_contents($file, $image_base64);
        return $filename;
      }


 // ride generated code here
  public function generateRide($requestData){
    $param                        = array();
    $param['userId']              = $requestData['userId'];
    $param['bookingId']           = rideCode();
    $param['pickupAddress']       = $requestData['pickupAddress'];
    $param['pickupLat']           = $requestData['pickupLat'];
    $param['pickupLong']          = $requestData['pickupLong'];
    $param['dropoffAddress']      = $requestData['dropoffAddress'];
    $param['dropoffLat']          = $requestData['dropoffLat'];
    $param['dropoffLong']         = $requestData['dropoffLong'];
    $param['dropoffName']         = $requestData['dropoffName'];
    $param['dropoffNumber']       = $requestData['dropoffNumber'];

    $param['pickupSubAddress']    = $requestData['pickupSubAddress'];
    $param['dropoffSubAddress']   = $requestData['dropoffSubAddress'];

    $param['loaderCount']         = $requestData['loaderCount'];
    $param['insuranceType']       = $requestData['insuranceType'];
    $param['payAt']               = $requestData['payAt'];
    $param['payType']             = $requestData['payType'];
    $param['deliveFare']          = $requestData['deliveFare'];
    $param['loaderCharge']        = $requestData['loaderCharge'];
    $param['insuranceCharge']     = $requestData['insuranceCharge'];
    $param['delayCharge']         = $requestData['delayCharge'];
    $param['tax']                 = $requestData['tax'];
    $param['totalCharge']         = $requestData['totalCharge'];
    $param['vehicle_id']          = $requestData['vehicle_id'];

    $snapshot                     = $requestData['snapshot'];
    $img1                         = $this->saveimage($snapshot);
    $param['snapshot']            = $img1;


 /*
      "userId":"51",
      "pickupAddress":"Bahraich, Uttar Pradesh, India",
      "pickupLat":"27.570500132374086",
      "PickupLong":"81.59769997000694",
      "dropoffAddress":"Madhavpuri Rd, Madhavpuri, Bahraich, Uttar Pradesh 271801, India",
      "dropoffLong":"81.59769997000694",
      "dropoffLat":"27.56072202056172",
      "dropoffName":"",
      "dropoffNumber":"",
      "pickupSubAddress":"",
      "dropoffSubAddress":"Madhavpuri",
      "loaderCount":"0",
      "insuranceType":"1",
      "payAt":"Source",
      "payType":"Cash",
      "deliveFare":"114.911995",
      "loaderCharge":"122",
      "insuranceCharge":"44",
      "delayCharge":"114.911995",
      "tax":"12.0",
      "totalCharge":"115.0",
       "vehicle_id":"2",
  */




    /*******************************check ride entry****************************************/

/*$this->db->where('status',1);
  $this->db->or_where('status',4);
    $check_ride_entry = $this->db->get_where('ride_master',array('userId'=>$requestData['userId']))->num_rows();
*/

       $this->db->order_by('id','desc');
    $check_data = $this->db->get_where('ride_master',array('userId'=>$requestData['userId']))->row_array();
    if (!empty($check_data)) 
    {
                     
      if (($check_data['status'] == 1) || ($check_data['status'] == 4)) 
      {
        $check_ride_entry = 1;
      }
      else
      {
        $check_ride_entry = 0;
      }

       if ($check_ride_entry > 0) 
      {
        generateServerResponse(F,'232');
      }
    }

    //$dd = $this->db->last_query();

    //print_r($dd);die;

    /**************************************END**********************************************/

    $vehicleData = $this->db->get_where('vehicle_master',array('id'=>$requestData['vehicle_id']))->row_array();
    $param['rate_per_km']                  = $vehicleData['charges_per_km'];
    $param['waiting_loading']              = $vehicleData['waiting_charges_loading'];
    $param['waiting_unloading']            = $vehicleData['waiting_charges_unloading'];

    $param['km']                  = $requestData['km'];

    $param['status']             = 1;
    $param['addDate']            = time();
    $param['modifyDate']         = time();

     $excuteQuery = $this->db->insert('ride_master',$param);
     $lastid = $this->db->insert_id();
   
     $array = array();
     $array['bookingId'] = $lastid;

      /*******************************New Implementation********************************/
    if(isset($requestData['driverId'])){
        $vehArray = array();
        array_push($vehArray, $requestData['driverId']);
        $finalveharray = $vehArray;
        
    }else{
         $dropoffaddress = $requestData['dropoffAddress'];
         $dropofflat  = $requestData['dropoffLat'];
         $dropofflong = $requestData['dropoffLong'];
    
         $latitude  = $requestData['pickupLat'];
         $longitude = $requestData['pickupLong'];
    
          $vehicle_data = $this->db->get_where('vehicle_master',array('id'=>$requestData['vehicle_id']))->row_array();
          $owner_vehicle_data = $this->db->get_where('owner_vehicle_master',array('vehicle_master_id'=>$vehicle_data['id']))->result_array();
    
          $vehArray = array();
          foreach ($owner_vehicle_data as $key => $value) 
          {   
             $vehicle_request_data = $this->db->get_where('vehicle_request_master',array('vehicle_id'=>$value['id'],'status'=>1))->row_array();
             if (!empty($vehicle_request_data['driver_id'])) 
             {
               array_push($vehArray, $vehicle_request_data['driver_id']);
             }
          }
    
          if (!empty($vehArray)) 
          {
             $finalveharray = $vehArray;
          }
          else
          {
             $finalveharray = array('0');
          }
    }

      $this->db->where_in('id',$finalveharray);         
      $drivers = $this->db->get_where('driver_master',array('online_status'=>1,'status'=>1))->result_array();

      $driver_array = array();
      $final_array = array();
      $distance_data = $this->db->get_where('settings')->row_array();
      foreach ($drivers as $key => $value) 
      { 
        /****************new*******************/
        if ((!empty($value['favourite_location'])) && (!empty($dropofflat))) 
        {
            $distance1 = $this->calculateDistance($value['favourite_latitude'],$value['favourite_longitude'],$dropofflat,$dropofflong);

            $distance = $this->calculateDistance($value['location_latitude'],$value['location_longitude'],$latitude,$longitude);

            $final_array['id'] = $value['id'];
            $final_array['distance'] = round($distance,1);

            if (($distance <= $distance_data['ride_range']) && ($distance1 <= $distance_data['ride_range'])) 
            {
              array_push($driver_array, $value['id'],$distance);
            }

        }
        elseif ((!empty($value['favourite_location'])) && (empty($dropofflat))) 
        {

        }
        else
        {  
            /****************END*******************/
            $distance = $this->calculateDistance($value['location_latitude'],$value['location_longitude'],$latitude,$longitude);

            $final_array['id'] = $value['id'];
            $final_array['distance'] = round($distance,1);

            if ($distance <= $distance_data['ride_range']) 
            {
              //array_push($driver_array, $value['id'],$distance);
              array_push($driver_array, $value['id']);
            }

        }
        
      }
     

     // print_r($driver_array);die;

      if (!empty($driver_array)) 
      {
        $this->db->where_in('driver_master.id', $driver_array);
        $data['drivers'] = $this->db->get_where('driver_master',array('online_status'=>1,'status'=>1))->result_array();
        //$data['distance'] = $driver_array;
      }
      else
      {
        $data['drivers'] = array();
        $insert_delete_data['booking_id'] = $lastid;
        $insert_delete_data['time_date']  = date('Y-m-d H:i:s');
        $insert_delete_data['add_date']   = time();

        $this->db->insert('delete_ride_master',$insert_delete_data);

      }
      
       $this->db->where_in('driver_master.id', $requestData['driverId']);
        $data['drivers'] = $this->db->get_where('driver_master',array('online_status'=>1,'status'=>1))->result_array();


        $get_range_data = $this->db->get_where('settings')->row_array();

        $startTime = date("Y-m-d h:i:s");
        $cenvertedTime = date('Y-m-d h:i:s',strtotime('+'.$get_range_data['acceptance_time'].' minutes',strtotime($startTime)));

      if (!empty($data['drivers'])) 
      {
            foreach ($data['drivers'] as $key1 => $value1) 
            {    

              /**************************delete data************************************************/

              $this->db->order_by('id','desc');  
              $check1 = $this->db->get_where('booking_ride_request_master',array('driver_id'=>$value1['id']))->row_array();
                if (($check1['range_timing'] < $startTime) && ($check1['status'] == 2)) 
                { 
                  $this->db->where('id',$check1['id']);  
                  $this->db->delete('booking_ride_request_master');
                }

              /*************************************************************************************/                             
                                              $this->db->order_by('id','desc');  
                $check = $this->db->get_where('booking_ride_request_master',array('driver_id'=>$value1['id']))->row_array();
                if ((empty($check)) ||($check['status'] == 3) || ($check['status'] == 4) || ($check['range_timing'] < $startTime)) 
                {   
                    $insertdata['booking_id']   = $lastid;
                    $insertdata['driver_id']    = $value1['id'];
                    $insertdata['time_range']   = $get_range_data['acceptance_time'];
                    $insertdata['range_timing'] = $cenvertedTime;
                    $insertdata['add_date']     = time();
                    $insertdata['status']       = 2;

                    $this->db->insert('booking_ride_request_master',$insertdata);
                    $lastrequest_id = $this->db->insert_id();

                    /*************No. of rides *************/

                    $driverData = $this->db->get_where('driver_master',array('id'=>$value1['id']))->row_array();

                    $upArray['rides'] = $driverData['rides']+1;

                    $this->db->where('id',$value1['id']);
                    $this->db->update('driver_master',$upArray);

                    /*****************Acceptance ride rate*******************/

                    $currdate = date('Y-m-d');
                    $check_acceptance = $this->db->get_where('acceptance_rate_master',array('driver_id'=>$value1['id'],'add_date'=>$currdate))->row_array();

                    if (!empty($check_acceptance)) 
                    {
                        $update_acceptance_rate_data['offered']   = $check_acceptance['offered']+1;

                        $this->db->where('id',$check_acceptance['id']);
                        $this->db->update('acceptance_rate_master',$update_acceptance_rate_data);
                    }
                    else
                    {
                        $acceptance_rate_data['driver_id'] = $value1['id'];
                        $acceptance_rate_data['add_date'] = date('Y-m-d');
                        $acceptance_rate_data['offered']   = 1;
                        $acceptance_rate_data['time_date'] = time();

                        $this->db->insert('acceptance_rate_master',$acceptance_rate_data);
                    }

                    /********************************************************/

                    /*$INSERTDATA['request_id'] = $lastrequest_id;
                    $INSERTDATA['booking_id'] = $lastid;
                    $INSERTDATA['type']       = 1;
                    $INSERTDATA['add_date']   = time();

                    $this->db->insert('ride_log_history',$INSERTDATA);*/

                    /******************************notification********************************/

                    $booking_data = $this->db->get_where('ride_master',array('id'=>$lastid))->row_array();

                    $device_id = $this->db->select('*')
                                 ->from('login_master')
                                 ->where(array('userID' => $value1['id'],'type'=>2))
                                 ->get()->result_array();
                    
                    foreach ($device_id as $device_id_data) 
                    {
                          $Device_Id = $device_id_data['device_token'];

                          // Message to be sent
                          $message = "1 New Ride Arrived";
                          $dataMessage = array();
                          $dataMessage['Codruk']['message']  = $message;
                          $dataMessage['Codruk']['booking_details']  = json_encode($booking_data);
                          $dataMessage['Codruk']['regId']  = $Device_Id;
                          $dataMessage['Codruk']['apikey']   = "AAAAxm2v14c:APA91bEfay7Rff6TK85Ine_PDK6b90mjle_UkbKHY2-4Jpvi-qUJA_FMw9x7QVCALXR6EkaCp_IHuTXqSIGeYIimjZO-VISLeRFPR_PbXkJPPi6NiPt4gMADLXpIkPeBnmGhv_gMvZJj";
                          $dataMessage['Codruk']['notification_type']  = "01";
                          $sendMessage = json_encode($dataMessage, true);

                          $send_notification = $this->pushSurveyorNotification($sendMessage);
                    }

                    //$this->dell();


                    $INSERTDATA['request_id'] = $lastrequest_id;
                    $INSERTDATA['booking_id'] = $lastid;
                    $INSERTDATA['type']       = 1;
                    $INSERTDATA['add_date']   = time();

                    $this->db->insert('ride_log_history',$INSERTDATA);

                }

                    

                /**************************************************************************/
            }
      }  
     


     /*********************************************************************************/
    if($excuteQuery > 0){
       generateServerResponse(S,SUCCESS,$array); 

    }else{
        generateServerResponse(F,'W');
    }
  }

    public function dell()
  {   
      $dataMessage = array();
      $dataMessage['Codruk']['message']  = "hello sir";
      $dataMessage['Codruk']['booking_details']  = "";
      $dataMessage['Codruk']['regId']  = "eNBs6vqem-U:APA91bGiVRKczfCyl3RX6wmY5YWfw5HB1TD_5-aZIGJOWhfzi-sIq513tP09nUfeR6hgbJAILcVX4H0FqoyQUTdDqOp_QH7r-mudVcOGtXWIsZ5Nael601a4hhj_HB7LBk_5cKqRirzn";
      $dataMessage['Codruk']['apikey']   = "AAAAxm2v14c:APA91bEfay7Rff6TK85Ine_PDK6b90mjle_UkbKHY2-4Jpvi-qUJA_FMw9x7QVCALXR6EkaCp_IHuTXqSIGeYIimjZO-VISLeRFPR_PbXkJPPi6NiPt4gMADLXpIkPeBnmGhv_gMvZJj";
      $sendMessage = json_encode($dataMessage, true);

      $send_notification = $this->pushSurveyorNotification($sendMessage);
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

    public function pushSurveyorNotification_backup($send_data){

        $requestJson = json_decode($send_data, true);

        if (empty($requestJson)) {
            generateServerResponse('0', '100');
        }

         $check_request_keys = array(
                    '0' => 'message',
                    '1' => 'regId',
                    '2' => 'apikey'
                );

            $notification_type  = '01';           
            $regId = trim($requestJson['Codruk']['regId']);
            $registrationId = ''; // set variable as array

            // get all ids in while loop and insert it into $regIDS array
            $deviceIds = explode(",", $regId);
            
            foreach ($deviceIds as  $devid) { 
                $registrationId .= $devid.",";
            }

            $message  = trim($requestJson['Codruk']['message']);            
            $apikey   = trim($requestJson['Codruk']['apikey']);

                        
            $url = 'https://android.googleapis.com/gcm/send'; 

            $fields = array(
                            'to'  => rtrim($registrationId,","),
                            'notification' => array(
                                    "title" => "Codruk",
                                    "body"  => $message
                            ),
                            'data' => array(
                                "notification_type" => $notification_type
                               
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

            // Close connection
            curl_close($ch);

            return $result;
    }  



  public function calculateDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371)
    {
      // convert from degrees to radians
      $latFrom = deg2rad($latitudeFrom);
      $lonFrom = deg2rad($longitudeFrom);
      $latTo = deg2rad($latitudeTo);
      $lonTo = deg2rad($longitudeTo);

      $lonDelta = $lonTo - $lonFrom;
      $a = pow(cos($latTo) * sin($lonDelta), 2) +
        pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
      $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

      $angle = atan2(sqrt($a), $b);
      return $angle * $earthRadius;
    }


  public function delete_non_accepted($requestData)
  {           
              $this->db->where('id',$requestData['booking_id']);
      $data = $this->db->delete('ride_master');

      generateServerResponse(S,'Success'); 

  }  


    public function arrived_pickup($requestData)
    {
        $booking_details = $this->db->get_where('booking_ride_request_master',array('id'=>$requestData['request_id']))->row_array();
        $booking_data = $this->db->get_where('ride_master',array('id'=>$booking_details['booking_id']))->row_array();
        $userdata = $this->db->get_where('customer_master',array('id'=>$booking_data['userId']))->row_array();

        $updateArray['arrive_status'] = 1;
        $updateArray['arrive_date']   = time();

        $this->db->where('id',$requestData['request_id']);
        $this->db->update('booking_ride_request_master',$updateArray);

        $INSERTDATA['request_id'] = $requestData['request_id'];
        $bookingdata = $this->db->get_where('booking_ride_request_master',array('id'=>$requestData['request_id']))->row_array();

        $INSERTDATA['booking_id'] = $bookingdata['booking_id'];
        $INSERTDATA['type']       = 4;
        $INSERTDATA['add_date']   = time();

        $this->db->insert('ride_log_history',$INSERTDATA);

        $device_id = $this->db->select('*')
                     ->from('login_master')
                     ->where(array('userID' => $userdata['id'],'type'=>1))
                     ->get()->result_array();
        
        foreach ($device_id as $device_id_data) 
        {
              $Device_Id = $device_id_data['device_token'];

              // Message to be sent
              $message = "Pilot has arrived on your location";
              $dataMessage = array();
              $dataMessage['Codruk']['message']  = $message;
              $dataMessage['Codruk']['booking_details']  = json_encode($booking_data);
              $dataMessage['Codruk']['regId']  = $Device_Id;
               $dataMessage['Codruk']['notification_type']  = "04";
              $dataMessage['Codruk']['apikey']   = "AAAAxm2v14c:APA91bEfay7Rff6TK85Ine_PDK6b90mjle_UkbKHY2-4Jpvi-qUJA_FMw9x7QVCALXR6EkaCp_IHuTXqSIGeYIimjZO-VISLeRFPR_PbXkJPPi6NiPt4gMADLXpIkPeBnmGhv_gMvZJj";
              $sendMessage = json_encode($dataMessage, true);

              $send_notification = $this->pushSurveyorNotification($sendMessage);
        }


        generateServerResponse(S,'Success'); 

    }

    public function sendnote($userId)
    {
       $device_id = $this->db->select('*')
                     ->from('login_master')
                     ->where(array('userID' => $userId,'type'=>1))
                     ->get()->result_array();
        
        foreach ($device_id as $device_id_data) 
        {
              $Device_Id = $device_id_data['device_token'];

              // Message to be sent
              $message = "No Pilot found nearby !";
              $dataMessage = array();
              $dataMessage['Codruk']['message']  = $message;
              $dataMessage['Codruk']['booking_details']  = json_encode($booking_data);
              $dataMessage['Codruk']['regId']  = $Device_Id;
              $dataMessage['Codruk']['notification_type']  = "11";
              $dataMessage['Codruk']['apikey']   = "AAAAxm2v14c:APA91bEfay7Rff6TK85Ine_PDK6b90mjle_UkbKHY2-4Jpvi-qUJA_FMw9x7QVCALXR6EkaCp_IHuTXqSIGeYIimjZO-VISLeRFPR_PbXkJPPi6NiPt4gMADLXpIkPeBnmGhv_gMvZJj";
              $sendMessage = json_encode($dataMessage, true);

              $send_notification = $this->pushSurveyorNotification($sendMessage);
        }

    }


    public function get_pilot_ride_request($requestData)
    {  
        $currenttime = date('Y-m-d h:i:s');

                 /*$this->db->order_by('id','desc'); 
                 $this->db->where('driver_id',$requestData['userId']);   
                 $this->db->where(array('booking_ride_request_master.status'=>1));   
                 $this->db->or_where(array('booking_ride_request_master.status'=>2));
       $data1 =  $this->db->get('booking_ride_request_master')->row_array();*/

                  $this->db->order_by('id','desc'); 
                  $this->db->where('driver_id',$requestData['userId']); 
                  $this->db->group_start();
                  $this->db->where(array('booking_ride_request_master.status'=>1));   
                  $this->db->or_where(array('booking_ride_request_master.status'=>2));
                  $this->db->group_end();
       $data1 =   $this->db->get('booking_ride_request_master')->row_array();

       $data2 =  $this->db->get_where('ride_master',array('id'=>$data1['booking_id']))->row_array();
       $data3 =  $this->db->get_where('customer_master',array('id'=>$data2['userId']))->row_array();
       $data4 =  $this->db->get_where('vehicle_master',array('id'=>$data2['vehicle_id']))->row_array();
 
       $response_array['request_details']      = $data1;
       $response_array['booking_ride_details'] = $data2;
       $response_array['customer_details']     = $data3;
       $response_array['vehicle_details']      = $data4;

       if (!empty($data1)) 
       {  
          if ($data1['range_timing'] > $currenttime) 
          { 
            generateServerResponse(S,'222',$response_array); 
          }
          else
          { 
            if ($data1['status'] == 1) 
            {
              generateServerResponse(S,'222',$response_array); 
            }
            else
            {
              generateServerResponse(F,'227');
            }
            
          }
          
       }
       else
       {
          generateServerResponse(F,'223');
       }

    }

     public function complete_ride($requestData)
    {
        $updateArray['status']        = 4;
        $updateArray['modify_date']   = time();
        $check = $this->db->get_where('booking_ride_request_master',array('id'=>$requestData['request_id']))->row_array();

           $this->db->where('id',$requestData['request_id']);
           $this->db->update('booking_ride_request_master',$updateArray);

           $updata['status'] = 3;
           $updata['completed_date'] = time();
           $this->db->where('id',$check['booking_id']);
           $this->db->update('ride_master',$updata);

              $INSERTDATA['request_id'] = $requestData['request_id'];
              $bookingdata = $this->db->get_where('booking_ride_request_master',array('id'=>$requestData['request_id']))->row_array();

              $INSERTDATA['booking_id'] = $bookingdata['booking_id'];
              $INSERTDATA['type']       = 7;
              $INSERTDATA['add_date']   = time();

              $this->db->insert('ride_log_history',$INSERTDATA);

               /*************No. of rides *************/

          $driverData = $this->db->get_where('driver_master',array('id'=>$check['driver_id']))->row_array();

          $upArray['completed'] = $driverData['completed']+1;

          $this->db->where('id',$check['driver_id']);
          $this->db->update('driver_master',$upArray);

          /***************************completed Ride Data******************************/

          $currdate = date('Y-m-d');
          $check_completed = $this->db->get_where('ride_complete_master',array('driver_id'=>$check['driver_id'],'add_date'=>$currdate))->row_array();

          if (!empty($check_completed)) 
          {
              $update_acceptance_rate_data['rides']   = $check_completed['rides']+1;
              $this->db->where('id',$check_completed['id']);
              $this->db->update('ride_complete_master',$update_acceptance_rate_data);
          }
          else
          {
              $acceptance_rate_data['driver_id'] = $check['driver_id'];
              $acceptance_rate_data['add_date'] = date('Y-m-d');
              $acceptance_rate_data['rides']   = 1;
              $acceptance_rate_data['time_date'] = time();

              $this->db->insert('ride_complete_master',$acceptance_rate_data);
          }

          /***************************************************************************/   

           /*****************************Notification*********************************/

              $booking_data = $this->db->get_where('ride_master',array('id'=>$check['booking_id']))->row_array();
              $driverdata = $this->db->get_where('driver_master',array('id'=>$check['driver_id']))->row_array();

              $allArr['booking_data'] = $booking_data;
              $allArr['driverdata'] = $driverdata;

              $this->db->order_by('id','desc');
              $dr = $this->db->get_where('vehicle_request_master',array('driver_id'=>$requestData['userId'],'status'=>1))->row_array();

              /**************Save Owner Notification***************/

              $notifyArray['owner_id']    = $booking_data['vehicle_owner_id'];
              $notifyArray['booking_id']  = $check['booking_id'];
              $notifyArray['driver_id']   = $check['driver_id'];
              $notifyArray['vehicle_id']  = $dr['vehicle_id'];
              $notifyArray['message']     = "Ride has completed by ".ucfirst($driverdata['name'])." for Vehicle Number ".$booking_data['vehicle_number'];
              $notifyArray['add_date']    = time();
              

              $this->db->insert('owner_notification',$notifyArray);

              /*************************END************************/

              $device_id = $this->db->select('*')
                           ->from('login_master')
                           ->where(array('userID' => $booking_data['userId'],'type'=>1))
                           ->get()->result_array();
              
              foreach ($device_id as $device_id_data) 
              {
                    $Device_Id = $device_id_data['device_token'];

                    // Message to be sent
                    $message = "Your Ride has Completed";
                    $dataMessage = array();
                    $dataMessage['Codruk']['message']  = $message;
                    $dataMessage['Codruk']['booking_details']  = json_encode($allArr);
                    $dataMessage['Codruk']['regId']  = $Device_Id;
                     $dataMessage['Codruk']['notification_type']  = "07";
                    $dataMessage['Codruk']['apikey']   = "AAAAxm2v14c:APA91bEfay7Rff6TK85Ine_PDK6b90mjle_UkbKHY2-4Jpvi-qUJA_FMw9x7QVCALXR6EkaCp_IHuTXqSIGeYIimjZO-VISLeRFPR_PbXkJPPi6NiPt4gMADLXpIkPeBnmGhv_gMvZJj";
                    $sendMessage = json_encode($dataMessage, true);

                    $send_notification = $this->pushSurveyorNotification($sendMessage);
              }

           

           /**************************************************************************/

           $response_array['total_fare'] = $booking_data['totalCharge'];
           generateServerResponse(S,'Success',$response_array); 
        
    }

    function secondsToTime($inputSeconds) 
    {

    $secondsInAMinute = 60;
    $secondsInAnHour  = 60 * $secondsInAMinute;
    $secondsInADay    = 24 * $secondsInAnHour;

    // extract days
    $days = floor($inputSeconds / $secondsInADay);

    // extract hours
    $hourSeconds = $inputSeconds % $secondsInADay;
    $hours = floor($hourSeconds / $secondsInAnHour);

    // extract minutes
    $minuteSeconds = $hourSeconds % $secondsInAnHour;
    $minutes = floor($minuteSeconds / $secondsInAMinute);

    // extract the remaining seconds
    $remainingSeconds = $minuteSeconds % $secondsInAMinute;
    $seconds = ceil($remainingSeconds);

    // return the final array
    $obj = array(
        'd' => (int) $days,
        'h' => (int) $hours,
        'm' => (int) $minutes,
        's' => (int) $seconds,
    );
    return $obj;

    }

      public function get_pilot_profile($requestData)
  {   
      $response['driver_data'] = $this->db->get_where('driver_master',array('id'=>$requestData['userId']))->row_array();            

      $data1 = $this->db->get_where('vehicle_request_master',array('driver_id'=>$requestData['userId'],'status'=>1))->row_array();
      $data2 = $this->db->get_where('owner_vehicle_master',array('id'=>$data1['vehicle_id']))->row_array();

               $this->db->select('vehicle_master.*,unit_master.name as unitname');
               $this->db->join('unit_master','unit_master.id = vehicle_master.unitId');         
      $data3 = $this->db->get_where('vehicle_master',array('vehicle_master.id'=>$data2['vehicle_master_id']))->row_array();

      $data_array1 = $data2;
      $data_array2 = $data3;

      $data_array = array_merge($data_array1,$data_array2);

      $response['vehicle_data'] = $data_array;

      /******************************Dashboard Data*********************************/

      $check = $this->db->get_where('on_off_master',array('driver_id'=>$requestData['userId']))->num_rows();
      if ($check > 0) 
      {
         $data = $this->db->get_where('on_off_master',array('driver_id'=>$requestData['userId'],'add_date >='=>$requestData['from_date'],'add_date <='=>$requestData['to_date']))->result_array();
      }
      else
      {
         $data = array();
      }

      
      $final_time = 0;
      foreach ($data as $key => $value) 
      {  
         if (!empty($value['offline_time'])) 
         {
            $offline_time = $value['offline_time'];
         }  
         else
         {
            $offline_time = time();
         }

         $time_data = $offline_time-$value['online_time'];

         $final_time = $final_time+$time_data;
      }

      /***********************************New Time Duration Implementation********************/    

            /*$tm = $final_time;
            $time_data = $this->secondsToTime($tm);
            if ($time_data['d'] > 1) 
            {
                $D = 'days';
            }
            else
            {
                $D = 'day';
            }

            if ($time_data['h'] > 1) 
            {
                $H = 'hours';
            }
            else
            {
                $H = 'hour';
            }

            if ($time_data['m'] > 1) 
            {
                $M = 'minutes';
            }
            else
            {
                $M = 'minute';
            }

             if ($time_data['s'] > 1) 
            {
                $S = 'seconds';
            }
            else
            {
                $S = 'second';
            }

            if ($time_data['d'] > 0) 
            {   
                $t = $time_data['d'].' '.$D.' '.$time_data['h'].' '.$H.' '.$time_data['m'].' '.$M;
            }
            else
            {
                if ($time_data['h'] > 0) 
                {   
                    $t = $time_data['h'].' '.$H.' '.$time_data['m'].' '.$M;
                }
                else
                {
                    if ($time_data['m'] > 0) 
                    {   
                        $t = $time_data['m'].' '.$M;
                    }
                    else
                    {
                        $t = $time_data['m'].' '.$M;
                    }
                }
            }*/

            $tm = $final_time;
            $time_data = $this->secondsToTime($tm);
            if ($time_data['d'] > 1) 
            {
                $D = 'd';
            }
            else
            {
                $D = 'd';
            }

            if ($time_data['h'] > 1) 
            {
                $H = 'h';
            }
            else
            {
                $H = 'h';
            }

            if ($time_data['m'] > 1) 
            {
                $M = 'm';
            }
            else
            {
                $M = 'm';
            }

             if ($time_data['s'] > 1) 
            {
                $S = 's';
            }
            else
            {
                $S = 's';
            }

            if ($time_data['d'] > 0) 
            {   
                $t = $time_data['d'].''.$D.' '.$time_data['h'].''.$H.' '.$time_data['m'].''.$M;
            }
            else
            {
                if ($time_data['h'] > 0) 
                {   
                    $t = $time_data['h'].''.$H.' '.$time_data['m'].''.$M;
                }
                else
                {
                    if ($time_data['m'] > 0) 
                    {   
                        $t = $time_data['m'].''.$M;
                    }
                    else
                    {
                        $t = $time_data['m'].''.$M;
                    }
                }
            }

            /*************************************End************************************************/

        if (!empty($t)) 
        {
          $available_hours = $t;
        }
        else
        {
          $available_hours = "";
        }  

        $start_time = strtotime($requestData['from_date'].'23:59:59');
        $end_time = strtotime($requestData['to_date'].'00:00:00');

                  $this->db->where("add_date BETWEEN $start_time AND $end_time");
        $rating = $this->db->get_where('rating_master',array('driver_id'=>$requestData['userId']))->result_array();

                          $this->db->where("add_date BETWEEN $start_time AND $end_time");  
        $rating_number = $this->db->get_where('rating_master',array('driver_id'=>$requestData['userId']))->num_rows();    
        $rate = 0;
        foreach ($rating as $key1 => $value1) 
        {
           $rate = $rate+$value1['rating'];
        }

        if ($rating_number > 0) 
        {
          $finalrating = $rate/$rating_number;
        }
        else
        {
           $finalrating = 0;
        }

        

        if (!empty($finalrating)) 
        {
          $Rating = round($finalrating,1);
        }
        else
        {
          $Rating = "";
        }

        $response['driver_data'] = $this->db->get_where('driver_master',array('id'=>$requestData['userId']))->row_array();

        $check1 = $this->db->get_where('acceptance_rate_master',array('driver_id'=>$requestData['userId']))->num_rows();
        if ($check1 > 0) 
        {
                        $this->db->select_sum('offered');
                        $this->db->select_sum('accepted');
        $acceptedData = $this->db->get_where('acceptance_rate_master',array('driver_id'=>$requestData['userId'],'add_date >='=>$requestData['from_date'],'add_date <='=>$requestData['to_date']))->row_array();
        }
        else
        {
           $acceptedData = array();
        }

                        

        if (!empty($acceptedData['accepted'])) 
        {
          $acceptance_rate = round(($acceptedData['accepted']/$acceptedData['offered'])*100);
        }
        else
        {
          $acceptance_rate = 0;
        }


         $check2 = $this->db->get_where('ride_complete_master',array('driver_id'=>$requestData['userId']))->num_rows();
        if ($check2 > 0) 
        {

                        $this->db->select_sum('rides');
        $comData = $this->db->get_where('ride_complete_master',array('driver_id'=>$requestData['userId'],'add_date >='=>$requestData['from_date'],'add_date <='=>$requestData['to_date']))->row_array();

        }
        else
        {
           $comData = array();
        }

        if (!empty($comData['rides'])) 
        {
          $completed_rate = ($comData['rides']/$acceptedData['offered'])*100;
        }
        else
        {
          $completed_rate = 0;
        }

        
        

        $response['available_hours'] = $available_hours;
        $response['Rating'] = $Rating;
        $response['acceptance_rate'] = $acceptance_rate;
        $response['completed_rate'] = round($completed_rate,1);

      /**********************************End****************************************/

      
      generateServerResponse(S,'222',$response);
      
  }

    public function post_rating($requestData)
    {
       $insertdata['customer_id'] =  $requestData['customer_id'];
       $insertdata['driver_id']   =  $requestData['driver_id'];
       $insertdata['booking_id']  =  $requestData['booking_id'];
       $insertdata['comment_id']  =  $requestData['comment_id'];
       $insertdata['rating']      =  $requestData['rating'];
       $insertdata['remark']      =  $requestData['remark'];
       $insertdata['add_date']    =  time();

       $this->db->insert('rating_master',$insertdata);

       /****************rating list data *****************/
       $currentdate = date('Y-m-d');
       $check = $this->db->get_where('ride_rating_master',array('driver_id'=>$requestData['driver_id'],'add_date'=>$currentdate))->row_array();

       if (!empty($check)) 
       {
          
          $updateData['ride']      = $check['ride']+1;
          $updateData['rating']    = $check['rating']+$requestData['rating'];

          $this->db->where('id',$check['id']);
          $this->db->update('ride_rating_master',$updateData);
       }
       else
       {
          $ratingData['driver_id'] = $requestData['driver_id'];
          $ratingData['add_date']  = date('Y-m-d');
          $ratingData['ride']      = 1;
          $ratingData['rating']    = $requestData['rating'];
          $ratingData['time_date'] = time();


          $this->db->insert('ride_rating_master',$ratingData);
       }

        

       /**************************************************/

       generateServerResponse(S,'231');
    }




    public function change_ride_status($requestData)
    {
        $updateArray['status']        = $requestData['status'];
        $updateArray['accept_status'] = 1;
        $updateArray['accept_date']   = time();
        $check = $this->db->get_where('booking_ride_request_master',array('id'=>$requestData['request_id']))->row_array();

        $next_check1 = $this->db->get_where('booking_ride_request_master',array('booking_id'=>$check['booking_id'],'status'=>1))->num_rows();

        if ($next_check1 > 0) 
        {
           generateServerResponse(F,'226');
        }

         $next_check2 = $this->db->get_where('booking_ride_request_master',array('booking_id'=>$check['booking_id'],'status'=>3))->num_rows();

        if ($next_check2 > 0) 
        {
           generateServerResponse(F,'230');
        }

/*        elseif ($check['status'] == 3) 
        {
           generateServerResponse(F,'230');
        }
        else
        {  */
          /****************************Save owner id in ridemaster**********************/

                $this->db->order_by('id','desc');
          $dr = $this->db->get_where('vehicle_request_master',array('driver_id'=>$requestData['userId'],'status'=>1))->row_array();

          if (!empty($dr)) 
          {
            $getowner = $this->db->get_where('owner_vehicle_master',array('id'=>$dr['vehicle_id']))->row_array();
            $getvehnumber = $this->db->get_where('owner_vehicle_master',array('id'=>$dr['vehicle_id']))->row_array();

            $uparray['vehicle_owner_id'] = $getowner['owner_id'];
            $uparray['vehicle_number']   = $getvehnumber['vehicle_number'];
            $this->db->where('id',$check['booking_id']);
            $this->db->update('ride_master',$uparray);
          }

          /*****************************************************************************/
           $this->db->where('id',$requestData['request_id']);
           $this->db->update('booking_ride_request_master',$updateArray);

           $updata['driver_id'] = $requestData['userId'];
           $updata['status'] = 4;
           $this->db->where('id',$check['booking_id']);
           $this->db->update('ride_master',$updata);

              $INSERTDATA['request_id'] = $requestData['request_id'];
              $bookingdata = $this->db->get_where('booking_ride_request_master',array('id'=>$requestData['request_id']))->row_array();

              $INSERTDATA['booking_id'] = $bookingdata['booking_id'];
              $INSERTDATA['type']       = 2;
              $INSERTDATA['add_date']   = time();

              $this->db->insert('ride_log_history',$INSERTDATA);

            /*************No. of rides *************/

            $driverData = $this->db->get_where('driver_master',array('id'=>$requestData['userId']))->row_array();

            $upArray['accepted'] = $driverData['accepted']+1;

            $this->db->where('id',$requestData['userId']);
            $this->db->update('driver_master',$upArray);


            /***********************acceptance ride rate******************************/

            $currdate = date('Y-m-d');
            $check_acceptance = $this->db->get_where('acceptance_rate_master',array('driver_id'=>$requestData['userId'],'add_date'=>$currdate))->row_array();

            if (!empty($check_acceptance)) 
            {
                $update_acceptance_rate_data['accepted']   = $check_acceptance['accepted']+1;

                $this->db->where('id',$check_acceptance['id']);
                $this->db->update('acceptance_rate_master',$update_acceptance_rate_data);
            }

            /**********************************END**************************************/  

           /*****************************Notification*********************************/

           if ($requestData['status'] == 1) 
           {

              $booking_data = $this->db->get_where('ride_master',array('id'=>$check['booking_id']))->row_array();
              $driverdata = $this->db->get_where('driver_master',array('id'=>$check['driver_id']))->row_array();

              $this->db->order_by('id','desc');
              $dr = $this->db->get_where('vehicle_request_master',array('driver_id'=>$requestData['userId'],'status'=>1))->row_array();

               /**************Save Owner Notification***************/

              $notifyArray['owner_id']    = $booking_data['vehicle_owner_id'];
              $notifyArray['booking_id']  = $check['booking_id'];
              $notifyArray['driver_id']   = $check['driver_id'];
              $notifyArray['vehicle_id']  = $dr['vehicle_id'];
              $notifyArray['message']     = "Ride has accepted by ".ucfirst($driverdata['name'])." for Vehicle Number ".$booking_data['vehicle_number'];
              $notifyArray['add_date']    = time();
              

              $this->db->insert('owner_notification',$notifyArray);

              /*************************END************************/

              $device_id = $this->db->select('*')
                           ->from('login_master')
                           ->where(array('userID' => $booking_data['userId'],'type'=>1))
                           ->get()->result_array();
              
              foreach ($device_id as $device_id_data) 
              {
                    $Device_Id = $device_id_data['device_token'];

                    // Message to be sent
                    $message = "Your Ride has accepted by ".ucfirst($driverdata['name']);
                    $dataMessage = array();
                    $dataMessage['Codruk']['message']  = $message;
                    $dataMessage['Codruk']['booking_details']  = json_encode($driverdata);
                    $dataMessage['Codruk']['regId']  = $Device_Id;
                    $dataMessage['Codruk']['notification_type']  = "02";
                    $dataMessage['Codruk']['apikey']   = "AAAAxm2v14c:APA91bEfay7Rff6TK85Ine_PDK6b90mjle_UkbKHY2-4Jpvi-qUJA_FMw9x7QVCALXR6EkaCp_IHuTXqSIGeYIimjZO-VISLeRFPR_PbXkJPPi6NiPt4gMADLXpIkPeBnmGhv_gMvZJj";
                    $sendMessage = json_encode($dataMessage, true);

                    $send_notification = $this->pushSurveyorNotification($sendMessage);
              }

           } 

           /**************************************************************************/
           generateServerResponse(S,'225'); 
        //}
    }

     public function start_navigate($requestData)
    {   
        $booking_details = $this->db->get_where('booking_ride_request_master',array('id'=>$requestData['request_id']))->row_array();
        $booking_data = $this->db->get_where('ride_master',array('id'=>$booking_details['booking_id']))->row_array();
        $userdata = $this->db->get_where('customer_master',array('id'=>$booking_data['userId']))->row_array();

        $updateArray['navigation_status'] = 1;
        $updateArray['navigation_date']   = time();

        $this->db->where('id',$requestData['request_id']);
        $this->db->update('booking_ride_request_master',$updateArray);

        $INSERTDATA['request_id'] = $requestData['request_id'];
        $bookingdata = $this->db->get_where('booking_ride_request_master',array('id'=>$requestData['request_id']))->row_array();

        $INSERTDATA['booking_id'] = $bookingdata['booking_id'];
        $INSERTDATA['type']       = 3;
        $INSERTDATA['add_date']   = time();

        $this->db->insert('ride_log_history',$INSERTDATA);

        $device_id = $this->db->select('*')
                     ->from('login_master')
                     ->where(array('userID' => $userdata['id'],'type'=>1))
                     ->get()->result_array();
        
        foreach ($device_id as $device_id_data) 
        {
              $Device_Id = $device_id_data['device_token'];

              // Message to be sent
              $message = "Pilot has start navigation to your location";
              $dataMessage = array();
              $dataMessage['Codruk']['message']  = $message;
              $dataMessage['Codruk']['booking_details']  = json_encode($booking_data);
              $dataMessage['Codruk']['regId']  = $Device_Id;
              $dataMessage['Codruk']['notification_type']  = "03";
              $dataMessage['Codruk']['apikey']   = "AAAAxm2v14c:APA91bEfay7Rff6TK85Ine_PDK6b90mjle_UkbKHY2-4Jpvi-qUJA_FMw9x7QVCALXR6EkaCp_IHuTXqSIGeYIimjZO-VISLeRFPR_PbXkJPPi6NiPt4gMADLXpIkPeBnmGhv_gMvZJj";
              $sendMessage = json_encode($dataMessage, true);

              $send_notification = $this->pushSurveyorNotification($sendMessage);
        }

        generateServerResponse(S,'Success'); 
    }

     public function start_to_destination($requestData)
    {   
        $booking_details = $this->db->get_where('booking_ride_request_master',array('id'=>$requestData['request_id']))->row_array();
        $booking_data = $this->db->get_where('ride_master',array('id'=>$booking_details['booking_id']))->row_array();
        $userdata = $this->db->get_where('customer_master',array('id'=>$booking_data['userId']))->row_array();

        $updateArray['start_destination']       = 1;
        $updateArray['start_destination_date']  = time();

        $this->db->where('id',$requestData['request_id']);
        $this->db->update('booking_ride_request_master',$updateArray);

        $INSERTDATA['request_id'] = $requestData['request_id'];
        $bookingdata = $this->db->get_where('booking_ride_request_master',array('id'=>$requestData['request_id']))->row_array();

        $INSERTDATA['booking_id'] = $bookingdata['booking_id'];
        $INSERTDATA['type']       = 5;
        $INSERTDATA['add_date']   = time();

        $this->db->insert('ride_log_history',$INSERTDATA);

        $device_id = $this->db->select('*')
                     ->from('login_master')
                     ->where(array('userID' => $userdata['id'],'type'=>1))
                     ->get()->result_array();
        
        foreach ($device_id as $device_id_data) 
        {
              $Device_Id = $device_id_data['device_token'];

              // Message to be sent
              $message = "Pilot has start ride to your destination";
              $dataMessage = array();
              $dataMessage['Codruk']['message']  = $message;
              $dataMessage['Codruk']['booking_details']  = json_encode($booking_data);
              $dataMessage['Codruk']['regId']  = $Device_Id;
              $dataMessage['Codruk']['notification_type']  = "05";
              $dataMessage['Codruk']['apikey']   = "AAAAxm2v14c:APA91bEfay7Rff6TK85Ine_PDK6b90mjle_UkbKHY2-4Jpvi-qUJA_FMw9x7QVCALXR6EkaCp_IHuTXqSIGeYIimjZO-VISLeRFPR_PbXkJPPi6NiPt4gMADLXpIkPeBnmGhv_gMvZJj";
              $sendMessage = json_encode($dataMessage, true);

              $send_notification = $this->pushSurveyorNotification($sendMessage);
        }

        generateServerResponse(S,'Success'); 
    }

     public function arrived_destination($requestData)
    {   
        $booking_details = $this->db->get_where('booking_ride_request_master',array('id'=>$requestData['request_id']))->row_array();
        $booking_data = $this->db->get_where('ride_master',array('id'=>$booking_details['booking_id']))->row_array();
        $userdata = $this->db->get_where('customer_master',array('id'=>$booking_data['userId']))->row_array();

        $updateArray['arrived_destination']       = 1;
        $updateArray['arrived_destination_date']  = time();

        $this->db->where('id',$requestData['request_id']);
        $this->db->update('booking_ride_request_master',$updateArray);

        $INSERTDATA['request_id'] = $requestData['request_id'];
        $bookingdata = $this->db->get_where('booking_ride_request_master',array('id'=>$requestData['request_id']))->row_array();

        $INSERTDATA['booking_id'] = $bookingdata['booking_id'];
        $INSERTDATA['type']       = 6;
        $INSERTDATA['add_date']   = time();

        $this->db->insert('ride_log_history',$INSERTDATA);

        $device_id = $this->db->select('*')
                     ->from('login_master')
                     ->where(array('userID' => $userdata['id'],'type'=>1))
                     ->get()->result_array();
        
        foreach ($device_id as $device_id_data) 
        {
              $Device_Id = $device_id_data['device_token'];

              // Message to be sent
              $message = "Pilot has arrived at your destination";
              $dataMessage = array();
              $dataMessage['Codruk']['message']  = $message;
              $dataMessage['Codruk']['booking_details']  = json_encode($booking_data);
              $dataMessage['Codruk']['regId']  = $Device_Id;
              $dataMessage['Codruk']['notification_type']  = "06";
              $dataMessage['Codruk']['apikey']   = "AAAAxm2v14c:APA91bEfay7Rff6TK85Ine_PDK6b90mjle_UkbKHY2-4Jpvi-qUJA_FMw9x7QVCALXR6EkaCp_IHuTXqSIGeYIimjZO-VISLeRFPR_PbXkJPPi6NiPt4gMADLXpIkPeBnmGhv_gMvZJj";
              $sendMessage = json_encode($dataMessage, true);

              $send_notification = $this->pushSurveyorNotification($sendMessage);
        }


        generateServerResponse(S,'Success'); 
    }

    /******************************Customer cancel the ride after driver accept the ride******************/

         public function customer_cancel_ride($requestData)
    {   
        $updateArray['cancel_reason_id'] = $requestData['reason_id'];
        $updateArray['status'] = 3;
        $check = $this->db->get_where('booking_ride_request_master',array('booking_id'=>$requestData['booking_id']))->row_array();

           $this->db->where('booking_id',$requestData['booking_id']);
           $this->db->update('booking_ride_request_master',$updateArray);

            $updata['type']         = 1; //1=customer,2=driver
            $updata['cancellerId']  = $requestData['userId'];
            $updata['reasonId']     = $requestData['reason_id'];
            $updata['status']       = 2;
            $this->db->where('id',$check['booking_id']);
            $this->db->update('ride_master',$updata);

            $INSERTDATA['cancel_by_type'] = 1;
            $INSERTDATA['cancel_by_id']   = $requestData['userId'];  
            $INSERTDATA['request_id']     = $requestData['booking_id'];
            $INSERTDATA['booking_id'] = $requestData['booking_id'];
            $INSERTDATA['type']       = 8;
            $INSERTDATA['add_date']   = time();

            $this->db->insert('ride_log_history',$INSERTDATA);

           /*****************************Notification*********************************/

     /*      if ($requestData['status'] == 3) 
           {
*/
              $booking_data = $this->db->get_where('ride_master',array('id'=>$check['booking_id']))->row_array();
              $driverdata = $this->db->get_where('driver_master',array('id'=>$check['driver_id']))->row_array();
              $customer_data = $this->db->get_where('customer_master',array('id'=>$booking_data['userId']))->row_array();

                    $this->db->order_by('id','desc');
              $dr = $this->db->get_where('vehicle_request_master',array('driver_id'=>$requestData['userId'],'status'=>1))->row_array();

              /**************Save Owner Notification***************/

/*              $notifyArray['owner_id']    = $booking_data['vehicle_owner_id'];
              $notifyArray['booking_id']  = $check['booking_id'];
              $notifyArray['driver_id']   = $check['driver_id'];
              $notifyArray['vehicle_id']  = $dr['vehicle_id'];
              $notifyArray['message']     = "Ride has cancelled by ".ucfirst($driverdata['name'])." for Vehicle Number ".$booking_data['vehicle_number'];
              $notifyArray['add_date']    = time();
              

              $this->db->insert('owner_notification',$notifyArray);*/

              /*************************END************************/

              $device_id = $this->db->select('*')
                           ->from('login_master')
                           ->where(array('userID' => $booking_data['driver_id'],'type'=>2))
                           ->get()->result_array();
              
              foreach ($device_id as $device_id_data) 
              {
                    $Device_Id = $device_id_data['device_token'];

                    // Message to be sent
                    $message = "Ride has been Cancelled by ".ucfirst($customer_data['name']);
                    $dataMessage = array();
                    $dataMessage['Codruk']['message']  = $message;
                    $dataMessage['Codruk']['booking_details']  = json_encode($driverdata);
                    $dataMessage['Codruk']['regId']  = $Device_Id;
                    $dataMessage['Codruk']['notification_type']  = "08";
                    $dataMessage['Codruk']['apikey']   = "AAAAxm2v14c:APA91bEfay7Rff6TK85Ine_PDK6b90mjle_UkbKHY2-4Jpvi-qUJA_FMw9x7QVCALXR6EkaCp_IHuTXqSIGeYIimjZO-VISLeRFPR_PbXkJPPi6NiPt4gMADLXpIkPeBnmGhv_gMvZJj";
                    $sendMessage = json_encode($dataMessage, true);

                    $send_notification = $this->pushSurveyorNotification($sendMessage);
              }

          // } 

           /**************************************************************************/
           generateServerResponse(S,'228'); 
        
    }

    /*************************************************END*************************************************/
  

     public function cancel_ride($requestData)
    {   
        $updateArray['cancel_reason_id'] = $requestData['reason_id'];
        $updateArray['status'] = $requestData['status'];
        $check = $this->db->get_where('booking_ride_request_master',array('id'=>$requestData['request_id']))->row_array();

           $this->db->where('id',$requestData['request_id']);
           $this->db->update('booking_ride_request_master',$updateArray);

           $updata['status'] = 2;
           $this->db->where('id',$check['booking_id']);
           $this->db->update('ride_master',$updata);

            $INSERTDATA['request_id'] = $requestData['request_id'];
            $bookingdata = $this->db->get_where('booking_ride_request_master',array('id'=>$requestData['request_id']))->row_array();

            $INSERTDATA['booking_id'] = $bookingdata['booking_id'];
            $INSERTDATA['type']       = 8;
            $INSERTDATA['add_date']   = time();

            $this->db->insert('ride_log_history',$INSERTDATA);

           /*****************************Notification*********************************/

           if ($requestData['status'] == 3) 
           {

              $booking_data = $this->db->get_where('ride_master',array('id'=>$check['booking_id']))->row_array();
              $driverdata = $this->db->get_where('driver_master',array('id'=>$check['driver_id']))->row_array();

              $this->db->order_by('id','desc');
              $dr = $this->db->get_where('vehicle_request_master',array('driver_id'=>$requestData['userId'],'status'=>1))->row_array();

              /**************Save Owner Notification***************/

              $notifyArray['owner_id']    = $booking_data['vehicle_owner_id'];
              $notifyArray['booking_id']  = $check['booking_id'];
              $notifyArray['driver_id']   = $check['driver_id'];
              $notifyArray['vehicle_id']  = $dr['vehicle_id'];
              $notifyArray['message']     = "Ride has cancelled by ".ucfirst($driverdata['name'])." for Vehicle Number ".$booking_data['vehicle_number'];
              $notifyArray['add_date']    = time();
              

              $this->db->insert('owner_notification',$notifyArray);

              /*************************END************************/

              $device_id = $this->db->select('*')
                           ->from('login_master')
                           ->where(array('userID' => $booking_data['userId'],'type'=>1))
                           ->get()->result_array();
              
              foreach ($device_id as $device_id_data) 
              {
                    $Device_Id = $device_id_data['device_token'];

                    // Message to be sent
                    $message = "Your Ride has Cancelled by ".ucfirst($driverdata['name']);
                    $dataMessage = array();
                    $dataMessage['Codruk']['message']  = $message;
                    $dataMessage['Codruk']['booking_details']  = json_encode($driverdata);
                    $dataMessage['Codruk']['regId']  = $Device_Id;
                    $dataMessage['Codruk']['notification_type']  = "09";
                    $dataMessage['Codruk']['apikey']   = "AAAAxm2v14c:APA91bEfay7Rff6TK85Ine_PDK6b90mjle_UkbKHY2-4Jpvi-qUJA_FMw9x7QVCALXR6EkaCp_IHuTXqSIGeYIimjZO-VISLeRFPR_PbXkJPPi6NiPt4gMADLXpIkPeBnmGhv_gMvZJj";
                    $sendMessage = json_encode($dataMessage, true);

                    $send_notification = $this->pushSurveyorNotification($sendMessage);
              }

           } 

           /**************************************************************************/
           generateServerResponse(S,'228'); 
        
    }

      public function cancel_ride_before_accept($requestData)
    {
       $update_array['status'] = 3;

       $this->db->where('id',$requestData['request_id']);
       $this->db->update('booking_ride_request_master',$update_array);

       generateServerResponse(S,'Success'); 
    }

    public function getfare_charges($requestData)
    {   
        $check_vehicle_data = $this->db->get_where('customer_vehicle_rate',array('user_id'=>$requestData['userId']))->row_array();
        if (!empty($check_vehicle_data)) 
        {               
                        $this->db->select('vehicle_master.name,vehicle_master.image,vehicle_master.capacity,vehicle_master.loadingTime,customer_vehicle_rate.*');
                        $this->db->join('vehicle_master','vehicle_master.id = customer_vehicle_rate.vehicle_id');
           $checkData = $this->db->get_where('customer_vehicle_rate',array('customer_vehicle_rate.user_id'=>$requestData['userId'],'customer_vehicle_rate.vehicle_id'=>$requestData['vehicle_id'],'customer_vehicle_rate.apply'=>1))->row_array();
           if (!empty($checkData)) 
           {  

              $vehicleData = $checkData;
           }
           else
           {
              $vehicleData = $this->db->get_where('vehicle_master',array('id'=>$requestData['vehicle_id']))->row_array();
           }

        }
        else
        {
           $vehicleData = $this->db->get_where('vehicle_master',array('id'=>$requestData['vehicle_id']))->row_array();
        }
       
        $distance = $this->calculateDistance($requestData['source_lat'],$requestData['source_long'],$requestData['destination_lat'],$requestData['destination_long']);
        $final_array['distance'] = round($distance,1);

        $insurance = $this->db->get_where('insurance_master',array('id'=>$requestData['insurance_id']))->row_array();
        $loader = $this->db->get_where('loader_master',array('id'=>$requestData['loader_id']))->row_array();
        $tax = $this->db->get_where('settings')->row_array();

        $response_data['vehicle_data'] = $vehicleData;
        $response_data['distance_km'] = $final_array['distance'];
        $response_data['insurance_rate'] = $insurance['rate'];
        $response_data['loader'] = $loader;
        $response_data['tax'] = $tax['tax'];
        $response_data['currency'] = $tax['currency'];

        generateServerResponse(S,'222',$response_data); 
    }

   public function get_last_vehicle($requestData)
  {           
              $this->db->order_by('id','desc');    
      $list = $this->db->get_where('ride_master',array('userId'=>$requestData['userId']))->row_array();
      $vehicle_data = $this->db->get_where('vehicle_master',array('id'=>$list['vehicle_id']))->row_array();

      if (!empty($vehicle_data)) 
      {   
         $response_array['Vehicle'] = $vehicle_data;
         generateServerResponse(S,SUCCESS,$response_array); 
      }
      else
      {
         generateServerResponse(F,'E');
      }


  } 

  public function set_status_old($requestData)
  {   

     /*************************new implementation******************************/

     if ($requestData['status'] == 1) 
     {
        $insertArray['driver_id']   = $requestData['userId'];
        $insertArray['online_time'] = time();
        $insertArray['month']       = date('m');
        $insertArray['year']        = date('Y');

        $this->db->insert('online_status_log',$insertArray);
     }
     else
     {  
        $updateArray['offline_time'] = time();
        $this->db->where(array('driver_id'=>$requestData['userId'],'offline_time'=> NULL));
        $this->db->update('online_status_log',$updateArray);
     }

     /**************************************************************************/
     $update_array['online_status'] = $requestData['status']; 
     $this->db->where('id',$requestData['userId']);
     $this->db->update('driver_master',$update_array);

     generateServerResponse(S,SUCCESS,$update_array); 
  } 


    public function set_status($requestData)
  {   

     /*************************new implementation******************************/

     if ($requestData['status'] == 1) 
     {
        $insertArray['driver_id']   = $requestData['userId'];
        $insertArray['online_time'] = time();
        $insertArray['month']       = date('m');
        $insertArray['year']        = date('Y');

        $this->db->insert('online_status_log',$insertArray);
     }
     else
     {  
        $updateArray['offline_time'] = time();
        $this->db->where(array('driver_id'=>$requestData['userId'],'offline_time'=> NULL));
        $this->db->update('online_status_log',$updateArray);
     }

     /**********************************On Off master record*********************/
     if ($requestData['status'] == 1) 
     {
       $insertlog_array['driver_id']   = $requestData['userId'];
       $insertlog_array['online_time'] = time();
       $insertlog_array['add_date']    = date('Y-m-d');

       $this->db->insert('on_off_master',$insertlog_array);
     }
     else
     {  
        $updatelog_Array['offline_time'] = time();
        $this->db->where(array('driver_id'=>$requestData['userId'],'offline_time'=> NULL));
        $this->db->update('on_off_master',$updatelog_Array);
     }

     /***************************************************************************/
     $update_array['online_status'] = $requestData['status']; 
     $this->db->where('id',$requestData['userId']);
     $this->db->update('driver_master',$update_array);

     generateServerResponse(S,SUCCESS,$update_array); 
  } 
  
   public function set_shipment_status($requestData)
  {   

    $this->db->where(array('driver_id'=>$requestData['userId'],'ID'=>$requestData['ID']));
    $this->db->update('shipments',array('status'=> $requestData['status']));


     generateServerResponse(S,SUCCESS,$update_array); 
  } 


  public function set_location($requestData)
  {   
     $update_array['location'] = $requestData['location']; 
     $update_array['location_latitude'] = $requestData['location_latitude']; 
     $update_array['location_longitude'] = $requestData['location_longitude']; 
     $update_array['modifyDate'] = time(); 

     $this->db->where('id',$requestData['userId']);
     $this->db->update('driver_master',$update_array);

     if ($update_array['location_latitude'] == "") 
     {
       generateServerResponse(F,SUCCESS); 
     }
     else
     {
       generateServerResponse(S,SUCCESS); 
     }

  } 



 /* public function searchvehicle($requestData)
  {
                 $this->db->like('vehicle_number',$requestData['search']);
        $list =  $this->db->get_where('owner_vehicle_master',array('admin_approval'=>1))->result_array();

        $vehicleArray = array();
        foreach ($list as $key => $value) 
        {
          $vehicleArray['VehicleData'][$key]['id']             = $value['id'];
          $vehicleArray['VehicleData'][$key]['vehicle_number'] = $value['vehicle_number'];

          $vehdata = $this->db->get_where('vehicle_master',array('id'=>$value['vehicle_master_id']))->row_array();
          $vehicleArray['VehicleData'][$key]['name'] = $vehdata['name'];
          $vehicleArray['VehicleData'][$key]['image'] = $vehdata['image'];

          $check_request = $this->db->get_where('vehicle_request_master',array('driver_id'=>$requestData['uuid'],'vehicle_id'=>$value['id'],'status!='=>4))->row_array();

          if ($check_request['status'] == 1)
          {
            $vehicleArray['VehicleData'][$key]['request_status'] = 1;
          }
          elseif($check_request['status'] == 2)
          {
            $vehicleArray['VehicleData'][$key]['request_status'] = 2;
          }
          else
          {
            $vehicleArray['VehicleData'][$key]['request_status'] = 3;
          }

        }

        $response['VehicleData'] = $vehicleArray;

        if (!empty($list)) 
        {
           generateServerResponse(S,SUCCESS,$response); 
        }
        else
        {
           generateServerResponse(F,'E');
        }
        
  }*/

   public function searchvehicle($requestData)
  {     
                 $this->db->like('vehicle_number',$requestData['search']);
        $list =  $this->db->get_where('owner_vehicle_master',array('admin_approval'=>1))->result_array();

        $vehicleArray = array();
        $i = 0;
        foreach ($list as $key => $value) 
        {   
            if ($value['vehicle_status'] == 1) 
            {
               $maincheck = $this->db->get_where('vehicle_request_master',array('driver_id'=>$requestData['uuid'],'vehicle_id'=>$value['id']))->row_array();
               if (!empty($maincheck)) 
               {
                    $vehicleArray['VehicleData'][$i]['id']             = $value['id'];
                    $vehicleArray['VehicleData'][$i]['vehicle_number'] = $value['vehicle_number'];

                    $vehdata = $this->db->get_where('vehicle_master',array('id'=>$value['vehicle_master_id']))->row_array();
                    $vehicleArray['VehicleData'][$i]['name'] = $vehdata['name'];
                    $vehicleArray['VehicleData'][$i]['image'] = $vehdata['image'];

                    $check_request = $this->db->get_where('vehicle_request_master',array('driver_id'=>$requestData['uuid'],'vehicle_id'=>$value['id'],'status!='=>4))->row_array();

                    if ($check_request['status'] == 1)
                    {
                      $vehicleArray['VehicleData'][$i]['request_status'] = 1;
                    }
                    elseif($check_request['status'] == 2)
                    {
                      $vehicleArray['VehicleData'][$i]['request_status'] = 2;
                    }
                    else
                    { 

                      $newcheck = $this->db->get_where('vehicle_request_master',array('driver_id !='=>$requestData['uuid'],'vehicle_id'=>$value['id'],'status'=>1))->num_rows();
                      if ($newcheck > 0) 
                      {
                        $vehicleArray['VehicleData'][$i]['request_status'] = 0;
                      }
                      else
                      {
                         $vehicleArray['VehicleData'][$i]['request_status'] = 3;
                      }

                      
                    }

                   $i++;  
               }
                
            }
            else
            {
                $vehicleArray['VehicleData'][$i]['id']             = $value['id'];
                $vehicleArray['VehicleData'][$i]['vehicle_number'] = $value['vehicle_number'];

                $vehdata = $this->db->get_where('vehicle_master',array('id'=>$value['vehicle_master_id']))->row_array();
                $vehicleArray['VehicleData'][$i]['name'] = $vehdata['name'];
                $vehicleArray['VehicleData'][$i]['image'] = $vehdata['image'];

                $check_request = $this->db->get_where('vehicle_request_master',array('driver_id'=>$requestData['uuid'],'vehicle_id'=>$value['id'],'status!='=>4))->row_array();

                if ($check_request['status'] == 1)
                {
                  $vehicleArray['VehicleData'][$i]['request_status'] = 1;
                }
                elseif($check_request['status'] == 2)
                {
                  $vehicleArray['VehicleData'][$i]['request_status'] = 2;
                }
                else
                { 
                   $newcheck = $this->db->get_where('vehicle_request_master',array('driver_id !='=>$requestData['uuid'],'vehicle_id'=>$value['id'],'status'=>1))->num_rows();
                    if ($newcheck > 0) 
                    {
                      $vehicleArray['VehicleData'][$i]['request_status'] = 0;
                    }
                    else
                    {
                       $vehicleArray['VehicleData'][$i]['request_status'] = 3;
                    }
                  //$vehicleArray['VehicleData'][$key]['request_status'] = 3;
                }
                $i++;  
            }

        }

       //print_r($vehicleArray);die;

        $response['VehicleData'] = $vehicleArray;

        if (empty($requestData['search'])) 
        {
            generateServerResponse(F,'E');
        }
        else
        {
           if (!empty($vehicleArray)) 
          {
             generateServerResponse(S,SUCCESS,$response); 
          }
          else
          {
             generateServerResponse(F,'E');
          }
        }
        

        
        
  }

    public function send_request($requestData)
    {  
      $param                        = array();
      $param['driver_id']           = $requestData['uuid'];
      $param['vehicle_id']          = $requestData['vehicle_id'];
      $param['add_date']            = time();
      //$param['modify_date']         = time();
      $param['status']              = 2;

      $check = $this->db->get_where('vehicle_request_master',array('driver_id'=>$requestData['uuid'],'status'=>1))->row_array();

      if (!empty($check)) 
      {
          generateServerResponse(F,'219');
      }
      else
      {
          $excuteQuery = $this->db->insert('vehicle_request_master',$param);
          if($excuteQuery > 0)
          {
             generateServerResponse(S,'Send_request'); 
          }
          else
          {
              generateServerResponse(F,'W');
          }
      }

      
    }

     public function cancel_request($requestData)
    {  

      $check = $this->db->get_where('vehicle_request_master',array('driver_id'=>$requestData['uuid'],'vehicle_id'=>$requestData['vehicle_id'],'status'=>1))->row_array();

      if (!empty($check)) 
      {
          generateServerResponse(F,'220');
      }
      else
      {
          $this->db->where(array('driver_id'=>$requestData['uuid'],'vehicle_id'=>$requestData['vehicle_id'],'status!='=>4));
         $excuteQuery = $this->db->delete('vehicle_request_master');

          if($excuteQuery > 0)
          {
             generateServerResponse(S,'Cancel_request'); 
          }
          else
          {
              generateServerResponse(F,'W');
          }
      }
                      
    }


  /*public function getrides($requestData)
  {     
      if ($requestData['status'] == 1) 
      {
          $ridedata = $this->db->get_where('ride_master',array('userId'=>$requestData['userId'],'status'=>1))->result_array();
      }
      else
      {
          $ridedata = $this->db->get_where('ride_master',array('userId'=>$requestData['userId'],'status'=>2))->result_array();
      }

      $rideArray = array();
      foreach ($ridedata as $key => $value) 
      {
           $rideArray['RideArray'][$key]['id'] = $value['id'];
           $rideArray['RideArray'][$key]['userId'] = $value['userId'];
           $rideArray['RideArray'][$key]['bookingId'] = $value['bookingId'];
           $rideArray['RideArray'][$key]['pickupAddress'] = $value['pickupAddress'];
           $rideArray['RideArray'][$key]['pickupLat'] = $value['pickupLat'];
           $rideArray['RideArray'][$key]['pickupLong'] = $value['pickupLong'];
           $rideArray['RideArray'][$key]['dropoffAddress'] = $value['dropoffAddress'];

           $rideArray['RideArray'][$key]['dropoffLat'] = $value['dropoffLat'];
           $rideArray['RideArray'][$key]['dropoffLong'] = $value['dropoffLong'];
           $rideArray['RideArray'][$key]['dropoffName'] = $value['dropoffName'];
           $rideArray['RideArray'][$key]['dropoffNumber'] = $value['dropoffNumber'];
           $rideArray['RideArray'][$key]['loaderCount'] = $value['loaderCount'];
           $rideArray['RideArray'][$key]['insuranceType'] = $value['insuranceType'];
           $rideArray['RideArray'][$key]['payAt'] = $value['payAt'];

           $rideArray['RideArray'][$key]['payType'] = $value['payType'];
           $rideArray['RideArray'][$key]['deliveryFare'] = $value['deliveFare'];
           $rideArray['RideArray'][$key]['loaderCharge'] = $value['loaderCharge'];
           $rideArray['RideArray'][$key]['insuranceCharge'] = $value['insuranceCharge'];
           $rideArray['RideArray'][$key]['delayCharge'] = $value['delayCharge'];
           $rideArray['RideArray'][$key]['tax'] = $value['tax'];
           $rideArray['RideArray'][$key]['totalCharge'] = $value['totalCharge'];

           $rideArray['RideArray'][$key]['pickupSubAddress'] = $value['pickupSubAddress'];
           $rideArray['RideArray'][$key]['dropoffSubAddress'] = $value['dropoffSubAddress'];

           $rideArray['RideArray'][$key]['type'] = $value['type'];

           if ($value['type'] == 1) 
           {
               $rideArray['RideArray'][$key]['cancelBy'] = "Customer";
               $customer_data = $this->db->get_where('customer_master',array('id'=>$value['cancellerId']))->row_array();
               $rideArray['RideArray'][$key]['cancelByName'] = ucfirst($customer_data['name']);
               $reasondata = $this->db->get_where('reason_master',array('id'=>$value['reasonId']))->row_array();
               $rideArray['RideArray'][$key]['cancelReason'] = ucfirst($reasondata['name']);
           }
           elseif ($value['type'] == 2) 
           {
               $rideArray['RideArray'][$key]['cancelBy'] = "Driver";
               $driver_data = $this->db->get_where('driver_master',array('id'=>$value['cancellerId']))->row_array();
               $rideArray['RideArray'][$key]['cancelByName'] = ucfirst($driver_data['name']);
               $reasondata = $this->db->get_where('reason_master',array('id'=>$value['reasonId']))->row_array();
               $rideArray['RideArray'][$key]['cancelReason'] = ucfirst($reasondata['name']);
           }
           else
           {
                $rideArray['RideArray'][$key]['cancelBy'] = "";
                $rideArray['RideArray'][$key]['cancelByName'] = "";
                $rideArray['RideArray'][$key]['cancelReason'] = "";
           }

      }

      if (!empty($ridedata)) 
      {
          generateServerResponse('1','S',$rideArray);
      }
      else
      {
         generateServerResponse('0','E');
      }


      
  }*/

    public function getrides($requestData)
  {     
      if ($requestData['status'] == 1) 
      {
          $ridedata = $this->db->get_where('ride_master',array('userId'=>$requestData['userId'],'status'=>1))->result_array();
      }
      else
      {
          $ridedata = $this->db->get_where('ride_master',array('userId'=>$requestData['userId'],'status'=>2))->result_array();
      }

      $rideArray = array();
      foreach ($ridedata as $key => $value) 
      {
           $rideArray['RideArray'][$key]['id'] = $value['id'];
           $rideArray['RideArray'][$key]['userId'] = $value['userId'];
           $rideArray['RideArray'][$key]['bookingId'] = $value['bookingId'];
           $rideArray['RideArray'][$key]['pickupAddress'] = $value['pickupAddress'];
           $rideArray['RideArray'][$key]['pickupLat'] = $value['pickupLat'];
           $rideArray['RideArray'][$key]['pickupLong'] = $value['pickupLong'];
           $rideArray['RideArray'][$key]['dropoffAddress'] = $value['dropoffAddress'];

           $rideArray['RideArray'][$key]['dropoffLat'] = $value['dropoffLat'];
           $rideArray['RideArray'][$key]['dropoffLong'] = $value['dropoffLong'];
           $rideArray['RideArray'][$key]['dropoffName'] = $value['dropoffName'];
           $rideArray['RideArray'][$key]['dropoffNumber'] = $value['dropoffNumber'];
           $rideArray['RideArray'][$key]['loaderCount'] = $value['loaderCount'];
           $rideArray['RideArray'][$key]['insuranceType'] = $value['insuranceType'];
           $rideArray['RideArray'][$key]['payAt'] = $value['payAt'];

           $rideArray['RideArray'][$key]['payType'] = $value['payType'];
           $rideArray['RideArray'][$key]['deliveryFare'] = $value['deliveFare'];
           $rideArray['RideArray'][$key]['loaderCharge'] = $value['loaderCharge'];
           $rideArray['RideArray'][$key]['insuranceCharge'] = $value['insuranceCharge'];
           $rideArray['RideArray'][$key]['delayCharge'] = $value['delayCharge'];
           $rideArray['RideArray'][$key]['tax'] = $value['tax'];
           $rideArray['RideArray'][$key]['totalCharge'] = $value['totalCharge'];

           $rideArray['RideArray'][$key]['pickupSubAddress'] = $value['pickupSubAddress'];
           $rideArray['RideArray'][$key]['dropoffSubAddress'] = $value['dropoffSubAddress'];

           $rideArray['RideArray'][$key]['type'] = $value['type'];

           if ($value['type'] == 1) 
           {
               $rideArray['RideArray'][$key]['cancelBy'] = "Customer";
               $customer_data = $this->db->get_where('customer_master',array('id'=>$value['cancellerId']))->row_array();
               $rideArray['RideArray'][$key]['cancelByName'] = ucfirst($customer_data['name']);
               $reasondata = $this->db->get_where('reason_master',array('id'=>$value['reasonId']))->row_array();
               $rideArray['RideArray'][$key]['cancelReason'] = ucfirst($reasondata['name']);
           }
           elseif ($value['type'] == 2) 
           {
               $rideArray['RideArray'][$key]['cancelBy'] = "Driver";
               $driver_data = $this->db->get_where('driver_master',array('id'=>$value['cancellerId']))->row_array();
               $rideArray['RideArray'][$key]['cancelByName'] = ucfirst($driver_data['name']);
               $reasondata = $this->db->get_where('reason_master',array('id'=>$value['reasonId']))->row_array();
               $rideArray['RideArray'][$key]['cancelReason'] = ucfirst($reasondata['name']);
           }
           else
           {
                $rideArray['RideArray'][$key]['cancelBy'] = "";
                $rideArray['RideArray'][$key]['cancelByName'] = "";
                $rideArray['RideArray'][$key]['cancelReason'] = "";
           }

      }

      if (!empty($ridedata)) 
      {
         generateServerResponse('1','Success',$rideArray);
      }
      else
      {
         generateServerResponse('0','E');
      }


      
  }

 // Cancel ride code here
  public function rideCancelled($requestData){  
    $param                 = array();
    $param['type']         = 1; //1=customer,2=driver
    $param['cancellerId']  = $requestData['userId'];
    $param['reasonId']     = $requestData['reasonId'];
    $param['status']       = 2; //for cancel the ride
    $param['modifyDate']   = time();
     $this->db->where('id',$requestData['bookingId']);
     $excuteQuery = $this->db->update('ride_master',$param);

     $updatarr['status'] = 3;
     $this->db->where('booking_id',$requestData['bookingId']);
     $this->db->update('booking_ride_request_master',$updatarr);

     /**********************************new***************************************/
      $INSERTDATA['cancel_by_type'] = 1;
      $INSERTDATA['cancel_by_id']   = $requestData['userId'];

      $INSERTDATA['request_id'] = $requestData['bookingId'];
      $INSERTDATA['booking_id'] = $requestData['bookingId'];
      $INSERTDATA['type']       = 8;
      $INSERTDATA['add_date']   = time();

      $this->db->insert('ride_log_history',$INSERTDATA);

     /************************************END*************************************/       

    if($excuteQuery > 0){
       generateServerResponse(S,SUCCESS); 
    }else{
        generateServerResponse(F,'W');
    }
  }
 
 // Cancel ride code here
  public function getAccessTokens(){ 
    $str=rand(); 
    $result = md5($str); 
    $this->db->insert('access_tokens',array('access'=>$result,'add_date'=>time(),'expire_date'=>time()));
    $response['accessToken'] =$result;
    generateServerResponse(S,SUCCESS,$response); 
  }
 // Cancel ride code here
  public function postShipment($requestData){  
    isBlank($requestData['shipper_name'],NOT_EXISTS,205);
    isBlank($requestData['shipper_address'],NOT_EXISTS,206);
    isBlank($requestData['consignee_name'],NOT_EXISTS,207);
    isBlank($requestData['consignee_address'],NOT_EXISTS,208);
    isBlank($requestData['consignee_mobile_number'],NOT_EXISTS,29);
    isBlank($requestData['collection_type'],NOT_EXISTS,210);
    isBlank($requestData['collection_amount'],NOT_EXISTS,211);
    isBlank($requestData['borcode_id'],NOT_EXISTS,212);
    $shipment = array();
    $shipment['shipper_name'] = $requestData['shipper_name'];
    $shipment['shipper_address'] = $requestData['shipper_address'];
    $shipment['shipper_city'] = $requestData['shipper_city'];
    $shipment['consignee_name'] = $requestData['consignee_name'];
    $shipment['consignee_address'] = $requestData['consignee_address'];
    $shipment['consignee_city'] = $requestData['consignee_city'];
    $shipment['consignee_mobile_number'] = $requestData['consignee_mobile_number'];
    $shipment['collection_type'] = $requestData['collection_type'];
    $shipment['collection_amount'] = $requestData['collection_amount'];
    $shipment['borcode_url'] = $requestData['borcode_url'];
        if(!empty($requestData['borcode_base'])):
            $path  = CUSTOMER_DIRECTORY.'mediaFile/barcode/';
           echo $shipment['borcode_base'] = saveProfilesImage($requestData['borcode_base'],$path,time());
        endif;
    $shipment['borcode_id'] = $requestData['borcode_id'];
    $shipment['add_date'] =  time();
    $shipment['update_date'] = time(); 
    $shipment['status'] = 2;

    $check = $this->db->get_where('post_shipment',array('borcode_id'=>$shipment['borcode_id']))->num_rows();
    if ($check > 0) 
    {
       generateServerResponse(F,218);  
    }      


    $this->db->insert('post_shipment',$shipment);
     $checkAffectedRows = $this->db->affected_rows();
     if($checkAffectedRows > 0):
          generateServerResponse(S,213);  
         else:
         generateServerResponse(F,'WRONG');  
        endif;
  }

  // Cancel ride code here
  public function updateShipment($requestData){  
    isBlank($requestData['barcode_id'],NOT_EXISTS,212);
    isBlank($requestData['status'],NOT_EXISTS,215);

    $shipment = array();
    $shipment['status'] = $requestData['status'];
       
    $this->db->where('borcode_id',$requestData['barcode_id']);    
    $this->db->update('post_shipment',$shipment);
     $checkAffectedRows = $this->db->affected_rows();
     if($checkAffectedRows > 0):
          generateServerResponse(S,216);  
         else:
         generateServerResponse(F,217);  
        endif;
  }

   public function accessApiRequest($accessToken){
        $checkApiRequest = $this->db->get_where('access_tokens',array('access'=>$accessToken,'type'=>1))->row_array();
        // echo $this->db-
        if(!empty($checkApiRequest)){
            $this->db->where('id',$checkApiRequest['id']);
            $this->db->update('access_tokens',array('type'=>2));
             return 1;
        }else{
           generateServerResponse(F,214);   
        }
   }
 
}
?>