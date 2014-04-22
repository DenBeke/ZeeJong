<?php
/*
Template part for login page

Created: February 2014
*/
?>


<div class="container">


	<?php
	if($this->loggedIn) {
		?>
		<h2></h2>
		
		<div class="alert alert-success">
			<strong><?php echo $this->loginMessage; ?></strong>
			You are successfully logged in!
		</div>
		<?php
	}
	else {
	?>
	
	<h2 id="title-login">Login</h2>
	
	<div class="alert alert-danger">
		<strong>Error</strong> 
		<?php echo $this->loginMessage; ?>
	</div>
	

	<div class="well">
		<form id="signup" class="form-horizontal" method="post" action="<?php echo SITE_URL; ?>login">
			
			<div class="form-group">
				<label class="control-label col-sm-2">Username</label>
				<div class="controls col-sm-10">
					<div class="input-group">
						<span class="add-on input-group-addon"> <span class="glyphicon glyphicon-user"></span> </span>
						<input type="text" class="form-control input-xlarge" id="username" name="username" placeholder="Username">
					</div>
				</div>
			</div>
			
			
			<div class="form-group">
				<label class="control-label col-sm-2">Password</label>
				<div class="controls col-sm-10">
					<div class="input-group">
						<span class="add-on input-group-addon"> <span class="glyphicon glyphicon-lock"></span> </span>
						<input type="Password" class="form-control input-xlarge" id="password" name="password" placeholder="Password">
					</div>
				</div>
			</div>
			
			
			<div class="form-group">
				<label class="control-label col-sm-2"></label>
				<div class="controls col-sm-10">
					<button type="submit" class="btn btn-success" >
						Login
					</button>
			
				</div>
			</div>
			
		</form>
	</div>
	
	
	<?php	
	}
	?>

</div>
