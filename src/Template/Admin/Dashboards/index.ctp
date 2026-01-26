<script>
  jQuery(document).ready(function() {
    jQuery(".sidebar-toggle").click(function() {
      jQuery("body").toggleClass("sidebar-collapse");
    });
  });
</script>
<style type="text/css">
  /* .col-lg-3 {
    width: 25%;
  } */
  .abc {
    background-color: #79c324 !important;
  }

  .small-box>.inner {
    padding: 10px;
    min-height: 100px;
  }

  p {
    margin: 0 0 0px;
  }
</style>

<?php  ?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Dashboard
      <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-lg-3">
        <div class="small-box bg-aqua">
          <div class="inner">

            <h3><?php echo $total_product; ?></h3>
            <p>Total Products</p>
          </div>
          <div class="icon" style="top: 0px;">
            <i class="fa fa-align-right"></i>
          </div>
          <a href="<?php echo ADMIN_URL; ?>product/index" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3">
        <div class="small-box abc bg-aqua">
          <div class="inner">

            <h3><?php echo $total_customer; ?></h3>
            <p>Total Customers</p>
          </div>
          <div class="icon" style="top: 0px;">
            <i class="fa fa-product-hunt"></i>
          </div>
          <a href="<?php echo ADMIN_URL; ?>customer/index" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3">
        <div class="small-box bg-yellow">
          <div class="inner">

            <h3><?php echo $order; ?></h3>
            <p>Total Order</p>
          </div>
          <div class="icon" style="top: 0px;">
            <i class="fa fa-user"></i>
          </div>
          <a href="<?php echo ADMIN_URL; ?>order/index" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="clearfix visible-sm-block"></div>

      <?php $role_id = $this->request->session()->read('Auth.User.role_id');

      if ($role_id != 2) { ?>

        <div class="col-lg-3">
          <div class="small-box bg-red">
            <div class="inner">

              <h3><?php echo $total_vendor; ?></h3>
              <p>Total Vendor</p>
            </div>
            <div class="icon" style="margin-top: 14px;">
              <i class="fa fa-flag"></i>
            </div>
            <a href="<?php echo ADMIN_URL ?>vendor/index" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

      <?php } ?>

      <!-- <div class="col-lg-3">
        <div class="small-box bg-red">
          <div class="inner">
            <h3><?php echo count($users) + count($customer) + count($Products) + count($order); ?></h3>
            <p>Total Output</p>
          </div>
          <div class="icon" style="margin-top: 8px;">
            <i class="fa fa-first-order"></i>
          </div>
          <a href="<?php echo ADMIN_URL ?>order/index" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div> -->
    </div>

    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title"><strong>Latest Products</strong></h3>
      </div>
      <div class="box-body">
        <div class="table-responsive">
          <table class="table no-margin">

            <thead>
              <tr>
                <th width="5%">S.No</th>
                <th width="13%">Prduct Name</th>
                <th width="13%">Brand Name</th>
                <th width="8%">Measurement</th>
                <th width="8%">HSN</th>
                <th width="8%">Created</th>
                <th width="8%">Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $counter = 1;
              if (isset($Products) && !empty($Products)) {
                foreach ($Products as $product) { ?>
                  <tr>
                    <!-- <td><?php echo $counter; ?></td> -->
                    <td><?php echo $counter; ?></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo ucwords(strtolower($product['brand_name'])); ?></td>
                    <td><?php echo $product['measurement']; ?></td>
                    <td><?php echo $product['hsn']; ?></td>
                    <!-- <td><?php //echo substr($product['description'],0,200); 
                              ?></td> -->
                    <td><?php echo date('d-m-Y', strtotime($product['created'])); ?></td>
                    <td>
                      <?php if ($product['status'] == 'Y') {
                        echo $this->Html->link('', [
                          'action' => 'status',
                          $product->id,
                          'N'
                        ], ['title' => 'Active', 'class' => 'fa fa-check-circle', 'style' => 'font-size: 21px !important; margin-left: 12px; color: #36cb3c;']);
                      } else {
                        echo $this->Html->link('', [
                          'action' => 'status',
                          $product->id,
                          'Y'
                        ], ['title' => 'Inactive', 'class' => 'fa fa-times-circle-o', 'style' => 'font-size: 21px !important; margin-left: 12px; color:#FF5722;']);
                      } ?>
                    </td>
                  </tr>
              <?php $counter++;
                }
              } ?>
            </tbody>
          </table>
          <?php echo $this->element('admin/pagination'); ?>
        </div>

        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title"><strong>Latest Customer</strong> </h3>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table class="table no-margin">
                <thead>
                  <tr>
                    <th width="5%">S.No</th>
                    <th width="15%">Name</th>
                    <!-- <th width="15%">Email</th>   -->
                    <th width="10%">Mobile</th>
                    <th width="10%">Village Name</th>
                    <th width="5%">Animals</th>
                    <th width="10%">Milk Quantity</th>
                    <th width="10%">Created</th>
                    <?php if ($role_id == 1) { ?>
                      <th width="8%">Status</th>
                    <?php } ?>
                  </tr>
                </thead>
                <tbody>
                  <?php $page = $this->request->params['paging']['']['page'];
                  $limit = $this->request->params['paging']['']['perPage'];
                  $counter = ($page * $limit) - $limit + 1;
                  if (isset($users) && !empty($users)) {
                    foreach ($users as $users) {  ?>
                      <tr>
                        <td><?php echo $counter; ?></td>
                        <td><?php echo ucwords(strtolower($users['name']));  ?></td>
                        <td><?php echo $users['mobile'];  ?></td>
                        <td><?php echo ucfirst($users['villagename']);  ?></td>
                        <td><?php echo $users['animalCount'];  ?></td>
                        <td><?php echo $users['milkQuantity'];  ?></td>
                        <td><?php echo date('d-m-Y', strtotime($users['created'])); ?></td>


                        <?php if ($role_id == 1) { ?>
                          <td>
                            <?php if ($users['status'] == '1') {
                              echo $this->Html->link('', [
                                'action' => 'user_status',
                                $users->id,
                                '0'
                              ], ['title' => 'Active', 'class' => 'fa fa-check-circle', 'style' => 'font-size: 21px !important; margin-left: 12px;     color: #36cb3c;']);
                            } else {
                              echo $this->Html->link('', [
                                'action' => 'user_status',
                                $users->id,
                                '1'
                              ], ['title' => 'Inactive', 'class' => 'fa fa-times-circle-o', 'style' => 'font-size: 21px !important; margin-left: 12px; color:#FF5722;']);
                            } ?>
                          </td>
                        <?php } ?>

                      </tr>
                    <?php $counter++;
                    }
                  } else { ?>
                    <tr>
                      <td colspan="8">No Record Found</td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
              <?php echo $this->element('admin/pagination'); ?>

            </div>
          </div>
        </div>
  </section>
</div>
<!-- <script src="<?php echo SITE_URL; ?>/dist/js/pages/dashboard2.js"></script> -->