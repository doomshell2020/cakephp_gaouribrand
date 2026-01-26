


<div class="content-wrapper">
    <!-- Content Header  header) -->
      <section class="content-header">
          <h1>
      static Manager
          </h1>
<ol class="breadcrumb">
<li><a href="<?php echo SITE_URL; ?>admin/dashboards"><i class="fa fa-home"></i>Home</a></li>
<li><a href="<?php echo SITE_URL; ?>admin/static">Manage static</a></li> 
<li class="active"><a href="<?php echo SITE_URL; ?>admin/static/add">Add static</a></li>
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
          <h3 class="box-title"><i class="fa fa-plus-square" aria-hidden="true"></i> <?php echo 'Create static'; ?></h3>
        </div>
            <!-- /.box-header -->
            <!-- form start -->
    <?php echo $this->Form->create('static',array(
         'class'=>'form-horizontal',
         'controller'=>'static',
         'action'=>'add',
         'enctype' => 'multipart/form-data',
         'validate' )); ?>
 <div class="box-body">
  <div class="container-fluid">
    <div class="form-group" style="width: 50%;">
    <label for="inputEmail3" class="control-label">Title</label>
      <?php echo $this->Form->input('title', array('class' =>'form-control','placeholder'=>'Title','required','label'=>false,'autocomplete'=>'off','onkeypress'=>'return isSpecial()','id'=>'postTitle')); ?>
      <h5 id="msg" style="display:none;" class="text">**Special characters not acceptable</h5>

       <?php echo $this->Form->input('slug', array('id'=>'permalink','label'=>false,'autocomplete'=>'off','id'=>'permalink','type'=>'hidden')); ?>   
    </div>

    <div class="form-group" style="width: 60%;">
    <label for="inputEmail3" class="control-label">Description</label>
      <?php echo $this->Form->input('content', array('class' =>'form-control','placeholder'=>'Content','required','label'=>false,'type'=>'textarea','autocomplete'=>'off','id'=>'summernote')); ?>
    </div>

   
  </div>
  </div>
  <!-- /.box-body -->
          <div class="box-footer">
      <?php
        if(isset($companies['id'])){
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


    <script src="<?php echo SITE_URL; ?>js/slugger.js"></script>
  <script>

   $('#postTitle').keyup(function(){
     $('#permalink').val('');

   });
   $('#permalink').slugger({
    source: '#postTitle',
    prefix: '',
    suffix:'',

  });

</script>