<script>
   function checkextension() {
    var file = document.querySelector("#fUpload");
    if ( /\.(jpe?g|png|gif)$/i.test(file.files[0].name) === false ) 
      { alert("not an image please choose a image!");
    $('#fUpload').val('');
  }
  return false;
}
</script>
<style type="text/css">
 .text{
  color:red; 
  font-size: 12px;
}
.filename{
  font-size: 11px;
  color: #e02727;
}
</style>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Users Manager
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo SITE_URL; ?>admin/dashboards"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo SITE_URL; ?>admin/users">Manage User</a></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
     
      <!-- right column -->
      <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info">
          <?php echo $this->Flash->render(); ?>
          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-plus-square" aria-hidden="true"></i>Edit User</h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <?php echo $this->Form->create($users, array(
           'class'=>'form-horizontal',
           'enctype' => 'multipart/form-data',
           'validate'
         ));
         //pr($category); die;
         ?>
         <div class="box-body">
         <div class="form-group">
          <div class="col-sm-3">
          <label for="inputEmail3" class="control-label">Select Branch</label>
          <?php echo $this->Form->input('store_id', array('class' => 
              'form-control','id'=>'exampleInputEmail1','label'=>false,'options'=>$store,'empty'=>'--Select Branch--','required')); ?>
            </div>
            <div class="col-sm-3">
              <label for="inputEmail3" class="control-label">Name</label>
              <?php echo $this->Form->input('name', array('class' => 'form-control','required','label'=>false,'placeholder'=>'Name','autofocus','autocomplete'=>'off')); ?>   
            </div>
            <div class="col-sm-3">
            <label for="inputEmail3" class="control-label">Email</label>
              <?php echo $this->Form->input('email', array('class' => 'form-control','required','label'=>false,'placeholder'=>'Email','autofocus','autocomplete'=>'off')); ?>   
            </div>
            <div class="col-sm-3">
            <label for="inputEmail3" class="control-label">Mobile</label>
              <?php echo $this->Form->input('mobile', array('class' => 'form-control','required','label'=>false,'placeholder'=>'Mobile','autofocus','autocomplete'=>'off','type'=>'number')); ?>   
            </div>
            </div>
            <div class="form-group">
            <!-- <div class="col-sm-3">
            <label for="inputEmail3" class="control-label">Update Image</label>
              <?php //if($users['image']){ ?>
                <?php //echo $this->Form->input('image', array('class' => 
                //'form-control','autocomplete' => 'off','label'=>false,'type'=>'file','id'=>'fUpload','onchange'=>'checkextension()')); ?>
                 <img src="<?php echo SITE_URL;?>images/user_images/<?php echo $users['image']; ?>" height="100px" width="100px">
                 <?php// }else{ ?>
                    <?php //echo $this->Form->input('image', array('class' => 
                //'form-control','autocomplete' => 'off','label'=>false,'type'=>'file','id'=>'fUpload','onchange'=>'checkextension()','required')); ?>
                <?php //} ?>
            </div> -->

            <div class="col-sm-3" style="margin-top: 32px;">
            <label for="inputEmail3" class="control-label"></label>
            <a href="javascript:void(0)" class="chngpassword"  >Do you want to change password ?</a>
            </div>
           

            <div class="col-sm-3 passdata" style="display:none;">
            <label for="inputEmail3" class="control-label">New Password</label>
            <?php echo $this->Form->input('new_password',array('class'=>'form-control input2','placeholder'=>'New Password', 'id'=>'password-field','label' =>false,'autocomplete'=>'off')); ?>
            </div>

            <div class="col-sm-3 passdata" style="display:none;">
            <label for="inputEmail3" class="control-label">Confirm Password</label>
            <?php echo $this->Form->input('confirm_passs',array('class'=>'form-control input3','placeholder'=>'Confirm Password', 'id'=>'confirm_pass','label' =>false,'autocomplete'=>'off')); ?>  
            </div>

            </div>


        
          
         </div> <!-----close passdata--->
         <!-- /.box-body -->
         <div class="box-footer">
          <?php
            echo $this->Form->submit(
              'Update', 
              array('class' => 'btn btn-info pull-right formsubmit', 'title' => 'Update')
            ); 
            ?><?php
            echo $this->Html->link('Back', [
              'action' => 'index'
              
            ],['class'=>'btn btn-default']); ?>
          </div>
          <!-- /.box-footer -->
          <?php echo $this->Form->end(); ?>
        </div>
        
      </div>
      <!--/.col (right) -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div> 


<script type="text/javascript">
 $(document).ready(function() {
  $(".formsubmit").click(function(){
  var newpass = $('.input2').val();
  var confrmpass = $('.input3').val();
  if(newpass && confrmpass){
if(newpass!=confrmpass){
    alert('New password and confirm password Does Not Match');
    return false;
  }
}
 });
});
</script>  


<script>	
$(document).ready(function(){
    $(".chngpassword").click(function(){
    $(".passdata").toggle();
     var test=$(this).find('.passdata');
     if(!$('#password-field').is(':visible'))
     {
	  $('#password-field').prop('required',false);
	  $('#confirm_pass').prop('required',false);
	 }
	 else{
	  $('#password-field').prop('required',true);
	  $('#confirm_pass').prop('required',true);
	 }
    });
});
</script>