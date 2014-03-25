<?php
/*
Template part for news feed page

Created: February 2014
*/
?>

<div class="container">

	<h2 id="title-news">Latest News</h2>
	
	
	<?php foreach($this->feeds[0]['items'] as $item): ?>
		<div class="chunk">
	
	
			<div class="panel panel-default">
			
				<div class="panel-heading">
					<h3 class="panel-title">
						<?php if ($item->get_permalink()) echo '<a href="' . $item->get_permalink() . '">'; echo $item->get_title(); if ($item->get_permalink()) echo '</a>'; ?>
					</h3>
				</div>
				
				<div class="panel-body">
					<?php echo $item->get_content(); ?>
				</div>
				
				<div class="panel-footer rss-footer">
					<?php echo $item->get_date('j M Y, g:i a'); ?>
				</div>
			
			
			</div>
	
	
		</div>
	
	<!-- Stop looping through each item once we've gone through all of them. -->
	<?php endforeach; ?>
	
	
</div>