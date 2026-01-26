<div class="content-wrapper">
 <section class="content-header">
  <h1>
  Order Detail
 </h1>
 <ol class="breadcrumb">
  <li><a href="<?php echo SITE_URL; ?>admin/dashboards"><i class="fa fa-home"></i>Home</a></li>
  <li><a href="<?php echo SITE_URL; ?>admin/order">Orders</a></li>
</ol> 
</section> <!-- content header -->

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">    
      <div class="box">
        <div class="box-header">
          <?php echo $this->Flash->render(); ?>
          </div><!-- /.box-header -->
          <div class="box-body">    
            <table class="table table-bordered table-striped" width="100%">
              <thead>
                <tr>
                  <th>S.No</th>                            
                  <th>Product Name</th>   
                  <th>Weight</th> 
                  <th>Price</th>    
                  <th>Quantity</th> 
                  <th>Total Price</th>            
                </tr>
              </thead>
              <tbody>
                <?php 
                $page = $this->request->params['paging'][$this->request->params['controller']]['page'];
                $limit = $this->request->params['paging'][$this->request->params['controller']]['perPage'];
                $counter = ($page * $limit) - $limit + 1;
                $total_price = 0;
                $total_qty = 0;
                $total = 0;
                if(isset($orders) && !empty($orders)){ 
                foreach($orders as $order){//pr($orders);die;
                    $product=$this->Comman->product($order['product_id']);
                    $total_price += $order['product_price'];
                    $total_qty += $order['quantity'];
                    $total += $order['product_price']*$order['quantity'];
                ?>
                  <tr>
                    <td><?php echo $counter;?></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo $order['weight']; ?></td>
                    <td><?php echo $order['product_price']; ?></td>
                    <td><?php echo $order['quantity']; ?></td>
                    <td><?php echo $order['product_price']*$order['quantity']; ?></td>

                 </tr>
                 <?php $counter++;} } ?>  

                 <tr>
                    <td></td>
                    <td></td>
                    <td><b>Total</b></td>
                    <td><b><?php echo $total_price; ?></b></td>
                    <td><b><?php echo $total_qty; ?></b></td>
                    <td><b style="font-size: 15px;"><?php echo $total; ?></b></td>
                    <td></td>
                 </tr>
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
 

