<?php
/*
 Template part for the user config panel

 Created: February 2014
 */
?>
<div class="container">

	<h1>Change your account settings</h1>
	<p>
		Leave fields open if you don't want them to be changed.
	</p>
	<p>
		Fields marked (*) are required.
	</p>
	<?php
	if(!loggedIn()){
	// User is not logged in

	?>
	<div class="alert alert-danger">
		<strong>You are not logged in.</strong>
	</div>
	<?php
	}else{
	if(strlen($this->configErrorMessage)>0){
	// there were errors, let's display them
	?>
	<div class="alert alert-danger">
		<strong> <?php
		echo nl2br($this -> configErrorMessage);
		?></strong>
	</div>

	<?php
	}
	if(strlen($this->configSuccessMessage)>0){
	// at least one thing succeeded, let's display what
	?>
	<div class="alert alert-success">
		<strong> <?php
		echo nl2br($this -> configSuccessMessage);
		?></strong>
	</div>
	<?php
	}
	// Display 'change settings' form
	?>


	<div class="well">
		<form id="changeSettings" class="form-horizontal" role="form" method="post" action="<?php echo SITE_URL ?>configPanel">
			<div class="form-group">
				<label class="control-label col-sm-2">Current Password (*)</label>
				<div class="controls col-sm-10">
					<div class="input-group">
						<span class="add-on input-group-addon"> <span class="glyphicon glyphicon-lock"></span> </span>
						<input type="Password" class="form-control input-xlarge" id="oldPass" name="oldPass" placeholder="">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2">New Email Address</label>
				<div class="controls col-sm-10">
					<div class="input-group">
						<span class="add-on input-group-addon"> <span class="glyphicon glyphicon-envelope"></span> </span>
						<input type="email" class="form-control input-xlarge" id="newEmail" name="newEmail" placeholder="New Email Address">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2">New Password</label>
				<div class="controls col-sm-10">
					<div class="input-group">
						<span class="add-on input-group-addon"> <span class="glyphicon glyphicon-lock"></span> </span>
						<input type="Password" class="form-control input-xlarge" id="newPassword" name="newPassword" placeholder="Password">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2">Please re-type New Password</label>
				<div class="controls col-sm-10">
					<div class="input-group">
						<span class="add-on input-group-addon"> <span class="glyphicon glyphicon-lock"></span> </span>
						<input type="Password" class="form-control input-xlarge" id="newPassword2" name="newPassword2" placeholder="Password">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"></label>
				<div class="controls col-sm-10">
					<button type="submit" class="btn btn-success" >
						Update settings
					</button>

				</div>
			</div>
		</form>
	</div>

	<?php
	}
?>
</div>

