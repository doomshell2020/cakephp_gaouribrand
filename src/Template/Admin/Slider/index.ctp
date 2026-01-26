<div class="content-wrapper">
 <section class="content-header">
  <h1>
  Slider Manager
 </h1>
 <ol class="breadcrumb">
  <li><a href="<?php echo SITE_URL; ?>admin/dashboards"><i class="fa fa-home"></i>Home</a></li>
  <!-- <li><a href="<?php echo SITE_URL; ?>admin/slider">Slider</a></li> -->
</ol> 
</section> <!-- content header -->

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">    
      <div class="box">
        <div class="box-header">
          <?php echo $this->Flash->render(); ?>
          <a href="<?php echo SITE_URL; ?>admin/slider/add">
            <button class="btn btn-success pull-right m-top10"><i class="fa fa-plus" aria-hidden="true"></i>
            Add Slider </button></a>
          </div><!-- /.box-header -->
          <div class="box-body">    
            <table class="table table-bordered table-striped" width="100%">
              <thead>
                <tr>
                  <th width="5%">S.No</th>                            
                  <th width="20%">Name</th>                     
                  <th width="15%">Image</th> 
                  <!-- <th width="15%">Type</th>  -->
                  <th width="15%">Created</th>       
                  <th width="15%">Status</th>                                
                </tr>
              </thead>
              <tbody>
                <?php 
                $page = $this->request->params['paging'][$this->request->params['controller']]['page'];
                $limit = $this->request->params['paging'][$this->request->params['controller']]['perPage'];
                $counter = ($page * $limit) - $limit + 1;
                if(isset($slider) && !empty($slider)){ 
                foreach($slider as $slider){
                    //pr($slider);die;?>
                  <tr>
                    <td><?php echo $counter;?></td>

                    <td><?php echo ucfirst(strtolower($slider['name'])); ?></td>

                    <!-- <td>
                      <img src="<?php echo SITE_URL; ?>images/image/<?php echo  $slider['image']; ?>" width="80px">
                    </td> -->

                    <td>
                    <?php if($slider['parent_id']) {?>
                    <img src="<?php echo SITE_URL; ?>images/image/<?php echo  $slider['image']; ?>" width="80px">
                    <?php }else{ ?>
                      <img src="<?php echo SITE_URL; ?>images/image/<?php echo  $slider['image']; ?>" width="80px">
                    <?php } ?>
                    </td>

                    <!-- <td><?php echo $slider['slider_type']; ?></td> -->
                    <td><?php echo date('d-M-Y',strtotime($slider['created'])); ?></td>

                    

                    <td>
                      <?php if($slider['status']=='Y'){ 
                        echo $this->Html->link('', [
                          'action' => 'status',
                          $slider->id,'N'
                        ],['title'=>'Active','class'=>'fa fa-check-circle','style'=>'font-size: 21px !important; margin-left: 12px;     color: #36cb3c;']);
                        
                      }else{ 
                        echo $this->Html->link('', [
                          'action' => 'status',$slider->id,'Y'
                        ],['title'=>'Inactive','class'=>'fa fa-times-circle-o','style'=>'font-size: 21px !important; margin-left: 12px; color:#FF5722;']);
                        
                      } ?>
                    
                   
                     <?php  echo $this->Html->link(__(''), ['action' => 'edit', $slider->id,],array('class'=>'fa fa-pencil-square-o fa-lg','title'=>'Edit','style'=>'font-size: 20px !important; margin-left: 12px;')) ?>

                     <?php echo $this->Html->link('', ['action' => 'delete',$slider->id],['title'=>'Delete','class'=> 'fa fa-trash','style'=>'color:#FF0000; margin-left: 13px; font-size: 19px !important;',"onClick"=>"javascript: return confirm('Are you sure do you want to delete this Slider')"]); ?> 
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
 

