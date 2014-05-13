<?php
/*
Template part for match page

Created: February 2014
*/
?>


<div class="container">

	<h2 id="title-match"><?php echo $this->match->getTeamA()->getName() ?> - <?php echo $this->match->getTeamB()->getName() ?></h2>
	
	
	
	<div class="row">
	
		<!-- Information panel -->
		<div class="col-md-4">
		
			<div class="panel panel-default">
			
			
				<div class="panel-heading">
			
					<h3 class="panel-title">Information</h3>
					
					
				</div>
				
				
				
				<div class="panel-body">
					
					<ul class="list-group">
					
						<li class="list-group-item">
							Final score: <?php try { echo $this->match->getScore(); } catch(exception $e) {} ?>
						</li>
					
					
						<li class="list-group-item">
							Competition: <a href="<?php echo SITE_URL . 'competition/' . $this->match->getTournament()->getCompetition()->getId(); ?>">
								<?php echo $this->match->getTournament()->getCompetition()->getName(); ?></a>
						</li>
					
						<li class="list-group-item">Date: <?php echo date('d-m-Y', $this->match->getDate()); ?></li>
						
						<li class="list-group-item">
							<span class="badge"><?php echo $this->match->getTotalCards(); ?></span>
							Cards
					  	</li>
					  	
					  	<li class="list-group-item">
							Referee:
							<?php if($referee = $this->match->getReferee()) { ?>
								<a href="<?php echo SITE_URL . 'referee/' . $this->match->getReferee()->getId(); ?>"><?php echo $this->match->getReferee()->getName(); ?></a>
							<?php } else { ?>
								Not found
							<?php } ?>
					  	</li>
					</ul>
					
					
				</div>
			
			</div>
			
			
			
		</div>
	
		
		
		
		<!-- Goals -->
		
		<?php if(sizeof($this->goals) > 0) { ?>
		
		<div class="col-md-8">
		
			<h4>Goals</h4>
		
			<table class="goals table table-striped">
				<?php foreach($this->goals as $goal) {
				
					if($goal->getTeamId() == $this->match->getTeamA()->getId()) {
						$gClass = 'team-a';
					}
					else {
						$gClass = 'team-b';
					}
				
				?>
				<tr class="goal">
					
					<td class="<?php echo $gClass; ?>">
						<a href="<?php echo SITE_URL . 'player/' . $database->getPlayerById($goal->getPlayerId())->getId(); ?>"><?php echo $database->getPlayerById($goal->getPlayerId())->getName(); ?></a>
						<span class="football-icon"></span>
					</td>
					
					<td><span class="badge"><?php echo $goal->getTime(); ?>'</span></td>
					
					<td class="<?php echo $gClass; ?>">
						<span class="football-icon"></span>
						<a href="<?php echo SITE_URL . 'player/' . $database->getPlayerById($goal->getPlayerId())->getId(); ?>">
							<?php echo $database->getPlayerById($goal->getPlayerId())->getName(); ?>
						</a>	
					</td>
					
				</tr>
				
				<?php } ?>
			</table>
		
		</div>
		
		<?php } ?>
		
		
		
		
		
		<!-- Cards -->
		
		<?php if(sizeof($this->cards) > 0) { ?>
		
		<div class="col-md-8">
			
			<h4>Cards</h4>
		
			<table class="cards table table-striped">
				<?php foreach($this->cards as $card) {
				
				
					if($card->getTeamId() == $this->match->getTeamA()->getId()) {
						$gClass = 'team-a';
					}
					else {
						$gClass = 'team-b';
					}
					
					
					
					if($card->getColor() == 1) {
						$color = 'yellow';
					}
					else if($card->getColor() == 2) {
						$color = 'red';
					}
					else {
						$color = 'yellow-red';
					}
				
				?>
				<tr class="goal">
					
					<td class="<?php echo $gClass; ?>">
						<a href="<?php echo SITE_URL . 'player/' . $database->getPlayerById($card->getPlayerId())->getId(); ?>"><?php echo $database->getPlayerById($card->getPlayerId())->getName(); ?></a>
						<span class="card-icon <?php echo $color; ?>"></span>
					</td>
					
					<td><span class="badge"><?php echo $card->getTime(); ?>'</span></td>
					
					<td class="<?php echo $gClass; ?>">
						<span class="card-icon <?php echo $color; ?>"></span>
						<a href="<?php echo SITE_URL . 'player/' . $database->getPlayerById($card->getPlayerId())->getId(); ?>"><?php echo $database->getPlayerById($card->getPlayerId())->getName(); ?></a>
					</td>
					
				</tr>
				
				<?php } ?>
			</table>
		
		</div>
		
		<?php } ?>
		
		
		
		
		
	
	</div>
	

		
	
	<div class="row">
	
	
		<!-- Team A -->
		<div class="col-md-6">
			<div class="panel panel-default">
			
			
				<div class="panel-heading">
			
					<h3 class="panel-title"><a href="<?php echo SITE_URL . 'team/' . $this->match->getTeamA()->getId(); ?>"><?php echo $this->match->getTeamA()->getName() ?></a></h3>
					
					
				</div>
				
				
				
				<div class="panel-body">
				
				
					<table class="table table-striped">
					         
					    <tbody>
						    <tr>
						    	<th>#</th>
						    	<th>Name</th>
						    </tr>
						    
						    
						    <?php
						    foreach($this->match->getPlayersTeamA() as $player) { 
						    ?>
						     <tr>
						     	<td><?php if($player->number > 0) echo $player->number; ?></td>
						     	<td><a href="<?php echo SITE_URL . 'player/' . $player->getId(); ?>"><?php echo $player->getName(); ?></a></td>
						     </tr>
						     
						     <?php
						     } //end foreach
						     ?>
					             
						</tbody>
					</table>
				
					
				</div>
				
				
				
				<div class="panel-footer">
						Coach:
						<?php if($coach = $this->match->getTeamA()->getCoachForMatch($this->match->getId())) { ?>
							<a href="<?php echo SITE_URL . 'coach/' . $coach->getId(); ?>"><?php echo $coach->getName(); ?></a>
						<?php } else { ?>
							Not found
						<?php } ?>
				</div>
				
			
			</div>
			
		</div>
		
		
		
		
		
		<!-- Team B -->
		<div class="col-md-6">
		
			<div class="panel panel-default">
			
			
				<div class="panel-heading">
			
					<h3 class="panel-title"><a href="<?php echo SITE_URL . 'team/' . $this->match->getTeamB()->getId(); ?>"><?php echo $this->match->getTeamB()->getName() ?></a></h3>
					
					
				</div>
				
				
				
				<div class="panel-body">
					
					<table class="table table-striped">
					         
					    <tbody>
						    <tr>
						    	<th>#</th>
						    	<th>Name</th>
						    </tr>
						    
						    
						    <?php
						    foreach($this->match->getPlayersTeamB() as $player) { 
						    ?>
						    
						     <tr>
						     	<td><?php if($player->number > 0) echo $player->number; ?></td>
						     	<td><a href="<?php echo SITE_URL . 'player/' . $player->getId(); ?>"><?php echo $player->getName(); ?></a></td>
						     </tr>
						     
						     <?php
						     } //end foreach
						     ?>
					             
						</tbody>
					</table>
					
					
				</div>
				
				
				
				<div class="panel-footer">
						Coach:
						<?php if($coach = $this->match->getTeamB()->getCoachForMatch($this->match->getId())) { ?>
							<a href="<?php echo SITE_URL . 'coach/' . $coach->getId(); ?>"><?php echo $coach->getName(); ?></a>
						<?php } else { ?>
							Not found
						<?php } ?>
				</div>
				
			
			</div>
			
		</div>
	
	</div>
	
	
	<p>
		<?php generateTweetButton() ?>
	</p>
	
	<p>
		<?php generateLikeButton(SITE_URL . 'match/' . $this->match->getId()); ?>
	</p>
	
	

</div>
