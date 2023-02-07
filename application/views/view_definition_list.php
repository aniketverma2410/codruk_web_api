<style>
    .group{cursor: pointer;}
    body {font-family: "Lato", sans-serif;}
    .img_h_w{height: 50px; width: 50px;}
    .del{cursor: pointer;}
    .divPadding{padding-right: 0px !important; padding-left: 0px !important; }
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
    .lbl { font-size:12px;padding:10px; }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Notification Definition Details </h1>

        <ol class="breadcrumb" style="padding: 0px 5px;">
            <li><a href="<?php echo base_url('welcome/addSetting'); ?>"><button type="button" class="btn btn-success">Add Definition</button></a> 
            
        </ol>
    </section>
    <style type="text/css">
        .action i{font-size: 20px}
        .ch_pwd{cursor: pointer;}
    </style>
    <!-- Main content -->
    <section class="content">  
        <div class="row"> 
            <div class="col-xs-12">
               <div id="hiddenSms"><?php echo $this->session->flashdata('message'); ?></div>  
                <div class="box col-xs-12 divPadding">
                    <div class="box-body col-xs-12 col-sm-12 divPadding">
                     
                        <div class="col-xs-12" id="success_msg" style="display: none;"></div>
                        <div class="col-sm-12" style="overflow: auto;">
                            <table id="example1" class="table table-condensed table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <td><b>S. No.</b></td>
                                        <td><b>Definition Name</b></td>
     
                                        <td><b>Status </b></td>
                                        <td><b>View Details</b></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <?php  $i = 1; foreach ($res as $value) { 
                                        
                                    ?>

                                            <tr id="<?php echo $value['id']; ?>" class="main_row">
                                                <td><?php echo $i; ?></td>
                                                <td> <?= $value['name']; ?> </td>
                                       
                                               <td> <?php 
                                                  if($value['status'] =='1'){?>
                                                         <span class="label label-success">Activated</span>  
                                                  <?php } else { ?>
                                                       <span class="label label-danger">Deactivated</span> 
                                                  <?php } ?></td>
                                                                        
                                                <td id="act">
                                                    
                                                    <a title="Edit details" href="<?php echo base_url('welcome/editSetting').'/'.base64_encode($value['id']); ?>" class="btn btn-primary btn-sm">
                                                        View/Edit
                                                    </a>
                                                </td>                                    
                                            </tr>
                                    <?php  $i++; } ?>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>










<script type="text/javascript">
    $('.del').on('click', function(){
        delRows(this);
    }); 

    $('.click_btn').on('click', function(){
        var get_id = $(this).attr('id');
        var s_id = $(this).attr('s_id');
        
        var text = $(this).html();
        var txt = '';
        
        if (text == 'Deactivate') {
            txt = 'Activate';
        } else {
            txt = 'Deactivate';
        }

        var conf_msg = 'Are you sure '+txt+' this record.';
        var con = confirm(conf_msg)

        if (con) {

            var table = 'faqs';
            var s_url = '<?php echo base_url('admin/faqs/changeStatus')?>';
            $.ajax({
                data: {'table': table, 'id': s_id},
                url: s_url,
                type: 'post',
                success: function(data){
                    if (data == '1') {
                        $('#'+get_id).removeClass('btn-warning');
                        $('#'+get_id).addClass('btn-success');
                        $('#'+get_id).text('Active');
                    } else if (data == '2') {
                        $('#'+get_id).removeClass('btn-success');
                        $('#'+get_id).addClass('btn-warning');
                        $('#'+get_id).text('Deactivate');
                    }
                    $message = '<div class="success_msg" id="secc_msg"><div class="col-xs-12 set_div_msg">Record successfully '+txt+'</div></div>';

                    $('.success').html($message).show();
                    setTimeout(function() {
                        $('.success').hide();
                    }, 3000);
                }
            });
        }

    });
    
    /* change status for active, deactive btn */
    function changeStatus(e){
      
    }

    function delRows(e) {
        var id = $(e).attr('id');
        
        var url = '<?php echo base_url('admin/deleteRecord')?>/'+id;
        var confirm = window.confirm("Are you sure to delete this record!");
 
        if ( confirm == true) {
            $.ajax({
                url: url,
                type: 'post',
                success: function(data) {
                   // alert(data);
                    if (data) {
                        $('.main_row#'+id).remove(); 
                    }
                }
            });
        }
    }
</script>