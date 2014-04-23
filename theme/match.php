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
							Prognose: <?php $prognose = $this->match->getPrognose(); echo $prognose[0] . '-' . $prognose[1]; ?>
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
			
			
			
			<?php if($this->match->getDate() >= strtotime(date('d M Y', time()))) { ?>
			
			
			<div class="col-md-12 bet-button-container container">
					<a href="<?php echo SITE_URL . 'place-bet/' . $this->match->getId(); ?>" class="btn btn-success btn-lg">Place Bet</a>
				
			</div>
			
			
			<?php } ?>
			
			
		</div>
	
		
		
		
		<!-- Goals -->
		
		<?php if(sizeof($this->goals) > 0) { ?>
		
		<div class="col-md-8">
		
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
						<?php echo $database->getPlayerById($goal->getPlayerId())->getName(); ?>
						<span class="football-icon"></span>
					</td>
					
					<td><span class="badge"><?php echo $goal->getTime(); ?>'</span></td>
					
					<td class="<?php echo $gClass; ?>">
						<span class="football-icon"></span>
						<?php echo $database->getPlayerById($goal->getPlayerId())->getName(); ?>		
					</td>
					
				</tr>
				
				<?php } ?>
			</table>
		
		</div>
		
		<?php } ?>
	
	</div>
	
	
	<!--<div id="field">
		
			<table>
			  <tbody><tr>
			    <td rowspan="4"><div class="player">1</div></td>
			    <td><div class="player">5</div></td>
			    <td><div class="player">8</div></td>
			    <td><div class="player">11</div></td>
			  </tr>
			  <tr>
			    <td><div class="player">4</div></td>
			    <td rowspan="2"><div class="player">8</div></td>
			    <td rowspan="2"><div class="player">9</div></td>
			  </tr>
			  <tr>
			    <td><div class="player">3</div></td>
			  </tr>
			  <tr>
			    <td><div class="player">2</div></td>
			    <td><div class="player">6</div></td>
			    <td><div class="player">7</div></td>
			  </tr>
			</tbody></table>
		
	</div>-->
	
	
	
		
	
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
	

</div>
