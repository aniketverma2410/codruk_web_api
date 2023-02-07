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
        <h1>Notification Setting Details </h1>
        <ol class="breadcrumb" style="padding: 0px 5px;">
            <li>
                <a href="<?php echo base_url('Welcome/addNotificationSetting'); ?>">
                    <button type="button" class="btn btn-success">Add</button>
                </a> 
                    &nbsp;<a href="<?php echo base_url('Welcome/manageDefinition'); ?>">
                    <button type="button" class="btn btn-primary">Manage Definition</button>
                </a>
        </li>
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
                                        <td><b>Type </b></td>
                                        <td><b>Definition </b></td>
                      
                                        <td><b>Status </b></td>
                                        <td><b>View Details</b></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <?php  $i = 1; foreach ($res as $value) { 
                                        if($value['type'] == '1'){
                                            $type = 'Email';
                                        } else {
                                            $type = 'SMS';
                                        }
                                    ?>
                                            <tr id="<?php echo $value['id']; ?>" class="main_row">
                                                <td><?php echo $i; ?></td>
                                                <td> <?= $type; ?> </td>
                                                <td> <?= $value['name']; ?> </td>
                                      
                                                <td> <?php 
                                                  if($value['status'] =='1'){?>
                                                         <span class="label label-success">Activated</span>  
                                                  <?php } else { ?>
                                                       <span class="label label-danger">Deactivated</span> 
                                                  <?php } ?>
                                              </td>
                                                
                                                <td>
                                                     <a title="Edit details" href="<?php echo base_url('welcome/editNotificationSetting').'/'.base64_encode($value['id']); ?>" class="btn btn-primary btn-sm">
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
