<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Vendor Manager
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo SITE_URL; ?>admin/dashboards"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo SITE_URL; ?>admin/vendor">Vendor</a></li>
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
            <!-- <script>          
    $(document).ready(function () { 
    $("#Mysubscriptions").bind("submit", function (event) {
    $('.lds-facebook').show();
    $.ajax({
                async:true,
                data:$("#Mysubscriptions").serialize(),
                dataType:"html",
                type:"get",
                url:"<?php echo ADMIN_URL; ?>product/search",
                success:function (data) {
          $('.lds-facebook').hide();   
                $("#example2").html(data); },
                });
                return false;
              });
            });


  $(document).on('click', '.pagination a', function(e) {
  var target = $(this).attr('href');
  //alert(target);
  var res = target.replace("/product/search", "/product");
  window.location = res;

  return false;
  });
  </script>

  <?php echo $this->Form->create('Mysubscription', array('type' => 'get', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'Mysubscriptions', 'class' => 'form-horizontal', 'method' => 'get')); ?>
      
      <div class="form-group" >
      <div class="col-sm-2">
          <label for="inputEmail3" class="control-label">Name</label> 
          <?php echo $this->Form->input('name', array('class' => 'form-control', 'label' => false, 'placeholder' => 'Name', 'autocomplete' => 'off')); ?>  
        </div> 
        <div class="col-sm-2">
            <label for="inputEmail3" class="control-label">Select Category</label>
                <?php echo $this->Form->input('name', array('class' =>
                'form-control', 'id' => 'cate', 'label' => false, 'options' => $categoryname, 'empty' => '--Select Category--', 'autofocus')); ?>
              </div>

          <div class="col-sm-1">
        <label for="inputEmail3" class="control-label" style="color:white">Search</label>
        <input type="submit" style="background-color:#00c0ef;" id="Mysubscriptions" class="btn btn4 btn_pdf myscl-btn date" value="Search">       
      </div> 
        <?php echo $this->Form->end(); ?> 
        </div>  
          </div> 
            </div>  -->

            <!-- <div class="box"> -->
            <!-- <div class="box-header">
            <a href="<?php echo SITE_URL; ?>admin/product/add">
              <button class="btn btn-success pull-right m-top10"><i class="fa fa-plus" aria-hidden="true"></i>
              Add Product </button></a>
              </div> -->
            <div class="box-body">
              <table class="table table-bordered table-striped" width="100%">
                <thead>
                  <tr>
                    <th width="5%">S.No</th>
                    <th width="15%">Name</th>
                    <th width="15%">Email</th>
                    <th width="10%">Mobile</th>
                    <th width="20%">Address</th>
                    <!-- <th width="5%">Animals</th>
                    <th width="5%">Milk Quantity</th> -->
                    <th width="10%">Created</th>
                    <th width="8%">Area Location</th>
                    <th width="10%">Action</th>

                  </tr>
                </thead>
                <tbody>
                  <?php
                  $counter = ($this->request->params['paging']['Products']['page'] - 1) * $this->request->params['paging']['Products']['perPage'];
                  if (isset($users) && !empty($users)) {
                    foreach ($users as $users) { //pr($users);die;
                      $get_location_name = $this->Comman->getlocationname($users['id']);
                 
                  ?>
                      <tr>
                        <td><?php echo $counter + 1; ?></td>
                        <td><?php echo ucwords(strtolower($users['name']));  ?></td>
                        <td><?php echo $users['email'];  ?></td>

                        <td><?php echo $users['mobile'];  ?></td>
                        <td><?php echo strip_tags($users['address']);  ?></td>
                        <!-- <td><?php //echo $users['animalCount'];  
                                  ?></td>
                        <td><?php //echo $users['milkQuantity'];  
                            ?></td> -->
                        <td><?php echo date('d-m-Y', strtotime($users['created'])); ?></td>
                        <td style="color: #0125ea;">
                          <?php
                          if (!empty($get_location_name)) {
                            $links = [];
                            foreach ($get_location_name as $location) {
                              $links[] = '<a href="' . ADMIN_URL . 'servicearea/servicearea/' . $location->id . '" class="documentcls">' . $location->name . '</a>';
                            }
                            echo implode(', ', $links);
                          } else {
                            echo '--';
                          }
                          ?>
                        </td>
                        <td>
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
                          <?php echo $this->Html->link(__(''), ['action' => 'vendoredit', $users->id], array('class' => 'fa fa-pencil-square-o fa-lg', 'title' => 'Edit', 'style' => 'font-size: 20px !important; margin-left: 12px;')) ?>


                          <!-- <a href=" <?php //echo SITE_URL; 
                                          ?>admin/vendor/commision/<?php //echo $users->id; \ 
                                                                    ?>">&nbsp;Add Commission</a> -->
                        </td>
                      </tr>
                  <?php $counter++;
                    }
                  } ?>
                </tbody>
              </table>

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


<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #3c8dbc;">
        <h5 class="modal-title" id="exampleModalLabel"><b>Area Location</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php echo $this->Form->create(null, ['url' => ['controller' => 'vendor', 'action' => 'index']]); ?>
        <div class="form-group">
          <div class="col-sm-6" style="display: flex; align-items: center;">
            <label for="inputEmail3" class="control-label" style="margin-right: 10px;">Location:</label>
            <?php

            echo $this->Form->select('location', $locations, ['class' => 'form-control', 'label' => false, 'empty' => '--Select Category--', 'autofocus']);
            ?>
          </div>
        </div>
      </div>
      <div class="modal-footer" style="border: none;">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
        <?php echo $this->Form->button('Submit', ['class' => 'btn btn-primary']); ?>
        <?php echo $this->Form->end(); ?>
      </div>
    </div>
  </div>
</div>