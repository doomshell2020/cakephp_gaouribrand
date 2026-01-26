<script>
    //  function checkextension() {
    //   var file = document.querySelector("#fUpload");
    //   if ( /\.(jpe?g|png|gif)$/i.test(file.files[0].name) === false ) 
    //     { alert("not an image please choose a image!");
    //   $('#fUpload').val('');
    // }
    // return false;
    // }


    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }
</script>
<style type="text/css">
    .text {
        color: red;
        font-size: 12px;
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Vendor Manager
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo SITE_URL; ?>admin/dashboards"><i class="fa fa-home"></i>Home</a></li>
            <li><a href="<?php echo SITE_URL; ?>admin/vendor">Manage Vendor</a></li>
            <li class="active"><a href="javascript:void(0)">Edit Vendor</a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <?php echo $this->Flash->render(); ?>
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-plus-square" aria-hidden="true"></i> <?php if (isset($vendor_data['id'])) {
                                                                                                        echo 'Edit Vendor';
                                                                                                    } else {
                                                                                                        echo 'Edit Vendor';
                                                                                                    } ?></h3>
                    </div>

                    <?php echo $this->Form->create($vendor_data, array(
                        'class' => 'form-horizontal',
                        'enctype' => 'multipart/form-data',
                        'validate'
                    )); ?>
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-sm-4">
                                <label for="inputEmail3" class="control-label">Vendor Name</label>
                                <?php echo $this->Form->input('name', array('class' => 'form-control', 'required', 'label' => false, 'placeholder' => 'Vendor Name', 'autofocus', 'autocomplete' => 'off')); ?>
                            </div>

                            <div class="col-sm-4">
                                <label for="inputEmail3" class="control-label">Mobile No.</label>
                                <?php echo $this->Form->input('mobile', array('class' => 'form-control', 'required', 'label' => false, 'placeholder' => 'Mobile No.', 'autofocus', 'autocomplete' => 'off')); ?>
                            </div>

                            <div class="col-sm-4">
                                <label for="inputEmail3" class="control-label">User Email</label><span style="color:red">*</span>
                                <?php echo $this->Form->input('email', array('class' => 'form-control', 'required', 'label' => false, 'placeholder' => 'User Email', 'autofocus', 'autocomplete' => 'off')); ?>
                            </div>

                            <div class="col-sm-4">
                                <label for="inputEmail3" class="control-label">Village Name</label>
                                <?php echo $this->Form->input('villagename', array('class' => 'form-control', 'label' => false, 'placeholder' => 'Village Name', 'autofocus', 'autocomplete' => 'off')); ?>
                            </div>

                            <div class="col-sm-4">
                                <label for="inputEmail3" class="control-label">Animals</label>
                                <?php echo $this->Form->input('animalCount', array('class' => 'form-control', 'label' => false, 'placeholder' => 'Animals', 'autofocus', 'autocomplete' => 'off')); ?>
                            </div>
                            <div class="col-sm-4">
                                <label for="inputEmail3" class="control-label">Location</label><span style="color:red">*</span>
                                <?php
                                echo $this->Form->input('location', array('class' =>
                                'form-control', 'label' => false, 'options' => $locations, 'empty' => '--Select Location--', 'autofocus', 'required')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <?php
                        if (isset($vendor_data['id'])) {
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