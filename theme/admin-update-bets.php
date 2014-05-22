<?php
include (dirname(__FILE__) . '/admin.php');
$this -> update();
?>
<div class="container">
    
    <p></p>
    
<div class=col-md-12>
<div class="alert alert-success">
    Successfully processed bets
</div>

<table class="table table-striped">
    <tr><td>Total bets processed</td> <td><?php echo $this->getBetsProcessed() ?></td></tr>
    <tr><td>Money distributed</td> <td>€ <?php echo $this->getMoneyDistributed() ?></td></tr>
    <tr><td>Total parameters bet on</td><td><?php echo $this->getParametersBetOn() ?></td></tr>
</table>
</div>
</div>