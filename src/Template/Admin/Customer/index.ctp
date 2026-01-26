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
            <!-- <script>
              $(document).ready(function() {
                $("#Mysubscriptions").bind("submit", function(event) {
                  $('.lds-facebook').show();
                  $.ajax({
                    async: true,
                    data: $("#Mysubscriptions").serialize(),
                    dataType: "html",
                    type: "POST",
                    url: "<? php // echo ADMIN_URL; 
                          ?>customer/search",
                    success: function(data) {
                      $('.lds-facebook').hide();
                      $("#example3").html(data);
                    },
                  });
                  return false;
                });
              });
              
            </script>

            <?php //echo $this->Form->create('Mysubscription', array('type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'Mysubscriptions', 'class' => 'form-horizontal')); 
            ?> -->
            <script>
              $(document).ready(function() {
                $("#Mysubscriptions").bind("submit", function(event) {
                  $('.lds-facebook').show();
                  $.ajax({
                    async: true,
                    data: $("#Mysubscriptions").serialize(),
                    dataType: "html",
                    type: "GET", // changed from "POST" to "GET"
                    url: "<?php echo ADMIN_URL; ?>customer/search",
                    success: function(data) {
                      $('.lds-facebook').hide();
                      $("#example3").html(data);
                    },
                  });
                  return false;
                });
              });
              $(document).on('click', '.pagination a', function(e) {
                var target = $(this).attr('href');
                // alert(target);
                var res = target.replace("/customer/search", "/customer");
                window.location = res;
                return false;
              });
            </script>

            <?php echo $this->Form->create('Mysubscription', array('type' => 'GET', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'Mysubscriptions', 'class' => 'form-horizontal', 'method' => 'GET')); ?>

            <div class="form-group">
              <div class="col-sm-2">
                <label for="inputEmail3" class="control-label">Name</label>
                <?php echo $this->Form->input('name', array('class' => 'form-control', 'label' => false, 'placeholder' => 'Name', 'autocomplete' => 'off', 'value' => $req_data['name'])); ?>
              </div>
              <div class="col-sm-2">
                <label for="inputEmail3" class="control-label">Mobile</label>
                <?php echo $this->Form->input('mobile', array('class' => 'form-control', 'label' => false, 'placeholder' => 'Mobile', 'autocomplete' => 'off', 'value' => $req_data['mobile'])); ?>
              </div>

              <?php if ($role_id == 1) { ?>
                <div class="col-sm-2">
                  <label for="inputEmail3" class="control-label">Location</label>
                  <?php

                  echo $this->Form->input('location', array('class' =>
                  'form-control', 'label' => false, 'options' => $locations, 'empty' => '--Select Location--', 'autofocus')); ?>
                </div>
              <?php } ?>


              <div class="col-sm-2">
                <label for="inputEmail3" class="control-label">Referred by</label>
                <?php echo $this->Form->input('referral_code', array('class' => 'form-control', 'label' => false, 'placeholder' => 'Referred by', 'autocomplete' => 'off', 'type' => 'number', 'value' => $req_data['referral_code']));
                ?>
              </div>

              <div class="col-sm-2">
                <label for="inputEmail3" class="control-label">From</label>
                <input class="span2 form-control" size="16" placeholder="Exam Date From" title="Exam Date From" type="date" name="from_date">
              </div>

              <div class="col-sm-2">
                <label for="inputEmail3" class="control-label">To</label>
                <input class="span2 form-control" size="16" placeholder="Exam Date From" title="Exam Date From" type="date" name="to_date">
              </div>

         
                  <div class="col-sm-1">
                    <label for="inputEmail3" class="control-label" style="color:white">Search</label>
                    <input type="submit" style="background-color:#00c0ef;" id="Mysubscriptions" class="btn btn4 btn_pdf myscl-btn date" value="Search">
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
                    <th width="5%">S.No</th>
                    <th width="20%">Name</th>
                    <!-- <th width="15%">Email</th>   -->
                    <th width="10%">Mobile</th>
                    <th width="10%">Referral Code</th>
                    <th width="10%">Referred by</th>
                    <th width="10%">Village</th>
                    <th width="5%">Animals</th>
                    <th width="10%">Milk Quantity</th>
                    <th width="10%">Total Orders</th>
                    <th width="10%">Created</th>
                    <!-- <th width="8%">Status</th>      -->
                    <!-- <?php if ($role_id != 2) { ?>
                      <th width="8%">Action</th>
                    <?php   } ?> -->
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $page = $this->request->params['paging']['Users']['page'];
                  $limit = $this->request->params['paging']['Users']['perPage'];
                  $counter = ($page * $limit) - $limit + 1;

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
                        <td><?php echo ucwords(strtolower($users['name']));  ?></td>
                        <td><?php echo $users['mobile'];  ?></td>
                        <td><?php echo $users['referral_code'];  ?></td>
                        <td><?php
                            if (!empty($users['referred_user_id'])) {
                              echo $get_referl['referral_code'] . '<br>' . '<b>Name:</b> ' . ucwords(strtolower($get_referl['name']));
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
                        <td><?php echo date('d-m-Y', strtotime($users['created'])); ?></td>


                        <!-- <td>
                      <?php if ($users['status'] == '1') {
                        echo $this->Html->link('', [
                          'action' => 'status',
                          $users->id, '0'
                        ], ['title' => 'Active', 'class' => 'fa fa-check-circle', 'style' => 'font-size: 21px !important; margin-left: 12px;     color: #36cb3c;']);
                      } else {
                        echo $this->Html->link('', [
                          'action' => 'status', $users->id, '1'
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
            </div>
            <?php echo $this->element('admin/pagination'); ?>

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