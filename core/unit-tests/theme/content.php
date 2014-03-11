<?php
/*
Template file for page content

Author: Mathias Beke
Url: http://denbeke.be
Date: March 2014
*/
?>


<h2>Running Unit Tests</h2>


<div id="total-tests" <?php if($scenario->numberOfFailures != 0) echo 'class="failed"'; ?>>
	
	<p><?php echo $scenario->numberOfTest . ' tests in ' .  sizeof($scenario->tests) . ' test cases'; ?></p>
	
	<?php
	
	if($scenario->numberOfFailures == 0) {
		?>
		<p>All tests passed</p>
		<?php
	}
	else {
		?>
		<p><?php echo $scenario->numberOfFailures; ?> failures</p>
		<?php
	}
	
	?>
	
</div>


<?php

foreach ($scenario->tests as $case) {
	
	?>
	
	<h3><?php echo $case->name; ?></h3>
	
	
	<div class="table-wrapper">
	
		<table>
			
			<tbody>
				
				
				<?php
				
				foreach ($case->sections as $section) {
				
				?>
				
				
				<tr <?php if(!$section->success) echo 'class="failed"'; ?>>
					
					<td>
						<?php echo $section->name; ?>
						
						
						
						<ul class="failed-tests">
							
							<?php 
							
							foreach ($section->tests as $test) {
								if($test['result'] == false) {
									?>
									<li>
										<?php if(isset($test['type']) and $test['type'] == 'unexpected') { ?>
										<p>Unexpected Exception</p>
										<?php } 
										else {
										?>
										<p>Failure on line <?php echo $test['line']; ?></p>
										<?php } ?>
										<code><?php echo $test['failed_line']; ?></code>
									</li>
									<?php
								}
							}
							
							?>
							
						</ul>
						
						
					</td>
					
					
					<td>
						
						<?php
						
						if($section->success) {
							echo 'OK';
						}
						else {
							echo 'ERROR';
							
						}
						
						?>
						
					</td>
					
				</tr>
				
				
				
				<?php } ?>
				
				
			</tbody>
			
		</table>	
		
	</div>
	
	<?php
	
}

?>