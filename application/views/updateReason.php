<style type="text/css">
  .box-body{overflow-x: hidden;}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Update Reason Data 
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin-dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Manage Reason</a></li>
        <li class="active">Update Reason</li>
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
                <form class="form-horizontal" action="<?php echo base_url('Admin/updateReasonPost'); ?>" enctype="multipart/form-data" method="post" > 

        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">

                   <div class="row">
                  <div class="col-sm-12">

                      <label>Type:</label>
                       <select class="form-control" name="type" required="">
                         <option value="">-Select Type-</option>
                         <option value="1" <?php if ($data['type'] == 1) {
                          echo "selected";
                         } ?>>Customer</option>
                         <option value="2" <?php if ($data['type'] == 2) {
                          echo "selected";
                         } ?>>Pilot</option>
                       </select>

                  </div>
                 
  
                </div> <br> 


                <div class="row">
                  <div class="col-sm-12">

                      <label>Name:</label>
                       <input type="text" class="form-control" name="name" value="<?php echo $data['name']; ?>" required="">

                  </div>
                 
  
                </div> <br> 
                <div class="row">
                  <div class="col-sm-12">
                      <label>Activated/Deactivated:</label>
                      <select class="form-control" name="status">
                        <option value="1" <?php echo ($data['status'] == 1) ? 'selected' : '' ?>>Activated</option>
                        <option value="2" <?php echo ($data['status'] == 2) ? 'selected' : '' ?>>Deactivated</option>
                      </select> 

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