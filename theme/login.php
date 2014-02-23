<?php
/*
Template part for login page

Created: February 2014
*/
?>


<div class="container">


	<?php
	if($login->loggedIn) {
		?>
		<div class="alert alert-success">
			<strong><?php echo $login->loginMessage; ?></strong>
			You are successfully logged in!
		</div>
		<?php
	}
	else {
	?>
	<div class="alert alert-error">
		<strong>Error</strong> 
		<?php echo $login->loginMessage; ?>
	</div>
	

	<div class="well">
	   <form id="signup" class="form-horizontal" method="post" action="<?php echo SITE_URL; ?>?page=login">
			<div class="control-group">
		        <label class="control-label">Username</label>
				<div class="controls">
				    <div class="input-prepend">
					<span class="add-on"><i class="icon-user"></i></span>
						<input type="text" class="input-xlarge" id="username" name="username" placeholder="Username">
					</div>
				</div>
			</div>
			<div class="control-group">
		        <label class="control-label">Password</label>
				<div class="controls">
				    <div class="input-prepend">
					<span class="add-on"><i class="icon-lock"></i></span>
						<input type="Password" class="input-xlarge" id="password" name="password" placeholder="Password">
					</div>
				</div>
			</div>
			<div class="control-group">
			<label class="control-label"></label>
		      <div class="controls">
		       <button type="submit" class="btn btn-success">Login</button>
	
		      </div>
		</div>
		  </form>
	</div>
	
	
	<?php	
	}
	?>

</div>