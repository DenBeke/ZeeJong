<?php
/*
Template part for events page

Created: March 2014
*/
?>

<div class="container">

	<h2 id="title-events">Upcoming Events</h2>


	<table class="table striped matches">


		<thead>

			<th>
				Team A
			</th>

			<th>Score</th>

			<th>Team B</th>

		</thead>


		<?php
		foreach($this->events as $match) { 
		?>

		<tr>
				<td><?php echo $match->getTeamA()->getName(); ?></td>

				<td><a href="<?php echo SITE_URL . 'match/' . $match->getId(0); ?>"><span class="badge"><?php try { echo $match->getScore(); } catch(exception $e) { echo date('d-m-Y', $match->getDate()); } ?></span></a></td>

				<td><?php echo $match->getTeamB()->getName(); ?></td>
		</tr>

	</tr>


		<?php
		} //end foreach
		?>

	</table>

</div>