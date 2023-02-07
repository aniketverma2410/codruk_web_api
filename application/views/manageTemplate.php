<?php $getEmailData = $this->db->get_where('settings',array('templateType'=>1))->row_array();
$getsmsData = $this->db->get_where('settings',array('templateType'=>2))->row_array(); 
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Manage Template
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin-dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Manage Template</a></li>
        <li class="active">List</li>
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
              <form action="<?php echo base_url('welcome/updateTemplateData'); ?>" id="register" method="post">
              <div class="row">
                <div class="col-md-12">
                  <div class="col-md-1">
                    <div class="radio">
                      <label><input type="radio" class="functionTemplate" name="templateType" value="1" checked>Email</label>
                    </div>
                  </div>
                  <div class="col-md-1">
                    <div class="radio">
                      <label><input type="radio" class="functionTemplate" name="templateType" value="2">SMS</label>
                    </div>
                  </div>
                   <div class="col-md-10"></div>

                </div>
              </div>

              <div class="row" id="emailDiv">
                <div class="col-md-6" style="padding-left: 35px;">

                      <div class="form-group">
                        <label for="email">Subject:</label>
                        <input type="text" name="subject" id="subject" value="<?php echo $getEmailData['subject']; ?>" class="form-control">
                        <span style="color:red;" id="subjectErr"></span>
                      </div>

                      <div class="form-group">
                        <label for="pwd">Body(message):</label>
                        <textarea class="form-control" name="emailBody" id="emailBody" rows="3"><?php echo $getEmailData['messageBody']; ?></textarea>
                        <span style="color:red;" id="emailBodyErr"></span>
                      </div>

                      <div class="form-group">
                        <label> Signature:</label>
                        <input type="text" name="signature" id="signature" value="<?php echo $getEmailData['signature']; ?>" class="form-control">
                        <span style="color:red;" id="signatureErr"></span>
                      </div>

                      <div class="form-group">
                        <label> Send To:</label>
                        <input type="text" name="sendTo" id="sendTo" value="<?php echo $getEmailData['sendTo']; ?>" class="form-control">
                        <span style="color:red;" id="sendToErr"></span>
                      </div>
                     

               </div>
                <div class="col-md-6"></div>
              </div>


              <div class="row" id="smsDiv">
                <div class="col-md-6" style="padding-left: 35px;">


                      <div class="form-group">
                        <label for="pwd">Body(message):</label>
                        <textarea class="form-control" name="smsBody" id="smsBody" rows="3"><?php echo $getsmsData['messageBody']; ?></textarea>
                        <span style="color:red;" id="smsBodyErr"></span>
                      </div>

                      
               </div>
                <div class="col-md-6"></div>
              </div>
              <div class="row">
                <div class="col-md-6" style="padding-left: 35px;">
                    <input type="submit" class="btn btn-info" value="Submit">
               </div>
                <div class="col-md-6"></div>
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
  $("#smsDiv").hide();
  $(".functionTemplate").click(function(){
    var radioValue = $("input[name='templateType']:checked"). val();
    if(radioValue == '1'){
      $("#emailDiv").show();
      $("#smsDiv").hide();

    } else if(radioValue == '2'){
      $("#emailDiv").hide();
      $("#smsDiv").show();
    }
  });
});

  $("#register").submit(function(){
    var radioValue = $("input[name='templateType']:checked"). val();
    if(radioValue == '1'){
      $("#emailDiv").show();
      var subject   = $("#subject").val();
      var emailBody = $("#emailBody").val();
      var signature = $("#signature").val();
      var sendTo    = $("#sendTo").val();
      if(subject == ""){
        $("#subjectErr").text('Subject field is mendatory.');
        $("#emailBodyErr").text('');
        $("#signatureErr").text('');
        $("#sendToErr").text('');
        return false;
      }else if(emailBody == ""){
        $("#emailBodyErr").text('Message field is mendatory.');
        $("#subjectErr").text('');
        $("#signatureErr").text('');
        $("#sendToErr").text('');
        return false;
      }else if(signature == ""){
        $("#signatureErr").text('Signature field is mendatory.');
        $("#subjectErr").text('');
        $("#emailBodyErr").text('');
        $("#sendToErr").text('');
        return false;
      }else if(sendTo == ""){
        $("#sendToErr").text('Signature field is mendatory.');
        $("#subjectErr").text('');
        $("#emailBodyErr").text('');
        $("#signatureErr").text('');
        return false;
      }else{
        return true;
      }

    }
    else if(radioValue == '2'){
      $("#emailDiv").hide();
      $("#smsDiv").show();
      var smsBody = $("#smsBody").val();
      if(smsBody == ""){
        $("#smsBodyErr").text('Message field is mendatory.');
        return false;
      }
    }
  });
</script>