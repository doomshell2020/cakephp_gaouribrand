<script>
 function checkextension() {
  var file = document.querySelector("#fUpload");
  if ( /\.(jpe?g|png|gif)$/i.test(file.files[0].name) === false ) 
    { alert("not an image please choose a image!");
  $('#fUpload').val('');
}
return false;
}
</script>
<style type="text/css">
 .text{
  color:red; 
  font-size: 12px;
}
</style>

<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Product Manager
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo SITE_URL; ?>admin/dashboards"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo SITE_URL; ?>admin/product">Manage Product</a></li>
      <?php if(isset($companies['id'])){ ?>
        <li class="active"><a href="javascript:void(0)">Edit Product</a></li>   
      <?php } else { ?>
        <li class="active"><a href="javascript:void(0)">Add Product</a></li>
      <?php } ?>
    </ol>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-info">
          <?php echo $this->Flash->render(); ?>
          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-plus-square" aria-hidden="true"></i> <?php if(isset($Products['id'])){ echo 'Edit Product'; }else{ echo 'Create Product';} ?></h3>
          </div>

          <?php echo $this->Form->create($Products, array(
           'class'=>'form-horizontal',
           'enctype' => 'multipart/form-data',
           'validate'
         )); ?>
         <div class="box-body">
          <div class="form-group">
            <div class="col-sm-3">
              <label for="inputEmail3" class="control-label">Product Name</label>
              <?php echo $this->Form->input('name', array('class' => 'form-control','required','label'=>false,'placeholder'=>'Product Name','autofocus','autocomplete'=>'off')); ?>   
              
            </div>
            <div class="col-sm-3">
              <label for="inputEmail3" class="control-label">Brand Name</label>
              <?php echo $this->Form->input('brand_name', array('class' => 'form-control','label'=>false,'placeholder'=>'Brand Name','autofocus','autocomplete'=>'off')); ?>   
              </div>
          

            <div class="col-sm-3">
              <label for="inputEmail3" class="control-label">Measurement</label>
              <?php echo $this->Form->input('measurement', array('class' => 'form-control','required','label'=>false,'placeholder'=>'Measurement','autofocus','autocomplete'=>'off')); ?>   
              
            </div>

            <div class="col-sm-3">
              <label for="inputEmail3" class="control-label">HSN</label>
              <?php echo $this->Form->input('hsn', array('class' => 'form-control','required','label'=>false,'placeholder'=>'HSN','autofocus','autocomplete'=>'off')); ?>   
              
            </div>

            <div class="col-sm-3">
              <label for="inputEmail3" class="control-label">Upload Image</label>
              <?php echo $this->Form->input('image[]', array('class' =>'form-control','autocomplete' => 'off','label'=>false,'type'=>'file','id'=>'fUpload','onchange'=>'checkextension()','required','multiple')); ?>
            </div>


            <div class="col-sm-12">
            <label for="inputEmail3" class="control-label">Description</label>
              <?php echo $this->Form->input('description', array('class' => 'form-control','label'=>false,'placeholder'=>'Description','autocomplete'=>'off','required','type'=>'textarea')); ?>  
            </div>

                	<div class="col-sm-12">
                		<div class="table-responsive">
                			<div class="multi-field-wrapperpayment">

                				<div class="table table-bordered" style="padding-bottom: 20px;
    margin-top: 20px;">
      <ul class="tab_foot_btn_add list-unstyled" style= "position: absolute;
    right: 20px;
    top: 50px; z-index: 999">
      <li style="text-align:right"><a type="button" class="btn-primary add-paymentfield pull-right" style = "height:34px !important; width:max-content !important; padding:0 20px; display: flex; align-items: center; ">Add </a></li>

  </ul>


                					<div class="tab_header">
                						<ul class="tab_hade_menu row list-unstyled " style= "padding-top:20px">
                							<li class = "col-sm-4">Packaging</li>
                							<li class = "col-sm-4 ">Price</li> 
                						
                						</ul>
                					</div>

                					<div class="payment_container">
                						<?php if(count($currentworking)>0)
                						{ ?>
                							<?php 
                							$currentexpcounter = 1;
                							foreach($currentworking as $current){ //pr($current);?>	
                								<div class="removecurrentworking">
                									<ul class="payment_details list-unstyled">

                										<li class = "col-sm-4">

                											<?php echo $this->Form->input('name',array('value'=>$current['name'],'class'=>'form-control','placeholder'=>'Where','id'=>'','label' =>false,'name'=>'current[name][]','type'=>'text')); ?>
                											<input type="hidden" value="<?php echo $current['id'] ?>" name="current[hid][]" id="<?php echo $currentexpcounter; ?>" class="ccounter"/>
                										</li>

                                                   <li class = "col-sm-4"><?php echo $this->Form->input('role',array('value'=>$current['role'],'class'=>'form-control','placeholder'=>'Role','id'=>'','label' =>false,'name'=>'current[role][]',)); ?>
                                               </li>
                                               <li class = "col-sm-4">    
                                               <a href="javascript:void(0);" class="delete_paymentcurrent btn remove-field btn-danger btn-block" data-val="<?php echo $current['id'] ?>"><i class="fa fa-remove"></i> Delete</a>
                                    </li>
                                    </ul>

                                
                            </div>
                            <?php 
                            $currentexpcounter++;
                        }}else{ ?>
                           <div class="removecurrentworking">
                              <ul class="payment_details list-unstyled row">

                                 <li class = "col-sm-4"><?php echo $this->Form->input('packaging',array('class'=>'form-control','placeholder'=>'Packaging','id'=>'','label' =>false,'empty'=>'--Select Payment Frequency--','options'=>$pay_freq,'name'=>'current[packaging][]','type'=>'text')); ?>
                                 <input type="hidden" value="<?php echo $current['id'] ?>" name="current[hid][]" id="1" class="ccounter"/>
                             </li>

                            

                         <li class = "col-sm-4"><?php echo $this->Form->input('Price',array('class'=>'form-control','placeholder'=>'Price','id'=>'','label' =>false,'name'=>'current[price][]',)); ?>
                     </li>

                    
                     <li class = "col-sm-4"><a href="javascript:void(0);" class="delete_paymentcurrent btn remove-field btn-danger btn-block" style = "height:34px !important; width:max-content !important; padding:0 20px; display: flex; align-items: center;" data-val="<?php echo $current['id'] ?>"><i class="fa fa-remove"></i> Delete</a></li>

             </ul>
           
         </div>
     <?php } ?>
 </div>
 <div>
 
</div>
</div>
</div>

</div>
</div>



            </div>
          </div>  

       
        </div>
        <div class="box-footer">
          <?php
          if(isset($products['id'])){
            echo $this->Form->submit(
              'Update', 
              array('class' => 'btn btn-info pull-right', 'title' => 'Update')
            ); }else{ 
              echo $this->Form->submit(
                'Add', 
                array('class' => 'btn btn-info pull-right formsubmit', 'title' => 'Add')
              );
            }
            ?><?php
            echo $this->Html->link('Back', [
              'action' => 'index'
              
            ],['class'=>'btn btn-default']); ?>
          </div>
          <?php echo $this->Form->end(); ?>
        </div>
      </div>
    </div>
  </section>
</div> 

<script>
	

	
	
	$('.multi-field-wrapperpayment').each(function() { 
		lasttr = $(".removecurrentworking:last-child li:first-child");
		var $wrapper = $('.payment_container', this);
		$(".add-paymentfield", $(this)).click(function(e) { 
			var currentwork = $('.removecurrentworking:first-child', $wrapper).clone(true).appendTo($wrapper)

			currentwork.find('input').val('').focus();
			currentwork.find('select').val('').focus();
			currentwork.find('textarea').val('').focus();
			currentwork.find('[data-val]').attr("data-val" , '');

			ccounter = lasttr.find('.ccounter').attr('id');
			ccounter++
			$lastinput = $(".removecurrentworking:last-child li:nth-last-child(1) .cdate_from");
			$lastinput.attr('id','cdate_from'+ccounter);
			$lastinput
			.removeClass('hasDatepicker')
			.removeData('datepicker')
			.unbind()
			.datepicker({
				autoclose: true,
				minViewMode: 1,
				format: 'yyyy-mm'
			});

		});
		$('.remove-field', $wrapper).click(function() {
			if ($('.removecurrentworking', $wrapper).length > 1)
				$(this).closest('.removecurrentworking').remove();
		});
	});
</script>

 <script>
$(document).ready(function(){
    $(".add-paymentfield").click(function(){ //alert('test');
            $(".datepicker-orient-left").css("display", "none");

  //$(".datepicker-months").addClass("intro");
  });
    
});
</script>