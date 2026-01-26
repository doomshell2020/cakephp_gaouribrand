<style type="text/css">
  .skin-blue .treeview-menu>li>a> svg path {
    fill: #fff;
}

.navbar-nav {
    float: none;
    margin: 0;
}
</style>

<?php $user_id=$this->request->session()->read('Auth.User.id'); ?>
<?php $userdetail=$this->request->session()->read('Auth.User'); 
$store_name=$this->Comman->findstore($userdetail['store_id']); 
?>
<?php $company_id=$this->request->session()->read('Auth.User.company_visitor_id'); ?>
<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <link rel="icon" href="<?php echo SITE_URL;?>favicon.ico" type="image/x-icon">
  <link rel="icon" href="<?php echo SITE_URL;?>css/admin/css/all.min.css" type="image/x-icon">
  <title>Gaouri Brand</title>
 <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <?= $this->Html->css('admin/bootstrap.min.css') ?>
    <?= $this->Html->script('admin/jquery.min.js') ?>
  <?= $this->Html->css('admin/dataTables.bootstrap.css') ?>
  <?= $this->Html->css('admin/AdminLTE.min.css') ?>
  <?= $this->Html->css('admin/skins/_all-skins.min.css') ?>
  <!-- bootstrap wysihtml5 - text editor -->
  <?= $this->Html->css('admin/style.css') ?>
  <?= $this->Html->script('admin/bootstrap.min.js') ?>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
  <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet">
 
  <script src="<?php echo SITE_URL;?>js/datetimepicker_ra.js"></script>

</head>
<script>
 var csrfToken = <?php echo json_encode($this->request->params["_csrfToken"]); ?>;
</script>
<?php $role_id=$this->request->session()->read('Auth.User.role_id'); 
	if($role_id=='1' || $role_id == '2') {
		?> 
<body class="hold-transition skin-blue sidebar-mini sidebar-collapse" onload="initialize()">
<div class="wrapper">
  <header class="main-header">
    <!-- Logo -->
	    <a href="/admin/dashboards" class="logo">
	      <!-- mini logo for sidebar mini 50x50 pixels -->
	      <span class="logo-mini" style="text-align: center"><b> Gaouri</b></span>
	      <!-- logo for regular state and mobile devices -->
	      <span class="logo-lg"><b> Gaouri Brand</b></span>
	    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" style="padding-left: 50px !important;">	
      <!-- Sidebar toggle button--> 
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <li class="dropdown user user-menu">
		    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
		      <img src="<?php echo SITE_URL;?>/img/user2-160x160.jpg" class="user-image" alt="User Image">
		      <span class="hidden-xs">
			<?php echo ucfirst($this->request->session()->read('Auth.User.email'));?></span>
		    </a>
		    <ul class="dropdown-menu">
		      <!-- User image -->
		      
		      <li class="user-header">
		      <img src="<?php echo SITE_URL;?>/img/user2-160x160.jpg" class="user-image" alt="User Image">
		       <p>
		         <?php echo ucfirst($this->request->session()->read('Auth.User.email'));?>
		        </p>
		      </li>
		     <!-- Menu Footer-->
		      <li class="user-footer">
				   <div class="pull-left">
		          <a href="<?php echo $this->Url->build('/admin/users/add/'.$user_id); ?>" class="btn btn-default btn-flat">Profile</a>
		        </div>
		        <div class="pull-right">
		          <a href="<?php echo $this->Url->build('/logins/logout'); ?>" class="btn btn-default btn-flat" >Sign out</a>
		        </div>
		      </li>
		    </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
<?php } ?>


