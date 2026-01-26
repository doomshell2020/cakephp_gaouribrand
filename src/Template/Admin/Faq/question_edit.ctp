
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
  <section class="content-header">
    <h1>
      FAQ Question Manager
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo SITE_URL; ?>admin/dashboards"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo SITE_URL; ?>admin/question_edit">Manage FAQ Question</a></li>
      <?php if(isset($FaqCatQuestion['id'])){ ?>
        <li class="active"><a href="javascript:void(0)">Edit FAQ Question</a></li>   
      <?php } else { ?>
        <li class="active"><a href="javascript:void(0)">Add FAQ Question</a></li>
      <?php } ?>
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
            <h3 class="box-title"><i class="fa fa-plus-square" aria-hidden="true"></i> Edit FAQ Question</h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <?php echo $this->Form->create($FaqCatQuestion, array(
           'class'=>'form-horizontal',
           'enctype' => 'multipart/form-data',
           'validate'
         ));
        //  pr($FaqCatQuestion); die;
         ?>
         <div class="box-body">
            <div class="form-group">
            <div class="col-sm-8">
          
          <label for="inputEmail3" class="control-label">Question Category</label>
               <?php echo $this->Form->input('faq_cat_id', array('class' => 
                'form-control','id'=>'cate','label'=>false,'options'=>$faq_cat,'empty'=>'--Select Category--','required','autofocus')); ?>
            </div>
            <div class="col-sm-8">
              <label for="inputEmail3" class="control-label">Update Question</label>
              <?php echo $this->Form->input('question', array('class' => 'form-control','required','label'=>false,'placeholder'=>'Update Question','autofocus','autocomplete'=>'off')); ?>   
            </div>
            
            <div class="col-sm-8">
              <label for="inputEmail3" class="control-label">Update Answer</label>
              <?php echo $this->Form->input('answer', array('class' => 'form-control','required','label'=>false,'placeholder'=>'Update Answer','autofocus','autocomplete'=>'off')); ?>   
            </div>




         </div> <!-- /.form-group -->
         <!-- /.box-body -->
         <div class="box-footer">
          <?php
          if(isset($FaqCatQuestion['id'])){
            echo $this->Form->submit(
              'Update', 
              array('class' => 'btn btn-info pull-right', 'title' => 'Update')
            ); }else{ 
              echo $this->Form->submit(
                'Add', 
                array('class' => 'btn btn-info pull-right', 'title' => 'Add')
              );
            }
            
            ?><br><?php
            echo $this->Html->link('Back', [
              'action' => 'question'
              
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


