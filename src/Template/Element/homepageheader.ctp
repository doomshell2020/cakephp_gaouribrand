<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="<?php echo SITE_URL; ?>htdocs/gaouribrand/webroot/logo_1.png" type="image/x-icon">
  <title>Gaouri Brand</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="<?php echo SITE_URL; ?>frontend/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="<?php echo SITE_URL; ?>frontend/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="<?php echo SITE_URL; ?>frontend/css/style.css" rel="stylesheet" type="text/css">
  <link href="<?php echo SITE_URL; ?>frontend/css/responsive.css" rel="stylesheet" type="text/css">
  <script>
    var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
  </script>
  <div class="modal fade" id="irefer" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content" style="text-align: center; width: 122%;">
        <div class="modal-body">
          <table class="table table-bordered" style="margin-bottom: 0; background-color: #44fdd6;">
            <thead>
              <tr>
                <th>We appreciate you contacting us. One of our colleagues will get back in touch with you soon!.</th>
              </tr>
            </thead>
          </table>
        </div>
        <div class="modal-footer" style="justify-content: center;
           border-top:0; margin-top: -17px;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="background: aliceblue;">Okay</button>
        </div>
      </div>
    </div>
  </div>
  <style>
    .navbar-light .navbar-nav .nav-link.active,
    .navbar-light .navbar-nav .nav-link.show,
    .navbar-light .navbar-nav .show>.nav-link {
      color: #1bbc9b;
    }

    .img-fluid {
      max-width: 125px;
      height: auto;
    }
  </style>
</head>
<?php $user = $this->Comman->user(); //pr($user); die; 
?>

<body class="home">
  <div class="page_wrapper">
    <header id="header">
      <div class="container">
        <div class="top-header">
          <div class="row">
            <div class="col-sm-6">
              <ul class="contact-no">
                <li> <a href="tel:<?php echo $user['mobile']; ?>"><i class="fas fa-phone-alt"></i> <?php echo $user['mobile']; ?></a> </li>
                <li> <a href="mailto:<?php echo $user['email']; ?>"><i class="fas fa-envelope"></i> <?php echo $user['email']; ?></a> </li>
              </ul>
            </div>
            <div class="col-sm-6">
              <ul class="ml-auto">
                <li class="list-inline-item"> <a href="<?php echo $user['fackbook']; ?>" target="_blank"> <i class="fab fa-facebook-f"></i> </a> </li>
                <li class="list-inline-item"> <a href="<?php echo $user['youtube']; ?>" target="_blank"> <i class="fab fa-youtube"></i> </a> </li>
                <li class="list-inline-item"> <a href="<?php echo $user['twitter']; ?>" target="_blank"> <i class="fab fa-twitter"></i> </a> </li>
                <li class="list-inline-item"> <a href="<?php echo $user['instagram']; ?>" target="_blank"> <i class="fab fa-instagram"></i> </a> </li>
              </ul>
            </div>
          </div>
        </div>
        <?php //pr($this->request->params); die;
        $control = $this->request->params['controller'];
        $action = $this->request->params['action'];
        ?>
        <nav class="navbar navbar-expand-lg navbar-light "> <a class="navbar-brand" href="<?php echo SITE_URL; ?>"> <img src="<?php echo SITE_URL; ?>frontend/images/Gaouri Brand logo_1.png" class="img-fluid"> </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item"> <a class="nav-link <?php if ($control == 'Pages' && $action == 'home') {
                                                          echo "active";
                                                        } ?>" href="<?php echo SITE_URL; ?>" target="_top">Home<span class="sr-only">(current)</span></a> </li>
              <li class="nav-item"> <a class="nav-link <?php if ($control == 'Pages' && $action == 'products') {
                                                          echo "active";
                                                        } ?>" href="<?php echo SITE_URL; ?>products/all" target="_top">Products</a> </li>
              <li class="nav-item "> <a class="nav-link <?php if ($control == 'Pages' && $action == 'aboutUs') {
                                                          echo "active";
                                                        } ?>" href="<?php echo SITE_URL; ?>aboutUs" target="_top">About Us</a> </li>
              <li class="nav-item"> <a class="nav-link <?php if ($control == 'Pages' && $action == 'contactUs') {
                                                          echo "active";
                                                        } ?>" href="<?php echo SITE_URL; ?>contactUs" target="_top">Contact Us</a> </li>
            </ul>
            <a href="<?php echo SITE_URL; ?>products/all">
              <button class="btn btn-outline-success my-2 my-sm-0">List of Products</button>
            </a>

          </div>
        </nav>
      </div>
    </header>