<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Manage Units
         <span style="padding-left:66%;"> <a href="<?php echo base_url('Admin/manageUnitType'); ?>" class="btn btn-success" >
          Manage Unit Type
        </a></span><a href="<?php echo base_url('Admin/addUnitData'); ?>" style="float: right;" class="btn btn-info" >
          Add Unit
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
                  <th>Type</th>
                  <th>Name</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  <?php 
                     $count = 1;
                    foreach($result as $list){ 
                      $unitType = $this->Common_model->getDataViaId('unit_type_master',$list['unit_type']);
                      ?>
                     <tr>
                       <td><?php echo $count; ?></td>
                        <td><?php echo $unitType['name']; ?></td>
                       <td><?php echo $list['name']; ?></td>
                       <td><?php 
                          if($list['status'] =='1'){?>
                                 <span class="label label-success">Activated</span>  
                          <?php } else { ?>
                               <span class="label label-danger">Deactivated</span> 
                          <?php } ?></td>
                       <td><a href="<?php echo base_url('Admin/updateUnitData/').$list['id']; ?>" class="btn btn-info btn-sm">View/Edit</a></td>
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

