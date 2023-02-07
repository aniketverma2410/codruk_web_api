<style type="text/css">
        span p{color:red}p#deleteFile{margin:0;color:#e0aeae}#myProgress{width:100%;background-color:#ddd}#myBar{width:1%;height:6px;background-color:#61bd65;margin-top:7px}#loaderShow{display:none}.loader{border:5px solid #f3f3f3;border-radius:50%;border-top:5px solid #3498db;width:25px;height:25px;top:5px;padding-left:5px;font-size:10px;-webkit-animation:spin 2s linear infinite;animation:spin 2s linear infinite}@-webkit-keyframes spin{0%{-webkit-transform:rotate(0)}100%{-webkit-transform:rotate(360deg)}}@keyframes spin{0%{transform:rotate(0)}100%{transform:rotate(360deg)}}span#videoSize{float:right}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Update Customer
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin-dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Manage Customer</a></li>
        <li class="active">Update</li>
      </ol>
    </section>
   <style type="text/css">span p{color: red;}
      #loaderShow{display: none;}
      p#deleteFile {
          margin: 0px;
          color: #e0aeae;
        }
        #myProgress {
        width: 100%;
        background-color: #ddd;
      }

      #myBar {
        width: 1%;
        height: 6px;
        background-color: #61bd65;
        margin-top: 7px;
      }
      .loader {
          border: 5px solid #f3f3f3;
          border-radius: 50%;
          border-top: 5px solid #3498db;
          width: 50px;
          height: 50px;
        -webkit-animation: spin 2s linear infinite; /* Safari */
        animation: spin 2s linear infinite;

      }
      /* Safari */
      @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
      }

      @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
      }

/****** CODE ******/
</style>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">

            <!-- /.box-header -->
            <div class="box-body">
                <form class="form-horizontal" action="<?php echo base_url('Customers/updateCustomerPost'); ?>" enctype="multipart/form-data" method="post" > 
                  <input type="hidden" name="id" value="<?php echo $id; ?>">
                  <input type="hidden" name="case" value="<?php echo $case; ?>">

                <div class="row">
                  <div class="col-sm-6">
                      <label>Name:</label>
                        <input type="text" class="form-control" name="name"  value="<?php echo $result['name']; ?>" required>
                  </div>

                  <div class="col-sm-6">
                      <label>Email:</label>
                      <input type="text" class="form-control" value="<?php echo $result['email']; ?>" readonly>
                  </div>
                </div> <br> 


                <div class="row">
                  <div class="col-sm-6">
                      <label>Mobile:</label>
                        <input type="text" class="form-control" value="<?php echo $result['mobile']; ?>" readonly>
                  </div>
              <?php if ($case == '2'){ ?>
                  <div class="col-sm-6">
                      <label>Gender:</label>
                      <select class="form-control" name="gender">
                        <option value="1" <?php echo ($result['gender'] == 1) ? 'selected' : '' ?>>Male</option>
                        <option value="2" <?php echo ($result['gender'] == 2) ? 'selected' : '' ?>>Female</option>
                      </select> 
                  </div>
                </div> <br> 

                <div class="row">
                  <div class="col-sm-6">
                      <label>DOB:</label>
                       <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" name="dob" value="<?php echo $result['dob']; ?>" class="form-control pull-right" id="datepicker">
                        </div>
                  </div>

                  <div class="col-sm-6">
                      <label>Photo:</label>
                      <input type="file" name="image" class="form-control"  id="thumbnail" onchange="ImageChange(this)" class="form-control" accept="image/*" />
<!--                         <?php if(!empty($result['image'])) { ?>
                            <img src="<?php echo base_url('mediaFile/customers/'); ?><?php echo $result['image']; ?>" width="180" height="205">
                        <?php  } else { ?>
                            <img src="<?php echo base_url(); ?>theme/dist/img/user2-160x160.jpg" width="180" height="205">
                        <?php } ?> -->
                      <div id="showFile" style="border: 2px solid #dedadad9;padding: 5px;width: 150px;">
                        <img id="blah" src="<?php echo base_url('mediaFile/customers/'); ?><?php echo $result['image']; ?>" alt="your image" width="100%" height="100" />
                        <div id="myProgress"><div id="myBar" style="width: 100%;"></div></div>
                        <span id="message" style="color:green;">Success</span>
                        <span class="fa fa-check" style="float:right;margin-top: 5px;color: green"></span>
                      </div>
                            
                  </div> 
                </div>

                 <?php }  ?>

                  <div class="col-sm-6">
                      <label>Activated/Deactivated:</label>
                      <select class="form-control" name="status">
                        <option value="1" <?php echo ($result['status'] == 1) ? 'selected' : '' ?>>Activated</option>
                        <option value="2" <?php echo ($result['status'] == 2) ? 'selected' : '' ?>>Deactivated</option>
                      </select> 
                  </div> 
                </div></br>


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
    });
</script>
  <!-- /.content-wrapper-->

  <script type="text/javascript">
  function ImageChange(input){
    $('#loaderShow').css('display','block');
    if (input.files && input.files[0]) {
           // if value is images
            var  file = input.files[0].name;
            var  ext = file.split(".");  
            ext = ext[ext.length-1].toLowerCase();      
            var arrayExtensions = ["jpg" , "jpeg", "png", "bmp", "gif"];
            var exactSize = getFileSize(input.files[0].size);
            var lastextType = exactSize.substr(exactSize.length - 2);
            var res = exactSize.split(".");
            var kbcheck = '';
            if(jQuery.isEmptyObject(res[1]) != true){
                  kbcheck = res[1].split("&");
            }
              if(lastextType == 'KB'){
                var res = res[0];
              }else if(lastextType == 'MB'){
                var res = res[0]*1024;
                var res = +(res)+ + +(kbcheck[0]);
              }else {
                var res = (res[0]*1024)*1024;
              }
              if(res > 5120){
                   alert('!Oops file size to larger. can\'t be upload more than 5 MB');
                   deletefile();
                }
              if($.inArray(ext, arrayExtensions) == -1) {
                console.log(res);
              }else{ 
                var reader = new FileReader();
                var image = '';
                reader.onload = function (e) {
                   $('#blah').attr('src', e.target.result);
                         var exactSize = getFileSize(input.files[0].size);
                         $('#displayImagesShow').html('<div id="showFile" style="border: 2px solid #dedadad9;padding: 5px;width: 150px;"><img id="blah" src="'+e.target.result+'" alt="your image" width="100%" height="100" /><div id="myProgress"><div id="myBar"></div></div><p id="deleteFile"><span id="message" style="color:green;"></span><span class="fa fa-check" style="float:right;margin-top: 5px;color: green">'+exactSize+'</span></p></div>');
                        $('input[name="sessionFileSize"]').val(exactSize);
                        move();
                        $('#displayImagesShow').css('display','block');
                        $('#showFile').css('display','block');
                        $('#displayError3').css('display','none');
                        // console.log(e.target.result)
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
   }
      function move() {
        var elem = document.getElementById("myBar");   
        var width = 1;
        var id = setInterval(frame, 10);
        function frame() {
          if (width >= 100) {
            clearInterval(id);
            $('#message').text('Success');
          } else {
            width++; 
            elem.style.width = width + '%'; 
          }
        }
    }

  function getFileSize(videoSize){
    var fSExt = new Array('Bytes', 'KB', 'MB', 'GB'),
      i=0;
      while(videoSize > 900){
        videoSize /=1024;i++;
      }
    return exactSize = (Math.round(videoSize*100)/100)+'&nbsp;'+fSExt[i];
  }
   function deletefile(){
      $("#thumbnail_file").val(null);
      $("#thumbnail").val(null);
      $("#showFile").hide();
    }
</script>