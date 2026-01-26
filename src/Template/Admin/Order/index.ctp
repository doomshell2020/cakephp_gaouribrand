<style>
  th {
    font-size: 12px !important;
  }

  td {
    font-size: 12px !important;
  }

  .form-control {
    height: 30px;
  }
</style>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Order Manager
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo SITE_URL; ?>admin/dashboards"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo SITE_URL; ?>admin/order/index">Order</a></li>
    </ol>
  </section> <!-- content header -->

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <?php echo $this->Flash->render(); ?>
            <?php $role_id = $this->request->session()->read('Auth.User.role_id'); ?>
            <script>
              $(document).ready(function () {
                $("#Mysubscriptions").bind("submit", function (event) {

                  $('.lds-facebook').show();
                  $.ajax({
                    async: true,
                    data: $("#Mysubscriptions").serialize(),
                    dataType: "html",
                    type: "POST",
                    url: "<?php echo ADMIN_URL; ?>order/search",
                    success: function (data) {
                      $('.lds-facebook').hide();
                      $("#example2").html(data);
                    },
                  });
                  return false;
                });
              });
            </script>

            <?php echo $this->Form->create('Mysubscription', array('type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'Mysubscriptions', 'class' => 'form-horizontal')); ?>


            <div class="form-group">
              <div class="col-sm-3">
                <label for="inputEmail3" class="control-label">Name</label>
                <?php echo $this->Form->input('name', array('class' => 'form-control', 'label' => false, 'placeholder' => 'Name', 'autocomplete' => 'off')); ?>
              </div>
              <div class="col-sm-3">
                <label for="inputEmail3" class="control-label">Mobile</label>
                <?php echo $this->Form->input('mobile', array('class' => 'form-control', 'label' => false, 'placeholder' => 'Mobile', 'autocomplete' => 'off', 'type' => 'text', 'maxlength' => 10, 'onkeypress' => "return validateNumber(event)")); ?>
              </div>


              <div class="col-sm-3">
                <label for="inputEmail3" class="control-label">From</label>
                <input class="span2 form-control" size="16" placeholder="Exam Date From" title="Exam Date From"
                  type="date" name="from_date">
              </div>

              <div class="col-sm-3">
                <label for="inputEmail3" class="control-label">To</label>
                <input class="span2 form-control" size="16" placeholder="Exam Date From" title="Exam Date From"
                  type="date" name="to_date">
              </div>


              <?php if ($role_id == 1) { ?>

                <div class="col-sm-3">
                  <label for="inputEmail3" class="control-label">Location</label>
                  <?php
                  echo $this->Form->input('location', array(
                    'class' =>
                      'form-control',
                    'label' => false,
                    'options' => $locations,
                    'empty' => '--Select Location--',
                    'autofocus'
                  )
                  ); ?>
                </div>

              <?php } ?>



              <div class="col-sm-3">
                <label for="inputEmail3" class="control-label">Order Id From</label>
                <input class="span2 form-control" placeholder="Order Id From" title="Order Id From" type="text"
                  name="order_id_from" onkeypress="return validateNumber(event)">
              </div>

              <div class="col-sm-3">
                <label for="inputEmail3" class="control-label">Order Id To</label>
                <input class="span2 form-control" placeholder="Order Id To" title="Order Id To" type="text"
                  name="order_id_to" onkeypress="return validateNumber(event)">
              </div>

              <script>
                function validateNumber(e) {
                  const pattern = /^[0-9]$/;

                  return pattern.test(e.key)
                }
              </script>

              <?php if ($role_id == '2') { ?>
                <div class="col-sm-1" style="margin-top: 25px;">
                <?php } else { ?>
                  <div class="col-sm-1">
                  <?php } ?>
                  <div class="col-sm-1">
                    <label for="inputEmail3" class="control-label" style="color:white">Search</label>
                    <input type="submit" style="background-color:#00c0ef;" id="Mysubscriptions"
                      class="btn btn4 btn_pdf myscl-btn date" value="Search">
                  </div>
                </div>
                <?php echo $this->Form->end(); ?>
              </div>
            </div>
          </div>

          <div class="box">
            <div class="box-header">
              <a href="<?php echo SITE_URL; ?>admin/order/orders_excel">
                <button class="btn btn-success pull-right mx-auto"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                  Excel </button></a>&nbsp;
              <a href="<?php echo SITE_URL; ?>admin/order/orders_pdf">
                <button class="btn btn-success pull-right mx-auto" style ="margin-right: 3px;"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                  Pdf </button></a>
                  <a href="<?php echo SITE_URL; ?>admin/order/add">
              <button class="btn btn-success pull-right m-top10" style ="margin-right: 3px;"><i class="fa fa-plus" aria-hidden="true"></i>
                Add Order </button></a>

            </div>
            <div class="box-body" id="example2">
              <table class="table table-bordered table-striped" width="100%">
                <thead>
                  <tr>
                    <th width="4%">S.No</th>
                    <th width="5%">Order ID</th>
                    <th width="9%">Name</th>
                    <th width="7%">Mobile</th>
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
                  // $page = $this->request->params['paging'][$this->request->params['controller']]['page'];
                  // $limit = $this->request->params['paging'][$this->request->params['controller']]['perPage'];
                  // $counter = ($page * $limit) - $limit + 1;
                  $page = $this->request->params['paging']['Orders']['page'];
                  $limit = $this->request->params['paging']['Orders']['perPage'];
                  $counter = ($page * $limit) - $limit + 1;

                  if (isset($orders) && !empty($orders)) {
                    foreach ($orders as $order) { // pr($order);exit;
                      $location_name = $this->Comman->get_location_name($order['location_id']);
                      $user_name = $this->Comman->get_user_details($order['user_id']);
                      $get_vendor_name = $this->Comman->get_vendor_name($order['vendor_id']);


                      ?>
                      <tr>
                        <td><?php echo $counter; ?></td>
                        <td style="color: #0125ea;"><a
                            href="<?php echo ADMIN_URL; ?>order/orderdetail/<?php echo $order['id']; ?>" data-toggle="modal"
                            class="documentcls" title="View Order Detail">#<?php echo $order['id']; ?></a></td>
                        <td><?php echo $user_name['name']; ?></td>
                        <td><?php echo $user_name['mobile']; ?></td>
                        <td><?php echo $order['billng_address']; ?></td>
                        <td><?php echo $location_name['name']; ?></td>
                        <?php if ($role_id == '1') { ?>
                          <td><?php echo ucfirst($get_vendor_name['name']); ?></td>
                        <?php } ?>
                        <td><?php echo $order['discount']; ?></td>
                        <td><?php echo round($order['total_amount']); ?></td>
                        <td><?php echo date('d-m-Y H:i A', strtotime($order['order_date'])); ?></td>
                        <td><?php echo date('d-m-Y', strtotime($order['delivery_date'])); ?></td>
                        <td><?php echo $order['payment_mode']; ?></td>
                        <td>
                          <?php $option = array('Delivered' => 'Delivered', 'Cancelled' => 'Cancelled', 'Pending' => 'Pending', 'Dispatch' => 'Dispatch'); ?>
                          <?php echo $this->Form->input('status', array('class' => 'form-control status', 'required', 'label' => false, 'options' => $option, 'empty' => 'Select Status', 'value' => $order['order_status'], 'data-val' => $order['id'])); ?>
                        </td>
                        <td>
                          <a href="<?php echo SITE_URL; ?>admin/order/pdf/<?php echo $order['id']; ?>"
                            class="fa fa-file-pdf-o" title="Edit"
                            style="font-size: 20px !important; margin-left: 12px;"></a>
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
<script>
  $(document).ready(function () {
    $(".status").on('change', function () {
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
        success: function (data) {
          var obj = JSON.parse(data);
          //alert(obj);
          if (obj == '1') {
            location.reload();
          }
        },
      });
    });
  });
</script>

<script src="https://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<script>
  $(function () {
    var dateFormat = 'dd-mm-yy',
      from = $("#datepicker1")
        .datepicker({
          dateFormat: 'dd-mm-yy',
          changeMonth: true,
          numberOfMonths: 1
        })
        .on("change", function () {
          to.datepicker("option", "minDate", getDate(this));
        }),
      to = $("#datepicker2").datepicker({
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        numberOfMonths: 1
      })
        .on("change", function () {
          from.datepicker("option", "maxDate", getDate(this));
        });

    function getDate(element) {
      var date;
      try {
        date = $.datepicker.parseDate(dateFormat, element.value);
      } catch (error) {
        date = null;
      }
      return date;
    }
  });
</script>