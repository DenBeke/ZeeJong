<?php
/*
Template part for match page

Created: February 2014
*/
?>


<div class="container">

	<h2 id="title-match"><?php echo $this->match->getTeamA()->getName() ?> - <?php echo $this->match->getTeamB()->getName() ?></h2>
	
	
	<h3><?php echo $this->match->getTeamA()->getName() ?></h3>
	
	<ul class="team-a">
	
		<?php
		foreach($this->match->getPlayersTeamA() as $player) { 
		?>
	
		<li>
			<a href="<?php echo SITE_URL . 'player/' . $player->getId(); ?>"><?php echo $player->getName(); ?></a>
		</li>
	
		<?php
		} //end foreach
		?>
	
	</ul>
	
	
	
	
	<h3><?php echo $this->match->getTeamB()->getName() ?></h3>
	
	<ul class="team-a">
	
		<?php
		foreach($this->match->getPlayersTeamB() as $player) { 
		?>
	
		<li>
			<a href="<?php echo SITE_URL . 'player/' . $player->getId(); ?>"><?php echo $player->getName(); ?></a>
		</li>
	
		<?php
		} //end foreach
		?>
	
	</ul>

</div>