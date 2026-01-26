<div class="content-wrapper">
 <section class="content-header">
  <h1>
   Gallary Manager
    </h1>
    <ol class="breadcrumb">
    <li><a href="<?php echo SITE_URL; ?>admin/dashboards"><i class="fa fa-home"></i>Home</a></li>
    <li><a href="<?php echo SITE_URL; ?>admin/gallary">Gallary</a></li>
    </ol> 
    </section> <!-- content header -->
<!-- Main content -->
<section class="content">
    <div class="row">
    <div class="col-xs-12">    
    <div class="box">
    <div class="box-header">
    <?php echo $this->Flash->render(); ?>
<script>          
        $(document).ready(function () { 
        $("#Mysubscriptions").bind("submit", function (event) {
        $('.lds-facebook').show();
        $.ajax({//building search function
               async:true,
               data:$("#Mysubscriptions").serialize(),
               dataType:"html",
               type:"get",
               url:"<?php echo ADMIN_URL ;?>gallary/search",
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
        var res = target.replace("/gallary/search", "/gallary");
        window.location = res;

        return false;
        });
</script>

<?php echo $this->Form->create('Mysubscription',array('type'=>'get','inputDefaults'=>array('div'=>false,'label'=>false),'id'=>'Mysubscriptions','class'=>'form-horizontal','method'=>'get')); ?>

<div class="form-group" >
     <div class="col-sm-2">
        <label for="inputEmail3" class="control-label">Title</label> 
        <?php echo $this->Form->input('title',array('class'=>'form-control','label' =>false,'placeholder'=>'Search Title','autocomplete'=>'off','required')); ?>  
     </div> 
     <div class="col-sm-1">
        <label for="inputEmail3" class="control-label" style="color:white">Search</label>
        <input type="submit" style="background-color:#00c0ef;" id="Mysubscriptions" class="btn btn4 btn_pdf myscl-btn date" value="Search">       
     </div> 
       
<?php echo $this->Form->end(); ?> 
</div>  
         </div> 
          </div> 
          <!-- // Completed the search window above  -->
<div class="box">
    <div class="box-header">
    <a href="<?php echo SITE_URL; ?>admin/gallary/add">
            <button class="btn btn-success pull-right m-top10"><i class="fa fa-plus" aria-hidden="true"></i>
            Add Deatils </button></a>
    </div>
    <div class="box-body" id="example2">   
            <table class="table table-bordered table-striped" width="100%">
            <thead>
            <tr>
                  <th width="5%">S.No</th>                                   
                  <th width="12%">Title</th> 
                  <th width="12%">Featured Image</th> 
                  <th width="12%">Other Image</th> 
                  <th width="8%">Status</th>                 
                  <th width="8%">Created</th>   
            </tr>
            </thead>
            <tbody>  
            <?php 
                $counter=($this->request->params['paging']['gallary']['page']-1) * $this->request->params['paging']['gallary']['perPage']; 
                if(isset($Gallary) && !empty($Gallary)){ 
                foreach($Gallary as $gallary){?>
                  <tr>
                    <td><?php echo $gallary['id']; ?></td>
                    
                    <td><?php echo $gallary['title']; ?></td>
                    
                    <td>
                    <?php if($gallary['parent_id']) {?>
                    <img src="<?php echo SITE_URL; ?>images/gallary/<?php echo  $gallary['featured_image']; ?>" width="80px">
                    <?php }else{ ?>
                      <img src="<?php echo SITE_URL; ?>images/gallary/<?php echo  $gallary['featured_image']; ?>" width="80px">
                    <?php } ?>
                    </td>

                    <td>
                    <?php if($gallary['parent_id']) {?>
                    <img src="<?php echo SITE_URL; ?>images/gallary/others<?php echo  $gallary['other_image']; ?>" width="80px">
                    <?php }else{ ?>
                      <img src="<?php echo SITE_URL; ?>images/gallary/others<?php echo  $gallary['other_image']; ?>" width="80px">
                    <?php } ?>
                    </td>

                    <td><?php echo date('d-M-Y',strtotime($gallary['created'])); ?></td>
                    
                    <td>
                    <?php if($gallary['status']=='Y'){ 
                        echo $this->Html->link('', [
                          'action' => 'status',
                          $gallary->id,'N'
                        ],['title'=>'Active','class'=>'fa fa-check-circle','style'=>'font-size: 21px !important; margin-left: 12px; color: #36cb3c;']);  
                      }else{ 
                        echo $this->Html->link('', [
                          'action' => 'status',$gallary->id,'Y'
                        ],['title'=>'Inactive','class'=>'fa fa-times-circle-o','style'=>'font-size: 21px !important; margin-left: 12px; color:#FF5722;']); 
                      } ?>
                     <?php  echo $this->Html->link(__(''), ['action' => 'edit', $gallary->id,],array('class'=>'fa fa-pencil-square-o fa-lg','title'=>'Edit','style'=>'font-size: 20px !important; margin-left: 12px;')) ?>

                     <?php echo $this->Html->link('', ['action' => 'delete',$gallary->id],['title'=>'Delete','class'=> 'fa fa-trash','style'=>'color:#FF0000; margin-left: 13px; font-size: 19px !important;',"onClick"=>"javascript: return confirm('Are you sure do you want to delete this gallary')"]); ?>
                   </td>
                    </tr>
                    <?php $counter++;} } ?>  
                    </tbody>
                    </table>
                    <?php echo $this->element('admin/pagination'); ?> 
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
 


                    