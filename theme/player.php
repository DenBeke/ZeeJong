<?php
/*
Template part for player page

Created: February 2014
*/
?>
<div class="container">

	<h2 id="title-player"><?php echo $this->player->getName(); ?></h2>
	
	
	<ul class="list-group player-meta">
	
	  <li class="list-group-item">
	  	First name: <?php echo $this->player->getFirstName(); ?>
	  </li>
	  
	  <li class="list-group-item">
	  	Last name: <?php echo $this->player->getLastName(); ?>
	  </li>
	  
	  <li class="list-group-item">
	  	Nationality: <?php echo $this->player->getCountry()->getName(); ?>
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
	

	<div class="col-md-6">

		<h3>Matches</h3>
	
		<?php
		generateChart($this->player->getPlayedMatchesStats());		
		?>
	
	</div>
	
	
	
	<div class="col-md-6">
		<h3>Matches won</h3>
	
	
		<?php
		generateChart($this->player->getWonMatchesStats());		
		?>

	</div>
	


</div>