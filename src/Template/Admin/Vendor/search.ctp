<table class="table table-bordered table-striped" width="100%">
              <thead>
                <tr>
                  <th width="5%">S.No</th>                            
                  <th width="13%">Name</th> 
                  <th width="14%">Product Category</th> 
                  <th width="5%">MRP</th>    
                  <th width="6%">Net Price</th> 
                  <th width="5%">Margin</th>  
                  <th width="6%">Weight(%)</th> 
                  <th width="5%">CGST(%)</th> 
                  <th width="5%">SGST(%)</th> 
                  <th width="5%">IGST(%)</th>                
                  <th width="7%">Image</th> 
                  <th width="8%">Created</th>       
                  <th width="6%">Fright Free</th>          
                  <th width="12%">Action</th>     
                </tr>
              </thead>
              <tbody>
                <?php 
                $counter=($this->request->params['paging']['Products']['page']-1) * $this->request->params['paging']['Products']['perPage']; 
                if(isset($products) && !empty($products)){ 
                foreach($products as $product){//pr($product);die;?>
                  <tr>
                    <td><?php echo $counter+1;?></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo $product['category']['name']; ?></td>
                    <td><?php echo $product['mrp']; ?></td>
                    <td><?php echo $product['net_price']; ?></td>
                    <td><?php echo $product['margin']; ?></td>
                    <td>
                    <?php echo $product['weight']/1000; ?> kg
                    </td>
                    <td><?php echo $product['gst']['cgst']; ?></td>
                    <td><?php echo $product['gst']['sgst']; ?></td>
                    <td><?php echo $product['gst']['igst']; ?></td>
                    <td><?php if($product['image']) {?>
                      <img src="<?php echo SITE_URL; ?>images/products/<?php echo  $product['image']; ?>" width="80px">
                    <?php }else{?>
                      <img src="<?php echo SITE_URL; ?>images/noimage.png" width="80px">
                    <?php } ?>
                    </td>
                    <td><?php echo date('d-M-Y',strtotime($product['created'])); ?></td>

                    
                    <td>
                      <?php if($product['freightfree']=='yes'){ 
                      echo "Yes";
                      }else{ 
                       echo "No";
                      } ?>
                    </td>
                    <td>
                    <?php if($product['status']=='Y'){ 
                        echo $this->Html->link('', [
                          'action' => 'status',
                          $product->id,'N'
                        ],['title'=>'Active','class'=>'fa fa-check-circle','style'=>'font-size: 21px !important; margin-left: 12px; color: #36cb3c;']);  
                      }else{ 
                        echo $this->Html->link('', [
                          'action' => 'status',$product->id,'Y'
                        ],['title'=>'Inactive','class'=>'fa fa-times-circle-o','style'=>'font-size: 21px !important; margin-left: 12px; color:#FF5722;']);
                        
                      } ?>
                     <?php  echo $this->Html->link(__(''), ['action' => 'edit', $product->id,],array('class'=>'fa fa-pencil-square-o fa-lg','title'=>'Edit','style'=>'font-size: 20px !important; margin-left: 12px;')) ?>

                     <?php echo $this->Html->link('', ['action' => 'delete',$product->id],['title'=>'Delete','class'=> 'fa fa-trash','style'=>'color:#FF0000; margin-left: 13px; font-size: 19px !important;',"onClick"=>"javascript: return confirm('Are you sure do you want to delete this Product')"]); ?>
                   </td>
                 </tr>
                 <?php $counter++;} } ?>  
               </tbody>
             </table>
             <?php echo $this->element('admin/pagination'); ?> 