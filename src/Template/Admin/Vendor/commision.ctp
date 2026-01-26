<div class="content-wrapper">
 <section class="content-header">
  <h1>
  Commision Manager
 </h1>
 <ol class="breadcrumb">
  <li><a href="<?php echo SITE_URL; ?>admin/dashboards"><i class="fa fa-home"></i>Home</a></li>
  <li><a href="<?php echo SITE_URL; ?>admin/commision">Commision</a></li>
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
   $.ajax({
               async:true,
               data:$("#Mysubscriptions").serialize(),
               dataType:"html",
               type:"get",
               url:"<?php echo ADMIN_URL ;?>Commision/search",
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
var res = target.replace("/Commision/search", "/Commision");
window.location = res;
return false;
});
</script>
          <div class="box-body" id="example2">  
          <?php echo $this->Form->create('', array(
           'class'=>'form-horizontal',
           'enctype' => 'multipart/form-data',
           'action' => 'update_all_commision',
           'validate',
           
         )); ?>
          <?php
        echo $this->Form->submit('Update All',array('class'=>'btn btn-info pull-right','title'=>'Submit')); ?>  
            <table class="table table-bordered table-striped" width="100%">
              <thead>
                <tr>
                  <th width="5%">S.No</th>                                   
                  <th width="10%">Product Name</th> 
                  <th width="3%">Brand Name</th> 
                  <th width="8%">Fixed</th>                 
                  <th width="8%">Percentage</th>                    
                  <th width="3%">Action</th>     
                  <!-- <th width="6%">Net Price</th> 
                  <th width="5%">Margin</th>  
                  <th width="6%">Weight(%)</th> 
                  <th width="8%">Fright Free</th>
                  <th width="5%">CGST(%)</th> 
                  <th width="5%">SGST(%)</th> 
                  <th width="5%">IGST(%)</th>   -->
                </tr>
              </thead>
              <tbody>
                <?php 
                $counter=($this->request->params['paging']['products']['page']-1) * $this->request->params['paging']['products']['perPage']; 
                if(isset($Products) && !empty($Products)){ 
                foreach($Products as $product){ //pr($product['product_commision'][0]['fixed']); die;?>
 
                  <tr>
                    <td><?php echo $counter+1;?></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo $product['brand_name']; ?></td>
                    <input type="hidden" name="commision[product_id][]" value="<?php echo $product['id']?>" >

                    <td> <input type="number" name="commision[fixed][]" id="txtF" class="form-control" placeholder="Fixed" autofocus="autofocus" autocomplete="off" value="<?php echo $product['product_commision'][0]['fixed']?>">  </td>

                    <td> <input type="number"  name="commision[percentage][]" class="form-control txtF" placeholder="Percentage" autofocus="autofocus" autocomplete="off" value="<?php echo $product['product_commision'][0]['percentage']?>" onKeyPress="return check(event,value)" onInput="checkLength()">


                  
                  </td>

                    <td>
                    <?php
                    echo $this->Form->submit('Update',array('class'=>'btn btn-info','title'=>'Submit')); ?> </td>
       
                 <?php $counter++;} } ?> 
                 <?php echo $this->Form->end(); ?> 
               </tbody>
             </table>
 
             
           </div>
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
 <script>
 var point=false;
 var count=0;
    function check(e,value){
    //Check Charater
    debugger;
    if(count==3)return false;
        var unicode=e.charCode? e.charCode : e.keyCode;
        
        if( unicode == 46 && point==true)
               return false;
        if( unicode == 46 && point==false)
        {
        		point=true;
        }
        if (unicode!=8)if((unicode<48||unicode>57)&&unicode!=46)return false;
        if(point==true)count++;
    }
    function checkLength(){
    var fieldVal = document.getElementById('.txtF').value;
    //Suppose u want 3 number of character
    if(fieldVal <= 100){
        return true;
    }
    else
    {
        var str = document.getElementById('.txtF').value;
        str = str.substring(0, str.length - 1);
    document.getElementById('.txtF').value = str;
    }
    }
</script>
 

