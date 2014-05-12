<?php
/*
 Place a bet template

 Created March 2014
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
		}
		if(strlen($this->getErrorMessage())>0){
			?>
			<div class="alert alert-danger">
			<strong><?php echo $this->getErrorMessage() ?></strong>
			
			</div>
			
			
			<?php
			}else if(!$this->setGroup()){
			?>
			<div class="alert alert-danger">
			<strong>This group does not exist.</strong>
			</div>
			<?php

			}else{
			// We're good to go
			?>
			
			<div class="col-md-12">
			<div class=top-left><div class=badge><h1><?php echo $this->getGroup()->getName() ?></h1></div></div>
			<div class="col-md-5">
				<h2>Members</h2>
				<table class="table table-striped">
					<tr>
						<th>Name</th>
						<th>Action</th>
					</tr>
				<?php		
				$members = $this->getGroup()->getMembers();
				foreach($members as $memberId) {
				$user = new User($memberId); ?>
				<tr>
				<td><?php echo $user->getUserName() ?></td>
				<?php if($this->getGroup()->isUserOwner($_SESSION['userID'])&&!$this->getGroup()->isUserOwner($memberId)){
							?>
						
								<form id="removeUser" class="form-horizontal" role="form" method="post" action="<?php echo SITE_URL ?>group/<?php echo $this->getGroup()->getName()?>">			
								<input type="hidden" name="userToRemove" id="userToRemove" value=<?php echo $memberId?> />
								<input type="hidden" name="groupName" id="groupName" value=<?php echo $this->getGroup()->getName()?> />
								<td>
									<button type="submit" class="btn btn-warning" >Remove</button>
								</td>
								</form>							
								
								
							
							<?php
							}
							if($this->mayGroupBeDeleted()){
					?>
								<form id="deleteGroup" class="form-horizontal" role="form" method="post" action="<?php echo SITE_URL ?>group/<?php echo $this->getGroup()->getName()?>">			
								<input type="hidden" name="groupToRemove" id="groupToRemove" value=<?php echo $this->getGroup()->getName()?> />
								<td>
									<button type="submit" class="btn btn-warning" >Remove group</button>
								</td>
								</form>		
						<?php

						}else if($memberId == $_SESSION['userID']&&!$this->getGroup()->isUserOwner($memberId))	{
							?>
						
								<form id="removeUser" class="form-horizontal" role="form" method="post" action="<?php echo SITE_URL ?>group/<?php echo $this->getGroup()->getName()?>">			
								<input type="hidden" name="userToRemove" id="userToRemove" value=<?php echo $memberId?> />
								<input type="hidden" name="groupName" id="groupName" value=<?php echo $this->getGroup()->getName()?> />
								<td>
									<button type="submit" class="btn btn-warning" >Leave</button>
								</td>
								</form>							
								
								
							
							<?php
							}
						?>
				</tr>
				
				<?php } ?>
				</table>
			</div>
			
			
			<div class="col-md-4">
				
				<div id="chatResults" class="well">
					
					<div class="loader-container">
						<div class="loader"></div>
						loading chat
					</div>
					
				</div>

				<div class="input-group">
				  <input type="hidden" id="author" name="author" value="<?php echo user() -> getUserName(); ?>">
				  <input type="text" class="form-control" id="text" name="text" size="100">
				  <input type="hidden" id="chat-group-id" name="chat-group-id" value="<?php echo $this -> groupId; ?>">
				  <span class="input-group-btn">
					  <input type="submit" value="Talk!" id="submitter" class="btn btn-default">
				  </span>
				</div><!-- /input-group -->
				
				
				
				
				
				
				
			</div>
			
			<div class="col-md-12">
				<h2>Bets</h2>
				<table class="table table-striped">
				<tr>
					<th>Made by</th>
					<th>Team 1</th>
					<th>Score</th>
					<th>Team 2</th>
					<th>Player that makes first goal</th>
					<th># Red Cards</th>
					<th># Yellow Cards</th>
					<th>Amount</th>
				</tr>
					<?php
					$bets = $this -> getGroup() -> getUnhandledBets();
					foreach ($bets as $betId) {
						$bet = new Bet($betId);?>
						<tr>
							
							<?php echo $bet -> dataHiddenAsString();?>
						</tr>
						
		
					<?php }
					?>
				</table>
		
			</div>
			
			
			<div class="col-md-12">
				<h2>Bets - History</h2>
				<table class="table table-striped">
				<tr>
					<th>Made by</th>
					<th>Team 1</th>
					<th>Score</th>
					<th>Team 2</th>
					<th>Player that makes first goal</th>
					<th># Red Cards</th>
					<th># Yellow Cards</th>
					<th>Amount</th>
				</tr>
					<?php
					// Heel dit zal opnieuw gemaakt worden, dus heeft geen zin om nu $database weg te doen
					$bets = $this -> getGroup() -> getHandledbets();
					foreach ($bets as $betId) {
						$bet = new Bet($betId);
						?>
						<tr>
						<?php echo $bet -> dataAsColouredString();?>
						</tr>
					<?php
					}
					?>
				</table>
		
			</div>
			
			
			
			
			
			
			</div>

			
			<?php
			}
		?>

