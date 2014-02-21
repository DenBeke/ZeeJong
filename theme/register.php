<?php
/*
Template part for register page

Created: February 2014
*/
?>
<div class="container">
	<form class="form-signin" role="form" action="core/register.php" method="post" id="register">
		<h2 class="form-signin-heading">Register</h2>
		<input name="username" type="username" class="form-control" placeholder="Username" required autofocus>
		<input name="email" type="email" class="form-control" placeholder="Email address" required autofocus>
		<input name="password" type="password" class="form-control" placeholder="Password" required>
		<label class="checkbox">
		<button type="submit" name="submit" value="login" class="btn">Register</button>
	</form>
</div> <!-- /container -->
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
