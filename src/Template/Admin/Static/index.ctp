 <style type="text/css">
   th{
text-align: center;
   }
   td{
    text-align: center;

   }
 </style>
 <div class="content-wrapper">
   <section class="content-header">
    <h1>
         Static Manager
    </h1>
    <ol class="breadcrumb">
    <li><a href="<?php echo SITE_URL; ?>admin/dashboards"><i class="fa fa-home"></i>Home</a></li>
<li><a href="<?php echo SITE_URL; ?>admin/static">static</a></li>
    </ol> 
    </section> <!-- content header -->

    <!-- Main content -->
    <section class="content">
  <div class="row">
    <div class="col-xs-12">    
  <div class="box">
    <div class="box-header">
  <?php echo $this->Flash->render(); ?>
    <a href="<?php echo SITE_URL; ?>admin/static/add">
    <button class="btn btn-success pull-right m-top10"><i class="fa fa-plus" aria-hidden="true"></i>
    Add static Page </button></a>
     </div><!-- /.box-header -->
      <div class="box-body">    
              <table class="table table-bordered table-striped" width="100%">
                <thead>
                <tr>
                  <th>S.No</th>                          
                  <th>Title</th>   
                   <th>Description</th>      
                  <th>Created</th>    
                  <th>Status</th>    
                  </tr>
                </thead>
                <tbody>
                <?php 
                $page = $this->request->params['paging'][$this->request->params['controller']]['page'];
                $limit = $this->request->params['paging'][$this->request->params['controller']]['perPage'];
                $counter = ($page * $limit) - $limit + 1;
                if(isset($static) && !empty($static)){ 
                foreach($static as $value){//pr($value);die;
                ?>
                <tr>
                <td><?php echo $counter;?></td>
                <td><?php echo $value['title'];  ?></td>
          <td> 
            <?php $string = strip_tags($value['content']);?>
<p>
  <span id="more<?php echo $value['id']; ?>" style="display: none;"><?php echo $string; ?>
</span>
<a href="javascript:void(0);" id="myBtn<?php echo $value['id']; ?>">View</a>
<a style="display: none;" href="javascript:void(0);" id="less<?php echo $value['id']; ?>">Close</a>
</p></td>

<script type="text/javascript">
$(document).ready(function(){
$('#myBtn<?php echo $value['id']; ?>').click(function(){

     $("#dots<?php echo $value['id']; ?>").css({ display: "none" });  
       $("#more<?php echo $value['id']; ?>").css({ display: "block" });
       $("#myBtn<?php echo $value['id']; ?>").css({ display: "none" });
       $("#less<?php echo $value['id']; ?>").css({ display: "block" });

});
});
</script>

<script type="text/javascript">
$(document).ready(function(){
$('#less<?php echo $value['id']; ?>').click(function(){

     $("#dots<?php echo $value['id']; ?>").css({ display: "block" });
       $("#more<?php echo $value['id']; ?>").css({ display: "none" });
       $("#myBtn<?php echo $value['id']; ?>").css({ display: "block" });
       $("#less<?php echo $value['id']; ?>").css({ display: "none" });

});
});
</script>

                 
                <td><?php echo date('d-m-Y',strtotime($value['created_date'])); ?></td>
           
    <td>
     <?php  echo $this->Html->link(__(''), ['action' => 'edit', $value->id,],array('class'=>'fa fa-pencil-square-o fa-lg','title'=>'Edit','style'=>'font-size: 20px !important; margin-left: 12px;')) ?>

                    
                    
     
                      <?php if($value['status']=='Y'){ 
                        echo $this->Html->link('', [
                          'action' => 'status',
                          $value->id,'N'
                        ],['title'=>'Active','class'=>'fa fa-check-circle','style'=>'font-size: 21px !important; margin-left: 12px;     color: #36cb3c;']);
                        
                      }else{ 
                        echo $this->Html->link('', [
                          'action' => 'status',$value->id,'Y'
                        ],['title'=>'Inactive','class'=>'fa fa-times-circle-o','style'=>'font-size: 21px !important; margin-left: 12px; color:#FF5722;']);
                        
                      } ?>
                    
                    <?php
                    echo $this->Html->link('', ['action' => 'delete',$value->id],['title'=>'Delete','class'=> 'fa fa-trash','style'=>'color:#FF0000; margin-left: 13px; font-size: 19px !important;',"onClick"=>"javascript: return confirm('Are you sure do you want to delete this static Category?')"]); ?>
                    
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
     
     

