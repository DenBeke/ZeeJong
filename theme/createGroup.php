<?php
/*
 Template part for the create group page

 Created: March 2014
 */
?>

<div class="container">

	<h1>Create a new group</h1>

	<div class="well">
		<form id="signup" class="form-horizontal" role="form" method="post" action="<?php echo SITE_URL ?>create-group">
			<div class="form-group">
				<label class="control-label col-sm-2">Name</label>
				<div class="controls col-sm-10">
					<div class="input-group">
						<span class="add-on input-group-addon"> <span class="glyphicon glyphicon-user"></span> </span>
						<input type="text" class="form-control input-xlarge" id="name" name="name" placeholder="name">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2"></label>
				<div class="controls col-sm-10">
					<button type="submit" class="btn btn-success" >
						Create Group!
					</button>

				</div>
			</div>
		</form>
	</div>

</div>
