<style type="text/css">
   span p{color:red}p#deleteFile{margin:0;color:#e0aeae}#myProgress{width:100%;background-color:#ddd}#myBar{width:1%;height:6px;background-color:#61bd65;margin-top:7px}#loaderShow{display:none}.loader{border:5px solid #f3f3f3;border-radius:50%;border-top:5px solid #3498db;width:25px;height:25px;top:5px;padding-left:5px;font-size:10px;-webkit-animation:spin 2s linear infinite;animation:spin 2s linear infinite}@-webkit-keyframes spin{0%{-webkit-transform:rotate(0)}100%{-webkit-transform:rotate(360deg)}}@keyframes spin{0%{transform:rotate(0)}100%{transform:rotate(360deg)}}span#videoSize{float:right}

   .box-body {overflow-x: hidden;}
</style>
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
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Update Owner Profile 
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin-dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Owner Profile</li>
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
                <form class="form-horizontal" action="<?php echo base_url('owner/updateownerprofile'); ?>" enctype="multipart/form-data"  method="post" > 

                <div class="row">
                  <div class="col-sm-6">
                      <label>Name:</label>
                       <input type="text" class="form-control" name="name" value="<?php echo $reg['name']; ?>" required="">
                  </div>
                  <div class="col-sm-6">
                      <label>Email:</label>
                       <input type="email" class="form-control" id="email" name="email" value="<?php echo $reg['email']; ?>">
                       <input type="hidden" id="old_email" value="<?php echo $reg['email'];?>" >
                        <span id="email_err" style="color:red;"></span>
                  </div>
                </div>
                <br> 

                <div class="row">
                  <div class="col-sm-6">
                      <label>Mobile:</label>
                      <input type="text" maxlength="10" class="form-control" id="mobile" name="mobile" value="<?php echo $reg['mobile']?>" readonly>
                       <input type="hidden" id="old_mobile" value="<?php echo $reg['mobile'];?>" >
                      <span id="mob_err" style="color:red;"></span>
                  </div>

                  <div class="col-sm-6">
                      <label>Password:</label>
                      <input type="password" class="form-control" name="password" value="">
                  </div>
                </div>
                <br> 

                <div class="row">
                   <div class="col-sm-6">
                      <label>Profile Image:</label>
                      <input type="file" name="image" class="form-control" id="thumbnail" onchange="ImageChange(this)" class="form-control" accept="image/*" /><br>
<!--                       <div id="showFile">
                        <?php if (!empty($reg['profile_pic'])) {?>
                        <img id="blah" src="<?php echo base_url('mediaFile/'); ?><?php echo $reg['profile_pic']; ?>" alt="your image" style="width:150px;height: 150px;" class="img-circle"/>
                        <?php }?>  
                  </div> -->

                   <div id="showFile" style="border: 2px solid #dedadad9;padding: 5px;width: 150px;    margin-bottom: 30px;">
                        <img id="blah" src="<?php echo base_url('mediaFile/'); ?><?php echo $reg['profile_pic']; ?>" alt="your image" width="100%" height="100" />
                        <div id="myProgress"><div id="myBar" style="width: 100%;"></div></div>
                        <span id="message" style="color:green;">Success</span>
                        <span class="fa fa-check" style="float:right;margin-top: 5px;color: green"></span>
                   </div>

                </div> 
                </div>


                <div class="row">
                  <div class="col-sm-12">
                       <button type="submit" id="submit" class="btn btn-success">Update Profile</button>
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
  <script type="text/javascript">

  $(document).ready(function(){
  
  var check = "<?php echo $reg['profile_pic']?>";
  if (check == "") 
  {
     $('#showFile').hide();
  }
});  

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
                         $('#displayImagesShow').html('<div id="showFile"><img id="blah" src="'+e.target.result+'" alt="your image" style="width:150px;height: 150px;" class="img-circle"/></div>');
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

<script type="text/javascript">

    $(function() {

$("#email").keyup(function() {

  var email  =  $("#email").val();
  var old_email =  $("#old_email").val();

    $.ajax({  
    type: "POST",  
    url: "<?php echo base_url('owner/check_mail_new'); ?>",  
    data: 'email='+ email+'&old_email='+old_email,

    success: function(mess)
    {
      if(mess==0)
      { 
          $("#email_err").html('Email is already exist');
          //$("#mobile").val('');
          $("#submit").prop('disabled', true);
      }
      else
      {   
          var mob = $('#mob_err').html();
          if (mob == "") 
          {
            $("#submit").prop('disabled', false);
          }
          else
          {
              $("#submit").prop('disabled', true);
          } 
          $("#email_err").html('');         
      }
    } 
   
  }); 
});
});


        $(function() {

$("#mobile").keyup(function() {

  var mobile  =  $("#mobile").val();
   var old_mobile =  $("#old_mobile").val();

    $.ajax({  
    type: "POST",  
    url: "<?php echo base_url('owner/check_mobile_new'); ?>",  
    data: 'mobile='+ mobile+'&old_mobile='+old_mobile,

    success: function(mess)
    {
      if(mess==0)
      { 
          $("#mob_err").html('Mobile number is already exist');
          $("#submit").prop('disabled', true);
      }
      else
      {   
          var ema = $('#email_err').html();
          if (ema == "") 
          {
            $("#submit").prop('disabled', false);
          }
          else
          {
              $("#submit").prop('disabled', true);
          } 
          $("#mob_err").html('');
      }
    } 
   
  }); 
});
});

</script>
  <!-- /.content-wrapper-->