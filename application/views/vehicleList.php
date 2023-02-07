<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Manage Vehicles
          <a href="<?php echo base_url('Admin/addVehicle'); ?>" style="float: right;" class="btn btn-info" title="Add Vehicle">
          Add Vehicle
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
                  <th>Vehicle Image</th>
                  <th>Name</th>
                  <th>Type</th>
                  <th>Capacity</th>
                  <!-- <th>Loading Time</th> -->
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  <?php 
                     $count = 1;
                    foreach($result as $list){ 
                      $capacityUnit = $this->Common_model->getDataViaId('unit_master',$list['unitId']);
                      $durationUnit = $this->Common_model->getDataViaId('unit_master',$list['durationId']);
                  ?>
                     <tr>
                       <td><?php echo $count; ?></td>
                       <td><?php echo !empty($list['image']) ? '<img src="'.base_url('mediaFile/vehicles/').$list['image'].'" width="100" height="80">' : ''; ?></td>
                       <td><?php echo $list['name']; ?></td>
                      <td><?php 
                          if($list['type'] =='1'){?>
                                 <span>Truck</span>  
                          <?php } elseif($list['type'] =='2') { ?>
                               <span >Dyna</span> 
                          <?php }else{ ?>
                            <span >Dabbab</span> 
                          <?php }?>
                          </td>
                       <td><?php echo $list['capacity'].' '.(($list['capacity'] != 0 ) ? $capacityUnit['name']  : ''); ?></td>
                      <!--  <td><?php echo $list['loadingTime'].' '.(($list['loadingTime'] != 0 ) ? $durationUnit['name']  : ''); ?></td> -->
                       <td><?php 
                          if($list['status'] =='1'){?>
                                 <span class="label label-success">Activated</span>  
                          <?php } else { ?>
                               <span class="label label-danger">Deactivated</span> 
                          <?php } ?></td>
                       <td><a href="<?php echo base_url('Admin/updateVehicle/'); ?><?php echo $list['id']; ?>" title="" class="btn btn-info btn-sm">View/Edit</a></td>
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

