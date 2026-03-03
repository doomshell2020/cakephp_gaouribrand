<?php $role_id = $this->request->session()->read('Auth.User.role_id'); ?>
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
                        ], ['title' => 'Active', 'class' => 'fa fa-check-circle', 'style' => 'font-size: 21px !important; margin-left: 12px;     color: #36cb3c;']);
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
<?php echo $this->element('admin/pagination');
?>