
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
      FAQ Manager
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo SITE_URL; ?>admin/dashboards"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo SITE_URL; ?>admin/faq_cat">Manage FAQ</a></li>
      <?php if(isset($faq_cat['id'])){ ?>
        <li class="active"><a href="javascript:void(0)">Edit FAQ</a></li>   
      <?php } else { ?>
        <li class="active"><a href="javascript:void(0)">Add FAQ</a></li>
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
            <h3 class="box-title"><i class="fa fa-plus-square" aria-hidden="true"></i> Edit FAQ</h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <?php echo $this->Form->create($faq_cat, array(
           'class'=>'form-horizontal',
           'enctype' => 'multipart/form-data',
           'validate'
         ));
        // pr($faq_cat); die;
         ?>
         <div class="box-body">
            <div class="form-group">
            <div class="col-sm-12">
              <label for="inputEmail3" class="control-label">Name</label>
              <?php echo $this->Form->input('name', array('class' => 'form-control','required','label'=>false,'placeholder'=>'Update Name','autofocus','autocomplete'=>'off')); ?>   
            </div>


            <!-- <div class="col-sm-3">
              <label for="exampleInputFile">Edit Image</label>
              <?php if($faq_cat['image']){ ?>
                <?php echo $this->Form->input('image', array('class' => 
                'form-control','autocomplete' => 'off','label'=>false,'type'=>'file','id'=>'fUpload','onchange'=>'checkextension()')); ?>
                  <img src="<?php echo SITE_URL;?>images/faq_cats/<?php echo $faq_cat['image']; ?>" height="100px" width="100px">
              <?php }else{ ?>
               <?php echo $this->Form->input('image', array('class' => 
               'form-control','autocomplete' => 'off','label'=>false,'type'=>'file','id'=>'fUpload','onchange'=>'checkextension()','required')); ?>
             <?php } ?>
           </div> -->
           

          <!--  <div class="col-sm-3">
              <label for="exampleInputFile">Edit Image</label>
              <?php if($faq_cat['image']){ ?>
                <?php echo $this->Form->input('image', array('class' => 
                'form-control','autocomplete' => 'off','label'=>false,'type'=>'file','id'=>'fUpload','onchange'=>'checkextension()')); ?>
                <?php if($faq_cat['parent_id']) {?>
                <img src="<?php echo SITE_URL;?>images/image/<?php echo $faq_cat['image']; ?>" height="100px" width="100px">
                <?php }else{ ?>
                  <img src="<?php echo SITE_URL;?>images/image/<?php echo $faq_cat['image']; ?>" height="100px" width="100px">
                <?php } ?>

              <?php }else{ ?>
               <?php echo $this->Form->input('image', array('class' => 
               'form-control','autocomplete' => 'off','label'=>false,'type'=>'file','id'=>'fUpload','onchange'=>'checkextension()','required')); ?>
             <?php } ?>
           </div> -->

         </div> <!-- /.form-group -->
         <!-- /.box-body -->
         <div class="box-footer">
          <?php
          if(isset($faq_cat['id'])){
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


