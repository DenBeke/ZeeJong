<?php
/*
Template part for tournament page

Created: February 2014
*/
?>

<div class="container">

	<h2 id="title-tournament"><?php echo $this->tournament->getName(); ?></h2>
	
	
	<table class="table striped matches">
		
		
		<thead>
			
			<th>
				Team A
			</th>
			
			<th>Score</th>
			
			<th>Team B</th>
			
		</thead>
	
	
		<?php
		foreach($this->tournament->getMatches(0) as $type => $matches) { 
			
			if(sizeof($matches) == 0) {
				continue;
			}
			
		?>
		
		
		<tr>
			<td colspan="5" class="final-type">
				<?php echo $type; ?>
			</td>
		</tr>
		
		
		<?php
		
			foreach ($matches as $match) {
		
			
		
		
		?>
		
		
	
		<tr>
			
			<!-- Team A -->
			<td>
				<a href="<?php echo SITE_URL . 'team/' . $match->getTeamA()->getId(); ?>">
					<?php echo $match->getTeamA()->getName(); ?>
				</a>
			</td>
			
			<!-- Score -->
			<td>
				<a href="<?php echo SITE_URL . 'match/' . $match->getId(0); ?>">
					<span class="badge"><?php try { echo $match->getScore(); } catch(exception $e) { echo date('d-m-Y', $match->getDate()); } ?></span>
				</a>
			</td>
			
			<!-- Team B -->
			<td>
				<a href="<?php echo SITE_URL . 'team/' . $match->getTeamB()->getId(); ?>">
					<?php echo $match->getTeamB()->getName(); ?>
				</a>
			</td>
			
			
			<td class="admin-only">
				<a href="<?php echo SITE_URL . 'admin/match/' . $match->getId() . '/edit'; ?>" class="btn-xs btn btn-default">Edit</a>
			</td>
			
			<td class="admin-only">
				<a href="<?php echo SITE_URL . 'admin/match/' . $match->getId() . '/delete'; ?>" class="btn-xs btn btn-default">Delete</a>
			</td>
			
		</tr>
	
	</tr>
	
	
		<?php
			}
		
		
		} //end foreach
		?>
	
	</table>
	
</div>