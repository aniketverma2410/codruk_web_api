<style type="text/css">
   .box-body 
   {
     overflow-x: hidden; 
   }

 .nav.nav-tabs{widows: 240px; float: left; border-bottom: 0px solid #ddd; margin-top: 15px;}


  .set_w_admin {
        width: 200PX;
        border: 1px solid #ddd;
        padding: 15px 0 0;
        margin: 5px;
    }
    .loader_img{
        height: 30px;
        position: absolute;
        margin-top: -32px;
        right: 30px;
        display: none;
    }
    .trash{color: red; cursor: pointer;}
    .set_w_admin img{height: 134px; width: 100%; padding: 0 15px;}

    .set_success{
        padding: 5px;
        background: #f1f9f9;
        margin-top: 15px;
    }
    .success{float: right; color: green;}
    .progress.col-xs-12.divPadding{
        height: 5px; margin: 0px;
    }
    .set_uploaded_img{
        padding: 5px;
        margin-top: 15px;
        background: #eee;
        border-bottom: 5px solid #5bc0de;
    }
    .progress{padding: 0px;}
    .last{    margin-left: 15px;
    margin-top: 21px;}
</style>
<?php $id = $this->uri->segment(3,0);?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Update Vehicle 
      </h1>
       <ul class="nav nav-tabs">
          <li class="active" ><a  href="<?php echo base_url('owner/updateVehicle/'.$id) ?>">Registration</a></li>
          <li><a  href="<?php echo base_url('owner/update_registration_doc/'.$id) ?>">Registration Documents</a></li>
          <li><a  href="<?php echo base_url('owner/update_route_permit/'.$id) ?>">Route Permit</a></li>
          <li><a  href="<?php echo base_url('owner/update_containment/'.$id) ?>">Containment</a></li>
        </ul>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin-dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Manage Vehicles</a></li>
        <li class="active">Update Vehicle</li>
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
                <form class="form-horizontal" action="<?php echo base_url('owner/updateVehiclePost'); ?>" enctype="multipart/form-data"  method="post" id="myForm" > 

                <input type="hidden" name="id" value="<?php echo $vehicleData['id'] ?>">  
                <div class="row">
                   <div class="col-sm-6">
                      <label>Vehicle Number:</label>
                       <input type="text" class="form-control" name="vehicle_number" placeholder="Enter Vehicle Number" value="<?php echo $vehicleData['vehicle_number']?>" required="">
                  </div>

                  <div class="col-sm-6">
                      <label>Vehicle Type:</label>
                      <select name="vehicle_type" class="form-control" required="" onchange="get_vehicles(this.value);" >
                        <option value="">Select</option>
                        <option value="1"<?php if ($vehicleData['vehicle_type'] == 1) {
                         echo "selected";
                        } ?>> Truck</option>
                        <option value="2"<?php if ($vehicleData['vehicle_type'] == 2) {
                         echo "selected";
                        } ?>> Dyna</option>
                        <option value="3"<?php if ($vehicleData['vehicle_type'] == 3) {
                         echo "selected";
                        } ?>> Dabbab</option>
                      </select>
                  </div>
                </div> 
                <br> 

                <div class="row">
                     <div class="col-sm-6">
                      <label>Vehicle:</label>
                      <select name="vehicle_master_id" class="form-control" id="vehicle" required="">
                        <option value="">-Select Vehicle-</option>
                      </select>
                  </div>
                </div>
                <br>

                 <div class="row">
                  <div class="col-sm-6">
                      <label>Vehicle Left Image:</label>
                      <!-- <input type="file" name="vehicle_left" class="form-control" class="form-control" accept="image/*" /> -->
                    <input type="file" name="input_files_1[]" id="input_files_1" placeholder="" class="form-control" onchange="uploadVideo(this, '1')">
                    <img src="<?php echo base_url() ?>assets/images/all_fixed_images/gallery_loading.gif" class="loader_img" id="loading_1">
                    <input type="hidden" name="vehicle_left" value="" id="file_name_1">
                    <span id="err_input_files_1" class="user_err"></span>

                    <div class=" col-sm-12 pad_left"> 
                       <?php
                          $img_name = '';
                          $img_name = base_url().'mediaFile/vehicles/'.$vehicleData['vehicle_left'];
                      ?>

                        <div class="col-sm-12" id="set_images_1" style="padding:0px;"><div class="col-xs-12 set_w_admin " id="img_preview_1"><img src="<?php echo $img_name; ?>" class="set_image" alt="" id="set_image_1"><div class="col-xs-12 set_success"><span class="success">Success</span></div><div class="progress col-xs-12 divPadding" style="margin: 0;"><div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%"></div></div></div></div>
                    </div>
                  </div>

                  <div class="col-sm-6">
                      <label>Vehicle Right  Image:</label>
                      <input type="file" name="input_files_2[]" id="input_files_2" placeholder="" class="form-control" onchange="uploadVideo(this, '2')">
                        <img src="<?php echo base_url() ?>assets/images/all_fixed_images/gallery_loading.gif" class="loader_img" id="loading_2">
                        <input type="hidden" name="vehicle_right" value="" id="file_name_2">
                        <span id="err_input_files_2" class="user_err"></span>
    
                       <div class=" col-sm-12 pad_left"> 
                       <?php
                          $img_name = '';
                          $img_name = base_url().'mediaFile/vehicles/'.$vehicleData['vehicle_right'];
                      ?>

                        <div class="col-sm-12" id="set_images_2" style="padding:0px;"><div class="col-xs-12 set_w_admin " id="img_preview_2"><img src="<?php echo $img_name; ?>" class="set_image" alt="" id="set_image_2"><div class="col-xs-12 set_success"><span class="success">Success</span></div><div class="progress col-xs-12 divPadding" style="margin: 0;"><div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%"></div></div></div></div>

                      </div>
                  </div>
                </div> 
                <br> 

                <div class="row">
                    <div class="col-sm-6">
                      <label>Vehicle Front  Image:</label>
                     <input type="file" name="input_files_3[]" id="input_files_3" placeholder="" class="form-control" onchange="uploadVideo(this, '3')">
                        <img src="<?php echo base_url() ?>assets/images/all_fixed_images/gallery_loading.gif" class="loader_img" id="loading_3">
                        <input type="hidden" name="vehicle_front" value="" id="file_name_3">
                        <span id="err_input_files_3" class="user_err"></span>
                       
                       <div class=" col-sm-12 pad_left"> 
                       <?php
                          $img_name = '';
                          $img_name = base_url().'mediaFile/vehicles/'.$vehicleData['vehicle_front'];
                      ?>

                         <div class="col-sm-12" id="set_images_3" style="padding:0px;"><div class="col-xs-12 set_w_admin " id="img_preview_3"><img src="<?php echo $img_name; ?>" class="set_image" alt="" id="set_image_3"><div class="col-xs-12 set_success"><span class="success">Success</span></div><div class="progress col-xs-12 divPadding" style="margin: 0;"><div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%"></div></div></div></div>

                      </div>
                  </div>

                  <!-- <div class="col-sm-6">
                      <label>Activated/Deactivated:</label>
                      <select class="form-control" name="status">
                        <option value="1" <?php echo ($vehicleData['status'] == 1) ? 'selected' : '' ?>>Activated</option>
                        <option value="2" <?php echo ($vehicleData['status'] == 2) ? 'selected' : '' ?>>Deactivated</option>
                      </select> 

                  </div> -->

                </div>
                <br>

                <div class="row" id="final">
                  <div class="col-sm-12 last">
                       <button type="submit" class="btn btn-info">Submit</button>
                  </div>
                </div> 
                <br> 

 
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
  <script type="text/javascript">


$(document).ready(function(){
    
   var type = "<?php echo $vehicleData['vehicle_type']?>"; 
   get_vehicles_new(type);

   var status = "<?php echo $vehicleData['admin_approval']?>"; 

   if (status == 1) 
   {
     $("#myForm :input").prop("disabled", true);
     $("#final").hide();
   }

});

function uploadVideo(input, new_id){
        var file;
        //alert(new_id);

        var document_name = $('#input_files_'+new_id).val();
        var g_d_id = new_id;
        console.log(input.files);
        if (input.files && input.files[0]) {

            var get_l = input.files.length;
            var url = '<?php echo base_url('owner/uoload_img') ?>';
            data = new FormData(input.files);

            //var file_url = $('#doc_'+new_id).get(0).files[0].name;
            
            var filesss = $('#input_files_'+new_id).prop("files");
            console.log(filesss);

            for (var i = 0; i < get_l; i++) {
                data.append('file_'+i, filesss[i]);
            } 
            
            data.append('id', 'home');
            data.append('type', new_id);
            data.append('document_name', document_name);
            data.append('table', 'archived_press_release');
            //$('#loading_'+new_id).show();
            $.ajax({
                url: url,
                data: data,
                type: 'post',
                enctype: 'multipart/form-data',
                processData:false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType
                dataType: 'JSON',
                success:  function(res) {
                    //$('#loading_'+new_id).hide();
                    if (res == 2) {
                        $('#set_images_'+new_id).css('color', 'red').html('Please chose pdf file.'); 
                        $('#input_files_'+new_id).val('');
                    } else {
                        //$('#loading').hide();
                        $('#set_images_'+new_id).html(res);
                        var alt_name = $('#set_image_'+new_id).attr('alt');
                        var alt_size = $('#set_image_'+new_id).attr('imgsize');

                        $('#file_name_'+new_id).val(alt_name);
                        $('#file_size_'+new_id).val(alt_size);
                    }
                }
            });
        }
    }






  function get_vehicles(type)
  {
    
      $.ajax({  
    type: "POST",  
    url: "<?php echo base_url('owner/get_vehicles'); ?>",  
    data: 'type='+ type,

    success: function(mess)
    {
       $('#vehicle').html(mess);
    } 
   
  }); 
  }  


   function get_vehicles_new(type)
  { 
    var vehicle = "<?php echo $vehicleData['vehicle_master_id']?>";
      $.ajax({  
    type: "POST",  
    url: "<?php echo base_url('owner/get_vehicles_new'); ?>",  
    data: 'type='+ type+'&vehicle='+vehicle,

    success: function(mess)
    {
       $('#vehicle').html(mess);
    } 
   
  }); 
  }  
</script>
  <!-- /.content-wrapper-->