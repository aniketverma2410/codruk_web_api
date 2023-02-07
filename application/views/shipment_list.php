 <!-- bootstrap datepicker -->

<link href="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Manage Shipment
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin-dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Manage Shipment</a></li>
       <!--  <li class="active">List</li> -->
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div  id="hiddenSms"><?php echo $this->session->flashdata('message'); ?></div>
            <div style="display:flex;padding: 0 10px;">
            <!-- /.box-header -->
              <form class="form-inline" action="<?php echo base_url('Shipment/index');?>" method="post" style="margin-top: 12px;">
                  <div class="form-group">
                     <div class="input-group date">
                    <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" value="<?php echo (!empty($searchDate) ? $searchDate : ''); ?>" name="Search" id="datepicker">
                </div>
                  </div>
                  To
                  <div class="form-group">
                     <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                          <input type="text" class="form-control pull-right" value="<?php echo (!empty($searchDate1) ? $searchDate1 : ''); ?>" name="Search1" id="datepicker1">
                    </div>
                  </div>

                   <div class="form-group">
                     <div class="input-group date">
                          <select class="form-control" name="status">
                            <option value="">All</option>
                            <option value="1"<?php if ($status == 1) {
                              echo "selected";
                            } ?>>Delivered</option>
                            <option value="2" <?php if ($status == 2) {
                              echo "selected";
                            } ?> >Pending</option>
                            <option value="3" <?php if ($status == 3) {
                              echo "selected";
                            } ?> >Cancelled</option>
                          </select>
                    </div>
                  </div>

                   

                  <button type="submit" class="btn btn-default">Search</button>
                  &nbsp;
                <?php echo $download;?> 
            </form>
            
            <form class="form-inline" action="<?php echo base_url('Shipment/uploadshipments');?>" enctype="multipart/form-data" method="post" style="margin-top: 12px;">
                  <div class="form-group" style="width: 230px;">
                     <div class="input-group">
                        <div class="input-group-addon">
                        <i class="fa fa-upload"></i>
                      </div>
                      <input type="file" class="form-control pull-right" name="shipments" id="shipments">
                    </div>
                  </div>
                  <button type="submit" name="uploadshipment" class="btn btn-default">Upload CSV</button>
                  &nbsp;
            </form>
            
            <div style="margin-top: 12px;"><a href="<?php echo base_url(); ?>uploads/csv/Mandatory_Fields_demo.csv" class="btn btn-default"><i class="fa fa-download"></i> Sample</a></div>
        </div>

              
            <div class="box-body">
              <table id="example1" class="table table-condensed table-bordered table-hover">
                <thead>
                <tr>
                  <th>S. No.</th>
                  <th>Air Waybill Numbere</th>
                  <th>Customer Name</th>
                  <th>Shipper Address</th>
                  <th>Consignee Name</th>
                  <th>Consignee Number</th>
                  <th>Consignee Address</th>
                  <th>Consignee City</th>
                  <th>Booking Date</th>
                  <th>Pickup Time</th>
                  <th>Delivered Time</th>
                  <th>Out for delivery time</th>
                  <th>Rescheduled Date</th>
                  <th>Assigned Driver</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                   <?php
                    $count = 1;
                     foreach($result as $list):
                    ?>   
                     <tr>
                             <td><?php echo $count; ?></td>
                             <td><?php echo $list['air_waybill_number']; ?></td>
                             <td><?php echo $list['customer_name']; ?></td>
                             <td><?php echo $list['source_address']; ?></td>
                             <td><?php echo $list['receiver_name']; ?></td>
                             <td><?php echo $list['receiver_mobile_number']; ?></td>
                             <td><?php echo $list['destination_address']; ?></td>
                             <td><?php echo $list['destination_city']; ?></td>
                              <td><?php echo $list['booking_date']; ?></td>
                              <td><?php echo $list['pickup_time']; ?></td>
                             <td><?php echo $list['delivered_time']; ?></td>
                             <td><?php echo $list['out_for_delivery_time']; ?></td>
                             <td><?php echo $list['rescheduled_date']; ?></td>
                             <td><?php echo $list['driver_id']; ?></td>
                              <td><?php echo ucwords(str_replace('_',' ',$list['status'])); ?></td>
                              <td>
                              <?php if($list['status']!="delivered"){ ?>
                                  
                              <?php if($list['driver_id']!=0 && ($list['status']!="pickup_awaited" || $list['status']!="denied")){ ?>
                              <a href="javascript:void(0);" onclick="addshipment(<?php echo $list['ID']; ?>)" data-toggle="modal" title="<?php echo $list['ID']; ?>" data-target="#shipmentModal" class="btn btn-info btn-sm">Re-Assign Driver</a>
                              <?php }else{ ?>
                              <a href="javascript:void(0);" onclick="addshipment(<?php echo $list['ID']; ?>)" data-toggle="modal" title="<?php echo $list['ID']; ?>" data-target="#shipmentModal" class="btn btn-info btn-sm">Assign Driver</a>
                              <?php } ?>
                              <?php } ?>
                              
                              <a href="<?php echo base_url("Shipment/update_shipment/".$list['ID']); ?>" class="btn btn-info btn-sm">View/Edit</a></td>
                              </tr>
                   <?php
                              $count++;
                         endforeach;
                    ?>
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
  <!-- bootstrap datepicker -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<!--   <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>    -->  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
  <script src="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
<script>
    //Date picker
   /* $('#datepicker').datepicker({
       autoclose: true,
       format: 'dd-mm-yyyy'
    });*/
</script>
<script type="text/javascript">
  $(function () {
      $('#datepicker').datetimepicker({
       format: 'DD-MM-YYYY h:m A'
     });
  });

   $(function () {
      $('#datepicker1').datetimepicker({
       format: 'DD-MM-YYYY h:m A'
     });
  });
  
  function addshipment(e){
      $('#shipid').val(e);
  }
  
</script>
<!-- Modal -->
<div class="modal fade" id="shipmentModal" tabindex="-1" role="dialog" aria-labelledby="shipmentModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Assign Shipment to Driver</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="<?php echo base_url('Shipment/assignshipment'); ?>">
        <input type="hidden" id="shipid" name="shipmentId"/>
        <div class="form-group">
        <lanel>Select Driver</lanel>
        <select class="form-control" name="driverId" required="true">
            <option value="">-Select-</option>
            <?php if($drivers){ ?>
            <?php foreach($drivers as $driver){?>
            <option value="<?php echo $driver['id']; ?>"><?php echo $driver['id']; ?> - <?php echo $driver['name']; ?></option>
            <?php } ?>
            <?php } ?>
        </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>

