<style type="text/css">
  .nav.nav-tabs{widows: 240px; float: left; border-bottom: 0px solid #ddd; margin-top: 15px;}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Running Rides for <?php echo ucfirst($customer['name']).' - '.$customer['mobile'];?>
      </h1>
       <ul class="nav nav-tabs">
          <li><a  href="<?php echo base_url($pending)?>">Pending</a></li>
          <li><a  href="<?php echo base_url($completed)?>">Completed</a></li>
          <li class="active"><a  href="<?php echo base_url($running)?>">Running</a></li>
          <li><a  href="<?php echo base_url($cancel)?>">Cancelled</a></li>
          <li><a  href="#">Schedule</a></li>

        </ul>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin-dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Running Rides</a></li>
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
              <table id="example1" class="table table-condensed table-bordered table-hover">
                <thead>
                <tr>
                  <th>S. No.</th>
                  <th>Booking Id</th>
                 <!--  <th>Name</th>
                  <th>Email</th>
                  <th>Mobile</th> -->
                  <th>Booking Date</th>
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

