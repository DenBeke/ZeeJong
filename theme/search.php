<?php
/*
Template part for search page

Created: May 2014
*/
?>

<script>
var players = [];

function addPlayers() {
	var html = '';
	for(i in players) {
		html += '<li class="players-result">';
		html += '<a href="<?php echo SITE_URL; ?>player/' + players[i].id + '">';
		html += players[i].firstName + ' ' + players[i].lastName;
		html += '</a>';
		html += '</li>';
	}

	$('#search-results').html(html);
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

$(document).ready(function(){
	$('#search-form :checkbox').change(function(e) {
		if(this.checked) {
			if(this.value == 'players') {
				addPlayers();
			}
		} else {
			$('.' + this.value + '-result').remove();
		}
	});

	$('#submit').click(function(e) {
		$('#search-form :checkbox').each(function(index) {
			if(this.checked) {
				if(this.value == 'players') {
					loadPlayers($('#term').val());
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
