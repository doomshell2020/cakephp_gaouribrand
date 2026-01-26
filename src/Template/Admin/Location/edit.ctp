<!-- <script>
   function checkextension() {
    var file = document.querySelector("#fUpload");
    if ( /\.(jpe?g|png|gif)$/i.test(file.files[0].name) === false ) 
      { alert("not an image please choose a image!");
    $('#fUpload').val('');
  }
  return false;
}
</script> -->
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
    State Manager
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo SITE_URL; ?>admin/dashboards"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo SITE_URL; ?>admin/state">Manage State</a></li>
      <?php if(isset($category['id'])){ ?>
        <li class="active"><a href="javascript:void(0)">Edit State</a></li>   
      <?php } else { ?>
        <li class="active"><a href="javascript:void(0)">Add State</a></li>
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
            <h3 class="box-title"><i class="fa fa-plus-square" aria-hidden="true"></i>Edit State</h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <?php echo $this->Form->create($state, array(
           'class'=>'form-horizontal',
           'enctype' => 'multipart/form-data',
           'validate'
         ));
        // pr($category); die;
         ?>
         <div class="box-body">
            <div class="form-group">
            <div class="col-sm-3">
              <label for="inputEmail3" class="control-label">State Name</label>
              <?php echo $this->Form->input('name', array('class' => 'form-control categoryname','required','label'=>false,'placeholder'=>'State Name','autofocus','autocomplete'=>'off')); ?>   
              <h5 id="msg" style="display:none;" class="text">**This State Is Already Exist</h5>
            </div>
            <?php echo $this->Form->input('cat_id', array('class' => 'form-control cat_id','label'=>false,'type'=>'hidden','value'=>$state['id'])); ?> 
         </div> <!-- /.form-group -->
         <!-- /.box-body -->
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
  $(document).ready(function(){
    $(".categoryname").on('keyup',function() {
      var stval=$(this).val();
      var cat_id = $('.cat_id').val();
//alert(cat_id); 
$.ajax({ 
  headers: { 'X-CSRF-Token': csrfToken },
  type: 'POST', 
  url: '<?php echo SITE_URL; ?>admin/state/checkcategory',
  data: {'categoryditname':stval,'cat_id':cat_id},
  success: function(data){  
    var obj = JSON.parse(data);
//alert(obj);
if (obj=='1') {
 $('#msg').css('display','block');
 $(".categoryname").val('');
 return false;
}if(obj=='2'){
  $('#msg').css('display','none');
}
},    
});
});
  });
</script>