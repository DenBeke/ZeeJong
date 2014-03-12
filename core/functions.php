<?php
/*
General functions

Created: February 2014
*/


require_once(dirname(__FILE__) . '/database.php');


function getObject($pageName) {
	
	global $database;
	
	if($pageName == 'home') {
		return NULL;
	}
	elseif ($pageName == 'competition') {
		if(isset($_GET['competition'])) {
			$competitionId = intval(htmlspecialchars($_GET['competition']));
			return $database->getCompetitionById($competitionId);
		}
	}
	elseif ($pageName == 'tournament') {
		if(isset($_GET['tournament'])) {
			$tournamentId = intval(htmlspecialchars($_GET['tournament']));
			return $database->getTournamentById($tournamentId);
		}
	}
	elseif ($pageName == 'match') {
		if(isset($_GET['match'])) {
			$matchId = intval(htmlspecialchars($_GET['match']));
			return $database->getMatchById($matchId);
		}
	}
	elseif ($pageName == 'player') {
		if(isset($_GET['player'])) {
			$playerId = intval(htmlspecialchars($_GET['player']));
			return $database->getPlayerById($playerId);
		}
	}
	elseif ($pageName == 'coach') {
		if(isset($_GET['coach'])) {
			$coachId = intval(htmlspecialchars($_GET['coach']));
			return $database->getCoachById($coachId);
		}
	}
	elseif ($pageName == 'referee') {
		if(isset($_GET['referee'])) {
			$refereeId = intval(htmlspecialchars($_GET['referee']));
			return $database->getRefereeById($refereeId);
		}
	}
}


/**
Hash a password with a given salt
*/
function hashPassword($password,$salt) {
	return hash('sha256', $password . $salt);
}




/**
Check if logged in
*/
function loggedIn() {
	//Check for active session
	global $database;
	
	if( isset($_SESSION['userID']) and $database->doesUserExist($_SESSION['userID'])) {
		return true;
	}
	else {
		return false;
	}
}



function user() {

	//Check for active session
	global $database;
	
	if( isset($_SESSION['userID']) and $database->doesUserExist($_SESSION['userID'])) {
		$user = new User($_SESSION['userID']);
		return $user;
	}
	else {
		throw new exception('User is not logged in, or the user does not exist');
	}
}

function requireMinCount($array, $min) {
	if(count($array) < $min) {
		throw new exception('Array does not have the required minimum length of ' . $min);
	}
}

function requireMaxCount($array, $max) {
	if(count($array) > $max) {
		throw new exception('Array length is bigger than the maximum ' . $max);
	}
}

function requireEqCount($array, $eq) {
	if(count($array) != $eq) {
		throw new exception('Array length is not ' . $eq);
	}
}




function getLatestYear() {
	
	$months = array();
	
	for($i = 0; $i < 13; $i++) {
	
		$month = date("Y-m-1", strtotime("-$i months"));
		$months[] = array(
		
			'name' => date("M Y", strtotime("-$i months")),
			'timestamp' => strtotime(date("Y-m-1", strtotime("-$i months")))
		
		);
		
	}
	
	return array_reverse($months);
	
			
}





function generateChart($input, $id = 0, $type = 'Bar') {
	
	$datasets = array();	
	$legends = array();
	
	foreach ($input as $legend => $dataset) {
	
		$labels = '';
		$data = '';
		$legends[] = $legend;
	
	
		foreach($dataset as $label => $number) {
			
			
			if($type == 'Line' and false) {
				$labels = $labels . '," "';
			}
			else {
				$labels = $labels . ',"' . $label . '"';
			}
			
			
			$data = $data . ',' . $number;
			
		}
		
		$labels = substr($labels, 1);
		$data = substr($data, 1);
		
		$datasets[] = [$labels,$data];
		
	}

	$id = md5(serialize($input).$id);
	
	
	
	
	$colors = array(
		'220,220,220',
		'151,187,205'
	);
	
	
	?>
	
	<canvas id="<?php echo $id; ?>"></canvas>
	
		<div class="legend">
	
		<?php
		$count = 0;
		foreach ($legends as $legend) {
			?>
			<span class="legend-item" style="background-color: rgba(<?php echo $colors[$count]; ?>,0.5); border-color: rgba(<?php echo $colors[$count]; ?>,1);"></span><?php echo $legend; ?>
			<?php
		$count++;
		}
		
		?>
		</div>
	
	
		<script>
	
			var data = {
				labels : [<?php echo $labels;?>],
				
				datasets : [
				
				<?php
				$count = 0;
				foreach($datasets as $data) {
				?>
					{
						fillColor : "rgba(<?php echo $colors[$count]; ?>,0.5)",
						strokeColor : "rgba(<?php echo $colors[$count]; ?>,1)",
						pointColor : "rgba(<?php echo $colors[$count]; ?>,1)",
						pointStrokeColor : "#fff",
						data : [<?php echo $data[1];?>]
					},
					
				<?php 
					$count++;
				} 
				?>
				]
			};
			
			var options = {
					animation : false,
					pointDot : false,
			}
	
			var ctx = document.getElementById("<?php echo $id; ?>").getContext("2d");
			
	
	
	
	
		var width = $('#<?php echo $id; ?>').parent().width();
		$('#<?php echo $id; ?>').attr("width",width);
		var myNewChart = new Chart(ctx).<?php echo $type; ?>(data, options);
		window.onresize = function(event){
			var width = $('#<?php echo $id; ?>').parent().width();
			$('#<?php echo $id; ?>').attr("width",width);
			var myNewChart = new Chart(ctx).<?php echo $type; ?>(data, options);
		};
	
	
		</script>
	
	
	
	<?php
}





function getAllMonths($begin, $end = NULL) {
	
	
	if($end == NULL) {
		$end = time();
	}
	
	$month = strtotime(date('Y-m-1',strtotime("-1 month", $begin)));
	$months = array();
	
	while($month <= $end) {
		 $months[date('M Y', strtotime("+1 month", $month))] = $month = strtotime(date('Y-m-1',strtotime("+1 month", $month)));
	}
	
	return $months;
}




?>
