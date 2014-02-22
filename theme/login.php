<?php
/*
Template part for login page

Created: February 2014
*/
?>


<div class="container">


	<?php
	if(LOGGED_IN) {
		?>
		<div class="alert-success">
			<strong><?php echo LOGIN_MESSAGE; ?></strong>
			You are successfully logged in!
		</div>
		<?php
	}
	else {
	?>
	<div class="alert-error">
		<strong>Error</strong> 
		<?php echo LOGIN_MESSAGE; ?>
	</div>
	<?php	
	}
	?>

</div>