<?php
/*
 Template part for the accept-invites page

 Created: April 2014
 */
?>
<div class="container">
	<h2>You have been invited to:</h2>
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
	<table class="table table-striped">
		<tr>
			<th>From</th>
			<th>Group</th>
			<th>Accept</th>
		</tr>

		<?php
		global $database;
		$invites = $this->getInvites();
		foreach($invites as $inviteId) {
		$membership = new GroupMembership($inviteId,$database);
		?>
		<tr>
			<form id="acceptInvite" class="form-horizontal" role="form" method="post" action="<?php echo SITE_URL ?>invites">			
			<td><?php echo $membership->getSender() ?></td>
			<td><?php echo $membership->getGroupName() ?></td>
			<input type="hidden" name="inviteId" id="inviteId" value=<?php echo $inviteId?> />
			<td>
				<button type="submit" class="btn btn-success" >Accept</button>
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