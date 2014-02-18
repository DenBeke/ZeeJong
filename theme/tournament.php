<?php
/*
Template part for tournament page

Created: February 2014
*/
?>
<h2 id="title-tournament"><?php echo $object->getName(); ?></h2>


<ul>

	<?php
	foreach($object->getMatches() as $match) { 
	?>

	<li>
		<a href="<?php echo SITE_URL . '?page=tournament&tournament=' . $match->getId(); ?>"><?php echo $match->getName(); ?></a>
	</li>



	<?php
	} //end foreach
	?>

</ul>