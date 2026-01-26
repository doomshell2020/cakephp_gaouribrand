
<style type="text/css">
 .text{
  color:red; 
  font-size: 12px;
}
</style>

<div class="content-wrapper">
  <section class="content-header">
    <h1>
    FAQ Question Manager
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo SITE_URL; ?>admin/dashboards"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo SITE_URL; ?>admin/faq/question">Manage FAQ Questions</a></li>
      <?php if(isset($companies['id'])){ ?>
        <li class="active"><a href="javascript:void(0)">Edit FAQ Questions</a></li>   
      <?php } else { ?>
        <li class="active"><a href="javascript:void(0)">Add FAQ Questions</a></li>
      <?php } ?>
    </ol>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-info">
          <?php echo $this->Flash->render(); ?>
          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-plus-square" aria-hidden="true"></i> <?php if(isset($faq_cat_question['id'])){ echo 'Edit FAQ'; }else{ echo 'Create FAQ';} ?></h3>
          </div>

          <?php echo $this->Form->create($faq_cat_question, array(
           'class'=>'form-horizontal',
           'enctype' => 'multipart/form-data',
           'validate'
         )); ?>
            
            
           
            <div class="box-body">
            <div class="col-sm-3">
              <label for="inputEmail3" class="control-label">Question Category</label>
              <?php echo $this->Form->input('faq_cat_id',array('class'=>
              'form-control','label'=>false,'type'=> 'select','options'=>$faq_cat,'empty'=>'--Select Service--','required','autofocus')); ?>
            </div>


         <div class="box-body">
          <div class="form-group">
            <div class="col-sm-12">
              <label for="inputEmail3" class="control-label">Question</label>
              <?php echo $this->Form->input('question', array('class' => 'form-control','required','label'=>false,'placeholder'=>'Question?','autofocus','autocomplete'=>'off')); ?>   
           
            
            <div style="width: 60%;">
            <label for="inputEmail3" class="control-label">Answer</label>
            <?php echo $this->Form->input('answer', array('class' =>'form-control','placeholder'=>'Answer Here','required','label'=>false,'type'=>'textarea','autocomplete'=>'off','id'=>'summernote')); ?>
            </div>


          
          
          
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

