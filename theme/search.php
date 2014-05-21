<?php
/*
Template part for search page

Created: May 2014
*/
?>

<script>
var players = [];
var coaches = [];
var referees = [];
var teams = [];

function clear() {
	players = [];
	coaches = [];
	referees = [];
	teams = [];
	$('#search-results').html('');
}

function addPlayers() {
	var html = '';
	for(i in players) {
		html += '<li class="players-result">';
		html += '<a href="<?php echo SITE_URL; ?>player/' + players[i].id + '">';
		html += players[i].firstName + ' ' + players[i].lastName;
		html += '</a>';
		html += '</li>';
	}

	$('#search-results').append(html);
}

function addCoaches() {
	var html = '';
	for(i in coaches) {
		html += '<li class="coaches-result">';
		html += '<a href="<?php echo SITE_URL; ?>coach/' + coaches[i].id + '">';
		html += coaches[i].firstName + ' ' + coaches[i].lastName;
		html += '</a>';
		html += '</li>';
	}

	$('#search-results').append(html);
}

function addReferees() {
	var html = '';
	for(i in referees) {
		html += '<li class="referees-result">';
		html += '<a href="<?php echo SITE_URL; ?>referee/' + referees[i].id + '">';
		html += referees[i].firstName + ' ' + referees[i].lastName;
		html += '</a>';
		html += '</li>';
	}

	$('#search-results').append(html);
}

function addTeams() {
	var html = '';
	for(i in teams) {
		html += '<li class="teams-result">';
		html += '<a href="<?php echo SITE_URL; ?>team/' + teams[i].id + '">';
		html += teams[i].name;
		html += '</a>';
		html += '</li>';
	}

	$('#search-results').append(html);
}

function loadPlayers(term) {
	$('#loader').fadeIn(100, function() {
		$.ajax({
			dataType: "json",
			url: '<?php echo SITE_URL; ?>core/ajax/player.php',
			data: {'search': term},
			success: function(data) {
				$('#loader').fadeOut(100, function() {
					players = data;
					addPlayers();
				});
			}
		});
	});
}

function loadCoaches(term) {
	$('#loader').fadeIn(100, function() {
		$.ajax({
			dataType: "json",
			url: '<?php echo SITE_URL; ?>core/ajax/coach.php',
			data: {'search': term},
			success: function(data) {
				$('#loader').fadeOut(100, function() {
					coaches = data;
					addCoaches();
				});
			}
		});
	});
}

function loadReferees(term) {
	$('#loader').fadeIn(100, function() {
		$.ajax({
			dataType: "json",
			url: '<?php echo SITE_URL; ?>core/ajax/referee.php',
			data: {'search': term},
			success: function(data) {
				$('#loader').fadeOut(100, function() {
					referees = data;
					addReferees();
				});
			}
		});
	});
}

function loadTeams(term) {
	$('#loader').fadeIn(100, function() {
		$.ajax({
			dataType: "json",
			url: '<?php echo SITE_URL; ?>core/ajax/team.php',
			data: {'name': term},
			success: function(data) {
				$('#loader').fadeOut(100, function() {
					teams = data;
					addTeams();
				});
			}
		});
	});
}

$(document).ready(function(){
	$('#search-form :checkbox').change(function(e) {
		if(this.checked) {
			if(this.value == 'players') {
				addPlayers();
			} else if(this.value == 'coaches') {
				addCoaches();
			} else if(this.value == 'referees') {
				addReferees();
			} else if(this.value == 'teams') {
				addTeams();
			}
		} else {
			$('.' + this.value + '-result').remove();
		}
	});

	$('#submit').click(function(e) {
		clear();

		$('#search-form :checkbox').each(function(index) {
			if(this.checked) {
				if(this.value == 'players') {
					loadPlayers($('#term').val());
				} else if(this.value == 'coaches') {
					loadCoaches($('#term').val());
				} else if(this.value == 'referees') {
					loadReferees($('#term').val());
				} else if(this.value == 'teams') {
					loadTeams($('#term').val());
				}
			}
		});

		return false;
	});
});
</script>

<div class="container">

	<h2 id="title-events">Search</h2>

	<div id="loader" class="loader" style="position: fixed; top: 50%; left: 50%; display: none;"></div>

	<form id="search-form" role="form" class="form-horizontal">
		<div class="form-group">
			<label for="term" class="control-label col-sm-2">Terms</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="term" placeholder="Enter search terms">
			</div>
			<div class="col-sm-2">
				<button type="submit" class="btn btn-default" id="submit">search</button>
			</div>

			<div class="col-sm-10 col-sm-offset-2">
				<div class="checkbox">
					<label>
						<input value="players" type="checkbox" checked> Players
					</label>
				</div>
				<div class="checkbox">
					<label>
						<input value="coaches" type="checkbox" checked> Coaches
					</label>
				</div>
				<div class="checkbox">
					<label>
						<input value="referees" type="checkbox" checked> Referees
					</label>
				</div>
				<div class="checkbox">
					<label>
						<input value="teams" type="checkbox" checked> Teams
					</label>
				</div>
			</div>

		</div>
	</form>


	<div class="col-sm-10 col-sm-offset-2">
		<ul id="search-results">

		</ul>
	</div>

</div>
