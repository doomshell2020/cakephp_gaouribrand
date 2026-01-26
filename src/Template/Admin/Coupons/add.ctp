<div class="content-wrapper">
  <section class="content-header">
    <h1>Coupon Code Manager</h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo SITE_URL; ?>admin/dashboards"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo SITE_URL; ?>admin/coupons">Coupon Code Manager</a></li>
      <li class="active"><a href="<?php echo SITE_URL; ?>admin/coupons/add">Add Coupon</a></li>
    </ol>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-info">
          <?php echo $this->Flash->render(); ?>
          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-plus-square" aria-hidden="true"></i> <?php echo 'Create Coupon'; ?></h3>
          </div>
          <?php echo $this->Form->create($coupans, array(
            'class' => 'form-horizontal',
            'controller' => 'coupons',
            'action' => 'add',
            'enctype' => 'multipart/form-data',
            'id' => 'MyForm',
            'validate'
          )); ?>
          <div class="box-body">
            <div class="container-fluid">
              <div class="form-group">
                <div class="col-sm-3">
                  <label for="inputEmail3" class="control-label">Coupon Code</label>
                  <?php echo $this->Form->input('code', array('class' => 'longinput form-control input-medium', 'placeholder' => 'Coupon Code', 'type' => 'text', 'label' => false, 'required', 'autocomplete' => 'off')); ?>
                </div>
                <!-- 
                  <div class="col-sm-3">
                    <label for="inputEmail3" class="control-label">Applicable To</label>
                    <?php echo $this->Form->input('applicable_to', array('class' => 'longinput form-control input-medium', 'id' => 'applicable-to', 'type' => 'select', 'options' => $applicableTo, 'label' => false, 'required', 'autocomplete' => 'off')); ?>
                  </div> -->

                <div class="col-sm-3">
                  <label for="inputEmail3" class="control-label">Applicable Type</label><br>
                  <?php echo $this->Form->radio(
                    'applicable_type',
                    [
                      ['value' => 'amount', 'text' => 'Amount', 'label' => false, 'checked', 'class' => 'custom-radio applicatble-type', 'required', 'autocomplete' => 'off', 'id' => 'amount'],
                      ['value' => 'percentage', 'text' => 'Percentage', 'label' => false, 'class' => 'custom-radio applicatble-type', 'required', 'autocomplete' => 'off', 'id' => 'percent'],
                    ]
                  );
                  ?>
                </div>
              </div>
              <div class="form-group">
                <!-- <div class="col-sm-3">
                    <label for="inputEmail3" class="control-label">Discount Type</label><br>
                      <?php echo $this->Form->radio(
                        'discount_type',
                        [
                          ['value' => 'flat', 'text' => 'Flat Discount', 'label' => false, 'checked', 'class' => 'custom-radio discount-type', 'required', 'autocomplete' => 'off'],
                        ]
                      );
                      ?>
                    </div> -->
                <div id="amnt">
                  <div class="col-sm-3">
                    <label for="inputEmail3" class="control-label">Minimum Order value</label>
                    <?php echo $this->Form->input('minimum_order_value', array('class' => 'longinput form-control input-medium', 'type' => 'number', 'palceholder' => 'Minimum Order Value', 'label' => false, 'autocomplete' => 'off', 'id' => 'minval')); ?>
                  </div>

                  <div class="col-sm-3">
                    <label for="inputEmail3" class="control-label">Discount Amount</label>
                    <?php echo $this->Form->input('discount_amount', array('class' => 'longinput form-control input-medium', 'type' => 'number', 'palceholder' => 'Maximum Discount', 'label' => false, 'autocomplete' => 'off', 'id' => 'maxval')); ?>
                  </div>
                </div>

                <div id="dis" style="display : none">
                  <div class="col-sm-3">
                    <label for="inputEmail3" class="control-label">Discount Rate</label>
                    <?php echo $this->Form->input('discount_rate', array('class' => 'longinput form-control input-medium', 'type' => 'text', 'palceholder' => 'Discount Rate', 'label' => false, 'autocomplete' => 'off', 'id' => 'discount')); ?>
                  </div>
                  <div class="col-sm-3">
                    <label for="inputEmail3" class="control-label">Maximum Discount Amount</label>
                    <?php echo $this->Form->input('maximum_discount', array('class' => 'longinput form-control input-medium', 'type' => 'text', 'palceholder' => 'Maximum Discount Amount', 'label' => false, 'autocomplete' => 'off', 'id' => 'maxdiscount')); ?>
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-sm-3">
                    <label for="inputEmail3" class="control-label">Coupon Valid From</label>
                    <?php echo $this->Form->input('valid_from', array('class' => 'longinput form-control input-medium', 'type' => 'text', 'palceholder' => 'Valid From Date', 'label' => false, 'required', 'autocomplete' => 'off', 'readonly', 'id' => 'datepicker1')); ?>
                  </div>

                  <div class="col-sm-3">
                    <label for="inputEmail3" class="control-label">Coupon Valid To</label>
                    <?php echo $this->Form->input('valid_to', array('class' => 'longinput form-control input-medium ', 'type' => 'text', 'palceholder' => 'Valid To Date', 'label' => false, 'required', 'autocomplete' => 'off', 'readonly', 'id' => 'datepicker2')); ?>
                  </div>


                </div>


                <div class="form-group">
                  <!-- <div class="col-sm-3">
                      <label for="inputEmail3" class="control-label">Applicable Categories</label>
                      <?php echo $this->Form->input('categories[]', array('class' => 'longinput form-control input-medium', 'id' => 'categories', 'type' => 'select', 'multiple', 'options' => $categories, 'empty' => 'Select Category', 'label' => false, 'autocomplete' => 'off', 'style' => "width:100%")); ?>
                    </div>

                    <div class="col-sm-3">
                      <label for="inputEmail3" class="control-label">Applicable Products</label>
                      <?php echo $this->Form->input('products[]', array('class' => 'longinput form-control input-medium', 'id' => 'products', 'type' => 'select', 'multiple', 'options' => $products, 'empty' => 'Select Products', 'label' => false, 'autocomplete' => 'off', 'style' => "width:100%")); ?>
                    </div>
                     -->
                  <div class="col-sm-3">
                    <label for="inputEmail3" class="control-label">Description</label>
                    <?php echo $this->Form->input('description', array('class' => 'longinput form-control input-medium', 'type' => 'textarea', 'palceholder' => 'Description', 'label' => false, 'required', 'autocomplete' => 'off')); ?>
                  </div>

                </div>
              </div>
            </div>
            <div class="box-footer">
              <?php echo $this->Form->submit('Add', array('class' => 'btn btn-info pull-right', 'title' => 'Add')); ?>
              <?php echo $this->Html->link('Back', ['action' => 'index'], ['class' => 'btn btn-default']); ?>
            </div>
            <?php echo $this->Form->end(); ?>
          </div>
        </div>
      </div>
  </section>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('MyForm');

    form.addEventListener('submit', function(event) {
      event.preventDefault();

      const selectedValue = document.querySelector('input[name="applicable_type"]:checked').value;
      var minOrderValue = $('#minval').val();
      var maxOrderValue = $('#maxval').val();
      var datepicker1Value = $('#datepicker1').val();
      var datepicker2Value = $('#datepicker2').val();
      var discountRateValue = $('#discount').val();

      if (selectedValue == 'amount') {
        if (minOrderValue == '') {
          alert('Minium Order Value Field are required');
        } else if (maxOrderValue == '') {
          alert('Discount Amount Field are required');
        } else if (datepicker1Value == '') {
          alert('Coupon Valid From Field are required');
        } else if (datepicker2Value == '') {
          alert('Coupon Valid to Field are required');
        } else {
          form.submit(); // This submits the form
        }
      } else if (selectedValue == 'percentage') {
        if (discountRateValue == '') {
          alert('Discount Rate Field are required')
        } else if (datepicker1Value == '') {
          alert('Coupon Valid From Field are required');
        } else if (datepicker2Value == '') {
          alert('Coupon Valid to Field are required');
        } else {
          form.submit(); // This submits the form
        }
      }
    });
  });
</script>

<script>
  $("#amount").click(function() {
    $('#amnt').css('display', 'block');
    $('#dis').css('display', 'none');
  });

  $("#percent").click(function() {
    $('#amnt').css('display', 'none');
    $('#dis').css('display', 'block');
  });
</script>
<script>
  $(document).ready(function() {
    $('#categories').select2({
      placeholder: "Select Categories",
      allowClear: true
    });
    $('#products').select2({
      placeholder: "Select Products",
      allowClear: true
    });

    $('.discount-type').click(function() {
      alert
      let type = $(this).val();
      if (type == 'cashback') {
        $('.max-redeem').show();
      } else {
        $('.max-redeem').hide();
      }
    });
    $('#applicable-to').on('change', function() {
      let type = $(this).val();
      if (type == 'category') {
        $('#categories-box').removeClass('hide');
        $('#products-box').addClass('hide');
      } else if (type == 'product') {
        $('#products-box').removeClass('hide');
        $('#categories-box').addClass('hide');
      } else {
        $('#products-box').addClass('hide');
        $('#categories-box').addClass('hide');
      }
    });
  });
</script>


<script>
  $(document).ready(function() {

    $(".minv").change(function() {
      var maxvalues = parseInt($(".maxv").val());
      var mvalues = parseInt($(".minv").val());

      if (mvalues > maxvalues) {
        $(".minv").val('');
      }
    });
  });
</script>
<script>
  $("#maxvalue").keyup(function() {
    var mvalue = $("#maxvalue").val();
    if (mvalue == '0') {
      var mvalue = $("#maxvalue").val('');
    }
  });

  $("#minvalue").keyup(function() {
    var mvalue = $("#minvalue").val();
    if (mvalue == '0') {
      var mvalue = $("#minvalue").val('');
    }
  });
</script>
<script>
  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 46 || charCode > 57 || charCode == 47)) {
      alert("Please Enter Only Numeric Characters!!!!");
      return false;
    }
    return true;

  }
</script>


<script src="https://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<script>
  $(function() {
    var dateFormat = 'dd-mm-yy',
      from = $("#datepicker1")
      .datepicker({
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        numberOfMonths: 1
      })
      .on("change", function() {
        to.datepicker("option", "minDate", getDate(this));
      }),
      to = $("#datepicker2").datepicker({
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        numberOfMonths: 1
      })
      .on("change", function() {
        from.datepicker("option", "maxDate", getDate(this));
      });

    function getDate(element) {
      var date;
      try {
        date = $.datepicker.parseDate(dateFormat, element.value);
      } catch (error) {
        date = null;
      }
      return date;
    }
  });
</script>