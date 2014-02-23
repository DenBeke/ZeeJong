<?php
/*
Template part for header

Created: February 2014
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Soccer Betting System</title>

	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<link href="<?php echo SITE_URL ?>style/style.css" rel="stylesheet" type="text/css">
	<link href="<?php echo SITE_URL ?>style/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="<?php echo SITE_URL ?>style/bootstrap-responsive.css" rel="stylesheet" type="text/css">
	<script src="<?php echo SITE_URL ?>js/jquery-1.11.0.min.js" type="text/javascript"></script>
	<script src="<?php echo SITE_URL ?>js/script.js" type="text/javascript"></script>
	<script src="<?php echo SITE_URL ?>js/bootstrap.js" type="text/javascript"></script>
	
	
	<?php
	if(PAGE == 'login' and $login->loggedIn == true) {
	?>
	<meta http-equiv="refresh" content="3; url=<?php echo SITE_URL; ?>" />
	<?php
	}
	?>
	

</head>
<body>

	<header>
		
		<div class="navbar navbar-inverse navbar-fixed-top">
		  <div class="navbar-inner">
			<div class="container">
			  <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="brand" href="<?php echo SITE_URL; ?>">ZeeJong</a>
			  <div class="nav-collapse collapse">
				<ul class="nav navbar-nav navbar-left">
				  <li class="active"><a href="#">Upcomming Events</a></li>
				  <li><a href="#">Players</a></li>
				  <li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Leagues <b class="caret"></b></a>
					<ul class="dropdown-menu">
					  <li><a href="#">World Cup</a></li>
					  <li><a href="#">Olympics</a></li>
					  <li><a href="#">...</a></li>
					</ul>
				  </li>
				  
				</ul>
				
				<?php
				if(!$login->loggedIn) {
					?>
					
					<form class="navbar-form pull-right" id="login" action="<?php echo SITE_URL; ?>?page=login" method="post">
						<input name="username" class="span2" type="text" placeholder="Username" id="username">
						<input name="password" class="span2" type="password" placeholder="Password" id="password">
						
						<button type="submit" name="submit" value="login" class="btn">Sign in</button>
						
						<a href="<?php echo SITE_URL; ?>?page=register" class="btn">Register</a>
					</form>
					
					<?php
				}
				else {
					?>
					
					<form class="navbar-form pull-right" id="login">
						<a href="?page=configPanel" class="btn"><?php echo $login->user->getUserName(); ?></a>
						<a href="<?php echo SITE_URL; ?>core/logout.php" class="btn">Logout</a>
					</form>
					
					<?php
				}
				?>
				
				
			  </div><!--/.nav-collapse -->
			</div>
		  </div>
		</div>
		
	</header>
	
	
	<div class="container">
	
