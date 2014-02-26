<?php
/*
Template part for register page

Created: February 2014
*/
?>


<h1>Sign up</h1>

<div class="well">
      <form id="signup" class="form-horizontal" method="post" action="<?php echo SITE_URL ?>core/register.php">
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
	        <label class="control-label">Email Address</label>
			<div class="controls">
			    <div class="input-prepend">
				<span class="add-on"><i class="icon-envelope"></i></span>
					<input type="email" class="input-xlarge" id="email" name="email" placeholder="Email Address">
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
	       <button type="submit" class="btn btn-success" >Register</button>

	      </div>
	</div>
	  </form>
</div>

