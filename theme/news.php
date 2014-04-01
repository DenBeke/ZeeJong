<?php
/*
Template part for news feed page

Created: February 2014
*/
?>

<div class="container">

	<h2 id="title-news">Latest News</h2>
	
	
	<ul class="nav nav-tabs nav-news">
	  <?php $count = 0; ?>
	  <?php foreach($this->feeds as $feed) { ?>
	  <!-- <li class="active"><a href="#">Home</a></li>
	  <li><a href="#">Profile</a></li> -->
	  <li class="news-button"><a href="#" data-json="<?php echo SITE_URL . 'core/ajax/news.php?feed=' . $count; ?>"><?php echo $feed['title']; ?></a></li>
	  <?php $count++; ?>
	  <?php } ?>
	  
	</ul>
	
	
	<div id="news-feed">
		<!-- Will be filled by ajax calls -->
	</div>
	
	
</div>