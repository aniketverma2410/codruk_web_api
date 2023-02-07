<style type="text/css">
  .box-body{overflow-x: hidden;}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Reason Data 
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin-dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Manage Reasons</a></li>
        <li class="active">add Reason</li>
      </ol>
    </section>


    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-6">
          <div class="box">
           <div  id="hiddenSms"><?php echo $this->session->flashdata('message'); ?></div>
            <!-- /.box-header -->
            <div class="box-body">
                <form class="form-horizontal" action="<?php echo base_url('Admin/addReasonPost'); ?>" enctype="multipart/form-data" method="post" > 

     
                      <div class="row">
                  <div class="col-sm-12">

                      <label>Type:</label>
                       <select class="form-control" name="type" required="">
                         <option value="">-Select Type-</option>
                         <option value="1">Customer</option>
                         <option value="2">Pilot</option>
                       </select>

                  </div>
                 
  
                </div> <br> 


                <div class="row">
                  <div class="col-sm-12">

                      <label>Reason:</label>
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