<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Manage Staff
          <a href="<?php echo base_url('Customers/add_staff'); ?>" style="float: right;" class="btn btn-info" title="Add Item">
          Add Staff
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
              <table id="example1" class="table table-condensed table-bordered table-hover">
                <thead>
                <tr>
                  <th>S. No.</th>
                  <th>Code</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Mobile</th>
                  <th>Last Login</th>
                  <th>Register At</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  <?php 
                     $count = 1;
                    foreach($result as $list){ 
                      ?>
                     <tr>
                       <td><?php echo $count; ?></td>
                       <td><?php echo !empty($list['uuid'])?$list['uuid']:"N/A" ?></td>
                       <td><?php echo ucfirst($list['name']); ?></td>
                       <td><?php echo $list['email']; ?></td>
                       <td><?php echo $list['mobile']; ?></td>
                       <td>N/A</td>
                       <td><?php echo date('dS M Y h:i A',$list['add_date']); ?></td>
                       <td><?php 
                          if($list['status'] =='1'){?>
                                 <span class="label label-success">Activated</span>  
                          <?php } else { ?>
                               <span class="label label-danger">Deactivated</span> 
                          <?php } ?></td>
                       <td><a href="<?php echo base_url('Customers/edit_staff/').$list['id']; ?>" class="btn btn-info btn-sm">View/Edit</a></td>
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

