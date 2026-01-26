<?php $role_id = $this->request->session()->read('Auth.User.role_id'); ?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Product Manager
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo SITE_URL; ?>admin/dashboards"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo SITE_URL; ?>admin/product">Products</a></li>
    </ol>
  </section> <!-- content header -->

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <?php echo $this->Flash->render(); ?>
            <script>
              $(document).ready(function() {
                $("#Mysubscriptions").bind("submit", function(event) {
                  $('.lds-facebook').show();
                  $.ajax({
                    async: true,
                    data: $("#Mysubscriptions").serialize(),
                    dataType: "html",
                    type: "POST",
                    url: "<?php echo ADMIN_URL; ?>product/search",
                    success: function(data) {
                      $('.lds-facebook').hide();
                      $("#example3").html(data);
                    },
                  });
                  return false;
                });
              });
            </script>
            <?php echo $this->Form->create('Mysubscription', array('type' => 'get', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'Mysubscriptions', 'class' => 'form-horizontal', 'method' => 'get')); ?>

            <div class="form-group">
              <div class="col-sm-2">
                <label for="inputEmail3" class="control-label">Name</label>
                <?php echo $this->Form->input('name', array('class' => 'form-control', 'label' => false, 'placeholder' => 'Product Name', 'autocomplete' => 'off')); ?>
              </div>
            <?php  if ($role_id == 1) { ?>
              <div class="col-sm-2">
                <label for="inputEmail3" class="control-label">Location</label>
                <?php

                echo $this->Form->input('location', array('class' =>
                'form-control', 'label' => false, 'options' => $locations, 'empty' => '--Select Location--', 'autofocus')); ?>
              </div>
              <?php } ?>

              <div class="col-sm-1">
                <label for="inputEmail3" class="control-label" style="color:white">Search</label>
                <input type="submit" style="background-color:#00c0ef;" id="Mysubscriptions" class="btn btn4 btn_pdf myscl-btn date" value="Search">
              </div>
              <?php echo $this->Form->end(); ?>
            </div>
          </div>
        </div>

        <!-- <div class="box"> -->
        <div class="box-header">
          <?php 
          if ($role_id == 1) { ?>
            <a href="<?php echo SITE_URL; ?>admin/product/add">
              <button class="btn btn-success pull-right m-top10"><i class="fa fa-plus" aria-hidden="true"></i>
                Add Product </button></a>
          <?php } ?>

        </div>
        <div class="box-body">
          <table id="example3" class="table table-bordered table-striped" width="100%">
            <thead>
              <tr>
                <th width="5%">S.No</th>
                <th width="12%">Product Name</th>
                <th width="12%">Brand Name</th>
                <th width="12%">Measurement</th>
                <th width="12%">HSN</th>
                <th width="12%">Total Sales</th>
                <?php if ($role_id == 1) { ?>
                  <th width="12%">Location</th>
                <?php } ?>
                <th width="8%">Created</th>
                <th width="8%">Status</th>

              </tr>
            </thead>
            <tbody>
              <?php
              $page = $this->request->params['paging'][$this->request->params['Products']]['page'];
              $limit = $this->request->params['paging'][$this->request->params['Products']]['perPage'];
              $counter = ($page * $limit) - $limit;

              if (isset($Products) && !empty($Products)) {
                foreach ($Products as $product) { //pr($product); die; 
              ?>
                  <tr>
                    <td><?php echo $counter + 1; ?></td>
                    <td><?php echo ucfirst(strtolower($product['name'])); ?> <br> </td>
                    <td><?php echo ucfirst(strtolower($product['brand_name'])); ?></td>
                    <td><?php echo ucfirst(strtolower($product['measurement'])); ?></td>
                    <td><?php echo $product['hsn']; ?></td>
                    <td> ₹ <?php echo sprintf('%.2f', $product['sum']);
                            ?></td>
                    <?php if ($role_id == 1) { ?>
                      <td><?php 
                      echo Ucfirst($product['locality']);
                       ?></td>
                    <?php } ?>
                    <td><?php echo date('d-m-Y', strtotime($product['created'])); ?></td>
                    <td>
                      <?php if ($product['status'] == 'Y') {
                        echo $this->Html->link('', [
                          'action' => 'status',
                          $product['id'], 'N'
                        ], ['title' => 'Active', 'class' => 'fa fa-check-circle', 'style' => 'font-size: 21px !important; margin-left: 12px; color: #36cb3c;']);
                      } else {
                        echo $this->Html->link('', [
                          'action' => 'status', $product['id'], 'Y'
                        ], ['title' => 'Inactive', 'class' => 'fa fa-times-circle-o', 'style' => 'font-size: 21px !important; margin-left: 12px; color:#FF5722;']);
                      } ?>
                      <?php echo $this->Html->link(__(''), ['action' => 'edit', $product['id']], array('class' => 'fa fa-pencil-square-o fa-lg', 'title' => 'Edit', 'style' => 'font-size: 20px !important; margin-left: 12px;')) ?>
                      <?php if ($role_id == 1) {
                        // echo $this->Html->link('', ['action' => 'delete', $product['id']], ['title' => 'Delete', 'class' => 'fa fa-trash', 'style' => 'color:#FF0000; margin-left: 13px; font-size: 19px !important;', "onClick" => "javascript: return confirm('Are you sure do you want to delete this Product')"]);
                      } ?>
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