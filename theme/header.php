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

	<meta name="viewport" content="width=device-width, initial-scale=1">


	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
	
	<!-- Optional theme -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">


	<link href="<?php echo SITE_URL ?>style/style.css" rel="stylesheet" type="text/css">
	<link href="<?php echo SITE_URL ?>style/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="<?php echo SITE_URL ?>style/bootstrap-theme.css" rel="stylesheet" type="text/css">
	<script src="<?php echo SITE_URL ?>js/jquery-1.11.0.min.js" type="text/javascript"></script>
	<script src="<?php echo SITE_URL ?>js/script.js" type="text/javascript"></script>
	<script src="<?php echo SITE_URL ?>js/bootstrap.js" type="text/javascript"></script>
	
	
	
	
	<?php	
	if($controller->page == 'login' and loggedIn() == true) {
	?>
	<meta http-equiv="refresh" content="3; url=<?php echo SITE_URL; ?>" />
	<?php
	}
	?>
	

</head>
<body>

	<header>
		
		
		<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		      <div class="container">
		
				<div class="navbar-header">
				     <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				       <span class="sr-only">Toggle navigation</span>
				       <span class="icon-bar"></span>
				       <span class="icon-bar"></span>
				       <span class="icon-bar"></span>
				     </button>
				     <a class="navbar-brand" href="<?php echo SITE_URL; ?>">ZeeJong</a>
				</div>
		
		
				<div class="navbar-collapse collapse" style="height: auto;">
				    <ul class="nav navbar-nav">
				      <li class="active"><a href="#">Upcoming Events</a></li>
				      <li><a href="<?php echo SITE_URL; ?>news">News</a></li>
				      <li class="dropdown">
				        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Leagues <b class="caret"></b></a>
				        <ul class="dropdown-menu">
				          <li><a href="#">World Cup</a></li>
				          <li><a href="#">Olympics</a></li>
				          <li><a href="#">European Championship</a></li>
				          <li class="divider"></li>
				          <li><a href="#">Champions League</a></li>
				          <li><a href="#">Bundesliga</a></li>
				        </ul>
				      </li>
				    </ul>
		         
				       <?php
				       if(!loggedIn()) {
				       	?>
				       	
				      
				       	
				       	
				       	<form class="navbar-form navbar-right" role="form" id="login" action="<?php echo SITE_URL; ?>login" method="post">
				       	
				       		 <div class="form-group">
				       	
				       			<input name="username" class="form-control" type="text" placeholder="Username" id="username">
				       		
				       		</div>
				       		
				       		
				       		<div class="form-group">
				       		
				       			<input name="password" class="form-control" type="password" placeholder="Password" id="password">
				       		
				       		</div>
				       		
				       		<button type="submit" name="submit" value="login" class="btn btn-default">Sign in</button>
				       		
				       		<a href="<?php echo SITE_URL; ?>register" class="btn btn-default">Register</a>       		
				       		
				       		
				       	</form>
				       	
				       	<?php
				       }
				       else {
				       	?>
				       	
				       	<form class="navbar-form pull-right" id="login">
				       		<a href="<?php echo SITE_URL; ?>configPanel" class="btn btn-default"><?php echo user()->getUserName(); ?></a>
				       		<a href="<?php echo SITE_URL; ?>core/logout.php" class="btn btn-default">Logout</a>
				       	</form>
				       	
				       	<?php
				       }
				       ?>
		 		</div>
		
		
			</div>
		</div>
		
		
		
	</header>
	
	
	
