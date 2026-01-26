
<style type="text/css">
.videoo{margin-left: 65%;
    margin-top: -26px;
    color: red;
  }
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	    <section class="content-header">
		      <h1>
           Profile Detail
		      </h1>

	      </ol>
	    </section>

<?php echo $this->Flash->render() ?>
    <!-- Main content -->
    <section class="content">
      <div class="row">
       
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
		    <div class="box-header with-border">
				<!-- <h3 class="box-title"><i class="fa fa-plus-square" aria-hidden="true"></i> <?php  echo 'Edit User';  ?></h3> -->
				</div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php //pr($ntypes); die; ?>
		<?php echo $this->Form->create($ntypes, array(
	    	           //'onsubmit'=>'return registration();',
                       'class'=>'form-horizontal',
                       'enctype' => 'multipart/form-data',
					   //'controller'=>'users',
					  //'action'=>'add',
                       'validate'
                     	)); ?>
 <div class="box-body">
 <h4 class="box-title"><i class="fa fa-plus-square" aria-hidden="true"></i> <?php  echo 'Contact Details';  ?></h4>
<?php if($ntypes['role_id']=='1') {?>	         
		        
	
				<div class="form-group">
		          <label for="inputEmail3" class="col-sm-2 control-label">Helpline Number</label>
		          <div class="col-sm-8">
			      <?php echo $this->Form->input('helpline_number', array('class' => 'form-control','required','label'=>false,'placeholder'=>'Enter Mobile Number','id'=>'phone','onkeypress'=> 'return isNumber(event);','required')); ?>
                  <span id="phonemessage" style="color:red; display:none">Mobile Number is already exist !</span> 
		          </div>
		        </div>  
				<div class="form-group">
		          <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
		          <div class="col-sm-8">
			      <?php echo $this->Form->input('contact_email', array('type'=>'text','class' =>'form-control','required','label'=>false,'placeholder'=>'Username','id'=>'myemail','required')); ?>
                   <span id="emailar" style="color:red; display:none">Email is already exist !</span> 		           
		          </div>
		        </div>
			
				<div class="form-group">
		          <label for="inputEmail3" class="col-sm-2 control-label">Registered Address</label>
		          <div class="col-sm-8">
			      <?php echo $this->Form->input('address', array('type'=>'text','class' =>'form-control','required','label'=>false,'placeholder'=>'Address','required')); ?>	           
		          </div>

		        </div>
				<div class="form-group">
		          <label for="inputEmail3" class="col-sm-2 control-label">Factory Address</label>
		          <div class="col-sm-8">
			      <?php echo $this->Form->input('factroy_address', array('type'=>'text','class' =>'form-control','required','label'=>false,'placeholder'=>'Address','required')); ?>	           
		          </div>
		        </div>

				<div class="form-group">
		          <label for="inputEmail3" class="col-sm-2 control-label">SMS</label>
		          <div class="col-sm-8">
			      <?php echo $this->Form->input('sms_mobile', array('type'=>'text','class' =>'form-control','required','label'=>false,'placeholder'=>'SMS Number','required')); ?>	           
		          </div>
		        </div>

				<div class="form-group">
		          <label for="inputEmail3" class="col-sm-2 control-label">Refferal Amount</label>
		          <div class="col-sm-8">
			      <?php echo $this->Form->input('referred_reward', array('type'=>'text','class' =>'form-control','required','label'=>false,'placeholder'=>'Refferal Amount','required')); ?>	           
		          </div>
		        </div>

	<h4 class="box-title"><i class="fa fa-plus-square" aria-hidden="true"></i> <?php  echo 'Address According to Pincode';  ?></h4>

				<div class="form-group">
		          <label for="inputEmail3" class="col-sm-2 control-label">Address 1</label>
		          <div class="col-sm-8">
			      <?php echo $this->Form->input('address_1', array('type'=>'text','class' =>'form-control','required','label'=>false,'placeholder'=>'Address','required')); ?>	           
		          </div>
		        </div>
				<div class="form-group">
		          <label for="inputEmail3" class="col-sm-2 control-label">Pincode</label>
		          <div class="col-sm-8">
			      <?php echo $this->Form->input('pincode_1', array('type'=>'text','class' =>'form-control','required','label'=>false,'placeholder'=>'Pincode','required')); ?>	           
		          </div>
		        </div>

				<div class="form-group">
		          <label for="inputEmail3" class="col-sm-2 control-label">Address 2</label>
		          <div class="col-sm-8">
			      <?php echo $this->Form->input('address_2', array('type'=>'text','class' =>'form-control','required','label'=>false,'placeholder'=>'Address','required')); ?>	           
		          </div>
		        </div>
				<div class="form-group">
		          <label for="inputEmail3" class="col-sm-2 control-label">Pincode</label>
		          <div class="col-sm-8">
			      <?php echo $this->Form->input('pincode_2', array('type'=>'text','class' =>'form-control','required','label'=>false,'placeholder'=>'Pincode','required')); ?>	           
		          </div>
		        </div>

				<div class="form-group">
		          <label for="inputEmail3" class="col-sm-2 control-label">Address 3</label>
		          <div class="col-sm-8">
			      <?php echo $this->Form->input('address_3', array('type'=>'text','class' =>'form-control','required','label'=>false,'placeholder'=>'Address','required')); ?>	           
		          </div>
		        </div>
				<div class="form-group">
		          <label for="inputEmail3" class="col-sm-2 control-label">Pincode</label>
		          <div class="col-sm-8">
			      <?php echo $this->Form->input('pincode_3', array('type'=>'text','class' =>'form-control','required','label'=>false,'placeholder'=>'Pincode','required')); ?>	           
		          </div>
		        </div>

<h4 class="box-title"><i class="fa fa-plus-square" aria-hidden="true"></i> <?php  echo 'Bank Details';  ?></h4>

				<div class="form-group">
		          <label for="inputEmail3" class="col-sm-2 control-label">Account Name</label>
		          <div class="col-sm-8">
			      <?php echo $this->Form->input('account_name', array('type'=>'text','class' =>'form-control','required','label'=>false,'placeholder'=>'Address','required')); ?>	           
		          </div>
		        </div>
				<div class="form-group">
		          <label for="inputEmail3" class="col-sm-2 control-label">Bank Name</label>
		          <div class="col-sm-8">
			      <?php echo $this->Form->input('bank_name', array('type'=>'text','class' =>'form-control','required','label'=>false,'placeholder'=>'Pincode','required')); ?>	           
		          </div>
		        </div>

				<div class="form-group">
		          <label for="inputEmail3" class="col-sm-2 control-label">Account Number</label>
		          <div class="col-sm-8">
			      <?php echo $this->Form->input('account_number', array('type'=>'text','class' =>'form-control','required','label'=>false,'placeholder'=>'Address','required')); ?>	           
		          </div>
		        </div>
				<div class="form-group">
		          <label for="inputEmail3" class="col-sm-2 control-label">IFSC Code</label>
		          <div class="col-sm-8">
			      <?php echo $this->Form->input('ifsc', array('type'=>'text','class' =>'form-control','required','label'=>false,'placeholder'=>'Pincode','required')); ?>	           
		          </div>
		        </div>

				<div class="form-group">
		          <label for="inputEmail3" class="col-sm-2 control-label">Branch</label>
		          <div class="col-sm-8">
			      <?php echo $this->Form->input('branch', array('type'=>'text','class' =>'form-control','required','label'=>false,'placeholder'=>'Address','required')); ?>	           
		          </div>
		        </div>
				

	<?php } ?>

		      	<!-- <div class="form-group">
			     <label for="inputEmail3" class="col-sm-2 control-label"></label>	
			    <div class="col-sm-10">
		        <a href="javascript:void(0)" class="chngpassword"  >Do you want to change password ?</a>
		        </div>  
		        </div>  
		        
		    <div class="passdata" style="display:none;">
		    <div class="form-group">
		    <label for="inputEmail3" class="col-sm-2 control-label">New Password<span style="color:red;">*</span></label>
		    <div class="col-sm-10">
			<?php echo $this->Form->input('new_password',array('class'=>'form-control input2','placeholder'=>'New Password', 'id'=>'password-field','label' =>false,'autocomplete'=>'off')); ?>
		    </div>
		    </div>
		    
			<div class="form-group">
		    <label for="inputEmail3" class="col-sm-2 control-label">Confirm Password<span style="color:red;">*</span></label>
		    <div class="col-sm-10">
			<?php echo $this->Form->input('confirm_passs',array('class'=>'form-control input3','placeholder'=>'Confirm Password', 'id'=>'confirm_pass','label' =>false,'autocomplete'=>'off')); ?>		           
		    </div>
		    </div>
		    
					
	       </div> close passdata--->
		        
		       
  
  </div>
  <!-- /.box-body -->
  <div class="box-footer">
			<?php
				if(isset($ntypes['id'])){
				echo $this->Form->submit(
				    'Update', 
				    array('class' => 'btn btn-info pull-right formsubmit', 'title' => 'Update')
				); }else{ 
				echo $this->Form->submit(
				    'Add', 
				    array('class' => 'btn btn-info pull-right', 'title' => 'Add')
				);
				}
		       ?>

		      </div>
 <?php echo $this->Form->end(); ?>
          </div>
    
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div> 
  
<!-- <script type="text/javascript">
 $(document).ready(function() {
  $(".formsubmit").click(function(){
  var oldpass = $('.input1').val();
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
	  $('#old_password').prop('required',false);
	 }
	 else{
	  $('#password-field').prop('required',true);
	  $('#confirm_pass').prop('required',true);
	  $('#old_password').prop('required',true);
	 }
    });
});

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 46 || charCode > 57 || charCode == 47)) {
       alert("Please Enter Only Numeric Characters!!!!");
        return false;
    }
    return true;

}
</script> -->


