<?php
/*
 Template part for register page

 Created: February 2014
 */
?>

<div class="container">

	<h1>Sign up</h1>

	<div class="well">
		<form id="signup" class="form-horizontal" role="form" method="post" action="<?php echo SITE_URL ?>register">
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
				<label class="control-label col-sm-2">Email Address</label>
				<div class="controls col-sm-10">
					<div class="input-group">
						<span class="add-on input-group-addon"> <span class="glyphicon glyphicon-envelope"></span> </span>
						<input type="email" class="form-control input-xlarge" id="email" name="email" placeholder="Email Address">
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
				<label class="control-label col-sm-2">Please re-type Password</label>
				<div class="controls col-sm-10">
					<div class="input-group">
						<span class="add-on input-group-addon"> <span class="glyphicon glyphicon-lock"></span> </span>
						<input type="Password" class="form-control input-xlarge" id="password2" name="password2" placeholder="Password">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"></label>
				<div class="controls col-sm-10">
					<button type="submit" class="btn btn-success" >
						Register
					</button>

				</div>
			</div>
		</form>
	</div>
	
	<div class="alert alert-error">
		<?php
		echo $this -> registerMessage;
		?>
	</div>
</div>
