<?php
/*
Template part for referee page

Created: February 2014
*/
?>

<div class="container">

	<div class="row">
	
		
	
			<div class="container">
				<h2 id="title-referee"><?php echo $this->referee->getName(); ?></h2>
			</div>
			
			<div class="col-md-10">
			
			
			<ul class="list-group player-meta">
			
			  <li class="list-group-item">
			  	<b>First name</b>: <?php echo $this->referee->getFirstName(); ?>
			  </li>
			  
			  <li class="list-group-item">
			  	<b>Last name</b>: <?php echo $this->referee->getLastName(); ?>
			  </li>
			  
			  <li class="list-group-item">
			  	<b>Nationality</b>: <a href="<?php echo SITE_URL . 'country/' . $this->referee->getCountry()->getId(); ?>"><?php echo $this->referee->getCountry()->getName(); ?></a>
			  </li>
			 
			   
			</ul>
		
		</div>
		
		
		<div class="col-md-2 image-container">
		
		
			<img src="<?php echo SITE_URL . 'core/cache/Referee-' . $this->referee->getId() . '.png'; ?>">
			
		
		</div>
	
	
	</div>


</div>