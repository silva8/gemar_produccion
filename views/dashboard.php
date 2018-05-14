<!DOCTYPE html>
<html lang="en">

<!--================================================================================
	Item Name: Materialize - Material Design Admin Template
	Version: 3.1
	Author: GeeksLabs
	Author URL: http://www.themeforest.net/user/geekslabs
================================================================================ -->

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport"
	content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="msapplication-tap-highlight" content="no">
<meta name="description"
	content="Materialize is a Material Design Admin Template,It's modern, responsive and based on Material Design by Google. ">
<meta name="keywords"
	content="materialize, admin template, dashboard template, flat admin template, responsive admin template,">
<title>Gemar</title>

<!-- Favicons-->
<link rel="icon" href="images/favicon/favicon-32x32.png" sizes="32x32">
<!-- Favicons-->
<link rel="apple-touch-icon-precomposed"
	href="images/favicon/apple-touch-icon-152x152.png">
<!-- For iPhone -->
<meta name="msapplication-TileColor" content="#00bcd4">
<meta name="msapplication-TileImage"
	content="images/favicon/mstile-144x144.png">
<!-- For Windows Phone -->


<!-- CORE CSS-->
<link href="css/materialize.min.css" type="text/css" rel="stylesheet"
	media="screen,projection">
<link href="css/style.css" type="text/css" rel="stylesheet"
	media="screen,projection">
<!-- Custome CSS-->
<link href="css/custom/custom.min.css" type="text/css" rel="stylesheet"
	media="screen,projection">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">

<!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
<link href="js/plugins/perfect-scrollbar/perfect-scrollbar.css"
	type="text/css" rel="stylesheet" media="screen,projection">
<link href="js/plugins/jvectormap/jquery-jvectormap.css" type="text/css"
	rel="stylesheet" media="screen,projection">
<link href="js/plugins/chartist-js/chartist.min.css" type="text/css"
	rel="stylesheet" media="screen,projection">

</head>

<body>
	<!-- Start Page Loading -->
	<div id="loader-wrapper">
		<div id="loader"></div>
		<div class="loader-section section-left"></div>
		<div class="loader-section section-right"></div>
	</div>
	<!-- End Page Loading -->

	<!-- //////////////////////////////////////////////////////////////////////////// -->

	<!-- START HEADER -->
	<header id="header" class="page-topbar">
		<!-- start header nav-->
		<div class="navbar-fixed">
			<nav class="navbar-color light-blue darken-4">
				<div class="nav-wrapper">
					<ul class="left col s2">
						<li><h1 class="logo-wrapper" >
								<a href="index.php" class="brand-logo darken-1"><img
									src="images/materialize-logo.png" alt="logo"></a> <span
									class="logo-text">Gemar Ingeniería</span>
							</h1>
					</ul>
					<div class="header-search-wrapper hide-on-med-and-down">
						<i class="mdi-action-search"></i> <input type="text" name="Search"
							class="header-search-input z-depth-2"
							placeholder="Explorar" />
					</div>
					<?php
						include_once dirname(__FILE__).'/../query/get_notifications.php'; // archivo de conexion local
						
						$notifications = getNotifications($_SESSION['user_id']);
						$count_new_notifications = 0;
						foreach($notifications as $notification){
							if($notification->leido == 0){
								$count_new_notifications++;
							}
						}
					?>
					<ul class="right hide-on-med-and-down">
						<li><a href="javascript:void(0);"
							class="waves-effect waves-block waves-light toggle-fullscreen"><i
								class="mdi-action-settings-overscan"></i></a></li>
						<li><a href="javascript:void(0);"
							class="waves-effect waves-block waves-light notification-button"
							data-activates="notifications-dropdown"><i
								class="mdi-social-notifications"><small
									class="notification-badge"><?php echo $count_new_notifications; ?></small></i> </a></li>
						<li><a href="index.php?logout"
							class="waves-effect waves-block waves-light"><i
								class="mdi-action-settings-power"></i></a></li>
					</ul>
			
					<!-- notifications-dropdown -->
					<ul id="notifications-dropdown" class="dropdown-content">
						<li>
							<h5>
								NOTIFICATIONS <span class="new badge"><?php echo $count_new_notifications; ?></span>
							</h5>
						</li>
						<li class="divider"></li>
						<?php
					
						foreach($notifications as $notification){
							$time = time-strtotime($notification->fecha);
							$readed = "";
							if($notification->leido == 1){
								$readed = "blue-grey lighten-4";
							}
							echo '<li class="notification '.$readed.'" notificationid="'.$notification->notificacion_id.'">'.$notification->descripcion.
							'</br><time class="media-meta">'.$notification->fecha.'</time></li>';
						}						
						?>
					</ul>
				</div>
			</nav>
		</div>
		<!-- end header nav-->
	</header>
	<!-- END HEADER -->

	<!-- //////////////////////////////////////////////////////////////////////////// -->

	<!-- START MAIN -->
	<div id="main">
		<!-- START WRAPPER -->
		<div class="wrapper">

			<!-- START LEFT SIDEBAR NAV-->
			<aside id="left-sidebar-nav">
				<ul id="slide-out" class="side-nav fixed leftside-navigation">
					<li class="user-details grey lighten-3">
						<div class="row">
							<div class="col col s4 m4 l4">
							<?php 
								include_once dirname(__FILE__).'/../query/get_users.php';
								if ($login->isAdminUser() == true) {
									$photo = "default.jpg";
									$title = "Administrador";
								}
								else{
									$user = get_users($_SESSION['user_id'])[0];
									$photo = $user->user_image_path;
									$title =$user->user_title;
								}
								echo '<img src="images/users/'.$photo.'" alt=""
									class="circle responsive-img valign profile-image">';
							?>
							</div>
							<div class="col col s8 m8 l8">
								<a
									class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn"
									href="#"> <?php echo $_SESSION['user_name']; ?></a>
								<p class="user-roal"><?php echo $title; ?></p>
							</div>
						</div>
					</li>
					
					<?php
					if ($login->isAdminUser() == true) {
					    include("admin/sidebar_content.php");
					    
					} else {
					    include("user/sidebar_content.php");
					}
					?>
					
				</ul>
				<a href="#" data-activates="slide-out"
					class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only grey lighten-1"><i
					class="mdi-navigation-menu"></i></a>
			</aside>
			<!-- END LEFT SIDEBAR NAV-->

			<!-- //////////////////////////////////////////////////////////////////////////// -->

			<!-- START CONTENT -->
			<section id="content">

			<?php
			if ($login->isAdminUser() == true) {
			    include("admin/index_content.php");
			    
			} else {
			    include("user/index_content.php");
			}
			?>
			
			</section>
			<!-- END CONTENT -->

		</div>
		<!-- END WRAPPER -->

	</div>
	<!-- END MAIN -->


<div style="min-height:28.6vh"></div>
	<!-- //////////////////////////////////////////////////////////////////////////// -->

	<!-- START FOOTER -->
	<footer class="page-footer light-blue darken-4">
		<div class="footer-copyright">
			<div class="container">
				Copyright © 2015 <a class="grey-text text-lighten-4"
					href="http://themeforest.net/user/geekslabs/portfolio?ref=geekslabs"
					target="_blank">GeeksLabs</a> All rights reserved. <span
					class="right"> Design and Developed by <a
					class="grey-text text-lighten-4" href="http://geekslabs.com/">GeeksLabs</a></span>
			</div>
		</div>
	</footer>
	<!-- END FOOTER -->

	<!-- ================================================
    Scripts
    ================================================ -->

	<!-- jQuery Library -->
	<script type="text/javascript" src="js/plugins/jquery-2.1.4.min.js"></script>
	<!--materialize js-->
	<script type="text/javascript" src="js/materialize.min.js"></script>
	<!--scrollbar-->
	<script type="text/javascript"
		src="js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

	<!-- chartist -->
	<script type="text/javascript"
		src="js/plugins/chartist-js/chartist.min.js"></script>

	<!-- sparkline -->
	<script type="text/javascript"
		src="js/plugins/sparkline/jquery.sparkline.min.js"></script>
	<script type="text/javascript"
		src="js/plugins/sparkline/sparkline-script.js"></script>


	<!--plugins.js - Some Specific JS codes for Plugin Settings-->
	<script type="text/javascript" src="js/plugins.min.js"></script>
	<!--custom-script.js - Add your own theme custom JS-->
	<script type="text/javascript" src="js/custom-script.js"></script>

    <script>
    	$( document ).ready(function() {

			<?php
			if ($login->isAdminUser() == true) {
			    
			    
			} else {
				?>
			    $('#content').load("views/app_todo.php");
			    <?php
			}
			?>

   	 		$( ".load-content" ).on('click', function() {
  				var load = $(this);
  				var what = load.attr('what');
  				var where = load.attr('where');
  				//console.log("what:" + what + " where: " +where);
  				$('#'+ where +'').load( ""+ what + "");

  				if($('#modal_perfiles, modal_calendario', 'modal_hojas').css('bottom') == "0px"){
  					setTimeout(function() {
	  			    	$('#modal_perfiles').hide();
	  			    	$('#modal_calendario').hide();
	  			    	$('#modal_hojas').hide();
	  					$('.lean-overlay').hide();
	  					$('body').css('overflow-y', 'scroll');      
  			   		 }, 100);
  				}

  			    setTimeout(function() {
  			    	$('#'+ where +'').addClass('loaded');      
  			    }, 5000);
			});

			$(document).on('click', '#saveReporte', function(e){
  				setTimeout(function() {
  			    	$('#content').load('views/app_todo.php');      
  			    }, 1000);
		    }); 		    
		});
    </script>
    <script>
	$( document ).ready(function() {
		$( ".sidebarlink" ).on('click', function() {
			$( ".sidebarlink" ).removeClass('active');
			$(this).addClass('active');
		});
		$(document).on('click', '.notification', function(){
			$(this).addClass("blue-grey lighten-4");
			$.ajax({
			      method: "POST",
			      url: "query/update_notification.php",
			      data: {"notificacion_id": $(this).attr("notificationid")},
			      success: function(response)
			      {
			       	//console.log(response);
			      }
			    });
		});
	});				
	</script>
    <script>
    //update session
	$( document ).ready(function() {
		$(document).on("click", throttle(function (event) {
		    jQuery.ajax({
		      method: "POST",
		      url: "ajax/update_session.php",
		      data: {},
		      error: function(response) {
		        //console.log(response);
		      },
		      success: function(response)
		      {
		       	//console.log(response);
		      }
		    });
		}, 60000));

		function throttle(func, milliseconds) {
		    var lastCall = 0;
		    return function () {
		        var now = Date.now();
		        if (lastCall + milliseconds < now) {
		            lastCall = now;
		            return func.apply(this, arguments);
		        }
		    };
		}
	});				
	</script>
</body>

</html>

	<?php
	if ($login->isAdminUser() == true) {
		require_once dirname(__FILE__) . "/admin/profile_modal.php";
		require_once dirname(__FILE__) . "/admin/calendar_modal.php";
		require_once dirname(__FILE__) . "/admin/hojas_modal.php";
		require_once dirname(__FILE__) . "/admin/logs_modal.php";
	}
	?>