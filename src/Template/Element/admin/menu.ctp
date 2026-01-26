<?php $role_id=$this->request->session()->read('Auth.User.role_id'); ?>
<?php $user = $this->request->session()->read('Auth.User');  ?> 
<?php if($role_id == '1' || $role_id == '2') {?>  
  <style type="text/css">
    .skin-blue .treeview-menu>li>a> svg path {
      fill: #fff;
    }
    .main-sidebar {
      width: 238px !important;
    }
  </style>
  <aside class="main-sidebar">
    <section class="sidebar">
      <div class="user-panel">
        <div class="pull-left image">
        </div>
        <div class="pull-left info">
          <p><?php echo ucfirst($this->request->session()->read('Auth.User.email'));?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li> 
        <li class="<?php if($this->request->params['controller'] == 'Dashboards'){ echo 'active';} ?> treeview">
          <a href="<?php echo $this->Url->build('/admin/dashboards/'); ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li class="treeview">
         <a href="<?php echo ADMIN_URL;?>customer/index">
           <i class="fa fa-user" style="color: aqua;"></i> <span>Customer Manager</span>
         </a>
       </li>
       <li class="treeview">
         <a href="<?php echo ADMIN_URL;?>product/index">
           <i class="fa fa-product-hunt" style="color: #2196F3;"></i> <span>Product Manager</span>
         </a>
       </li>
       <?php if($role_id != '2'){ ?>

       <li class="treeview">
         <a href="<?php echo ADMIN_URL;?>vendor/index">
         <i class="fa fa-user-secret" style="color: #33bb38;"></i> <span>Vendor Manager</span>
         </a>
       </li>
       <li class="treeview">
         <a href="<?php echo ADMIN_URL;?>slider/index">
           <i class="fa fa-sliders" style="color: #ff665a;"></i> <span>Slider Manager</span>
         </a>
       </li>
       <?php }?>
       <li class="treeview">
         <a href="<?php echo ADMIN_URL;?>order/index">
         <i class="fa fa-first-order" style="color: #e0cd20;"></i> <span>Order Manager</span>
         </a>
       </li>

     

       <li class="treeview">
         <a href="<?php echo ADMIN_URL;?>coupons/index">
         <i class="fa fa-money" style="color: #dd17ff;"></i> <span>Coupon Manager</span>
         </a>
       </li>
       <?php if($role_id != '2'){ ?>
       <li class="treeview">
         <a href="<?php echo ADMIN_URL;?>servicearea/index">
         <i class="fa fa-compass" style="color: #ea7109;"></i> <span>Location Manager</span>
         </a>
       </li>
      
       <li class="treeview">
         <a href="<?php echo ADMIN_URL;?>faq/index">
         <i class="fa fa-question-circle" style="color: #f7490a;"></i> <span>FAQ Manager</span>
         </a>
       </li>
       <li class="treeview">
         <a href="<?php echo ADMIN_URL;?>static/index">
         <i class="fa fa-adjust" style="color: #ff6d05;"></i> <span>Static Manager</span>
         </a>
       </li>
       <?php }?>
       <li class="treeview">
         <a href="<?php echo ADMIN_URL;?>notification/index">
         <i class="fa fa-bell" style="color: #ff6d05;"></i> <span>Notification Manager</span>
         </a>
       </li>


     </ul>
   </section>

 </aside>
<?php } ?>     
<?php $controller=$this->request->params['controller'];
if($controller!='Dashboards') { ?>
 <script>
  $(document).ready(function(){
    $(".manage").click(function(){ 
      $(".manage .fa-angle-left").toggleClass("fa-angle-down");
      var test=$(this).find('.manage-li');
      if(!$(test).is(':visible'))
      {
        $(test).hide('slow');
      }
      else{
        $(test).show('slow');
      }
    });
  });
</script>    
<?php }else{  ?>  
  <script>
    $(document).ready(function(){
      $(".manage").click(function(){ 
        $(".manage .fa-angle-left").toggleClass("fa-angle-down");
        var test=$(this).find('.manage-li');
        if(!$(test).is(':visible'))
        {
         $(test).show('slow');
       }
       else{
        $(test).hide('slow');
      }
    });
    });
  </script>  
<?php }  ?>
