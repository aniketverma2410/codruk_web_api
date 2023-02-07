<style type="text/css">
    #sections .box{ border-left: 1px solid #3c8dbc;border-right: 1px solid #3c8dbc;border-bottom: 1px solid #3c8dbc;
    }
    .form-control{
        height:0%;
    }
    .manage_divP, .divPadding{padding: 0px !important;}
    .box-body{padding: 10px 0px !important;}
    .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn){width: 100% !important;}
    .btn{ border-radius: 0px !important;}
    .box-header.with-border{border: 0px solid !important;}
    .red{color: red;}


    .success_msg{               
        width: 280px;                
        min-height: 50px;               
        position: fixed;                 
        top: 50px;                
        right: 0px; 
        background: #4BB543;                   
        color: #fff;                   
        z-index: 1000000;                
        padding: 15px 5px;               
        border: 1px solid #fff;              
        border-radius: 15px;            
    }              
    .set_div_img2{
        text-align: right; cursor: pointer;
    }
</style>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>theme/select/css/bootstrap-select.min.css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="http://cdn.ckeditor.com/4.5.10/full-all/ckeditor.js"></script> 
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Edit Notification Details </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#"> Manage Notification</a></li>
           
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <!-- small box -->
                <div class="box box-primary">
                <!-- form start -->
                    <div class="box-header with-border">
                      <h3 class="box-title">Notification Detail Form</h3>
                    </div>
                    <?php echo form_open_multipart('welcome/updateNotificationSettingData',array('id'=>'editpersonalinfo', 'class'=>'editpersonalinfo')); ?>
                        <div class="box-body col-xs-12 divPadding" style="border-bottom: 1px solid #f4f4f4;margin-bottom: 10px;">
                           <div class="error_validator">
                            <?php 
                                echo validation_errors(); 
                                if($this->session->flashdata('message'))
                                    echo $this->session->flashdata('message');
                            ?> 
                            </div>
                            <div class="col-xs-12 col-sm-12" id="error"></div>
                            <input type="hidden" name="setting_id" value="<?= $setting_id; ?>">
                            <div class="col-sm-12 col-xs-12 divPadding">
                                <!-- notification type -->
                                <input type="hidden" id="checkType" value="<?php echo $res['type']; ?>"> 
                                <div class="form-group col-sm-12 col-xs-12 manage_divP">
                                    <div  class="col-xs-3">
                                        <label for="exampleInputEmail1">Select Notification Type <span class="red">*</span></label>
                                    </div>
                                    <div  class="col-xs-9">
                                        <input type="radio" name="type" class="notification_type" onclick="checkVal(this.value)" <?php if($res['type'] == '1') { echo 'checked'; } ?> value="1"> Email &nbsp;
                                        <input type="radio" name="type" class="notification_type" onclick="checkVal(this.value)" <?php if($res['type'] == '2') { echo 'checked'; } ?> value="2"> SMS
                                        
                                        <span id="err_notification_type" class="user_err"></span>
                                    </div>
                                </div> <!-- notification type / -->

                                <!-- definition -->
                                <div class="form-group col-sm-12 col-xs-12 manage_divP">
                                    <div  class="col-xs-3">
                                        <label for="exampleInputEmail1">Definition <span class="red">*</span></label>
                                    </div>
                                    <div  class="col-xs-9">
                                        <select class="selectpicker" data-live-search="true" data-live-search-style="startsWith" class="selectpicker" name="definition" id="definition" required="">
                                            <option value="">Select Definition</option>
                                            <?php foreach ($definition_list as $key => $value) {
                                                if($res['definition'] == $value['id']){
                                                    $sel = 'selected';
                                                } else {
                                                    $sel = '';
                                                }
                                             ?>
                                                <option value="<?= $value['id']; ?>" <?= $sel; ?>><?= $value['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                        <span id="err_definition" class="user_err"></span>
                                    </div>
                                </div> <!-- definition / -->


                            <?php if($res['type'] == '2') { $cls = 'hide'; } else { $cls = '';} ?>
                            <div class="hide_div <?= $cls; ?>">
                                <!-- subject -->
                                <div class="form-group col-sm-12 col-xs-12 manage_divP">
                                    <div  class="col-xs-3">
                                        <label for="exampleInputEmail1">Subject <span class="red">*</span></label>
                                    </div>
                                    <div  class="col-xs-9">
                                        <input type="text" class="form-control" placeholder="Subject" name="subject" id="subject" value="<?= $res['subject']; ?>" required="">
                                        
                                        <span id="err_subject" class="user_err"></span>
                                    </div>
                                </div> <!-- subject / -->


                                <!-- body -->
                                <div class="form-group col-sm-12 col-xs-12 manage_divP">
                                    <div  class="col-xs-3">
                                        <label for="exampleInputEmail1">Body <span class="red">*</span></label>
                                    </div>
                                    <div  class="col-xs-9">
                                        <textarea class="form-control" name="body" id="body" placeholder="Enter Message Body.." required=""><?php if($res['type'] == '1') { echo $res['body']; } ?></textarea>
                                        
                                        <span id="err_body" class="user_err"></span>
                                    </div>
                                </div> <!-- body / -->
                            </div>

                            <?php if($res['type'] == '1') { $cls1 = 'hide'; } else { $cls1 = '';} ?>
                             <!-- body -->
                                <div class="form-group col-sm-12 col-xs-12 manage_divP <?= $cls1; ?>" id="showDiv">
                                    <div  class="col-xs-3">
                                        <label for="exampleInputEmail1">Body <span class="red">*</span></label>
                                    </div>
                                    <div  class="col-xs-9">
                                        <textarea class="form-control" name="sms_body" id="sms_body" rows="7" placeholder="Enter Message Body.." required=""><?php if($res['type'] == '2') { echo $res['body']; } ?></textarea>
                                        
                                        <span id="err_body" style="font-style: italic;" class="user_err"></span>
                                    </div>
                                </div> <!-- body / -->



                            <div class="hide_div <?= $cls; ?>">
                                <!-- signature -->
                                <div class="form-group col-sm-12 col-xs-12 manage_divP">
                                    <div  class="col-xs-3">
                                        <label for="exampleInputEmail1">Signature <span class="red">*</span></label>
                                    </div>
                                    <div  class="col-xs-9">
                                        <textarea class="form-control" name="content" rows="6" id="signature" placeholder="Enter Signature" required=""><?php echo $res['content']; ?></textarea>
                                        
                                        <span id="err_signature" style="font-style: italic;" class="user_err"></span>
                                    </div>
                                </div> <!-- signature / -->


                                 <!-- send to -->
                                <div class="form-group col-sm-12 col-xs-12 manage_divP">
                                    <div  class="col-xs-3">
                                        <label for="exampleInputEmail1">Send To <span class="red">*</span></label>
                                    </div>
                                    <div  class="col-xs-9">
                                       <input type="text" class="form-control" placeholder="Send To" name="send_to" value="<?= $res['send_to']; ?>" id="send_to" required="">
                                        
                                        <span id="err_send_to" class="user_err"></span>
                                    </div>
                                </div> <!-- send to / -->
                            </div>

                                <!-- status / -->
                                <div class="form-group col-sm-12 col-xs-12 manage_divP">
                                    <div  class="col-xs-3">
                                         <label for="exampleInputEmail1">Status <span class="red">*</span></label>

                                    </div>

                                    <div  class="col-xs-9">
                                        <select id="status" name="status" data-live-search="true" data-live-search-style="startsWith" class="selectpicker form-control">
                                            
                                                <option value="1" <?php
                                             if ($res['status'] == 1) {  echo "selected";  }
                                             else {
                                                echo ""; } ?>>Active</option>
                                                <option value="2" <?php
                                             if ($res['status'] == 2) {  echo "selected";  }
                                             else {
                                                echo ""; } ?>>Deactive</option>

                                        </select>

                                        <span id="err_bank_name" class="user_err"></span>

                                    </div>
                                </div> <!-- status / -->

                            </div>
                        </div>

                        <div class="box-footer">
                            <?php echo form_submit(array('value' => 'Submit', 'class' => 'btn btn-primary', 'id' => 'add')); ?>
                        </div>
                    <?php echo form_close();?>
                </div><!-- /.box -->
            </div><!-- ./col -->  
        </div><!-- /.row -->
        <!-- Main row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
     

 

<!-- check validation -->
<script type="text/javascript">
     var typeExact = $("#checkType").val();
     if(typeExact == '1'){
       $("#sms_body").removeAttr("required");
      }else{
         $("#subject").removeAttr("required");
         $("#body").removeAttr("required");
         $("#signature").removeAttr("required");
         $("#send_to").removeAttr("required"); 
      }

    var body = CKEDITOR.replace( 'body', {
        extraAllowedContent : 'div*(*);*{*}',
        height: 250
    } );
    body.on('instanceReady', function() {
        this.dataProcessor.writer.selfClosingEnd = '>';
        var dtd = CKEDITOR.dtd;
        for ( var e in CKEDITOR.tools.extend( {}, dtd.$nonBodyContent, dtd.$block, dtd.$listItem, dtd.$tableContent ) ) {
            this.dataProcessor.writer.setRules( e, {
                indent: true,
                breakBeforeOpen: true,
                breakAfterOpen: true,
                breakBeforeClose: true,
                breakAfterClose: true
            });
        }
        //this.setMode('source');
    });

    var signature = CKEDITOR.replace( 'signature', {
        extraAllowedContent : 'div*(*);*{*}',
        height: 200
    } );
    signature.on('instanceReady', function() {
        this.dataProcessor.writer.selfClosingEnd = '>';
        var dtd = CKEDITOR.dtd;
        for ( var e in CKEDITOR.tools.extend( {}, dtd.$nonBodyContent, dtd.$block, dtd.$listItem, dtd.$tableContent ) ) {
            this.dataProcessor.writer.setRules( e, {
                indent: true,
                breakBeforeOpen: true,
                breakAfterOpen: true,
                breakBeforeClose: true,
                breakAfterClose: true
            });
        }
        //this.setMode('source');
    });

    CKEDITOR.stylesSet.add( 'my_styles', [
        { element: 'table', attributes: { 'class': 'my_table' } }
    ]);


    setTimeout(function(){
        $('.error_validator').hide();
    },5000);

    $('#error').hide();

    $('#add').click(function(){
        
    });

    function checkVal(val) {
        if(val == '2'){
            $('.hide_div').hide();
            $('#showDiv').removeClass('hide');
             $("#subject").removeAttr("required");
             $("#body").removeAttr("required");
             $("#signature").removeAttr("required");
             $("#send_to").removeAttr("required");
        } else {
            $('.hide_div').show();
            $('#showDiv').addClass('hide');
        }
    }

</script>
<script src="<?php echo base_url(); ?>theme/select/js/bootstrap-select.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>theme/select/js/map.js" type="text/javascript"></script>
