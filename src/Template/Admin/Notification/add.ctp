<style type="text/css">
  .text {
    color: red;
    font-size: 12px;
  }
</style>
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Notification Manager
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo SITE_URL; ?>admin/dashboards"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo SITE_URL; ?>admin/notification">Manage Notification</a></li>
      <li class="active"><a href="javascript:void(0)">Add Notification</a></li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-info">
          <?php echo $this->Flash->render(); ?>
          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-plus-square" aria-hidden="true"></i> <?php echo 'Create Notification'; ?></h3>
          </div>
          <?php echo $this->Form->create($notification, array(
            'class' => 'form-horizontal',
            'enctype' => 'multipart/form-data',
            'validate'
          )); ?>
          <div class="box-body">
            <div class="form-group">
              <div class="col-sm-3">
                <label for="inputEmail3" class="control-label">Title</label>
                <?php echo $this->Form->input('title', array('class' => 'form-control', 'required', 'label' => false, 'placeholder' => 'Title', 'autofocus', 'autocomplete' => 'off')); ?>
              </div>
              <div class="col-sm-3">
                <label for="inputEmail3" class="control-label">Send Notification To</label>
                <?php
                $type = [0 => 'Customers'];
                echo $this->Form->input('role_id', array('class' => 'longinput form-control input-medium secrh-retail', 'type' => 'select', 'label' => false, 'required', 'autocomplete' => 'off', 'options' => $type)); ?>
              </div>
              <div class="col-sm-3">
                <label for="inputEmail3" class="control-label">Message</label>
                <?php echo $this->Form->input('message', array('class' => 'form-control', 'required', 'label' => false, 'placeholder' => 'Message', 'autofocus', 'autocomplete' => 'off')); ?>
              </div>
            </div>
          </div>
          <div class="box-footer">
            <?php
            if (isset($notification['id'])) {
              echo $this->Form->submit(
                'Update',
                array('class' => 'btn btn-info pull-right', 'title' => 'Update')
              );
            } else {
              echo $this->Form->submit(
                'Add',
                array('class' => 'btn btn-info pull-right', 'title' => 'Add')
              );
            }
            ?><?php
                        echo $this->Html->link('Back', [
                          'action' => 'index'

                        ], ['class' => 'btn btn-default']); ?>
          </div>
          <?php echo $this->Form->end(); ?>
        </div>
      </div>
    </div>
  </section>
</div>