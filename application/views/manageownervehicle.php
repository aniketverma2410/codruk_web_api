<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Manage Owner Vehicles
         <a href="<?php echo base_url('Admin/add_owner_vehicle'); ?>" style="float: right;" class="btn btn-info" title="Add Owner Vehicle">
          Add Owner Vehicle
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
                  <th>Owner</th>
                  <th>Vehicle Image</th>
                  <th>Name</th>
                  <th>Vehicle No.</th>
                  <th>Type</th>
                  <th>Register At</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  <?php 
                     $count = 1;
                    foreach($result as $list){ 
                      //$capacityUnit = $this->Common_model->getDataViaId('unit_master',$list['unitId']);
                      //$durationUnit = $this->Common_model->getDataViaId('unit_master',$list['durationId']);
                      $vechData = $this->db->get_where('vehicle_master',array('id'=>$list['vehicle_master_id']))->row_array();
                      $ownerdata =  $this->db->get_where('owner_master',array('id'=>$list['owner_id']))->row_array();
                  ?>
                     <tr>
                       <td><?php echo $count; ?></td>
                       <td><?php echo ucfirst($ownerdata['name']); ?><br><i class="fa fa-mobile"></i> <?php echo $ownerdata['mobile']?></td>
                       <td><?php echo !empty($vechData['image']) ? '<img src="'.base_url('mediaFile/vehicles/').$vechData['image'].'" width="100" height="80">' : ''; ?></td>
                       <td><?php echo $vechData['name']; ?></td>
                        <td><?php echo $list['vehicle_number']; ?></td>

                      <td><?php 
                          if($list['vehicle_type'] =='1'){?>
                                 <span>Truck</span>  
                          <?php } elseif($list['vehicle_type'] =='2') { ?>
                               <span >Dyna</span> 
                          <?php }else{ ?>
                            <span >Dabbab</span> 
                           <?php }?> 
                          </td>
                      <!--  <td><?php echo $list['capacity'].' '.(($list['capacity'] != 0 ) ? $capacityUnit['name']  : ''); ?></td>
                       <td><?php echo $list['loadingTime'].' '.(($list['loadingTime'] != 0 ) ? $durationUnit['name']  : ''); ?></td> -->
                       <td><?php echo date('dS M Y h:i',$list['add_date']); ?></td>
                       <td><?php 
                          if($list['admin_approval'] =='1'){?>
                                 <span class="label label-success">Approved</span>  
                          <?php } else { ?>
                               <span class="label label-warning">Pending</span> 
                          <?php } ?></td>
                       <td>
                        <a href="<?php echo base_url('Admin/updateownervehicle/'); ?><?php echo $list['id']; ?>" title="" class="btn btn-info btn-sm">View/Edit</a>
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

<script type="text/javascript">
        function deletedata(location,word,id)
        {
          var con = confirm('Are you sure you want to delete this '+word);
          if(con == true)
          {
            window.location = location+'/'+id;
          }
        }

</script>