
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Unit Data 
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin-dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Manage Units</a></li>
        <li class="active">add Unit</li>
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
                <form class="form-horizontal" action="<?php echo base_url('Admin/addUnitPost'); ?>" enctype="multipart/form-data" method="post" > 

     
                <div class="row">
                  <div class="col-sm-6">
                      <label>Unit Type:</label>
                       <select class="form-control" name="unit_type" required="">
                        <option value="">Select</option>
                          <?php foreach ($result as $key => $value) { ?>
                            <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                          <?php } ?>
                       
                      </select> 
                  </div>
                 
  
                </div> <br> 

                <div class="row">
                  <div class="col-sm-6">

                      <label>Name:</label>
                       <input type="text" class="form-control" name="name" required="">

                  </div>
                 
  
                </div> <br> 
            

                <div class="row">
                  <div class="col-sm-12">
                       <button type="submit" class="btn btn-info">Submit</button>
                       
                  </div>
                </div> <br> 

                </form>
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
 
  <!-- /.content-wrapper-->