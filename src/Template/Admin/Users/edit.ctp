<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	    <section class="content-header">
		      <h1>
			Subscription Manager
		      </h1>
<ol class="breadcrumb">
<li><a href="<?php echo SITE_URL; ?>admin/visitors/index"><i class="fa fa-home"></i>Home</a></li>
<li><a href="<?php echo SITE_URL; ?>admin/subscriptions/index">Manage Subscription</a></li>
<li class="active"><a href="javascript:void(0)">Edit Subscription</a></li>
	      </ol>
	    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
       
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
		    <div class="box-header with-border">
		      <h3 class="box-title"><i class="fa fa-plus-square" aria-hidden="true"></i> Edit Subscription</h3>
		    </div>
            <!-- /.box-header -->
            <!-- form start -->
		<?php echo $this->Form->create($subscription, array(
                       'class'=>'form-horizontal',
                       'enctype' => 'multipart/form-data',
                       'validate'
                     	)); ?>
 <div class="box-body">
	 
  <div class="form-group">
    <div class="col-sm-4">
    <label for="inputEmail3" class="control-label">Subscription Name<span style="color:red;">*</span></label>
    </div>  
     <div class="col-sm-8"> 
    <?php echo $this->Form->input('name',array('class'=>'form-control','placeholder'=>'Subscription Name','maxlength'=>'20','required'=>true,'label' =>false)); ?>
    </div>     
  </div>
  
    <div class="form-group">
    <div class="col-sm-4">
    <label for="inputEmail3" class="control-label">Price<span style="color:red;">*</span></label>
    </div>  
     <div class="col-sm-8"> 
    <?php echo $this->Form->input('price',array('class'=>'form-control','onkeypress'=>'return isNumber(event);','placeholder'=>'Subscription Price','maxlength'=>'20','required'=>true,'label' =>false)); ?>
    <span id="showmsg" style="color:red;display:none">Please Enter Only Numeric Characters!!!!</span>
    </div>     
  </div>
  
    <div class="form-group">
    <div class="col-sm-4">
    <label for="inputEmail3" class="control-label">Duration<span style="color:red;">*</span></label>
    </div>  
     <div class="col-sm-8"> 
     <?php $options=array('1'=>'Monthly','3'=>'Quarterly','6'=>'Half Yearly','12'=>'Yearly');
            echo $this->Form->input('duration', array('class' => 'form-control','empty'=>'Select Duration','options'=>$options,'required','label'=>false)); ?>
    </div>     
  </div>
  </div>
  <!-- /.box-body -->
		      <div class="box-footer">
			<?php
				echo $this->Form->submit(
				    'Update', 
				    array('class' => 'btn btn-info pull-right', 'title' => 'Update')
				);
		       ?>
		       	<?php
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
<script>
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 46 || charCode > 57 || charCode == 47)) {
       document.getElementById("showmsg").style.display = "block";
        return false;
    }
    return true;

}
</script>

