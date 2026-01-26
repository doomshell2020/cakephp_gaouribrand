<div class="content-wrapper">
 <section class="content-header">
  <h1>
  Notification Manager
 </h1>
 <ol class="breadcrumb">
  <li><a href="<?php echo SITE_URL; ?>admin/dashboards"><i class="fa fa-home"></i>Home</a></li>
  <li><a href="<?php echo SITE_URL; ?>admin/notification">Notification</a></li>
</ol> 
</section> <!-- content header -->

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">    
      <div class="box">
        <div class="box-header">
          <?php echo $this->Flash->render(); ?>
          <a href="<?php echo SITE_URL; ?>admin/notification/add">
            <button class="btn btn-success pull-right m-top10"><i class="fa fa-plus" aria-hidden="true"></i>
            Add Notification </button></a>
          </div><!-- /.box-header -->
          <div class="box-body">    
            <table class="table table-bordered table-striped" width="100%">
              <thead>
                <tr>
                  <th width="5%">S.No</th>                            
                  <th width="20%">Title</th>   
                  <th width="20%">Message</th>                   
                  <th width="15%">Created</th>       
                  <th width="15%">Status</th>          
                  <th width="15%">Action</th>     
                </tr>
              </thead>
              <tbody>
                <?php 
                $page = $this->request->params['paging'][$this->request->params['controller']]['page'];
                $limit = $this->request->params['paging'][$this->request->params['controller']]['perPage'];
                $counter = ($page * $limit) - $limit + 1;
                if(isset($notifications) && !empty($notifications)){ 
                foreach($notifications as $notification){//pr($states);die;?>
                  <tr>
                    <td><?php echo $counter;?></td>
                    <td><?php echo $notification['title']; ?></td>
                    <td><?php echo $notification['message']; ?></td>
                    <td><?php echo date('d-M-Y',strtotime($notification['created'])); ?></td>
                    <td>
                      <?php if($notification['status']=='1'){ 
                        echo $this->Html->link('', [
                          'action' => 'status',
                          $notification->id,'0'
                        ],['title'=>'Active','class'=>'fa fa-check-circle','style'=>'font-size: 21px !important; margin-left: 12px; color: #36cb3c;']);
                      }else{ 
                        echo $this->Html->link('', [
                          'action' => 'status',$notification->id,'1'
                        ],['title'=>'Inactive','class'=>'fa fa-times-circle-o','style'=>'font-size: 21px !important; margin-left: 12px; color:#FF5722;']);
                      } ?>
                    </td>
                    <td>
                     <?php echo $this->Html->link('', ['action' => 'delete',$notification->id],['title'=>'Delete','class'=> 'fa fa-trash','style'=>'color:#FF0000; margin-left: 13px; font-size: 19px !important;',"onClick"=>"javascript: return confirm('Are you sure do you want to delete this notification')"]); ?>
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
 

