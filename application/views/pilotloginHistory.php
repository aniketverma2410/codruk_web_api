<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo ucwords($userData['name']); ?> Login History
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin-dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Manage Pilots</a></li>
        <li class="active">Login History</li>
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
                  <th>Device ID</th>
                  <th>Platform</th>
                  <th>Login Time</th>
                </tr>
                </thead>
                <tbody>
                  <?php 
                     $count = 1;
                    foreach($result as $list){ 
                      ?>
                     <tr>
                       <td><?php echo $count; ?></td>
                       <td><?php echo $list['deviceID']; ?></td>
                       <td><?php echo ($list['plateform'] == 2) ? 'App' : 'Web'; ?></td>
                       <td><?php echo date('jS F Y h:i A',$list['addDate']); ?></td>
    
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

