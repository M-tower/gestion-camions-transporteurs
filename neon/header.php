<?php
include_once 'core/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="syntract-transport Admin Panel" />
  <meta name="author" content="ARTHEMYS TECHNOLOGY" />

	<title>SY.NA.TRA.C.T - Transport</title>

	<link rel="stylesheet" href="neon/assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
	<link rel="stylesheet" href="neon/assets/css/font-icons/entypo/css/entypo.css">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
	<link rel="stylesheet" href="neon/assets/css/bootstrap.css">
	<link rel="stylesheet" href="neon/assets/css/neon-core.css">
	<link rel="stylesheet" href="neon/assets/css/neon-theme.css">
	<link rel="stylesheet" href="neon/assets/css/neon-forms.css">
	<link rel="stylesheet" href="neon/assets/css/custom.css">
	<link rel="stylesheet" href="neon/css/main.css">
  <link rel="icon" href="img/favicon_synatract.PNG" sizes="32x32" />
  <link rel="icon" href="img/favicon_synatract.PNG" sizes="192x192" />
  <link rel="apple-touch-icon-precomposed" href="img/favicon_synatract.PNG" />
  <meta name="msapplication-TileImage" content="img/favicon_synatract.PNG" />
  
  <link rel="stylesheet" href="neon/assets/css/font-icons/font-awesome/css/font-awesome.min.css">

	<script src="neon/assets/js/jquery-1.11.0.min.js"></script>
	<script>$.noConflict();
    jQuery(document).ready(function(){
      var p_courant = lapage();
      setPageTitle(p_courant);
    //  console.log('cccc = '+p_courant);
    //  $('.root-level').removeClass('active');
      activeMenu(p_courant);
     });
  </script>

	<!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.e.2/respond.min.js"></script>
	<![endif]-->


</head>
<body class="page-body">
  <style>
    .page-container.horizontal-menu header.navbar .navbar-brand{
      padding: 4px;
    }
    .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, 
    .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, 
    .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td{
      border-color: #d6d6d6;
      color: #4e4e4e !important;
    }
    
  </style>
<div class="page-container horizontal-menu">

	
	<header class="navbar navbar-fixed-top"><!-- set fixed position by adding class "navbar-fixed-top" -->
		
		<div class="navbar-inner">
		
			<!-- logo -->
			<div class="navbar-brand">
				<a href="/">
          <img style="background-color: #fff;border-radius: 2px;" src="img/logo_new.PNG" width="100" alt="" />
				</a>
			</div>
			
			
			<!-- main menu -->
						
			<ul class="navbar-nav">
				<li class="opened _home">
					<a href="/">
						<i class="entypo-home"></i>
					</a>
				</li>
        <?php if(isset($_SESSION['header'])){ ?>
				<li class="_dashbord">
					<a href="/?page=dashbord">
						<i class="entypo-gauge"></i>
						<span class="title">Tableau de bord</span>
					</a>
				</li>
				<li class="_transporteurs">
					<a href="/?page=transporteurs">
						<i class="entypo-layout"></i>
						<span class="title">Transporteurs</span>
					</a>
					<ul>
						<li>
							<a href="/?page=edit-transporteur">
								<span class="title">Ajouter un transporteur</span>
							</a>
						</li>
						<li>
							<a href="/?page=camions">
								<span class="title">Voir tous les camions</span>
							</a>
						</li>
					</ul>
				</li>
				<li class="_clients">
					<a href="/?page=clients">
						<i class="entypo-layout"></i>
						<span class="title">Clients</span>
					</a>
					<ul>
						<li>
							<a href="/?page=edit-client">
								<span class="title">Ajouter un client</span>
							</a>
						</li>
					</ul>
				</li>
				<li class="_historique">
					<a href="/?page=historique-cycles">
						<i class="entypo-doc-text"></i>
						<span class="title">Historique des tableaux</span>
					</a>
          <ul>
						<li>
							<a href="/?page=historique-activites">
								<span class="title">Historique des activités</span>
							</a>
						</li>
					</ul>
				</li>
        <?php } ?>
			</ul>
						
			
			<!-- notifications and other links -->
			<ul class="nav navbar-right pull-right">
				<!-- raw links -->
        <?php if(isset($_SESSION['header'])){ ?>
				<li class="dropdown">
          <li>
            <a><?php echo 'Hello ' . $_SESSION['user_prenom'] . ' ' . $_SESSION['user_nom']; ?></a>
					</li>
									</li>
				
				<li class="sep"></li>
				
				<li>
          <a href="" onclick="deconnexion()">
						Déconnexion <i class="entypo-logout right"></i>
					</a>
				</li>
        <?php }else{ ?>
				<li>
          <a href="/connexion.php" >
						Connexion <i class="entypo-login right"></i>
					</a>
				</li>
        <?php } ?>
				<!-- mobile only -->
				<li class="visible-xs">	
				
					<!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
					<div class="horizontal-mobile-menu visible-xs">
						<a href="#" class="with-animation"><!-- add class "with-animation" to support animation -->
							<i class="entypo-menu"></i>
						</a>
					</div>
					
				</li>
				
			</ul>
	
		</div>
    <input type="hidden" id="mailLogout" value="<?php echo (isset($_SESSION['user_mail']))? $_SESSION['user_mail'] : ''; ?>">
	</header>
	<div class="main-content">
    
    <script>
      var $ = jQuery;
    </script>
    <script src="/modules/connexion/scripts.js"></script>
		