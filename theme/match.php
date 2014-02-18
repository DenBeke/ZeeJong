<?php
/*
Template part for match page

Created: February 2014
*/
?>
<h2 id="title-match"><?php echo $object->getTeamA()->getName() ?> - <?php echo $object->getTeamB()->getName() ?></h2>


<h3><?php echo $object->getTeamA()->getName() ?></h3>

<ul class="team-a">

	<?php
	foreach($object->getPlayersTeamA() as $player) { 
	?>

	<li>
		<a href="<?php echo SITE_URL . '?page=player&player=' . $player->getId(); ?>"><?php echo $player->getName(); ?></a>
	</li>

	<?php
	} //end foreach
	?>

</ul>




<h3><?php echo $object->getTeamB()->getName() ?></h3>

<ul class="team-a">

	<?php
	foreach($object->getPlayersTeamB() as $player) { 
	?>

	<li>
		<a href="<?php echo SITE_URL . '?page=player&player=' . $player->getId(); ?>"><?php echo $player->getName(); ?></a>
	</li>

	<?php
	} //end foreach
	?>

</ul>