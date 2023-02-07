<style type="text/css">
  .div_filter {
    width: 150px;
    position: absolute;
    left: 48%;
  }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Completed Rides
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin-dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Completed Rides</a></li>
       <!--  <li class="active">List</li> -->
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
              <div class="div_filter">
                 <?php echo form_open_multipart('Owner/completed_rides',array('id'=>'addTestForm', 'class'=>'addTestForm')); ?>
                 <div class="input-group input-group-sm">
                <select class="form-control" name="vehicles">
                  <option value="">All</option>
                  <?php foreach ($vehicle_data as $key => $value) {?>
                   <option value="<?php echo $value['id']?>"<?php if ($vehicles_id == $value['id']) {
                    echo "selected";
                   } ?>><?php echo ucfirst($value['name']); ?></option>
                  <?php } ?>
                </select>
                    <span class="input-group-btn">
                      <button type="submit" class="btn btn-info btn-flat">Go!</button>
                    </span>
              </div>
                  <?php echo form_close();?>
              </div>
              <table id="example1" class="table table-condensed table-bordered table-hover">
                <thead>
                <tr>
                  <th>S. No.</th>
                  <th>Booking Id</th>
                  <th>Customer Info</th>
                  <th>Pilot Info</th>
                  <th>Booking Date</th>
                  <th>Accepted Date</th>
                  <th>Vehicle</th>
                  <?php $settings = $this->db->get_where('settings')->row_array(); ?>
                  <th>Fare (<?php echo $settings['currency'];?>)</th>
                  <th>Action</th>
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

