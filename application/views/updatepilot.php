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
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Update Pilot Information
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin-dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Manage Pilot</a></li>
        <li class="active">Update Pilot Information</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">

            <!-- /.box-header -->
            <div class="box-body">
                <form class="form-horizontal" action="<?php echo base_url('Customers/updatepilot'); ?>" enctype="multipart/form-data" method="post" > 
                  <input type="hidden" name="id" value="<?php echo $id; ?>">

                <div class="row">
                  <div class="col-sm-6">
                      <label>Name:</label>
                        <input type="text" class="form-control" name="name"  value="<?php echo $result['name']; ?>" required>
                  </div>

                  <div class="col-sm-6">
                      <label>Email:</label>
                      <input type="text" class="form-control" name="email" value="<?php echo $result['email']; ?>">
                  </div>
                </div> <br> 


                <div class="row">
                  <div class="col-sm-6">
                      <label>Mobile:</label>
                        <input type="text" class="form-control" value="<?php echo $result['mobile']; ?>" readonly>
                  </div>
      
                 
                </div> <br> 

                <div class="row">
                  
                 <div class="col-sm-6">
                      <label>Profile Pic:</label>
                    <input type="file" name="input_files_1[]" id="input_files_1" placeholder="" class="form-control" onchange="uploadVideo(this, '1')">
                    <img src="<?php echo base_url() ?>assets/images/all_fixed_images/gallery_loading.gif" class="loader_img" id="loading_1">
                    <input type="hidden" name="image" value="" id="file_name_1">
                    <span id="err_input_files_1" class="user_err"></span>

                    <div class=" col-sm-12 pad_left"> 
                       <?php
                          $img_name = '';
                          if (!empty($result['image'])) 
                          {
                            $img_name = base_url().'mediaFile/drivers/'.$result['image'];
                          }
                          else
                          {
                            $img_name = base_url().'mediaFile/drivers/profile.jpg';
                          }
                          
                      ?>

                        <div class="col-sm-12" id="set_images_1" style="padding:0px;"><div class="col-xs-12 set_w_admin " id="img_preview_1">
                          <a href="<?php echo $img_name; ?>" download>
                          <img src="<?php echo $img_name; ?>" class="set_image" alt="" id="set_image_1">
                          </a>
                          <div class="col-xs-12 set_success"><span class="success">Success</span></div><div class="progress col-xs-12 divPadding" style="margin: 0;"><div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%"></div></div></div></div>
                    </div>
                  </div>

                  <div class="col-sm-6">
                      <label>License Image:</label>
                      <input type="file" name="input_files_2[]" id="input_files_2" placeholder="" class="form-control" onchange="uploadVideo(this, '2')">
                        <img src="<?php echo base_url() ?>assets/images/all_fixed_images/gallery_loading.gif" class="loader_img" id="loading_2">
                        <input type="hidden" name="licenceCopy" value="" id="file_name_2">
                        <span id="err_input_files_2" class="user_err"></span>
    
                       <div class=" col-sm-12 pad_left"> 
                       <?php
                          $img_name = '';
                          if (!empty($result['licenceCopy'])) 
                          {
                            $img_name = base_url().'mediaFile/drivers/'.$result['licenceCopy'];
                          }
                          else
                          {
                            $img_name = base_url().'mediaFile/drivers/no.jpeg';
                          }
                          
                      ?>

                        <div class="col-sm-12" id="set_images_2" style="padding:0px;"><div class="col-xs-12 set_w_admin " id="img_preview_2">
                          <a href="<?php echo $img_name; ?>" download>
                          <img src="<?php echo $img_name; ?>" class="set_image" alt="" id="set_image_2">
                          </a>
                          <div class="col-xs-12 set_success"><span class="success">Success</span></div><div class="progress col-xs-12 divPadding" style="margin: 0;"><div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%"></div></div></div></div>

                      </div>
                  </div>
                </div>
                <br>

         
                  <div class="row">
                    <div class="col-sm-6">
                      <label>CNIC  Image:</label>
                     <input type="file" name="input_files_3[]" id="input_files_3" placeholder="" class="form-control" onchange="uploadVideo(this, '3')">
                        <img src="<?php echo base_url() ?>assets/images/all_fixed_images/gallery_loading.gif" class="loader_img" id="loading_3">
                        <input type="hidden" name="cnicCopy" value="" id="file_name_3">
                        <span id="err_input_files_3" class="user_err"></span>
                       
                       <div class=" col-sm-12 pad_left"> 
                      <?php
                          $img_name = '';
                          if (!empty($result['cnicCopy'])) 
                          {
                            $img_name = base_url().'mediaFile/drivers/'.$result['cnicCopy'];
                          }
                          else
                          {
                            $img_name = base_url().'mediaFile/drivers/no.jpeg';
                          }
                          
                      ?>

                         <div class="col-sm-12" id="set_images_3" style="padding:0px;"><div class="col-xs-12 set_w_admin " id="img_preview_3">
                          <a href="<?php echo $img_name; ?>" download>
                          <img src="<?php echo $img_name; ?>" class="set_image" alt="" id="set_image_3">
                          </a>
                          <div class="col-xs-12 set_success"><span class="success">Success</span></div><div class="progress col-xs-12 divPadding" style="margin: 0;"><div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%"></div></div></div></div>

                      </div>
                  </div>

                  <div class="col-sm-6">
                      <label>Status:</label>
                      <select class="form-control" name="status" onchange="showtext_box(this.value);">
                        <option value="1" <?php echo ($result['status'] == 1) ? 'selected' : '' ?>>Activated</option>
                        <option value="2" <?php echo ($result['status'] == 2) ? 'selected' : '' ?>>Pending</option>
                        <option value="3" <?php echo ($result['status'] == 3) ? 'selected' : '' ?>>Rejected</option>
                      </select> 
                  </div> 
                </div>
              </br>

               <div class="row" id="reason_div" style="display:none;">
                      <div class="col-md-6">
                          <label for="exampleInputEmail1">Reason*</label>
                          <textarea class="form-control" name="reason" id="reason" style="height: 135px;"><?php echo $result['reason']?></textarea>
                      </div> 
                    </div>
                     <br> 


                  <div class="row"> 
                    <div class="col-md-12">
                      <button type="submit" class="btn btn-success">Update</button>
                    </div>
                  </div>
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
    $('#datepicker').datepicker({
      autoclose: true
    });

    var approval_status = '<?php echo $result['status'];?>';
    showtext_box(approval_status);

    });

 function showtext_box(value)
 {
    if (value == 3) 
    {
       $('#reason_div').show();
       $('#reason').attr('required',true);
    }
    else
    {
        $('#reason_div').hide();
        $('#reason').attr('required',false);
    }
 } 

</script>
  <!-- /.content-wrapper-->

  <script type="text/javascript">
 function uploadVideo(input, new_id){
        var file;
        //alert(new_id);

        var document_name = $('#input_files_'+new_id).val();
        var g_d_id = new_id;
        console.log(input.files);
        if (input.files && input.files[0]) {

            var get_l = input.files.length;
            var url = '<?php echo base_url('customers/uoload_img') ?>';
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
</script>