<?php include(dirname(__FILE__) . '/admin.php'); ?>

<p></p>

<div class="container">

	<?php foreach($this->competitions as $competition) { ?>
	<div class="competitions panel panel-default">
		<div class="panel-heading hidden-click">
			<h3 class="panel-title"><?php echo $competition->getName(); ?></h3>
		</div>
		
		<div class="competition-content hidden-content panel-body">
			
			
			<?php foreach($competition->getTournaments() as $tournament) { ?>
			<div class="panel panel-default">
				
				<div class="panel-heading hidden-click tournament-click">
				
					<h3 class="panel-title"><?php echo $tournament->getName(); ?></h3>
					
				</div>
				
				<div class="hidden-content panel-body" data-url="<?php echo SITE_URL . 'tournament/' . $tournament->getId(); ?>">
					
						<div class="loader-container"><div class="loader"></div>loading</div>	
										
				</div>
				
			</div>
				
			<?php } ?>	
			
			
		</div>
		
	</div>
		
	<?php } ?>	
	
</div>