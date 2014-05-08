<?php
/*
General functions

Created: February 2014
*/


require_once(dirname(__FILE__) . '/database.php');



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
	?>

	<div id="<?php echo $id; ?>" style="width: 100%; height: 300px;">

	</div>

	<script>
		var series = [];
		var yValues = [];

		<?php
			$smallestX = 0;
			$smallestY = 0;
			$largestX = 0;
			$largestY = 0;
			foreach($input as $label => $data) {
		?>
				var serie = {};
				serie.name = '<?php echo $label; ?>';

				serie.data = [
					<?php
						$i = 0;
						foreach($data as $x => $y) {
							echo "[$x * 1000,$y]";

							if(next($data) !== false) {
								echo ',';
							}

							$i++;
						}
					?>
				];

				series.push(serie);

		<?php
			}
		?>
	 
	$('#<?php echo $id; ?>').highcharts({
		chart: {
			type: 'column',
			zoomType: 'x',
		},

		title: {
			text: '',
		},

		xAxis: {
			type: 'datetime',
	
		},

		yAxis: {
			min: 0,
		},

		plotOptions: {
			column: {
				pointPadding: 0.2,
				borderWidth: 0,
			},
		},

		series: series,
	});

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




function generateLikeButton($url) {
	?>
	
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/nl_NL/sdk.js#xfbml=1&version=v2.0";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	
	
	<div class="fb-like" data-href="<?php echo $url; ?>" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
	
	<?php
	
}



function generateTweetButton() {
	?>
	
	<a href="https://twitter.com/share" class="twitter-share-button" data-via="twitterapi" data-lang="en">Tweet</a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	
	<?php
}






?>
