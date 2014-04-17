<?php
/*
Template part for player page

Created: February 2014
*/
?>
<div class="container">


	<div class="row">

		
	
			<div class="container">
				<h2 id="title-country"><?php echo $this->country->getName(); ?></h2>
			</div>
			
			
			<ul>
				
				<?php foreach ($this->teams as $team) { ?>
				
				<li>
					<a href="<?php echo SITE_URL . 'team/' . $team->getId(); ?>">
						<?php echo $team->getName(); ?>
					</a>
				</li>
				
				<?php } ?>
			
			</ul>
			
	
	
	</div>
	
	
	
	
	
	


</div>