<?php
/*
 Place a bet template

 Created March 2014
 */
 ?>
	<div class="container">


		
		
		
		<?php
		global $database;
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
			<h1><?php echo $this->getGroup()->getName() ?></h1>
			<div class="col-md-3">
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
			
			</div>

			
			<?php
			}
		?>

