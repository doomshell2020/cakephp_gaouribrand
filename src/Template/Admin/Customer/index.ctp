<?php $role_id = $this->request->session()->read('Auth.User.role_id'); ?>
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

                // 🔍 SEARCH (AJAX)
                $("#Mysubscriptions").on("submit", function(e) {
                  e.preventDefault();

                  $('.lds-facebook').show();

                  $.ajax({
                    type: "GET",
                    url: "<?php echo ADMIN_URL; ?>customer/search",
                    data: $(this).serialize(),
                    success: function(data) {
                      $('.lds-facebook').hide();
                      $("#example3").html(data);
                    }
                  });
                });

                $(document).on('click', '.pagination a', function(e) {
                  var target = $(this).attr('href');
                  var res = target.replace("/customer/search", "/customer");
                  window.location = res;
                  return false;
                });


              });
            </script>



            <?php echo $this->Form->create('Mysubscription', array('type' => 'GET', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'Mysubscriptions', 'class' => 'form-horizontal', 'method' => 'GET')); ?>

            <div class="form-group">

              <div class="col-sm-2" style="width: 13%;">
                <label for="inputEmail3" class="control-label">Name</label>
                <?php
                echo $this->Form->input('name', [
                  'class' => 'form-control',
                  'label' => false,
                  'placeholder' => 'Name',
                  'autocomplete' => 'off',
                  'value' => !empty($_GET['name']) ? $_GET['name'] : ''
                ]);
                ?>
              </div>

              <div class="col-sm-2" style="width: 13%;">
                <label for="inputEmail3" class="control-label">Mobile</label>
                <?php
                echo $this->Form->input('mobile', [
                  'class' => 'form-control',
                  'label' => false,
                  'placeholder' => 'Mobile',
                  'autocomplete' => 'off',
                  'value' => !empty($_GET['mobile']) ? $_GET['mobile'] : ''
                ]);
                ?>
              </div>

              <?php if ($role_id == 1) { ?>
                <div class="col-sm-2" style="width: 13%;">
                  <label for="inputEmail3" class="control-label">Location</label>
                  <?php
                  echo $this->Form->input('location', [
                    'class' => 'form-control',
                    'label' => false,
                    'options' => $locations,
                    'empty' => '--Select Location--',
                    'value' => !empty($_GET['location']) ? $_GET['location'] : ''
                  ]);
                  ?>
                </div>
              <?php } ?>

              <div class="col-sm-2" style="width: 13%;">
                <label for="inputEmail3" class="control-label">Referred by</label>
                <?php
                echo $this->Form->input('referral_code', [
                  'class' => 'form-control',
                  'label' => false,
                  'placeholder' => 'Referred by',
                  'autocomplete' => 'off',
                  'type' => 'number',
                  'value' => !empty($_GET['referral_code']) ? $_GET['referral_code'] : ''
                ]);
                ?>
              </div>

              <div class="col-sm-2" style="width: 13%;">
                <label for="inputEmail3" class="control-label">From</label>
                <input
                  class="span2 form-control"
                  size="16"
                  placeholder="Exam Date From"
                  title="Exam Date From"
                  type="date"
                  name="from_date"
                  value="<?php echo !empty($_GET['from_date']) ? $_GET['from_date'] : ''; ?>">
              </div>

              <div class="col-sm-2" style="width: 13%;">
                <label for="inputEmail3" class="control-label">To</label>
                <input
                  class="span2 form-control"
                  size="16"
                  placeholder="Exam Date From"
                  title="Exam Date From"
                  type="date"
                  name="to_date"
                  value="<?php echo !empty($_GET['to_date']) ? $_GET['to_date'] : ''; ?>">
              </div>
              <script>
                $(document).ready(function() {
                  $('input[type="checkbox"]').on('change', function() {
                    if ($(this).is(':checked')) {
                      // disable all other checkboxes
                      $('input[type="checkbox"]').not(this).prop('disabled', true);
                    } else {
                      // if unchecked, enable all
                      $('input[type="checkbox"]').prop('disabled', false);
                    }
                  });
                });
              </script>

              <div class="col-sm-2" style="width: 13%;">
                <label class="control-label">Sort By</label><br>

                <input type="checkbox" name="top_customer_basedon_order" value="1"
                  <?php echo (!empty($_GET['top_customer_basedon_order']) && $_GET['top_customer_basedon_order'] == 1) ? 'checked' : ''; ?>>
                Top Customer<br>

                <input type="checkbox" name="by_name" value="2"
                  <?php echo (!empty($_GET['by_name']) && $_GET['by_name'] == 2) ? 'checked' : ''; ?>>
                Name<br>

                <input type="checkbox" name="by_date" value="3"
                  <?php echo (!empty($_GET['by_date']) && $_GET['by_date'] == 3) ? 'checked' : ''; ?>>
                Last Order Date<br>
              </div>

              <div class="col-sm-1" style="width: 13%;">
                <label for="inputEmail3" class="control-label" style="color:white">Search</label>
                <input type="submit"
                  style="background-color:#00c0ef;"
                  id="Mysubscriptions"
                  class="btn btn4 btn_pdf myscl-btn date"
                  value="Search">

                <button type="button" style="background-color:#00c0ef;" class="btn btn4 btn_pdf myscl-btn date" onclick="window.location.href='<?php echo ADMIN_URL; ?>customer';">
                  Reset
                </button>


              </div>

              <?php echo $this->Form->end(); ?>

            </div>


          </div>
        </div>
        <div class="box">
          <div class="box-header">
            <?php if ($role_id == 1) { ?>
              <a href="<?php echo SITE_URL; ?>admin/customer/customerexcel">
                <button class="btn btn-success pull-right mx-auto"><i class="fa fa-circle" aria-hidden="true"></i>
                  Export Excel </button></a>
            <?php  } ?>

          </div>
          <div class="box-body" id="example3">
            <table class="table table-bordered table-striped" width="100%">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Customer Details</th>
                  <th>Referral Code</th>
                  <th>Referred By</th>
                  <th>Village</th>
                  <th>Animals</th>
                  <th>Milk Qty</th>
                  <th>Orders Details</th>
                  <th>Last Order Date</th>
                  <th>User Created</th>
                  <!-- <th width="8%">Status</th>      -->
                  <!-- <?php if ($role_id != 2) { ?>
                      <th width="8%">Action</th>
                    <?php   } ?> -->
                </tr>
              </thead>
              <tbody>
                <?php
                // $page = $this->request->params['paging']['Users']['page'];
                // $limit = $this->request->params['paging']['Users']['perPage'];
                // $counter = ($page * $limit) - $limit + 1;

                $paging = $this->request->getParam('paging');

                $page  = $paging['Users']['page'] ?? 1;
                $limit = $paging['Users']['perPage'] ?? 50;

                $counter = (($page - 1) * $limit) + 1;

                if (isset($users) && !empty($users)) {
                  foreach ($users as $users) { //pr($users);
                    //get index page orders count
                    $get_total_orders = $this->Comman->gettotalOrders($users['user_id'], $users['vendor_id']);

                    //get index page orders amount
                    $get_total_orderssum = $this->Comman->gettotalOrderssum($users['user_id'], $users['vendor_id']);

                    $get_referl = $this->Comman->getreferredby($users['referred_user_id']);

                ?>
                    <tr>
                      <td><?php echo $counter; ?></td>
                      <td><b>Name:</b> <?php echo ucwords(strtolower($users['name']));  ?><br>
                        <b>Mobile No:</b> <?php echo $users['mobile'];  ?>
                      </td>
                      <td>
                        <?php echo $users['referral_code'];  ?>
                      </td>
                      <td>
                        <b><?php
                            if (!empty($users['referred_user_id'])) {
                              echo '<b>Code:</b> ' . $get_referl['referral_code'] . '<br>' . '<b>Name:</b> ' . ucwords(strtolower($get_referl['name']));
                            } else {
                              echo "N/A";
                            }  ?>

                      </td>
                      <td><?php echo $users['villagename'];  ?></td>
                      <td><?php echo $users['animalCount'];  ?></td>
                      <td><?php echo $users['milkQuantity'];  ?></td>
                      <td><a href="<?php echo ADMIN_URL; ?>order/index/<?php echo $users['id']; ?>">Total Order: <?php echo $get_total_orders; ?></a><br>
                        <a href="#">Total Amount: <?php
                                                  if (!empty($get_total_orderssum['sum'])) {
                                                    echo $get_total_orderssum['sum'];
                                                  } else {
                                                    echo 0;
                                                  }
                                                  ?></a>
                      </td>
                      <td><?php echo date('d-m-Y', strtotime($users['order_date'])); ?></td>
                      <td><?php echo date('d-m-Y', strtotime($users['created'])); ?></td>


                      <!-- <td>
                      <?php if ($users['status'] == '1') {
                        echo $this->Html->link('', [
                          'action' => 'status',
                          $users->id,
                          '0'
                        ], ['title' => 'Active', 'class' => 'fa fa-check-circle', 'style' => 'font-size: 21px !important; margin-left: 12px;     color: #00ff08;']);
                      } else {
                        echo $this->Html->link('', [
                          'action' => 'status',
                          $users->id,
                          '1'
                        ], ['title' => 'Inactive', 'class' => 'fa fa-times-circle-o', 'style' => 'font-size: 21px !important; margin-left: 12px; color:#FF5722;']);
                      } ?>
                    </td> -->
                      <!-- <td><label for="inputEmail3" class="control-label" style="color:white">.</label>
                    <input type="submit" style="background-color:#00c0ef;" id=$users class="btn btn4 btn_pdf myscl-btn date" value="Vendor?"></td>-->

                      <!-- <?php if ($role_id != 2) { ?>
                          <td><a href="<?php echo SITE_URL; ?>admin/customer/customeredit/<?php echo $users->id; ?>">Make Vendor</a>
                          <?php } ?> -->

                      <!-- <li><a href="<?php echo SITE_URL; ?>admin/customer/">Customer</a></li> -->
                      <!-- <td><form action= method="POST">
                      <input type="submit"/>
                    </form></td> -->

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