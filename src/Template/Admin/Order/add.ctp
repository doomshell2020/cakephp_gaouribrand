<style type="text/css">
    .text {
        color: red;
        font-size: 12px;
    }

    div#productContains .col-sm-3 {
        margin-top: 15px;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Order Manager
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo SITE_URL; ?>admin/dashboards"><i class="fa fa-home"></i>Home</a></li>
            <li><a href="<?php echo SITE_URL; ?>admin/order">Manage Order</a></li>
            <li class="active"><a href="<?php echo SITE_URL; ?>admin/order/add">Add Order</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <?php echo $this->Flash->render(); ?>
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-plus-square" aria-hidden="true"></i>
                            <?php echo 'Create Order'; ?></h3>
                    </div>
                    <?php echo $this->Form->create('', [
                        'class' => 'form-horizontal',
                        'enctype' => 'multipart/form-data',
                        'id' => 'orderForm',
                        'validate'
                    ]); ?>
                    <div class="box-body">

                        <div class="form-group">
                            <div class="col-sm-3">
                                <label for="inputEmail3" class="control-label">Mobile<strong
                                        style="color:red;">*</strong></label>
                                <?php echo $this->Form->input('mobile', array('class' => 'form-control', 'label' => false, 'placeholder' => 'Mobile', 'autocomplete' => 'off', 'id' => 'mobileNo', 'type' => 'text', 'required', 'maxlength' => 10, 'onkeypress' => "return validateNumber(event)")); ?>
                            </div>
                            <div class="col-sm-3">
                                <label for="inputEmail3" class="control-label">Name<strong
                                        style="color:red;">*</strong></label>
                                <?php echo $this->Form->input('name', array('class' => 'form-control', 'id' => 'name', 'required', 'label' => false, 'placeholder' => 'Name', 'autocomplete' => 'off')); ?>
                            </div>
                            <div class="col-sm-3">
                                <label for="inputEmail3" class="control-label">Billing Address<strong
                                        style="color:red;">*</strong></label>
                                <input class="span2 form-control" placeholder="Billing Address" title="Billing Address"
                                    id="address" type="text" name="address" required>
                            </div>
                             <div class="col-sm-3">
                                <label for="inputEmail3" class="control-label">Village<strong
                                        style="color:red;">*</strong></label>
                                <input class="span2 form-control" placeholder="Village" title="Village"
                                    id="villagename" type="text" name="villagename" required>
                            </div>
                            <!-- <div class="col-sm-3">
                                <label for="inputEmail3" class="control-label">Village</label>
                                <input class="span2 form-control" placeholder="Village" title="Village" type="text"
                                    id="village" name="villagename">
                            </div> -->
                            <div class="col-sm-3">
                                <label for="inputEmail3" class="control-label">Location<strong
                                        style="color:red;">*</strong></label>
                                <?php
                                echo $this->Form->input('location', array('class' => 'form-control', 'label' => false, 'id' => 'location', 'options' => $locations, 'required', 'empty' => '--Select Location--', 'autofocus')); ?>
                            </div>
                            <div class="col-sm-3">
                                <label for="inputEmail3" class="control-label">Vendor<strong
                                        style="color:red;">*</strong></label>
                                <?php
                                echo $this->Form->input('vendor', array('class' => 'form-control', 'required', 'id' => 'vendor_id', 'label' => false, 'options' => $Vendor,'autofocus')); ?>
                            </div>

                            <script>
                                function validateNumber(e) {
                                    const pattern = /^[0-9]$/;
                                    return pattern.test(e.key)
                                }
                            </script>

                            <div class="col-sm-3">
                                <a href="#" class="btn btn-success" style="margin-right: 3px;margin-top: 26px;"
                                    id='addRow'><i class="fa fa-plus" aria-hidden="true"></i>
                                    Add Products </a>
                            </div>

                            <div class="col-sm-12">
                                <div class="row item-row" style="display:none;">
                                    <div class="col-sm-3">
                                        <label for="inputEmail3" class="control-label">Products Name<strong
                                                style="color:red;">*</strong></label>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="inputEmail3" class="control-label">Unit<strong
                                                style="color:red;">*</strong></label>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="inputEmail3" class="control-label">Quantity<strong
                                                style="color:red;">*</strong></label>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="inputEmail3" class="control-label">Price<strong
                                                style="color:red;">*</strong></label>
                                    </div>
                                    <div class="col-sm-12">
                                        <div id='productContains'>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-3">
                            </div>
                            <div class="col-sm-3">
                            </div>
                            <div class="col-sm-3">
                                <label for="inputEmail3" class="control-label">Discount</label>
                                <?php echo $this->Form->input('discount', array('class' => 'form-control', 'id' => 'discount', 'label' => false, 'value' => 0, 'type' => 'number', 'step' => '0.01')); ?>
                            </div>
                            <div class="col-sm-3">
                                <label for="inputEmail3" class="control-label">Total<strong
                                        style="color:red;">*</strong></label>
                                <?php echo $this->Form->input('total', array('class' => 'form-control', 'id' => 'total', 'readonly', 'label' => false, 'value' => 0)); ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="box-footer">
                <?php
                echo $this->Form->submit($checkuser['id'] ? 'Update' : 'Add', [
                    'class' => 'btn btn-info pull-right',
                    'title' => $checkuser['id'] ? 'Update' : 'Add'
                ]);
                echo $this->Html->link('Back', ['action' => 'index'], ['class' => 'btn btn-default']);
                ?>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
</div>
</div>
</section>
</div>
<?php $count = 1; ?>
<script>
    $("#mobileNo").change(function () {
        var mobile = $('#mobileNo').val();
        if (mobile != "") {
            $.ajax({
                type: "POST",
                url: '<?php echo SITE_URL; ?>admin/order/checkmobileno',
                data: {
                    'mobile': mobile
                },
                cache: false,
                success: function (response) {
                    if (response != 'null') {
                        var data = JSON.parse(response);
                        $('#name').val(data.name).prop('readonly', true);
                        $('#address').val(data.address).prop('readonly', true);
                        $('#villagename').val(data.villagename).prop('readonly', true);
                        $('#location').val(data.location_id).prop('disabled', true);
                        $('#vendor_id').val(data.vendor_id);
                    } else {
                        $('#name').val('').prop('readonly', false);
                        $('#address').val('').prop('readonly', false);
                        $('#villagename').val('').prop('readonly', false);
                        $('#location').val('').prop('disabled', false);
                        // $('#vendor_id').val('').prop('disabled', false);
                    }
                }
            });
        }
    });
</script>


<script>
    var count = <?php echo $count; ?>;

    $("#addRow").click(function () {
        var vendorId = $('#vendor_id').val();
        if (vendorId != "") {
            $.ajax({
                type: "POST",
                url: '<?php echo SITE_URL; ?>admin/order/getvendorproducts',
                data: {
                    'vendor_id': vendorId
                },
                cache: false,

                success: function (response) {
                    try {
                        $('.item-row').css('display', 'block');

                        if (response) {
                            var jsonArray = JSON.parse(response);

                            var parentDiv = $('<div>').addClass('row-' + count).addClass('row');

                            var productNameDiv = $('<div>').addClass('col-sm-3');
                            var productNameInput = $('<select>')
                                .attr('id', 'product-' + count)
                                .attr('name', 'product_id[]')
                                .prop('required', true)
                                .addClass('form-control product');
                            productNameInput.append($('<option>').attr('value', '').text('-- Select Product --'));
                            jsonArray.forEach(function (item) {
                                var option = $('<option>')
                                    .attr('value', item.id)
                                    .text(item.name);
                                productNameInput.append(option);
                            });

                            productNameDiv.append(productNameInput);
                            parentDiv.append(productNameDiv);

                            var unitDiv = $('<div>').addClass('col-sm-3');
                            var unitSelect = $('<select>')
                                .addClass('form-control unit')
                                .attr('id', 'unit-' + count)
                                .attr('name', 'unit[]')
                                .prop('required', true);
                            unitSelect.append($('<option>').attr('value', '').text(
                                '-- Select Unit --'));
                            unitDiv.append(unitSelect);
                            parentDiv.append(unitDiv);

                            var quantityDiv = $('<div>').addClass('col-sm-3');
                            var quantityInput = $('<input>')
                                .attr('type', 'number')
                                .addClass('form-control quantity')
                                .attr('id', 'quantity-' + count)
                                .attr('name', 'quantity[]')
                                .prop('required', true)
                                .attr('step', '0.01')
                                .val('1');
                            quantityDiv.append(quantityInput);
                            parentDiv.append(quantityDiv);

                            var priceDiv = $('<div>').addClass('col-sm-3');
                            var priceInput = $('<input>')
                                .attr('type', 'text')
                                .addClass('form-control price')
                                .attr('id', 'price-' + count)
                                .attr('name', 'price[]')
                                .prop('readonly', true);
                            priceDiv.append(priceInput);
                            parentDiv.append(priceDiv);

                            var colMd2Div = $('<div>').addClass('col-md-2');
                            var anchorTag = $('<a>')
                                .attr('href', '#')
                                .attr('id', 'delete-' + count)
                                .addClass('fa fa-trash delete')
                                .css({
                                    'color': 'red',
                                    'font-size': '20px'
                                })
                                .text(' Delete');
                            colMd2Div.append(anchorTag);
                            parentDiv.append(colMd2Div);

                            $('#productContains').append(parentDiv);
                            count++;
                        } else {
                            alert('Empty response received.');
                        }
                    } catch (e) {
                        console.error('Error parsing JSON:', e);
                        alert('Error parsing response.');
                    }
                }
            });
        } else {
            alert('Please select vendor');
        }
    });


    $(document).on('click', '.delete', function () {
        var idParts = $(this).attr('id').split('-');
        var count1 = idParts[1];
        $('.row-' + count1).remove();
        totalsAmount();
        count--;
    });

    $('#orderForm').on('submit', function () {

        if (count == 1 || count < 1) {
            alert('Atleast add one product');
            return false;
        } else {
            $('#location').prop('disabled', false);
            // $('#vendor_id').prop('disabled', false);
            return true;
        }
    });
</script>

<script>
    $(document).on('change', '.product', function () {
        var idParts = $(this).attr('id').split('-');
        var count = idParts[1];
        var productId = $('#product-' + count).val();
        var quantity = $('#quantity-' + count).val();
        if (productId != "") {
            $.ajax({
                type: "POST",
                url: '<?php echo SITE_URL; ?>admin/order/getproduct_details',
                data: {
                    'product_id': productId,
                },
                cache: false,
                success: function (response) {
                    var jsonArray = JSON.parse(response);
                    var price = quantity * jsonArray.price;
                    $('#price-' + count).val(price);
                    var select = $("#unit-" + count);
                    select.empty();
                    jsonArray.unit.forEach(function (unit) {
                        select.append($('<option>', {
                            value: unit,
                            text: unit
                        }));
                    });
                    totalsAmount();
                }
            });
        }
    });
</script>
<script>
    function totalsAmount() {
        let totalAmount = 0;
        $('.price').each(function () {
            totalAmount += parseFloat($(this).val()) || 0;
        });
        var discount = $('#discount').val();
        acutalAmount = totalAmount - discount;
        if(acutalAmount < 0){
            $('#total').val(0);
            $('#discount').val(0);
        }else{
            $('#total').val(acutalAmount);
        }
    }
</script>
<script>
    $(document).on('change', '.unit', function () {
        var idParts = $(this).attr('id').split('-');
        var productId = idParts[0];
        var count = idParts[1];
        var unitQty = $(this).val();
        var productId = $('#product-' + count).val();
        var quantity = $('#quantity-' + count).val();
        if (productId != "") {
            $.ajax({
                type: "POST",
                url: '<?php echo SITE_URL; ?>admin/order/getproductprice',
                data: {
                    'product_id': productId,
                    'unitQty': unitQty
                },
                cache: false,
                success: function (response) {
                    var price = quantity * response;
                    $('#price-' + count).val(price);
                    totalsAmount();
                }
            });
        }
    });
</script>
<script>
    $(document).on('input', '.quantity', function () {
        var idParts = $(this).attr('id').split('-');
        var count = idParts[1];
        var quantity = $(this).val();
        var unitQty = $('#unit-' + count).val();
        var productId = $('#product-' + count).val();
        if (productId != "") {
            $.ajax({
                type: "POST",
                url: '<?php echo SITE_URL; ?>admin/order/getproductprice',
                data: {
                    'product_id': productId,
                    'unitQty': unitQty
                },
                cache: false,
                success: function (response) {
                    var price = quantity * response;
                    $('#price-' + count).val(price);
                    totalsAmount();
                }
            });
        }
    });
</script>
<script>
    $(document).on('input', '#discount', function () {
        let totalAmount = 0;
        $('.price').each(function () {
            totalAmount += parseFloat($(this).val()) || 0;
        });
        var discount = $('#discount').val();
        acutalAmount = totalAmount - discount;
        if(acutalAmount < 0){
            alert('Amount can not be less then 0');
            $('#total').val(0);
            $('#discount').val(0);
        }else{
            $('#total').val(acutalAmount);
        }
    });
</script>
