<style type="text/css">
  .top{    position: relative;
    top: 3px;}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Manage rating and reviews for <?php echo ucfirst($driver['name']) ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin-dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Manage Pilots</a></li>
        <li class="active">Manage rating and reviews</li>
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
                  <th>Comment</th>
                  <th>Rating</th>
                  <th>Remark</th>
                  <th>Review On</th>
                </tr>
                </thead>
                <tbody>
                  <?php 
                     $count = 1;
                    foreach($result as $list){ 
                      $starcount   = $list['rating'];
                      $blankstart  = 5-$starcount; 

                      $booking = $this->db->get_where('ride_master',array('id'=>$list['booking_id']))->row_array();
                      $comment = $this->db->get_where('comment_master',array('id'=>$list['comment_id']))->row_array();

                      ?>
                     <tr>
                       <td><?php echo $count; ?></td> 
                      <td><?php echo $booking['bookingId']; ?></td>
                      <?php if (!empty($comment['comment'])) {?>
                      <td><?php echo ucfirst($comment['comment']) ; ?></td>
                    <?php }else{?>
                      <td><?php echo "N/A"; ?></td>
                    <?php }?>
                      <td>
                        <span class="top"><?php 
                          echo round($list['rating']).'.0';
                        ?>
                         </span>&nbsp;
                           <?php
                          for($i=1; $i<=$starcount; $i++){
                        ?>
                          <img class="avatar" alt="SuperAdmin" src="<?php echo base_url('mediaFile/yellow-star.png')?>" height="16px;" >
                        <?php
                        }
                        ?>

                        <?php
                          for($i=1; $i<=$blankstart; $i++){
                        ?>
                          <img class="avatar" alt="SuperAdmin" src="<?php echo base_url('mediaFile/grey-star.png')?>" height="16px;">
                        <?php
                        }
                        ?>
                       </td>

                      <?php if (!empty($list['remark'])) {?>
                  
                      <td><?php echo ucfirst($list['remark']) ; ?></td>
                    <?php }else{?>
                       <td><?php echo "N/A"; ?></td>
                    <?php }?>
                    
                       <td><?php echo date('jS M Y h:i A',$list['add_date']); ?></td>
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

