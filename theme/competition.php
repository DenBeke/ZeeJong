<?php
/*
Template part for error page

Created: February 2014
*/
?>
<h2 id="title-competition"><?php echo $object->getName(); ?></h2>


<ul>

	<?php
	foreach($object->getMatches() as $tournament) { 
	?>
	
	<li>
		<a href="<?php echo SITE_URL . '?page=match&match=' . $tournament->getId(); ?>"><?php echo $tournament->getName(); ?></a>
	</li>
		
	
	
	<?php
	} //end foreach
	?>

</ul>