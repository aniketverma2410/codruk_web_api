<style type="text/css">
   span p{color:red}p#deleteFile{margin:0;color:#e0aeae}#myProgress{width:100%;background-color:#ddd}#myBar{width:1%;height:6px;background-color:#61bd65;margin-top:7px}#loaderShow{display:none}.loader{border:5px solid #f3f3f3;border-radius:50%;border-top:5px solid #3498db;width:25px;height:25px;top:5px;padding-left:5px;font-size:10px;-webkit-animation:spin 2s linear infinite;animation:spin 2s linear infinite}@-webkit-keyframes spin{0%{-webkit-transform:rotate(0)}100%{-webkit-transform:rotate(360deg)}}@keyframes spin{0%{transform:rotate(0)}100%{transform:rotate(360deg)}}span#videoSize{float:right}

   .box-body {
    width: 100%;
    overflow-x: hidden;
}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Manage Settings 
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin-dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Manage Settings</a></li>
        <li class="active">Update Settings</li>
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
                <form class="form-horizontal" action="<?php echo base_url('Admin/updateSettingPost'); ?>" enctype="multipart/form-data" method="post" > 

     
                <div class="row">
                  <div class="col-sm-12">

                      <label>Currency:</label>
                       <input type="text" class="form-control" name="currency" value="<?php echo $result['currency']; ?>">

                  </div>
                 
  
                </div> <br> 

                <div class="row">
                  <div class="col-sm-12">

                      <label>Toll Free No:</label>
                       <input type="number" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" onKeyDown="if(this.value.length==15 && event.keyCode!=8) return false;" name="helpline" value="<?php echo $result['helpline']; ?>">

                  </div>
                 
  
                </div> <br> 

                 <div class="row">
                  <div class="col-sm-12">

                      <label>Minimum Ride Range (Km):</label>
                       <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" maxlength="3" name="ride_range" value="<?php echo $result['ride_range']; ?>" required>

                  </div>
                 
  
                </div> <br> 

                <div class="row">
                  <div class="col-sm-12">

                      <label>Maximum Ride Acceptance Time (Minutes):</label>
                       <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" maxlength="3" name="acceptance_time" value="<?php echo $result['acceptance_time']; ?>" required>

                  </div>
                 
  
                </div> <br> 

                 <div class="row">
                  <div class="col-sm-12">

                      <label>Tax percentage (%):</label>
                       <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" maxlength="3" name="tax" value="<?php echo $result['tax']; ?>" required>

                  </div>
                 
  
                </div> <br> 

                 <div class="row">
                  <div class="col-sm-12">

                      <label>Favourite Count in 24 Hrs:</label>
                       <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" maxlength="3" name="favourite_count" value="<?php echo $result['favourite_count']; ?>" required>

                  </div>
                 
  
                </div> <br> 

                 <div class="row">
                  <div class="col-sm-12">

                      <label>Customer Application Version:</label>
                       <input type="text" class="form-control"  name="customer_app_version" value="<?php echo $result['customer_app_version']; ?>" required>

                  </div>
                 
  
                </div> <br> 

                 <div class="row">
                  <div class="col-sm-12">

                      <label>Pilot Application Version:</label>
                       <input type="text" class="form-control"  name="pilot_app_version" value="<?php echo $result['pilot_app_version']; ?>" required>

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