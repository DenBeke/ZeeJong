<?php
/*
Template part for player page

Created: February 2014
*/
?>
<div class="container">

	<h2 id="title-player"><?php echo $this->player->getName(); ?></h2>
	
	
	<ul class="list-group player-meta">
	
	  <li class="list-group-item">
	  	First name: <?php echo $this->player->getFirstName(); ?>
	  </li>
	  
	  <li class="list-group-item">
	  	Last name: <?php echo $this->player->getLastName(); ?>
	  </li>
	  
	  <li class="list-group-item">
	  	Nationality: <?php echo $this->player->getCountry()->getName(); ?>
	  </li>
	
	  <li class="list-group-item">
	    <span class="badge"><?php echo $this->player->getTotalNumberOfGoals(); ?></span>
	    Goals
	  </li>
	  
	  <li class="list-group-item">
	    <span class="badge"><?php echo $this->player->getTotalNumberOfCards(); ?></span>
	    Yellow Cards
	  </li>
	  
	  <li class="list-group-item">
	    <span class="badge"><?php echo $this->player->getTotalNumberOfMatches(); ?></span>
	    Matches Played
	  </li>

	  <li class="list-group-item">
	    <span class="badge"><?php echo $this->player->getTotalNumberOfWonMatches(); ?></span>
	    Matches Won
	  </li>	  
	</ul>
	


	<?php
	
	function getLatestYear() {
		
		$months = array();
		
		for($i = 0; $i < 13; $i++) {
		
			$month = date("Y-m-1", strtotime("-$i months"));
			$months[] = array(
			
				'name' => date("M", strtotime("-$i months")),
				'timestamp' => strtotime(date("Y-m-1", strtotime("-$i months")))
			
			);
			
		}
		
		return array_reverse($months);
		
				
	}
	
	$year = getLatestYear();
	$labels = '';
	$data = '';
	
	for($i = 0; $i < sizeof($year)-1; $i++) {
		
		$labels = $labels . ',"' . $year[$i]['name'] . '"';
		$data = $data . ',' . $database->getTotalNumberOfPlayerMatchesInterval($this->player->getId(), $year[$i]['timestamp'], $year[$i+1]['timestamp']);
		
	}
	
	$labels = substr($labels, 1);
	$data = substr($data, 1);
	
	
	?>
	
	
	
	<h3>Matches</h3>
	
	<canvas id="myChart" width="400" height="200"></canvas>
	
	<script>
		
		var data = {
			labels : [<?php echo $labels;?>],
			datasets : [
				{
					fillColor : "rgba(151,187,205,0.5)",
					strokeColor : "rgba(151,187,205,1)",
					pointColor : "rgba(151,187,205,1)",
					pointStrokeColor : "#fff",
					data : [<?php echo $data;?>]
				}
			]
		};
		
		var ctx = document.getElementById("myChart").getContext("2d");
		var myNewChart = new Chart(ctx).Line(data, {
animation : false});
	</script>
	


</div>