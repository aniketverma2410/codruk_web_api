<style type="text/css">
  .box-body {
     overflow-x: hidden; 
}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Staff 
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin-dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Manage Staff</a></li>
        <li class="active">Add Staff</li>
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
                <form class="form-horizontal" action="<?php echo base_url('Customers/add_staff'); ?>" enctype="multipart/form-data"  method="post" > 


                <div class="row">
                  <div class="col-sm-12">

                      <label>Name:</label>
                       <input type="text" class="form-control" name="name" required="">
                       <br>
                  </div>


                  <div class="col-sm-12">
                      <label>Email:</label>
                       <input type="email" class="form-control" name="email"  id="email" required="">
                       <span id="email_err" style="color:red;"></span>
                       <br>
                  </div>
          
                  <div class="col-sm-12">
                      <label>Mobile:</label>
                       <input type="text" class="form-control" name="mobile" required="" id="mobile" maxlength="10">
                       <span id="mob_err" style="color:red;"></span>
                       <br>
                  </div>

                  <div class="col-sm-12">
                      <label>Password:</label>
                       <input type="password" class="form-control" name="password"  required="">
                  
                  </div>
                </div>
                 <br> 

                <div class="row">
                  <div class="col-sm-12">
                       <button type="submit" id="submit" class="btn btn-info">Submit</button>
                       
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
   window.onload=function(){
      $(".alert").fadeOut(5000);
  }

    $(function() {

$("#email").keyup(function() {

  var email  =  $("#email").val();

    $.ajax({  
    type: "POST",  
    url: "<?php echo base_url('Customers/check_mail'); ?>",  
    data: 'email='+ email,

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

    $.ajax({  
    type: "POST",  
    url: "<?php echo base_url('Customers/check_mobile'); ?>",  
    data: 'mobile='+ mobile,

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