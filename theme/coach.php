<?php
/*
Template part for coach page

Created: February 2014
*/
?>

<div class="container">
	
	
	<div class="row">
	
		
	
			<div class="container">
				<h2 id="title-coacg"><?php echo $this->coach->getName(); ?></h2>
			</div>
			
			<div class="col-md-10">
			
			
			<ul class="list-group player-meta">
			
			  <li class="list-group-item">
			  	<b>First name</b>: <?php echo $this->coach->getFirstName(); ?>
			  </li>
			  
			  <li class="list-group-item">
			  	<b>Last name</b>: <?php echo $this->coach->getLastName(); ?>
			  </li>
			  
			  <li class="list-group-item">
			  	<b>Nationality</b>: <?php echo $this->coach->getCountry()->getName(); ?>
			  </li>
			 
			   
			</ul>
		
		</div>
		
		
		<div class="col-md-2 image-container">
		
		
			<img src="<?php echo SITE_URL . 'core/cache/Coach-' . $this->coach->getId() . '.png'; ?>">
			
		
		</div>
	
	
	</div>
	

</div>