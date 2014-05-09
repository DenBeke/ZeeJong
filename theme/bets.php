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
			<th>Team 1</th>
			<th>Score</th>
			<th>Team 2</th>
			<th>Player that makes first goal</th>
			<th># Red Cards</th>
			<th># Yellow Cards</th>
			<th>Amount</th>
		</tr>
	<?php
		$bets = $this->getBets();
		foreach($bets as $betId) {
		$bet = new Bet($betId);
	?>
		<tr>
			<?php
			 echo $bet->dataAsString();
			?>
		</tr>
	<?php
	}
	}
	?>
		</table>
</div>

