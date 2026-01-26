<?php $role_id = $this->request->session()->read('Auth.User.role_id'); ?>
<table class="table table-bordered table-striped" width="100%">
  <thead>
    <tr>
      <th width="4%">S.No</th>
      <th width="5%">Order ID</th>
      <th width="9%">Name</th>
      <th width="7%">Mobile</th>
      <!-- <th width="14%">Referral Code</th> -->
      <th width="14%">Billing Address</th>
      <th width="7%">Location</th>
      <?php if ($role_id == '1') { ?>
        <th width="7%">Vendor</th>
      <?php } ?>
      <th width="4%">Discount</th>
      <th width="4%">Total</th>
      <th width="6%">Order Date</th>
      <th width="7%">Delivery Date</th>
      <th width="6%">Pay. Mode</th>
      <th width="8%">Status</th>
      <th width="4%">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $page = $this->request->params['paging'][$this->request->params['controller']]['page'];
    $limit = $this->request->params['paging'][$this->request->params['controller']]['perPage'];
    $counter = ($page * $limit) - $limit + 1;
    if (isset($orders) && !empty($orders)) {
      foreach ($orders as $order) { //pr($orders);die; 
        $location_name = $this->Comman->get_location_name($order['location_id']);
        $user_name = $this->Comman->get_user_details($order['user_id']);
        $get_vendor_name = $this->Comman->get_vendor_name($order['vendor_id']);
    ?>
        <tr>
          <td><?php echo $counter; ?></td>
          <td style="color: #0125ea;"><a href="<?php echo ADMIN_URL; ?>order/orderdetail/<?php echo $order['id']; ?>" data-toggle="modal" class="documentcls" title="View Order Detail">#<?php echo $order['id']; ?></a></td>
          <td><?php echo $user_name['name'];  ?></td>
          <td><?php echo $user_name['mobile'];  ?></td>
          <!-- <td><?php// echo $user_name['referral_code'];  ?></td> -->
          <td><?php echo $order['billng_address'];  ?></td>
          <td><?php echo $location_name['name'];  ?></td>
          <?php if ($role_id == 1) { ?>
            <td><?php echo ucfirst($get_vendor_name['name']);  ?></td>
          <?php  } ?>
          <td><?php echo $order['discount'];  ?></td>
          <td><?php echo  round($order['total_amount']);  ?></td>
          <td><?php echo date('d-m-Y  H:i A', strtotime($order['order_date'])); ?></td>
          <td><?php echo date('d-m-Y', strtotime($order['delivery_date'])); ?></td>
          <td><?php echo $order['payment_mode'];  ?></td>
          <td>
            <?php $option = array('Delivered' => 'Delivered', 'Cancelled' => 'Cancelled', 'Pending' => 'Pending', 'Dispatch' => 'Dispatch'); ?>
            <?php echo $this->Form->input('status', array('class' => 'form-control status', 'required', 'label' => false, 'options' => $option, 'empty' => 'Select Status', 'value' => $order['order_status'], 'data-val' => $order['id'])); ?>

          </td>
          <td>
            <a href="<?php echo SITE_URL; ?>admin/order/pdf/<?php echo $order['id']; ?>" class="fa fa-file-pdf-o" title="Edit" style="font-size: 20px !important; margin-left: 12px;"></a>
          </td>



        </tr>
    <?php $counter++;
      }
    } ?>
  </tbody>
</table>
<?php //echo $this->element('admin/pagination'); 
?>

<script>
  $(document).ready(function() {
    $(".status").on('change', function() {
      var stval = $(this).val();
      var userid = $(this).data('val');
      //alert(userid);
      $.ajax({
        type: 'POST',
        url: '<?php echo SITE_URL; ?>admin/order/statusupdate',
        data: {
          'status': stval,
          'id': userid
        },
        success: function(data) {
          var obj = JSON.parse(data);
          if (obj == '1') {
            location.reload();
          }
        },
      });
    });
  });
</script>