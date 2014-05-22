<?php
include (dirname(__FILE__) . '/admin.php');
$this -> update();
?>
<div class="container">
<div class=col-md-10>
<div class="alert alert-success">
	<h2>Successfully processed bets</h2>
</div>

<table class="table table-striped">
	<tr><td>Total bets processed</td> <td><?php echo $this->getBetsProcessed() ?></td></tr>
	<tr><td>Money distributed</td> <td>€ <?php echo $this->getMoneyDistributed() ?></td></tr>
	<tr><td>Total parameters bet on</td><td><?php echo $this->getParametersBetOn() ?></td></tr>
</table>
</div>
</div>