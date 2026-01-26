<?php $user=$this->Comman->user(); //pr($user); die; ?>
<footer>
    <div class="container">
      <div class="row footer_top">
        <div class="col-sm-4"> 
        <a href="<?php echo SITE_URL; ?>" target="_top"><img src="<?php echo SITE_URL; ?>frontend/images/Gaouri Brand logo_1.png" class="img-fluid"> </a> </div>
        <div class="col-sm-8">
          <p>We are committed to offering only the finest-quality psychiatric medicines. We are dedicated to helping people fulfill their health needs.</p>
        </div>
      </div>
      <div class="row footer_buttom">
        <div class="col-sm-3">
          <h4>Quick Link</h4>
          <ul>
            <li><a href="<?php echo SITE_URL; ?>" target="_top"> Home</a> </li>
            <li><a href="<?php echo SITE_URL; ?>products/all" target="_top">Products </a> </li>
            <li><a href="<?php echo SITE_URL; ?>aboutUs" target="_top">About Us</a> </li>
            <li><a href="<?php echo SITE_URL; ?>contactUs" target="_top">Contact Us</a> </li>
          </ul>
        </div>
        <div class="col-sm-6 ">
          <h4>Products</h4>
          <ul class=" f_product">
        <?php  $categories=$this->Comman->categories($order['product_id']); ?>
        <?php foreach ($categories as $category){?>
            <li><a href="<?php echo SITE_URL; ?>products/<?php echo $category['name']; ?>"> <?php echo $category['name']; ?> </a> </li>
        <?php }?>
          </ul>
        </div>
        <div class="col-sm-3">
          <h4>Contact Us</h4>
          <ul class="f_info">
             <ul>
                <li>
                  <i class="fas fa-phone-alt"></i> 
                  <a href="tel:<?php echo $user['mobile']; ?>">
                    <?php echo $user['mobile']; ?>
                  </a> 
                </li>
                <li>
                  <i class="far fa-envelope"></i> 
                  <a href="mailto:<?php echo $user['email']; ?>">
                  <?php echo $user['email']; ?>
                  </a> 
                </li>
                
        
                
              
              </ul>
          </ul>
        </div>
      </div>
    </div>
    <p class="copyright"> Copyright © 2021 Gaouri Brand:: All Rights Reserved</p>
  </footer>
  
  <!--------------------------------------
  ----------------------------------------------------------> 
  
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script> 
<script src="<?php echo SITE_URL; ?>frontend/js/bootstrap.min.js" type="text/javascript"></script>


<script>
 <?php if($this->Flash->render('refer_fail')){  ?>
 $(document).ready(function() {
   $('#irefer').modal('show');
 });
 <?php } ?>
</script>

</body>
</html>