<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Manage Cancel Reasons</h1>
        <ol class="breadcrumb" style="padding: 0px 5px;">
            <li>
           
              <a href="<?php echo base_url('Admin/addReason'); ?>" style="color: #fff !important;" class="btn btn-info" >
                Add Reason
              </a>  
            </li>
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
                  <th>Reason</th>
                  <th>Type</th>
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
     
                       <td><?php echo $list['name']; ?></td>
                       <?php if ($list['type'] == 1) 
                       {?>
                         <td><?php echo "Customer"; ?></td>
                       <?php }else{ ?>
                        <td><?php echo "Pilot"; ?></td>
                       <?php }?>
                       
                       <td><?php 
                          if($list['status'] =='1'){?>
                                 <span class="label label-success">Activated</span>  
                          <?php } else { ?>
                               <span class="label label-danger">Deactivated</span> 
                          <?php } ?></td>
                       <td><a href="<?php echo base_url('Admin/updateReasonData/').$list['id']; ?>" class="btn btn-info btn-sm">View/Edit</a></td>
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

