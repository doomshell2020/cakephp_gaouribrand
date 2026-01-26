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
</style>

<div class="content-wrapper">
  <section class="content-header">
    <h1>
    FAQ Category Manager
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo SITE_URL; ?>admin/dashboards"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo SITE_URL; ?>admin/faq">Manage FAQ Category</a></li>
      <?php if(isset($companies['id'])){ ?>
        <li class="active"><a href="javascript:void(0)">Edit FAQ Category</a></li>   
      <?php } else { ?>
        <li class="active"><a href="javascript:void(0)">Add FAQ Category</a></li>
      <?php } ?>
    </ol>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-info">
          <?php echo $this->Flash->render(); ?>
          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-plus-square" aria-hidden="true"></i> <?php if(isset($faq_cat['id'])){ echo 'Edit FAQ'; }else{ echo 'Create FAQ';} ?></h3>
          </div>

          <?php echo $this->Form->create($faq_cat, array(
           'class'=>'form-horizontal',
           'enctype' => 'multipart/form-data',
           'validate'
         )); ?>
         <div class="box-body">
          <div class="form-group">
            <div class="col-sm-6">
              <label for="inputEmail3" class="control-label">Name</label>
              <?php echo $this->Form->input('name', array('class' => 'form-control','required','label'=>false,'placeholder'=>'Name','autofocus','autocomplete'=>'off')); ?>   
            </div>
            
            
            <!-- <div class="col-sm-4">
              <label for="inputEmail3" class="control-label">Upload Image</label>
              <?php echo $this->Form->input('image', array('class' =>'form-control','autocomplete' => 'off','label'=>false,'type'=>'file','id'=>'fUpload','onchange'=>'checkextension()','required')); ?>
            </div> -->


            <!-- <?php $opt = array('App'=>'App','Website' =>'Website');?>
            <div class="col-sm-4">
              <label for="inputEmail3" class="control-label">Type</label>
              <?php echo $this->Form->input('enquiry_type',array('class'=>
              'form-control','label'=>false,'type'=> 'select','options'=>$opt,'required','autofocus','disabled')); ?>
            </div> -->
          
          
          </div> 
        </div>
        <div class="box-footer">
          <?php
          if(isset($category['id'])){
            echo $this->Form->submit(
              'Update', 
              array('class' => 'btn btn-info pull-right', 'title' => 'Update')
            ); }else{ 
              echo $this->Form->submit(
                'Add', 
                array('class' => 'btn btn-info pull-right', 'title' => 'Add')
              );
            }
            ?><?php
            echo $this->Html->link('Back', [
              'action' => 'index'
              
            ],['class'=>'btn btn-default']); ?>
          </div>
          <?php echo $this->Form->end(); ?>
        </div>
      </div>
    </div>
  </section>
</div> 

