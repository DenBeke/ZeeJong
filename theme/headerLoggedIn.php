<?php
/*
Template part for header when logged in

Created: February 2014
*/
$user = new User($_SESSION['userID']);
?>

<ul class="nav navbar-nav navbar-right">
  <li><a href="#"><?php echo $user->getUserName(); ?></a></li>
  <li><a href="<?php echo SITE_URL; ?>core/logout.php">Logout</a></li>
</ul>

	
