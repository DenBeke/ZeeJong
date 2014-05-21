<?php
include (dirname(__FILE__) . '/admin.php');
$this->update();
?>
<div class="container">
<div class="alert alert-success">
	<h2>Successfully processed bets</h2>
	<h3>Total bets processed: <?php echo $this->getBetsProcessed() ?></h3>
	<h3>Money distributed: <?php echo $this->getMoneyDistributed() ?></h3>
	<h3>Total parameters bet on: <?php echo $this->getParametersBetOn() ?></h3>
</div>
</div>