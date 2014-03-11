<?php
/*
 Template part all bets page
 This page displays the bets for all matches

 Created: March 2014
 */
?>
<div class="container">
	<?php
		if(!loggedIn()){
		// User is not logged in
	?>
	<div class="alert alert-danger">
		<strong>You are not logged in.</strong>
	</div>
	<?php
	}else{
	?>
	<h2>Your bets</h2>
	<table class="table table-striped">
		<tr>
			<th>MatchId</th>
			<th>Team 1</th>
			<th>Team 2</th>
			<th>Bet on team</th>
			<th>Amount</th>
		</tr>
	<?php

		global $database;
		$bets = $this->getBets();
		foreach($bets as $betId) {
		$bet = new Bet($betId,$database);
	?>
		<tr>
			<td><?php echo $bet->getMatchId() ?></td>
			<td><?php echo $database->getMatchById($bet->getMatchId())->getTeamA()->getName() ?></td>
			<td><?php echo $database->getMatchById($bet->getMatchId())->getTeamB()->getName() ?></td>
			<td><?php echo $database->getTeamById($bet->getTeamId())->getName() ?></td>
			<td><?php echo $bet->getMoney() ?></td>
		</tr>
	<?php
	}
	}
	?>
		</table>
</div>

