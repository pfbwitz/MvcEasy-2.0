<!DOCTYPE html>
<!--
* CoreUI - Free Bootstrap Admin Template
* @version v2.0.0
* @link https://coreui.io
* Copyright (c) 2018 creativeLabs Łukasz Holeczek
* Licensed under MIT (https://coreui.io/license)
-->

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <title><?php echo PAGE_TITLE; ?></title>
	
	<link href="/css/style.css" rel="stylesheet">
	
    <!-- Icons-->
    <link href="/core-ui/vendors/@coreui/icons/css/coreui-icons.min.css" rel="stylesheet">
    <link href="/core-ui/vendors/flag-icon-css/css/flag-icon.min.css" rel="stylesheet">
    <link href="/core-ui/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="/core-ui/vendors/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">
    <!-- Main styles for this application-->
    <link href="/core-ui/css/style.css" rel="stylesheet">
    <link href="/core-ui/vendors/pace-progress/css/pace.min.css" rel="stylesheet">
	
	 <!-- Bootstrap and necessary plugins-->
    <script src="/core-ui/vendors/jquery/js/jquery.min.js"></script>
    <script src="/core-ui/vendors/popper.js/js/popper.min.js"></script>
    <script src="/core-ui/vendors/bootstrap/js/bootstrap.min.js"></script>
    <script src="/core-ui/vendors/pace-progress/js/pace.min.js"></script>
    <script src="/core-ui/vendors/perfect-scrollbar/js/perfect-scrollbar.min.js"></script>
    <script src="/core-ui/vendors/@coreui/coreui/js/coreui.min.js"></script>
  </head>
  <body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
  <?php if ($this->renderLayout) : ?>
  <header class="app-header navbar">
      <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="#">
        <img class="navbar-brand-full" src="/core-ui/img/brand/logo.svg" width="89" height="25" alt="CoreUI Logo">
        <img class="navbar-brand-minimized" src="/core-ui/img/brand/sygnet.svg" width="30" height="30" alt="CoreUI Logo">
      </a>
      <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
        <span class="navbar-toggler-icon"></span>
      </button>
      <ul class="nav navbar-nav ml-auto">
       
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
			<i class="cui-user icons font-2xl d-block"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            <div class="dropdown-header text-center">
              <strong>Account</strong>
            </div>
             <span class="dropdown-item" href="#">
              <i class="fa fa-user"></i> <?php echo $this->gebruiker->username; ?></span>
            <div class="dropdown-header text-center">
              <strong><?php echo $this->resources->LblSettings; ?></strong>
            </div>
           
            <a class="dropdown-item" href="/Account/Index">
              <i class="fa fa-wrench"></i> <?php echo $this->resources->LblSettings; ?></a>
           
            
            <a class="dropdown-item" href="/Account/Logout">
              <i class="fa fa-lock"></i> <?php echo $this->resources->LblLogout; ?></a>
          </div>
        </li>
      </ul>
    </header>
    <div class="app-body">
      <div class="sidebar">
		<?php include_once("Menu.php"); ?>
      </div>
      <main class="main">
        <!-- Breadcrumb-->
		
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="/<?php echo $this->controllername; ?>"><?php echo $this->controllername; ?></a>
          </li>
          <li class="breadcrumb-item active"><?php echo $this->viewname; ?></li>
          <!-- Breadcrumb Menu-->
          <li class="breadcrumb-menu d-md-down-none">
            <div class="btn-group" role="group" aria-label="Button group">
				<?php 
					$env = Loaders_ConfigLoader::getCurrentEnvironment();
					if($env != ENV_PRD) : 
				?>
					<div><span style='font-weight:bold;'><?php echo $this->resources->LblEnvironment; ?>:</span> 
						<span style='font-weight: bold;color: red;'> 
							<?php echo $env; ?>
						</span>
					</div>
				<?php endif; ?>
            </div>
          </li>
        </ol>
  <?php endif; ?>
    
        <div class="container-fluid">
			<div> 
				<?php $this->loadView(); ?>
            </div>
		</div>
		  
 <?php if ($this->renderLayout) : ?>
        </div>
      </main>
    </div>
<?php endif; ?>
   
  </body>
</html>