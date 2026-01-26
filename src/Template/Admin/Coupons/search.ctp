<table id="bootstrap-data-table" class="table table-striped table-bordered ">
	<thead>
		<tr>
			<th class="align-top">S.No.</th>
			<th class="align-top">Coupon Code</th>
			<th class="align-top">Applicable To</th>
			<th class="align-top">Applicable Type</th>
			<th class="align-top">Discount Rate</th>
			<!-- <th class="align-top">Discount Type</th> -->
			<th class="align-top">Min. Order</th>
			<th class="align-top">Max. Discount</th>
			<th class="align-top">Valid From</th>
			<th class="align-top">Valid To</th>
			<th class="align-top">Expiry Date</th>
			<th class="align-top actions" ><?=__('Actions')?></th>
		</tr>
	</thead>
	<tbody >
								<?php //pr($this->request->params); die;
								$i = ($this->request->params['paging']['Coupancode']['page'] - 1) * $this->request->params['paging']['Coupancode']['perPage'];
								if (isset($coupancode) && !empty($coupancode)) {
    foreach ($coupancode as $value) {$i++; //pr($value);
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
    		<td><?php echo $value['discount_rate']; ?></td>
    		<td><?php echo $value['minimum_order_value']; ?></td>
    		<td><?php echo $value['maximum_discount']; ?></td>
    		<td><?php echo date('d-m-y', strtotime($value['valid_from'])); ?></td>
    		<td><?php echo date('d-m-y', strtotime($value['valid_to'])); ?></td>
    		<td><?php echo date('d-m-y', strtotime($value['cashback_expiry_date'])); ?></td>
    		<td>
    			<?php if ($value['status'] == '1') {?>
    				<?=$this->Html->link('', ['action' => 'status', $value->id, '0'], ['class' => 'fa fa-check-circle', 'style' => 'color:#36cb3c;font-size:20px !important; margin-right:5px'])?>
    			<?php } else {?>
    				<?=$this->Html->link('', ['action' => 'status', $value->id, '1'], ['class' => 'fa fa-check-circle', 'style' => 'color:#FF5722;font-size:20px !important; margin-right:5px'])?>
    			<?php }?>
    			
    			<?php echo $this->Html->link(__(''), ['action' => 'edit', $value->id], array('class' => 'fa fa-pencil-square-o fa-lg', 'title' => 'Edit','style'=>'font-size: 20px !important;')) ?>
    			<?php ?>
    		</td>
    	</tr>
    <?php }} else {?>
    	<tr>
    		<td colspan="12">No Data Available</td>
    	</tr>
    <?php }?>
</tbody>
</table>
<?php echo $this->element('admin/pagination'); ?>