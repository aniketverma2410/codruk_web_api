<style type="text/css">
  .top{    position: relative;
    top: 3px;}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Manage Pilots
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin-dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Manage Pilots</a></li>
        <li class="active">List</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div  id="hiddenSms"><?php echo $this->session->flashdata('message'); ?></div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-condensed table-bordered table-hover">
                <thead>
                <tr>
                  <th>S. No.</th>
                  <th>Unique ID</th>
                  <th>Profile Pic</th>
                  <th>Online/Offline</th>
                  <th>Name</th>
          <!--         <th>Email</th> -->
                  <th>Mobile</th>
                  <th>Last Ride</th>
                  <th>Assigned Vehicle</th>
                  <th>Last Updated Location</th>
                  <th>Last Login</th>
                  <th>Register&nbsp;At</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  <?php 
                     $count = 1;
                     $showhalfstar = "";
                    foreach($result as $list){ 
                      $lastLogin = $this->Customer_model->getLastLoginDetails($list['id'],2,1);

                      $this->db->select_sum('rating');
                      $pilotrating = $this->db->get_where('rating_master',array('driver_id'=>$list['id']))->row_array();

                      $number_rating = $this->db->get_where('rating_master',array('driver_id'=>$list['id']))->num_rows();


                      if ($number_rating > 0) 
                      {
                        $final_rating = $pilotrating['rating']/$number_rating;
                      }
                      else
                      {
                         $final_rating = 0;
                      }

                      $starcount   = $final_rating;
                      $blankstart  = 5-$starcount;


                      if(is_float($starcount))
                      {
                         $exdata = explode('.', $starcount);
                         if ($exdata[1] > 5) 
                         {
                           $showhalfstar = 0;
                         }
                         else
                         {
                           $showhalfstar = 1;
                         }
                      } 

                      ?>
                     <tr>
                       <td><?php echo $count; ?>
                       </td>
                       <td><?php echo "Pilot_".$list['id']; ?></td>
                        <td><?php echo !empty($list['image']) ? '<img src="'.base_url('mediaFile/drivers/').$list['image'].'" width="100" height="80">' : '<img src="'.base_url().'/theme/dist/img/user2-160x160.jpg" width="100" height="80">'; ?></td>
                        <td>
                          <?php if ($list['online_status'] == 1) 
                         {
                           $logimg = base_url('mediaFile/green.png');
                         }
                         else
                         {
                           $logimg = base_url('mediaFile/red.png');
                         }
                          ?>
                        <a href="<?php echo base_url('Customers/status_history/'.$list['id'])?>"><img src="<?php echo $logimg;?>" style="width: 15px;margin-left: 17px;"><br>&nbsp;View History</a>  </td>
                       <td><?php echo $list['name']; ?>
                                    <br>
                        <span class="top">
                          <?php 
                          if ($final_rating == 0) 
                          {
                            echo "0.0";
                          }
                          else
                          {
                            echo round($final_rating,1);
                          }
                          
                          ?>
                        </span>&nbsp;
                           <?php
                          for($i=1; $i<=$starcount; $i++){
                        ?>
                          <img class="" alt="" src="<?php echo base_url('mediaFile/yellow-star.png')?>" height="16px;" >
                        <?php
                        }
                        ?>
                        <?php if ($starcount > 0) 
                        {?>
                          
                        <?php if ($showhalfstar == 0) 
                        {?>
                          <img class="" alt="" src="<?php echo base_url('mediaFile/yellow-star.png')?>" height="16px;" >
                        <?php }else{?>
                          <img class="" alt="" src="<?php echo base_url('mediaFile/half-star.png')?>" height="16px;" >
                        <?php }?>
                       <?php }?>   

                        <?php
                          for($i=1; $i<=$blankstart; $i++){
                        ?>
                          <img class="avatar" alt="SuperAdmin" src="<?php echo base_url('mediaFile/grey-star.png')?>" height="16px;">
                        <?php
                        }
                        ?>
                        <br>                     
                        <?php if ($number_rating > 0) 
                        {?>
                        <?php  if ($number_rating > 0) {?>
                         
                        <a href="<?php echo base_url('Customers/rating_list/'.$list['id'])?>"><?php echo $number_rating?> Comments</a>
                      <?php }else{?>
                        <a href="<?php echo base_url('Customers/rating_list/'.$list['id'])?>"><?php echo $number_rating?> Comment</a>
                      <?php }?>
                      <?php }else{?>
                       <?php echo $number_rating?> Comment
                      <?php }?> 

                       </td>
                       <!-- <td><?php echo $list['email']; ?></td> -->
                       <td><?php echo $list['mobile'].' '.(($list['otpVerifyStatus'] == 1) ? '<span><i class="fa fa-check" style="color:green"></i></span>' : '<span><i class="fa fa-remove" style="color:red"></i></span>'); ?></td>

                       <?php 
                               $this->db->order_by('id','desc');
                       $ride = $this->db->get_where('ride_master',array('driver_id'=>$list['id']))->row_array();
                       ?>

                       <?php if (!empty($ride)) {?>
                      <?php if($ride['status'] == 2){ ?>
                        <td><?php echo date('jS M Y h:i A',$ride['addDate']); ?><br><a href="<?php echo base_url('Customers/pilot_cancel_rides/').$list['id'].'?first=2'; ?>">View All</a></td>
                      <?php }elseif($ride['status'] == 3){ ?>
                         <td><?php echo date('jS M Y h:i A',$ride['addDate']); ?><br><a href="<?php echo base_url('Customers/pilot_completed_rides/').$list['id'].'?first=2'; ?>">View All</a></td>
                      <?php }else{?>
                         <td><?php echo date('jS M Y h:i A',$ride['addDate']); ?><br><a href="<?php echo base_url('Customers/pilot_running_rides/').$list['id'].'?first=2'; ?>">View All</a></td> 
                      <?php } ?>  
                      <?php }else{?>
                        <td><?php echo "N/A"?></td>
                      <?php } ?>  
                      
                        <?php 
                               $this->db->order_by('id','desc');
                       $ride = $this->db->get_where('ride_master',array('userId'=>$list['id']))->row_array();

                       $this->db->order_by('id','desc');
                       $assigned = $this->db->get_where('vehicle_request_master',array('driver_id'=>$list['id'],'status'=>1))->row_array();
                       $vehicle = $this->db->get_where('owner_vehicle_master',array('id'=>$assigned['vehicle_id']))->row_array();
                       ?>

                       <?php if (!empty($vehicle)) {?>
                        
                       <td><?php echo $vehicle['vehicle_number']?><br><a href="<?php echo base_url('Customers/request_history/').$list['id']; ?>">View History</a></td>

                     <?php }else{?>
                       <td><?php echo "N/A" ?></td>
                     <?php }?>

                       <!-- <?php if (!empty($ride)) {?>
                        <?php if ($ride['status'] == 1) {?>
                        <td><?php echo date('jS M Y h:i A',$ride['addDate']); ?><br><a href="<?php echo base_url('Customers/customer_pending_rides/').$list['id'].'?first=2'; ?>">View All</a></td>
                      <?php }else{ ?>
                        <td><?php echo date('jS M Y h:i A',$ride['addDate']); ?><br><a href="<?php echo base_url('Customers/customer_cancel_rides/').$list['id'].'?first=2'; ?>">View All</a></td>
                      <?php } ?>
                      <?php }else{?>
                        <td><?php echo "N/A"?></td>
                      <?php } ?>   -->


                       <?php if (!empty($list['location'])) {?>
                        <td>
                          <?php echo $list['location'];?>
                          <br>
                          <span style="color:#549ec3;">Last Updated: <?php echo date('jS M Y h:i A',$list['modifyDate']); ?>  </span>
                        </td>
                      <?php }else{?>
                        <td><?php echo "N/A";?></td>
                      <?php }?>  

                     

                        <?php if (!empty($lastLogin)) {?>
                       <td><?php echo date('jS M Y h:i A',$lastLogin['addDate']); ?><br><a href="<?php echo base_url('Customers/pilotloginHistory/').$list['id']; ?>">View History</a></td>
                      <?php }else{?>
                        <td><?php echo "N/A"?></td>
                      <?php } ?> 
                      
                       <td><?php echo date('jS M Y h:i A',$list['addDate']); ?></td>
                       <td><?php 
                          if($list['status'] =='1'){ ?>
                            <span class="label label-success">Activated</span>  
                          <?php } elseif($list['status'] =='2') { ?>
                            <span class="label label-warning">Pending</span> 
                          <?php }else{ ?>
                             <span class="label label-danger">Rejected</span> 
                          <?php }?>  
                          </td>
                       <td>
                          
                           <a href="<?php echo base_url('Customers/updatepilot/'); ?><?php echo $list['id']; ?>/1" title="" class="btn btn-info btn-sm">View/Edit</a></td>
                      </tr>
                    <?php $count++; } ?>        
 
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
