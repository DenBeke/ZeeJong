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
			
			
			
			<!-- Teams -->
			<h2>Teams</h2>
			
			<ul>
				
				<?php foreach ($this->teams as $team) { ?>
				
				<li>
					<a href="<?php echo SITE_URL . 'team/' . $team->getId(); ?>">
						<?php echo $team->getName(); ?>
					</a>
				</li>
				
				<?php } ?>
			
			</ul>
			<!-- Teams -->
			
			
			
			<!-- Referees -->
			<h2>Referees</h2>
			
			<ul>
				
				<?php foreach ($this->referees as $ref) { ?>
				
				<li>
					<a href="<?php echo SITE_URL . 'referee/' . $ref->getId(); ?>">
						<?php echo $ref->getName(); ?>
					</a>
				</li>
				
				<?php } ?>
			
			</ul>
			<!-- Referees -->
			
	
	
	</div>
	
	
	
	
	
	


</div>