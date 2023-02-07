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
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/css/bootstrap-select.min.css"/>
<script>
    $( function() {
        $( "#datepicker" ).datepicker();
    });
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Add Notification Definition Details </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url('welcome/manageDefinition'); ?>"> Manage Definition</a></li>
           
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
                      <h3 class="box-title">Definition Detail Form</h3>
                    </div>
                    <?php echo form_open_multipart('welcome/addSetting',array('id'=>'editpersonalinfo', 'class'=>'editpersonalinfo')); ?>
                        <div class="box-body col-xs-12 divPadding" style="border-bottom: 1px solid #f4f4f4;margin-bottom: 10px;">
                           <div class="error_validator">
                            <?php 
                                echo validation_errors(); 
                                if($this->session->flashdata('message'))
                                    echo $this->session->flashdata('message');
                            ?> 
                            </div>
                            <div class="col-xs-12 col-sm-12" id="error"></div>
                            <div class="col-sm-12 col-xs-12 divPadding">
                            
                                <!-- signature -->
                                <div class="form-group col-sm-12 col-xs-12 manage_divP">
                                    <div  class="col-xs-3">
                                        <label for="exampleInputEmail1">Definition Name <span class="red">*</span></label>
                                    </div>
                                    <div  class="col-xs-9">
                                        <input type="text" class="form-control" placeholder="Definition Name" name="definition" value="" id="definition" required="">
                                        
                                        <span id="err_definition" class="user_err"></span>
                                    </div>
                                </div> <!-- signature / -->
 
                                
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
    setTimeout(function(){
        $('.error_validator').hide();
    },5000);

    $('#error').hide();

    $('#add').click(function(){
        
    });

    function checkVal(val) {
        if(val == '2'){
            $('#hide_div').addClass('hide');
        } else {
            $('#hide_div').removeClass('hide');
        }
    }

    $(document).ready(function(){
        setTimeout(function(){ $('#secc_msg').fadeOut(); }, 5000);
        $(".editpersonalinfo").validate();

        $('.set_div_img2').on('click', function() {
            $('#secc_msg').fadeOut();
        });
    });
</script>
