<?php
/*
 Template part for the accept-invites page

 Created: April 2014
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
	// Display invites
	?>
	<h2>You have been invited to:</h2>
	<table class="table table-striped">
		<tr>
			<th>From</th>
			<th>Group</th>
			<th>Accept</th>
		</tr>

		<?php
		$invites = $this->getInvites();
		foreach($invites as $inviteId) {
		$membership = new GroupMembership($inviteId);
		?>
		<tr>
			<form id="acceptInvite" class="form-horizontal" role="form" method="post" action="<?php echo SITE_URL ?>invites">			
			<td><?php echo $membership->getSender() ?></td>
			<td><?php echo $membership->getGroupName() ?></td>
			<input type="hidden" name="inviteId" id="inviteId" value=<?php echo $inviteId?> />
			<input type="hidden" name="accept" id="accept" value="True" />
			<td>
				<button type="submit" class="btn btn-success" >Accept</button>
			</td>
			</form>
		</tr>
		<?php
		}
		?>
	</table>
	<h2>Invites you sent:</h2>
	<table class="table table-striped">
		<tr>
			<th>To</th>
			<th>Group</th>
			<th>Withdraw</th>
		</tr>
		<?php
		$sentInvites = $this->getSentInvites();
		foreach($sentInvites as $inviteId) {
		$membership = new GroupMembership($inviteId);
		?>
		<tr>
			<form id="withdrawInvite" class="form-horizontal" role="form" method="post" action="<?php echo SITE_URL ?>invites">			
			<td><?php echo $membership->getUserName() ?></td>
			<td><?php echo $membership->getGroupName() ?></td>
			<input type="hidden" name="inviteId" id="inviteId" value=<?php echo $inviteId?> />
			<input type="hidden" name="withdraw" id="withdraw" value="True" />
			<td>
				<button type="submit" class="btn btn-success" >Withraw</button>
			</td>
			</form>
		</tr>
		<?php
		}
		?>
		</table>
</div>

<?php

}
?>