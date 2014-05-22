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
			
			
				<div class="pull-right">
					
					<img src="<?php echo $this->flag; ?>" class="country-flag-medium">
					
				</div>
			
			
			
				<!-- Teams -->
				<h3>Teams</h3>
				
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
				<h3>Referees</h3>
				
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
				
				
				<!-- Coaches -->
				<h3>Coaches</h3>
				
				<ul>
					
					<?php foreach ($this->coaches as $coach) { ?>
					
					<li>
						<a href="<?php echo SITE_URL . 'coach/' . $coach->getId(); ?>">
							<?php echo $coach->getName(); ?>
						</a>
					</li>
					
					<?php } ?>
				
				</ul>
				<!-- Coaches -->
				
			</div>
			
	
	
	</div>
	
	
	
	
	
	


</div>