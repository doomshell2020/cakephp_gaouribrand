<?php $role_id = $this->request->session()->read('Auth.User.role_id'); ?>
<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Coupon Code Manager
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo SITE_URL; ?>admin/dashboards"><i class="fa fa-home"></i>Home</a></li>
			<li><a href="<?php echo SITE_URL; ?>admin/coupons">Coupon Manager</a></li>
		</ol>
	</section>
	<?php echo $this->Flash->render(); ?>

	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<!-- <div class="box">
					<div class="box-header">
						<?php $role_id = $this->request->session()->read('Auth.User.role_id'); ?>
						<script>          
							$(document).ready(function () { 
								$("#Mysubscriptions").bind("submit", function (event) {
									$('.lds-facebook').show();
									$.ajax({
										async:true,
										data:$("#Mysubscriptions").serialize(),
										dataType:"html",
										type:"POST",
										url:"<?php echo ADMIN_URL; ?>coupons/search",
										success:function (data) {
											$('.lds-facebook').hide();   
											$("#example2").html(data); },
										});
									return false;
								});
							});

						</script>

						<?php echo $this->Form->create('Mysubscription', array('type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'Mysubscriptions', 'class' => 'form-horizontal')); ?>

							
							<div class="form-group" >
								<div class="col-sm-3">
									<input type="hidden" name="test_id" id="test_ids">
									<label for="to" class="form-control-label">Coupon code</label>
									<input type="text" name="coupan_code" placeholder ="coupon code" class="longinput form-control input-medium secrh_coupan_code" autocomplete="off" >
									<div id="myUL"><ul></ul></div>
								</div>

								<div class="col-sm-1">
									<label for="inputEmail3" class="control-label" style="color:white">Search</label>
									<input type="submit" style="background-color:#00c0ef;" id="Mysubscriptions" class="btn btn4 btn_pdf myscl-btn date" value="Search">       
								</div> 
								<?php echo $this->Form->end(); ?> 
							</div>  
						</div> 
					</div>  -->

				<div class="box">
					<div class="box-header">
						<?php //if ($role_id != 1) { ?>
							<a href="<?php echo SITE_URL; ?>admin/coupons/add">
								<button class="btn btn-success pull-right m-top10"><i class="fa fa-plus" aria-hidden="true"></i>
									Add Coupon </button></a>
						<?php  //} ?>
					</div>
					<div class="box-body" id="example2">
						<table class="table table-bordered table-striped" width="100%">
							<thead>
								<tr>
									<th>S.No.</th>
									<?php if ($role_id == 1) { ?>
										<th>Vendor Name</th>
									<?php } ?>
									<th>Coupon Code</th>
									<th width="10%">Applicable To</th>
									<th width="10%">Applicable Type</th>
									<th>Discount Rate</th>
									<!-- <th>Discount Type</th> -->
									<th>Min. Order</th>
									<th>Max. Discount</th>
									<th>Valid From</th>
									<th>Valid To</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$page = $this->request->params['paging'][$this->request->params['controller']]['page'];
								$limit = $this->request->params['paging'][$this->request->params['controller']]['perPage'];
								$counter = ($page * $limit) - $limit + 1;
								if (isset($coupancode) && !empty($coupancode)) {
									foreach ($coupancode as $value) {
										$vendor_name = $this->Comman->get_vendor_name($value['vendor_id']);
										$i++; //pr($value); 
										$categories = null;
										$products = null;
										if ($value['applicable_to'] == 'category') {
											$categories = array_map(function ($val) {
												return $val['name'];
											}, $value['categories']);
											$categories = implode(',', $categories);
										}
										if ($value['applicable_to'] == 'product') {
											$products = array_map(function ($val) {
												return $val['name'];
											}, $value['products']);
											$products = implode(',', $products);
										}

								?>
										<tr>
											<td><?php echo $i; ?></td>
											<?php if ($role_id == 1) { ?>
												<td><?php echo $vendor_name['name']; ?></td>
											<?php } ?>
											<td><?php echo $value['code']; ?></td>
											<td><?php echo $value['applicable_to'];
												if ($value['applicable_to'] == 'category') {
													echo "<br>(" . $categories . ')';
												}
												if ($value['applicable_to'] == 'product') {
													echo "<br>(" . $products . ')';
												}
												?></td>
											<td><?php echo $value['applicable_type']; ?></td>
											<td><?php if ($value['discount_rate']) {
													echo $value['discount_rate'];
												} else {
													echo "---";
												}  ?></td>
											<td><?php echo $value['minimum_order_value']; ?></td>
											<td><?php echo $value['maximum_discount']; ?></td>
											<td><?php echo date('d-m-y', strtotime($value['valid_from'])); ?></td>
											<td><?php echo date('d-m-y', strtotime($value['valid_to'])); ?></td>
											<td>
												<?php if ($value['status'] == '1') { ?>
													<?= $this->Html->link('', ['action' => 'status', $value->id, '0'], ['class' => 'fa fa-check-circle', 'style' => 'color:#36cb3c;font-size:20px !important; margin-right:5px']) ?>
												<?php } else { ?>
													<?= $this->Html->link('', ['action' => 'status', $value->id, '1'], ['class' => 'fa fa-check-circle', 'style' => 'color:#FF5722;font-size:20px !important; margin-right:5px']) ?>
												<?php } ?>
												<?php if ($role_id != 1) { ?>
													<?php echo $this->Html->link(__(''), ['action' => 'edit', $value->id], array('class' => 'fa fa-pencil-square-o fa-lg', 'title' => 'Edit', 'style' => 'font-size: 20px !important;')) ?>
												<?php } ?>
											</td>
										</tr>
								<?php $counter++;
									}
								} ?>
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