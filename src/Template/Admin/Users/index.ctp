<div class="content-wrapper">
 <section class="content-header">
  <h1>
   Users Manager
 </h1>
 <ol class="breadcrumb">
  <li><a href="<?php echo SITE_URL; ?>admin/dashboards"><i class="fa fa-home"></i>Home</a></li>
  <li><a href="<?php echo SITE_URL; ?>admin/users">Users</a></li>
</ol> 
</section> <!-- content header -->

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">    
      <div class="box">
        <div class="box-header">
          <?php echo $this->Flash->render(); ?>
          <a href="<?php echo SITE_URL; ?>admin/users/useradd">
            <button class="btn btn-success pull-right m-top10"><i class="fa fa-plus" aria-hidden="true"></i>
            Add User </button></a>
          </div><!-- /.box-header -->
          <div class="box-body">    
            <table class="table table-bordered table-striped" width="100%">
              <thead>
                <tr>
                  <th width="5%">S.No</th>                            
                  <th width="12%">Name</th> 
                  <th width="16%">Branch Name</th>
                  <th width="11%">Branch City</th>
                  <th width="17%">Email</th>  
                  <th width="10%">Mobile</th>                   
                  <th width="8%">Created</th>  
                  <th width="7%">Image</th>           
                  <th width="6%">Status</th>     
                  <th width="8%">Action</th>     
                </tr>
              </thead>
              <tbody>
                <?php 
                $page = $this->request->params['paging'][$this->request->params['controller']]['page'];
                $limit = $this->request->params['paging'][$this->request->params['controller']]['perPage'];
                $counter = ($page * $limit) - $limit + 1;
                if(isset($users) && !empty($users)){ 
                foreach($users as $users){//pr($category);die; ?>
                  <tr>
                    <td><?php echo $counter;?></td>
                    <td><?php echo $users['name'];  ?></td>
                    <td><?php 
                    if($users['store']){
                      echo $users['store']['address'];
                    }else{
                      echo "--";
                    }?>
                    <td><?php 
                    if($users['store']){
                      echo $users['store']['city'];
                    }else{
                      echo "--";
                    }?>
                    </td>
                    <td><?php echo $users['email'];  ?></td>
                    <td><?php echo $users['mobile'];  ?></td>            
                    <td><?php echo date('d-M-Y',strtotime($users['created'])); ?></td>
                    <td>
                    <?php if($users['image']) {?>
                    <img src="<?php echo SITE_URL; ?>images/user_images/<?php echo  $users['image']; ?>" width="70px">
                    <?php }else{ ?>
                      <img src="<?php echo SITE_URL; ?>img/noimage.jpeg" width="80px">
                    <?php } ?>
                    </td>
                    <td>
                      <?php if($users['status']=='1'){ 
                        echo $this->Html->link('', [
                          'action' => 'status',
                          $users->id,'0'
                        ],['title'=>'Active','class'=>'fa fa-check-circle','style'=>'font-size: 21px !important; margin-left: 12px;     color: #36cb3c;']);
                        
                      }else{ 
                        echo $this->Html->link('', [
                          'action' => 'status',$users->id,'1'
                        ],['title'=>'Inactive','class'=>'fa fa-times-circle-o','style'=>'font-size: 21px !important; margin-left: 12px; color:#FF5722;']);
                        
                      } ?>
                    </td>
                    
                    <td>
                     <?php  echo $this->Html->link(__(''), ['action' => 'useredit', $users->id,],array('class'=>'fa fa-pencil-square-o fa-lg','title'=>'Edit','style'=>'font-size: 20px !important; margin-left: 12px;')) ?>

                     <?php echo $this->Html->link('', ['action' => 'delete',$users->id],['title'=>'Delete','class'=> 'fa fa-trash','style'=>'color:#FF0000; margin-left: 13px; font-size: 19px !important;',"onClick"=>"javascript: return confirm('Are you sure do you want to delete this User')"]); ?>
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
 

