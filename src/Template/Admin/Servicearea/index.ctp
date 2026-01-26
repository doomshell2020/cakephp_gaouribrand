<div class="content-wrapper">
 <section class="content-header">
  <h1>
   Location Manager
 </h1>
 <ol class="breadcrumb">
  <li><a href="<?php echo SITE_URL; ?>admin/dashboards"><i class="fa fa-home"></i>Home</a></li>
  <li><a href="<?php echo SITE_URL; ?>admin/location">Location</a></li>
</ol> 
</section> <!-- content header -->

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">    
    <div class="box">
    <div class="box-header">
    <?php echo $this->Flash->render(); ?>
  <?php $role_id=$this->request->session()->read('Auth.User.role_id'); ?>
          <!-- <script>          
    $(document).ready(function () { 
    $("#Mysubscriptions").bind("submit", function (event) {
    $('.lds-facebook').show();
    $.ajax({
                async:true,
                data:$("#Mysubscriptions").serialize(),
                dataType:"html",
                type:"get",
                url:"<?php echo ADMIN_URL ;?>product/search",
                success:function (data) {
          $('.lds-facebook').hide();   
                $("#example2").html(data); },
                });
                return false;
              });
            });


  $(document).on('click', '.pagination a', function(e) {
  var target = $(this).attr('href');
  //alert(target);
  var res = target.replace("/product/search", "/product");
  window.location = res;

  return false;
  });
  </script>

  <?php echo $this->Form->create('Mysubscription',array('type'=>'get','inputDefaults'=>array('div'=>false,'label'=>false),'id'=>'Mysubscriptions','class'=>'form-horizontal','method'=>'get')); ?>
      
      <div class="form-group" >
      <div class="col-sm-2">
          <label for="inputEmail3" class="control-label">Name</label> 
          <?php echo $this->Form->input('name',array('class'=>'form-control','label' =>false,'placeholder'=>'Name','autocomplete'=>'off')); ?>  
        </div> 
        <div class="col-sm-2">
            <label for="inputEmail3" class="control-label">Select Category</label>
                <?php echo $this->Form->input('name', array('class' => 
                  'form-control','id'=>'cate','label'=>false,'options'=>$categoryname,'empty'=>'--Select Category--','autofocus')); ?>
              </div>

          <div class="col-sm-1">
        <label for="inputEmail3" class="control-label" style="color:white">Search</label>
        <input type="submit" style="background-color:#00c0ef;" id="Mysubscriptions" class="btn btn4 btn_pdf myscl-btn date" value="Search">       
      </div> 
        <?php echo $this->Form->end(); ?> 
        </div>  
          </div> 
            </div>  -->

      <!-- <div class="box"> -->
        <!-- <div class="box-header">
            <a href="<?php echo SITE_URL; ?>admin/product/add">
              <button class="btn btn-success pull-right m-top10"><i class="fa fa-plus" aria-hidden="true"></i>
              Add Product </button></a>
              </div> -->
          <div class="box-body" >   
            <table class="table table-bordered table-striped" width="100%">
              <thead>
              <tr>
                  <th width="5%">S.No</th>                            
                  <!-- <th width="10%">Name</th> 
                  <th width="15%">Email</th>  
                  <th width="10%">Mobile</th>                    -->
                  <th width="10%">Location Name</th>  
                  <!-- <th width="5%">Animals</th> 
                  <th width="10%">Milk Quantity</th> 
                  <th width="10%">Created</th> 
                  <th width="8%">Status</th>      -->
                  <th width="10%">Action</th>     

                </tr>
              </thead>
              <tbody>
                <?php 
                $counter=($this->request->params['paging']['Products']['page']-1) * $this->request->params['paging']['Products']['perPage']; 
                if(isset($locations) && !empty($locations)){ 
                foreach($locations as $locations){ //pr($locations);die;?>
                  <tr>
                    <td><?php echo $counter+1;?></td>      
                    <td><?php echo ucwords(strtolower($locations['name']));  ?></td> 
                    <td>
                    <?php echo $this->Html->link(__(''), ['action' => 'servicearea', $locations['id']], array('class' => 'fa fa-map-marker', 'title' => 'Edit', 'style' => 'font-size:20px;margin-right:5px; color:red')) ?>
                 </tr>
                 <?php $counter++;} } ?>  
               </tbody>
             </table>
                      
           </div>
                      
           <!-- /.box-body -->
         </div>
         <!-- /.box -->
       </div>
       <!-- /.col -->  
     </div>
     <!-- /.row -->      
   </section>
   <!-- /.content -->  
   
 </div>     
 <!-- /.   content-wrapper -->  
 

