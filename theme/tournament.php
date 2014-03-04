<?php
/*
Template part for tournament page

Created: February 2014
*/
?>

<div class="container">

	<h2 id="title-tournament"><?php echo $this->tournament->getName(); ?></h2>
	
	
	<ul>
	
		<?php
		foreach($this->tournament->getMatches(0) as $match) { 
		?>
	
		<li>
			<a href="<?php echo SITE_URL . 'match/' . $match->getId(0); ?>"><?php echo $match->getTeamA()->getName(); ?> - <?php echo $match->getTeamB()->getName(); ?></a>
		</li>
	
	
	
		<?php
		} //end foreach
		?>
	
	</ul>
	
</div>