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
	<title><?php echo $controller->title; ?></title>

	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href="<?php echo SITE_URL ?>style/style.css" rel="stylesheet" type="text/css">
	<link href="<?php echo SITE_URL ?>style/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="<?php echo SITE_URL ?>style/bootstrap-theme.css" rel="stylesheet" type="text/css">
	<link href="<?php echo SITE_URL ?>style/loader.css" rel="stylesheet" type="text/css">
	<link href="<?php echo SITE_URL ?>js/jqplot/jquery.jqplot.css" rel="stylesheet" type="text/css">
	<link href="<?php echo SITE_URL ?>style/chatbox.css" rel="stylesheet" type="text/css">
	<script src="<?php echo SITE_URL ?>js/jquery-1.11.0.min.js" type="text/javascript"></script>
	<script src="<?php echo SITE_URL ?>js/script.js" type="text/javascript"></script>
	<script src="<?php echo SITE_URL ?>js/bootstrap.js" type="text/javascript"></script>
	<script src="<?php echo SITE_URL ?>js/hchart/highcharts.js" type="text/javascript"></script>
	<script src="<?php echo SITE_URL ?>js/hchart/modules/funnel.js" type="text/javascript"></script>
	<script src="<?php echo SITE_URL ?>js/tinymce/js/tinymce/tinymce.min.js" type="text/javascript"></script>
	<script src="<?php echo SITE_URL ?>js/chatbox.php" type="text/javascript"></script>

	<?php
	if($controller->page == 'login' and loggedIn() == true) {
	?>
	<meta http-equiv="refresh" content="3; url=<?php echo SITE_URL; ?>" />
	<?php
	}
	?>

	<script type="text/javascript">
	tinymce.init({
		selector: "textarea.editor"
	 });
	</script>



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
				      <li class=""><a href="<?php echo SITE_URL . 'events/'; ?>">Upcoming Events</a></li>
				      <li><a href="<?php echo SITE_URL; ?>news">News</a></li>
				      <li class="dropdown">
				        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Leagues <b class="caret"></b></a>
				        <ul class="dropdown-menu">


					      <?php foreach($header->competitions as $competition) { ?>
						      <li><a href="<?php echo SITE_URL . 'competition/' . $competition -> getId(); ?>"><?php echo $competition -> getName(); ?></a></li>
						  <?php } ?>

				        </ul>

				      </li>
				    <?php
					if (loggedIn()) {

					?>

					<li><a href="<?php echo SITE_URL; ?>bets">Bets</a></li>

					  <li class="dropdown">
				        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Groups <b class="caret"></b></a>
				        <ul class="dropdown-menu">
				        	<li> <a href ="<?php echo SITE_URL; ?>create-group">Create a group</a></li>
					      	<li> <a href ="<?php echo SITE_URL; ?>invite-user">Invite users</a></li>
					        <li> <a href ="<?php echo SITE_URL; ?>invites">Invites</a></li>

					      	<?php foreach($header->userGroupNames as $groupName) {?>				      		
						    <li><a href="<?php echo SITE_URL . 'group/' . $groupName; ?>"><?php echo $groupName; ?></a></li>
						   	<?php } ?>

				        </ul>

				      </li>

					<li><a href="#">€&nbsp;<?php echo $header->money; ?></a></li>
					<li><a href="#">Score:&nbsp;<?php echo $header->score; ?></a></li>

					<?php
					}
					?>
				    </ul>

				       <?php
				       if(!loggedIn()) {
				       	?>



						<div class="navbar-form navbar-right form-group">

						    <a href="<?php echo SITE_URL; ?>login/" class="btn btn-default">Login</a>
							<a href="<?php echo SITE_URL; ?>register" class="btn btn-default">Register</a>

						</form>

						<?php
						}
						else {
						?>




						<form class="navbar-form pull-right" id="login">
							<a href="<?php echo SITE_URL; ?>config-panel" class="btn btn-default"><?php echo user() -> getUserName(); ?></a>
							<a href="<?php echo SITE_URL; ?>core/logout.php" class="btn btn-default">Logout</a>
						</form>

				       	<?php
						}
				       ?>
					</div>


			</div>
		</div>



	</header>


	<?php if(sizeof($navigator->getNavigator($controller)) > 1) { ?>

	<div class="container">

		<ol class="breadcrumb">
			<?php foreach ($navigator->getNavigator($controller) as $title => $url) { ?>
				<li><a href="<?php echo $url; ?>"><?php echo $title; ?></a></li>
			<?php } ?>
		</ol>

	</div>

	<?php } ?>
