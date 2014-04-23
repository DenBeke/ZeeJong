<?php
/*
Template part for player page

Created: February 2014
*/
?>
<div class="container">


	<div class="row">

		
	
			<div class="container">
				<h2 id="title-player"><?php echo $this->player->getName(); ?></h2>
			</div>
			
			<div class="col-md-4">
			
			
			<ul class="list-group player-meta">
			
			  <li class="list-group-item">
			  	<b>First name</b>: <?php echo $this->player->getFirstName(); ?>
			  </li>
			  
			  <li class="list-group-item">
			  	<b>Last name</b>: <?php echo $this->player->getLastName(); ?>
			  </li>
			  
			  <li class="list-group-item">
			  	<b>Nationality</b>: <a href="<?php echo SITE_URL . 'country/' . $this->player->getCountry()->getId(); ?>"><?php echo $this->player->getCountry()->getName(); ?></a>
			  </li>
			  
			  
			  <li class="list-group-item">
			   	<b>Date of birth</b>: <?php echo date('d M Y',$this->player->getDateOfBirth()); ?>
			   </li>
			   
			   
			   <li class="list-group-item">
			   	<b>Position</b>: <?php echo $this->player->getPosition(); ?>
			   </li>
			  
			  
			  <li class="list-group-item">
			   	<b>Teams</b>:
			   	<?php
			   		$count = 0;
			   		foreach($this->teams as $team) {
				   		if($count > 0) echo ',';
				   		$count++;
				?>
				<a href="<?php echo SITE_URL . 'team/' . $team->getId(); ?>"><?php echo $team->getName(); ?></a>
				<?php } ?>
			   </li>
			  
			
			  <li class="list-group-item">
			    <span class="badge"><?php echo $this->player->getTotalNumberOfGoals(); ?></span>
			    Goals
			  </li>
			  
			  <li class="list-group-item">
			    <span class="badge"><?php echo $this->player->getTotalNumberOfCards(); ?></span>
			    Yellow Cards
			  </li>
			  
			  <li class="list-group-item">
			    <span class="badge"><?php echo $this->player->getTotalNumberOfMatches(); ?></span>
			    Matches Played
			  </li>
		
			  <li class="list-group-item">
			    <span class="badge"><?php echo $this->player->getTotalNumberOfWonMatches(); ?></span>
			    Matches Won
			  </li>	  
			</ul>
		
		</div>
		
		
		<div class="col-md-2 image-container">
		
		
			<img src="<?php echo SITE_URL . 'core/cache/Player-' . $this->player->getId() . '.png'; ?>">
			
		
		</div>
		
		
		
		<div class="col-md-6">
			
			<div class="wiki">
			<?php echo $this->info; ?>
			</div>
		</div>		
	
	
	</div>
	

	<div class="col-md-12">

		<h3>Matches Played Last Year</h3>
	
		<?php
		generateChart(['Matches' => $this->player->getPlayedMatchesStats(), 'Matches won' => $this->player->getWonMatchesStats()], $this->player->getId()+1, 'Bar');		
		?>
	
	</div>
	
	
	
	
	<?php if($this->player->getTotalNumberOfMatches() != 0) { ?>
	
	
	<div class="col-md-12">
	
		<h3>Overall Stats</h3>	
		
		<?php generateChart($this->player->getOveralStats(), 1, 'Line'); ?>
		
		
	
	</div>
	
	
	<?php } ?>
	
	
	
	
	
	


</div>