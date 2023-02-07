<style type="text/css">
    .h3, h3{margin: 0px;margin-bottom: -8px;}
     .box-body{overflow-x: hidden;}
    .show{    background: #fff;
    padding: 9px 0px;
    color: #444;
    /* border-top: 1px solid #d2d6de; */
    background-color: #ffffff66;
    border: 1px #e6e4e478 solid;
    z-index: 9999999;
     box-shadow:1px 2px 6px 2px #bfbfbf;
  }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Ride Details
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin-dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
         <li><a href="#" onclick="window.history.go(-1); return false;"><i class="fa fa-dashboard"></i>Cancel Rides</a></li>
        <li class="active">Ride Details</li>
      </ol>
    </section>


    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-6">
          <div class="box">
           <div  id="hiddenSms"><?php echo $this->session->flashdata('message'); ?></div>
            <!-- /.box-header -->
            <div class="box-body">
                <form class="form-horizontal" action="<?php echo base_url('Admin/addUnitPost'); ?>" enctype="multipart/form-data" method="post" > 

                <div class="row">
                  <div class="col-sm-12">
                      <h3>Customer Information</h3>
                  </div>
                </div>   

                <hr>
     
                 <div class="row">
                  <div class="col-sm-6">
                      <label>Name:</label>
                       <input type="text" class="form-control" value="<?php echo ucfirst($customerdata['name']) ?>" disabled="">
                  </div>
                  <div class="col-sm-6">
                      <label>Email:</label>
                       <input type="text" class="form-control" value="<?php echo $customerdata['email'] ?>" disabled="">
                  </div>
                </div>
                &nbsp;

                 <div class="row">
                  <div class="col-sm-12">
                      <label>Mobile Number:</label>
                       <input type="text" class="form-control"  value="<?php echo $customerdata['mobile']?>" disabled="">
                  </div>
                </div>

                 &nbsp;

                </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          <!-- /.box -->

        <div class="row">
            <div class="col-xs-12">
               <div class="box">
           <div  id="hiddenSms"><?php echo $this->session->flashdata('message'); ?></div> 
            <div class="box-body">
                <form class="form-horizontal" action="<?php echo base_url('Admin/addUnitPost'); ?>" enctype="multipart/form-data" method="post" > 

                <div class="row">
                  <div class="col-sm-12">
                      <h3>Ride Details</h3>
                  </div>
                </div>   

                <hr>
     
                <div class="row">
                  <div class="col-sm-12">
                      <label>Booking Id:</label>
                       <input type="text" class="form-control" value="<?php echo $ridedata['bookingId'] ?>" disabled="">
                  </div>
                </div>
                &nbsp;

                <div class="row">
                  <div class="col-sm-12">
                      <label>Pickup Location:</label>
                       <textarea class="form-control" disabled=""><?php echo $ridedata['pickupSubAddress']?><?php echo $ridedata['pickupAddress']?></textarea>
                  </div>
                </div>

                &nbsp;

                  <!--  <div class="row">
                  <div class="col-sm-12">
                      <label>Pickup Sub Address:</label>
                       <textarea class="form-control" disabled=""><?php echo $ridedata['pickupSubAddress']?></textarea>
                  </div>
                </div>

                 &nbsp;

                 <div class="row">
                  <div class="col-sm-12">
                      <label>Pickup Lat/ Long:</label>
                       <input type="text" class="form-control"  value="<?php echo $ridedata['pickupLat'].'/ '.$ridedata['pickupLong']?>" disabled="">
                  </div>
                </div>

                 &nbsp;

                 <div class="row">
                  <div class="col-sm-12">
                      <label>Drop Off Name:</label>
                       <input type="text" class="form-control"  value="<?php echo $ridedata['dropoffName']?>" disabled="">
                  </div>
                </div>

                 &nbsp;

                  <div class="row">
                  <div class="col-sm-12">
                      <label>Drop Off Number:</label>
                       <input type="text" class="form-control"  value="<?php echo $ridedata['dropoffNumber']?>" disabled="">
                  </div>
                </div>

                 &nbsp; -->

                 <div class="row">
                  <div class="col-sm-12">
                      <label>Drop Off Location:</label>
                       <textarea class="form-control" disabled=""><?php echo $ridedata['dropoffSubAddress']?><?php echo $ridedata['dropoffAddress']?></textarea>
                  </div>
                </div>

                 &nbsp;

                  <div class="row">
                  <div class="col-sm-12">
                      <label>Total Distance (Km):</label>
                       <input type="text" value="<?php echo $ridedata['km']?>" class="form-control" disabled>
                  </div>
                </div>

                &nbsp;

                <!--  <div class="row">
                  <div class="col-sm-12">
                      <label>Drop Off Sub Address:</label>
                       <textarea class="form-control" disabled=""><?php echo $ridedata['dropoffSubAddress']?></textarea>
                  </div>
                </div>

                 &nbsp;

                 <div class="row">
                  <div class="col-sm-12">
                      <label>Drop Off Lat/ Long:</label>
                       <input type="text" class="form-control"  value="<?php echo $ridedata['dropoffLat'].'/ '.$ridedata['dropoffLong']?>" disabled="">
                  </div>
                </div>

                 &nbsp; -->

                </form>
            </div>
    
          </div> 
         
          <!-- /.box -->
          <!-- /.box -->
        </div>

         <div class="col-xs-12">
          
        <div class="box">
           <div  id="hiddenSms"><?php echo $this->session->flashdata('message'); ?></div>
           
            <div class="box-body">
                <form class="form-horizontal" action="<?php echo base_url('Admin/addUnitPost'); ?>" enctype="multipart/form-data" method="post" > 

                <div class="row">
                  <div class="col-sm-12">
                      <h3>Receipt Details</h3>
                  </div>
                </div>   

                <hr>
     
                <div class="row">
                  <div class="col-sm-12 padding0">
                      <label class="col-xs-4">Base Fare (<?php echo $currency['currency']?>):</label>
                      <div class="col-xs-8">
                       <input type="text" class="form-control" value="<?php echo $ridedata['deliveFare'] ?>" disabled="" placeholder="0.00" ></div>
                  </div>
                </div>
                &nbsp;

                 <div class="row">
                  <div class="col-sm-12 padding0">
                      <label class="col-xs-4">Rate Per Km (<?php echo $currency['currency']?>):</label>
                       <div class="col-xs-8">
                       <input type="text" class="form-control"  value="<?php echo $ridedata['rate_per_km']?>" disabled="" placeholder="0.00">
                     </div>
                  </div>
                </div>

                 &nbsp;

                 <?php 

                  $total = ($ridedata['rate_per_km']*$ridedata['km'])+$ridedata['deliveFare'];


                 ?>

                  <div class="row">
                  <div class="col-sm-12 padding0">
                      <label class="col-xs-4">Your Trip (<?php echo $currency['currency']?>):</label>
                       <div class="col-xs-8">
                       <input type="text" class="form-control"  value="<?php echo $total?>" disabled="" placeholder="0.00">
                     </div>
                  </div>
                </div>

                 &nbsp;

                  <div class="row show">
                  <div class="col-sm-12 padding0">
                      <label class="col-xs-4">Total Fare (<?php echo $currency['currency']?>):</label>
                       <div class="col-xs-8">
                       <input type="text" class="form-control"  value="<?php echo round($total); ?>" disabled="" placeholder="0.00">
                     </div>
                  </div>
                </div>

                 &nbsp;

                  <?php $tax_amount =  round($total)*($ridedata['tax']/100); ?>

                  <div class="row">
                  <div class="col-sm-12 padding0">
                      <label class="col-xs-4">Taxes(<?php echo $ridedata['tax']; ?>%):</label>
                       <div class="col-xs-8">
                       <input type="text" class="form-control"  value="<?php echo $tax_amount; ?>" disabled="" placeholder="0.00">
                     </div>
                  </div>
                </div>

                 &nbsp;
              
                 <?php  if ($ridedata['loaderCount']!= 0) {?>
                 
                 <div class="row">
                  <div class="col-sm-12 padding0">
                      <label class="col-xs-4">Loader (<?php echo $currency['currency']?>):</label>
                       <div class="col-xs-8">
                       <input type="text" class="form-control"  value="<?php echo $ridedata['loaderCharge']?>" disabled="" placeholder="0.00">
                     </div>
                  </div>
                </div>

                 &nbsp;

               <?php }?>

               
                

                <div class="row show">
                  <div class="col-sm-12 padding0">
                      <label class="col-xs-4">Total Charge (<?php echo $currency['currency']?>):</label>
                      <div class="col-xs-8">
                       <input type="text" class="form-control"  value="<?php echo $ridedata['totalCharge']?>" disabled="" placeholder="0.00">
                     </div>
                  </div>
                </div>

                 &nbsp;

                 <div class="row">
                  <div class="col-sm-12">
                      <h3>Other Charges</h3>
                  </div>
                </div>  
                 <hr>

                <div class="row">
                  <div class="col-sm-12 padding0">
                      <label class="col-xs-4">Waiting fee per min loading (<?php echo $currency['currency']?>):</label>
                      <div class="col-xs-8">
                       <input type="text" class="form-control"  value="<?php echo $ridedata['waiting_loading']?>" disabled="" placeholder="0.00">
                     </div>
                  </div>
                </div>

                 &nbsp;

                 <div class="row">
                  <div class="col-sm-12 padding0">
                      <label class="col-xs-4">Waiting fee per min unloading (<?php echo $currency['currency']?>):</label>
                      <div class="col-xs-8">
                       <input type="text" class="form-control"  value="<?php echo $ridedata['waiting_unloading']?>" disabled="" placeholder="0.00">
                     </div>
                  </div>
                </div>

                 &nbsp; 

                <hr>


                </form>
            </div>
     
          </div> 

         
          <!-- /.box -->
          <!-- /.box -->
        </div>
          </div>




        </div>

        <?php if ($driverstatus == 1) {?>
          
         <div class="col-xs-6">
          <div class="box">
           <div  id="hiddenSms"><?php echo $this->session->flashdata('message'); ?></div>
            <!-- /.box-header -->
            <div class="box-body">
                <form class="form-horizontal" action="<?php echo base_url('Admin/addUnitPost'); ?>" enctype="multipart/form-data" method="post" > 

                <div class="row">
                  <div class="col-sm-12">
                      <h3>Pilot Information</h3>
                  </div>
                </div>   

                <hr>

                 <div class="row">
                  <div class="col-sm-6">
                      <label>Name:</label>
                       <input type="text" class="form-control" value="<?php echo ucfirst($driverData['name'])?>" disabled="">
                  </div>
                   <div class="col-sm-6">
                      <label>Email:</label>
                       <input type="text" class="form-control" value="<?php echo $driverData['email']?>" disabled="">
                  </div>
                </div>

                 &nbsp;
     
                <div class="row">
                 
                    <div class="col-sm-12">
                      <label>Mobile Number:</label>
                       <input type="text" class="form-control" value="<?php echo $driverData['mobile']?>" disabled="">
                  </div>
                </div>
                &nbsp;

              
                </form>
            </div>
            <!-- /.box-body -->
          </div>
        
          <!-- /.box -->
          <!-- /.box -->
        </div>

      <?php }?>

        <div class="col-xs-6">

          <div class="box">
           <div  id="hiddenSms"><?php echo $this->session->flashdata('message'); ?></div>
        
            <div class="box-body">
                <form class="form-horizontal" action="<?php echo base_url('Admin/addUnitPost'); ?>" enctype="multipart/form-data" method="post" > 

                <div class="row">
                  <div class="col-sm-12">
                      <h3>Items and Destination Details</h3>
                  </div>
                </div>   

                <hr>

                 <?php  if ($ridedata['loaderCount']!= 0) {?>

                <div class="row">
                  <div class="col-sm-6">
                      <label>Loader:</label>
                       <input type="text" class="form-control" value="<?php echo $ridedata['loaderCount'] ?>" disabled="">
                  </div>

                  <div class="col-sm-6">
                      <label>Loader Price (<?php echo $currency['currency']?>):</label>
                       <input type="text" class="form-control" value="<?php echo $ridedata['loaderCharge'] ?>" disabled="">
                  </div>

                </div>
                 &nbsp;

               <?php }?>


                 <?php  if (!empty($ridedata['insuranceType'])) {?>

                <div class="row">
                  <div class="col-sm-12">
                      <label>Items Details:</label>
                      <?php 
                       $itemarray = array(); 
                       $items = explode(',', $ridedata['insuranceType']);
                       foreach ($items as $key => $value) 
                       {
                         $itemdata = $this->db->get_where('insurance_master',array('id'=>$value))->row_array();
                         array_push($itemarray, ucfirst($itemdata['name']));
                       }
                        $finalitems = implode(',', $itemarray);
                       ?>
                       <input type="text" class="form-control" value="<?php echo $finalitems; ?>" disabled="">
                  </div>
                </div>
                &nbsp;
              <?php }?>

               <?php  if (!empty($ridedata['dropoffName'])) {?>
                <div class="row">
                  <div class="col-sm-12">
                      <label>Contact Person:</label>
                       <input type="text" class="form-control" value="<?php echo $ridedata['dropoffName'] ?>" disabled="">
                  </div>
                </div>

                 &nbsp;

                 <div class="row">
                  <div class="col-sm-12">
                      <label>Contact Phone Number:</label>
                       <input type="text" class="form-control" value="<?php echo $ridedata['dropoffNumber'] ?>" disabled="">
                  </div>
                </div>

                 &nbsp;

                <?php }?> 


               <div class="row">
                  <div class="col-sm-6">
                      <label>Pay Location:</label>
                       <input type="text" class="form-control" value="<?php echo ($ridedata['payAt'] == 1?"Source":"Destination") ?>" disabled="">
                  </div>
                  <div class="col-sm-6">
                      <label>Payment Method:</label>
                       <input type="text" class="form-control" value="<?php echo ($ridedata['payType'] == 1?"Cash":"Credit") ?>" disabled="">
                  </div>
                </div>

                 &nbsp;


                </form>
            </div>
    
          </div> 

         <div class="box">
           <div  id="hiddenSms"><?php echo $this->session->flashdata('message'); ?></div>

            <div class="box-body">
                <form class="form-horizontal" action="<?php echo base_url('Admin/addUnitPost'); ?>" enctype="multipart/form-data" method="post" > 

                <div class="row">
                  <div class="col-sm-12">
                      <h3>Ride Booking Status</h3>
                  </div>
                </div>   

                <hr>

                <div class="row">
                  <div class="col-sm-12">
                      <label>Current Status:</label>
                       <input type="text" class="form-control" value="Cancelled" disabled="">
                  </div>
                </div>
                 &nbsp;
     
                <div class="row">
                  <div class="col-sm-12">
                      <label>Booking Request Date & Time:</label>
                       <input type="text" class="form-control" disabled="" value="<?php echo date('dS M Y h:i A',$ridedata['addDate'])?>">
                  </div>
                </div>
                &nbsp;

                <div class="row">
                  <div class="col-sm-12">
                      <label>Booking Cancelled Date & Time:</label>
                        <input type="text" class="form-control" disabled="" value="<?php echo date('dS M Y h:i A',$ridedata['modifyDate'])?>">
                  </div>
                </div>
                &nbsp;

                 <div class="row">
                  <div class="col-sm-12">
                      <label>Cancellation Reason:</label>
                       <textarea class="form-control" disabled=""><?php echo $reasondata['name']?></textarea>
                  </div>
                </div>
                &nbsp;

                   <div class="row">
                  <div class="col-sm-12">
                      <label>Cancelled By:</label>
                       <input type="text" class="form-control" value="<?php echo ($ridedata['type'] == 1?"Customer":"Pilot") ?>" disabled="">
                  </div>
                </div>

                 &nbsp;

                  <div class="row">
                  <div class="col-sm-12">
                      <label>Cancellation Charge:</label>
                        <input type="text" class="form-control" disabled="" value="">
                  </div>
                </div>
                &nbsp;

                </form>
            </div>
  
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
 
  <!-- /.content-wrapper-->


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Ride Log History
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin-dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Cancelled Rides</a></li>
        <li class="active">Ride Log History</li>
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
                  <th>Activity</th>
                  <th>Status</th>
                  <th>Date & Time</th>
                </tr>
                </thead>
                <tbody>
                    <?php echo $table;?>  
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