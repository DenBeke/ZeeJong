<?php
/*
Template part for error page

Created: February 2014
*/
?>

<div class="container">
	

	<h2 id="title-competition"><?php echo $this->competition->getName(); ?></h2>
	
	
	<ul>
	
		<?php
		foreach($this->competition->getTournaments() as $tournament) { 
		?>
		
		<li>
			<a href="<?php echo SITE_URL . 'tournament/' . $tournament->getId(); ?>"><?php echo $tournament->getName(); ?></a>
		</li>
			
		
		
		<?php
		} //end foreach
		?>
	
	</ul>


</div>