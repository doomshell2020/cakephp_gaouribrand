<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Customer Manager
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo SITE_URL; ?>admin/dashboards"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo SITE_URL; ?>admin/customer/">Customer</a></li>
    </ol>
  </section> <!-- content header -->


 
   <!-- Main content -->
   <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <?php echo $this->Flash->render(); ?>
            <?php $role_id = $this->request->session()->read('Auth.User.role_id');  ?>
            <script>
              $(document).ready(function() {
                $("#Mysubscriptions").bind("submit", function(event) {
                  $('.lds-facebook').show();
                  $.ajax({
                    async: true,
                    data: $("#Mysubscriptions").serialize(),
                    dataType: "html",
                    type: "POST",
                    url: "<?php echo ADMIN_URL; ?>customer/search",
                    success: function(data) {
                      $('.lds-facebook').hide();
                      $("#example2").html(data);
                    },
                  });
                  return false;
                });
              });
            </script>

           
                </div>
            </div>
          </div>
          <div class="box">
          <div class="box-header">
          <a href="<?php echo SITE_URL; ?>admin/customer/customerexcel">
              <button class="btn btn-success pull-right mx-auto"><i class="fa fa-circle" aria-hidden="true"></i>
                Export Excel </button></a>
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
                    <th width="4%">Discount</th>
                    <th width="4%">Total</th>
                    <th width="6%">Order Date</th>
                    <th width="7%">Delivery Date</th>
                    <th width="6%">Pay. Mode</th>
                    <!-- <th width="8%">Status</th>
                    <th width="4%">Action</th> -->
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $page = $this->request->params['paging'][$this->request->params['controller']]['page'];
                  $limit = $this->request->params['paging'][$this->request->params['controller']]['perPage'];
                  $counter = ($page * $limit) - $limit + 1;
                  if (isset($data) && !empty($data)) {
                    foreach ($data as $users) { //pr($users); die; 
        
                  ?>
                        <tr>
                        <td><?php echo $counter; ?></td>
                        <td style="color: #0125ea;"><a href="<?php echo ADMIN_URL; ?>order/orderdetail/<?php echo $users['id']; ?>" data-toggle="modal" class="documentcls" title="View Order Detail">#<?php echo $users['id']; ?></a></td>
                        <td><?php echo $users['user']['name'];  ?></td>
                        <td><?php echo $users['user']['mobile'];  ?></td>
                        <td><?php echo $users['billng_address'];  ?></td>
                        <td><?php echo $users['locality'];  ?></td>
                        <td><?php echo $users['discount'];  ?></td>
                        <td><?php echo  round($users['total_amount']);  ?></td>
                        <td><?php echo date('d-m-Y H:i A', strtotime($users['order_date'])); ?></td>
                        <td><?php echo date('d-m-Y', strtotime($users['delivery_date'])); ?></td>
                        <td><?php echo $users['payment_mode'];  ?></td>
                      
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