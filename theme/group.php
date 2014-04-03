<?php
/*
 Place a bet template

 Created March 2014
 */
 ?>
	<div class="container">


		
		
		
		<?php
		global $database;
		if(!loggedIn()){
		// User is not logged in
	
		?>
		<div class="alert alert-danger">
			<strong>You are not logged in.</strong>
		</div>
		<?php
		}
		if(strlen($this->getErrorMessage())>0){
			?>
			<div class="alert alert-danger">
			<strong><?php echo $this->getErrorMessage() ?></strong>
			
			</div>
			
			
			<?php
			
			
		}else{
			// We're good to go
			
			?>
			
			<div class="col-md-12">
			<h1><?php echo $this->getGroup()->getName() ?></h1>
			</div>
			
			
			
			
			
			<?php
			
		}
		
		
?>

</div>