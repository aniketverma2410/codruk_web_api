<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Manage Drivers
        <a href="<?php echo base_url('Drivers/addDriver'); ?>" style="float: right;" title="Add Driver">
          <i class="fa fa-plus-circle" style="font-size: 35px;"></i>
        </a>
      </h1>

       

    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div  id="hiddenSms"><?php echo $this->session->flashdata('message'); ?></div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>S No.</th>
                  <th>Photo</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Mobile</th>
                  <th>City Name</th>
                  <th>Date & Time</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  <?php 
                     $count = 1;
                    foreach($result as $list){ ?>
                     <tr>
                       <td><?php echo $count; ?></td>
                       <td><?php echo !empty($list['image']) ? '<img src="'.base_url('mediaFile/drivers/').$list['image'].'" width="100" height="80">' : '<img src="http://localhost/codruk/theme/dist/img/user2-160x160.jpg" width="100" height="80">'; ?></td>
                       <td><?php echo $list['name']; ?></td>
                       <td><?php echo $list['email']; ?></td>
                       <td><?php echo $list['mobile']; ?></td>
                       <td><?php echo $list['city']; ?></td>
                       <td><?php echo date('d m Y h:i A',$list['addDate']); ?></td>
                       <td> <?php 
                          if($list['status'] =='1'){?>
                            <span class="label label-success">Activated</span>  
                          <?php } else { ?>
                            <span class="label label-danger">Deactivated</span> 
                          <?php } ?></td>
                       <td><a href="<?php echo base_url('Drivers/updateDrivers/'); ?><?php echo $list['id']; ?>" title="" class="btn btn-info btn-sm">View/Edit</a></td>
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

