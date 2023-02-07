<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Manage Customers
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin-dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Manage Customers</a></li>
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
                  <th>Image</th>
                  <th>Name</th>
                 <!--  <th>Email</th> -->
                  <th>Mobile</th>
                  <th>Last Ride</th>
                  <th>Last Login</th>
                    <th>Register&nbsp;At</th>
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
                        <td><?php echo "Cust_".$list['id']; ?></td>
                          <td><?php echo !empty($list['image']) ? '<img src="'.base_url('mediaFile/customers/').$list['image'].'" width="100" height="80">' : '<img src="'.base_url().'/theme/dist/img/user2-160x160.jpg" width="100" height="80">'; ?></td>
                       <td><?php echo $list['name']; ?></td>
                     <!--   <td><?php echo $list['email']; ?></td> -->
                       <td><?php echo $list['countryCode']."-".$list['mobile'].' '.(($list['otpVerifyStatus'] == 1) ? '<span><i class="fa fa-check" style="color:green"></i></span>' : '<span><i class="fa fa-remove" style="color:red"></i></span>'); ?></td>

                        <?php 
                               $this->db->order_by('id','desc');
                       $ride = $this->db->get_where('ride_master',array('userId'=>$list['id']))->row_array();
                       ?>

                       <?php if (!empty($ride)) {?>
                        <?php if ($ride['status'] == 1) {?>
                        <td><?php echo date('jS M Y h:i A',$ride['addDate']); ?><br><a href="<?php echo base_url('Customers/customer_pending_rides/').$list['id'].'?first=2'; ?>">View All</a></td>
                      <?php }elseif($ride['status'] == 2){ ?>
                        <td><?php echo date('jS M Y h:i A',$ride['addDate']); ?><br><a href="<?php echo base_url('Customers/customer_cancel_rides/').$list['id'].'?first=2'; ?>">View All</a></td>
                      <?php }elseif($ride['status'] == 3){ ?>
                         <td><?php echo date('jS M Y h:i A',$ride['addDate']); ?><br><a href="<?php echo base_url('Customers/customer_completed_rides/').$list['id'].'?first=2'; ?>">View All</a></td>
                      <?php }else{?>
                         <td><?php echo date('jS M Y h:i A',$ride['addDate']); ?><br><a href="<?php echo base_url('Customers/customer_running_rides/').$list['id'].'?first=2'; ?>">View All</a></td> 
                      <?php } ?>  
                      <?php }else{?>
                        <td><?php echo "N/A"?></td>
                      <?php } ?>  


                     

                        <?php if (!empty($lastLogin)) {?>
                       <td><?php echo date('jS M Y h:i A',$lastLogin['addDate']); ?><br><a href="<?php echo base_url('Customers/manageloginHistory/').$list['id']; ?>">View History</a></td>
                      <?php }else{?>
                        <td><?php echo "N/A"?></td>
                      <?php } ?> 

                       
                       <td><?php echo date('jS M Y h:i A',$list['addDate']); ?></td>
                       <td><?php 
                          if($list['status'] =='1'){ ?>
                            <span class="label label-success">Activated</span>  
                          <?php } else { ?>
                            <span class="label label-danger">Deactivated</span> 
                          <?php } ?></td>
                       <td><a href="<?php echo base_url('Customers/updateCustomers/'); ?><?php echo $list['id']; ?>/1" title="" class="btn btn-info btn-sm">View/Edit</a></td>
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

