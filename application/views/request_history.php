<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo ucwords($userData['name']); ?> Assigned Vehicle Request History
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin-dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Manage Pilots</a></li>
        <li class="active">Assigned Vehicle Request History</li>
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
                  <th>Vehicle No.</th>
                  <th>Received At</th>
                  <th>Assigned At</th>
                  <th>Status</th>
                </tr>
                </thead>
                <tbody>
                  <?php 
                     $count = 1;
                    foreach($result as $list){ 
                      ?>
                     <tr>
                       <td><?php echo $count; ?></td>
                       <?php $vehicle = $this->db->get_where('owner_vehicle_master',array('id'=>$list['vehicle_id']))->row_array(); ?>
                       <td><?php echo $vehicle['vehicle_number']; ?></td>
                       <td><?php echo date('dS M Y h:i A',$list['add_date']);?></td>
                       <?php if (!empty($list['modify_date'])) {?>
                       <td><?php echo date('dS M Y h:i A',$list['modify_date']);?></td>
                     <?php }else{?>
                       <td><?php echo "N/A"?></td>
                     <?php }?>
                       <td> <?php 
                             if($list['status'] =='1'){?>
                               <span class="label label-success">Approved</span>  
                             <?php } elseif($list['status'] =='2') { ?>
                               <span class="label label-warning">Pending</span> 
                             <?php }else{ ?>
                               <span class="label label-primary">Completed</span> 
                             <?php }?> 
                             </td>
    
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

