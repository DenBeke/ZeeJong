<?php include(dirname(__FILE__) . '/admin.php'); ?>

<div class="container">

	<?php foreach($this->competitions as $competition) { ?>
	<div class="competitions">
		<h5 class="hidden-click"><?php echo $competition->getName(); ?></h5>
		
		<div class="competition-content hidden-content">
			
			<?php foreach($competition->getTournaments() as $tournament) { ?>
			<div class="">
				<p class="hidden-click tournament-click"><?php echo $tournament->getName(); ?></p>
				
				<div class="hidden-content" data-url="<?php echo SITE_URL . 'tournament/' . $tournament->getId(); ?>">
					
						<div class="loader-container"><div class="loader"></div>loading</div>	
										
				</div>
				
			</div>
				
			<?php } ?>	
			
			
		</div>
		
	</div>
		
	<?php } ?>	
	
</div>