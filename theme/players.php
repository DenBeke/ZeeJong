<?php
/*
Template part for events page

Created: March 2014
*/
?>

<div class="container">

	<h2 id="title-events">Top Players</h2>


	<table class="table table-striped">
	
			 	<tr>
			 		<th>Name</th>
			 		<th class="center">Matches</th>
			 		<th class="center">Goals</th>
			 	</tr>
	
	
			 	<?php foreach($this->players as $player) { ?>
	
			 	<tr>
	
				 	<td><a href="<?php echo SITE_URL . 'player/' . $player->getId(); ?>"><?php echo $player->getName(); ?></a></td>
	
				 	<td class="center"><span class="badge"><?php echo $player->getTotalNumberOfMatches(); ?></span></td>
	
				 	<td class="center"><span class="badge"><?php echo $player->getTotalNumberOfGoals(); ?></span></td>
	
				</tr>
	
	
			 	<?php } ?>
	
			 </table>

</div>