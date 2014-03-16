<?php
/*
Template part for home page

Created: February 2014
*/
?>


<?php if(!loggedIn()) { ?>

<div class="jumbotron">
      <div class="container">
        <h1>ZeeJong</h1>
        <p>ZeeJong is the ultimate betting website! With over 25000 players, 5000 matches and 7 competitions in the database, ZeeJong covers most of the matches in the world of soccer!</p>
        <p><a class="btn btn-primary btn-lg" role="button" href="<?php echo SITE_URL ?>register">Register now »</a></p>
      </div>
</div>
    
    
<?php } ?>
    
<div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-4">
          <h2>Upcoming Events</h2>
          
          <table class="table table-striped matches">
          
          
          	<tr>
          		<th>Team A</th>
          		<th>Date</th>
          		<th>Team B</th>
          	</tr>
          
          
          	<?php
          	
          	foreach ($this->events as $match) {
				?>
				<tr>
						<td><?php echo $match->getTeamA()->getName(); ?></td>
						
						<td><a href="<?php echo SITE_URL . 'match/' . $match->getId(0); ?>"><span class="badge"><?php try { echo $match->getScore(); } catch(exception $e) { echo date('d-m-Y', $match->getDate()); } ?></span></a></td>
						
						<td><?php echo $match->getTeamB()->getName(); ?></td>
				</tr>
				<?php
			}
          	
          	?>
	          
          </table>
          
          <p><a class="btn btn-default" href="<?php echo SITE_URL . 'events/'; ?>" role="button">More Events »</a></p>
        </div>
        <div class="col-md-4">
          <h2>Players</h2>
         
         
         <table class="table table-striped">
         
         	<tr>
         		<th>Name</th>
         		<th class="center">Matches</th>
         		<th class="center">Goals</th>
         	</tr>
         	
         	
         	<?php foreach($this->players as $player) { ?>
         	
         	<tr>
	         	
	         	<td><a href="<?php echo SITE_URL . 'player/' . $player->getId(); ?>"><?php echo $player->getName(); ?></a></td>
	         	
	         	<td class="center"><span class="badge"><?php echo $player->getTotalNumberOfMatches(); ?></span></td>
	         	
	         	<td class="center"><span class="badge"><?php echo $player->getTotalNumberOfGoals(); ?></span></td>
	         	
	        </tr>
         	
         	
         	<?php } ?>
             
         </table>
         
         
          <p><a class="btn btn-default" href="<?php echo SITE_URL . 'player/'; ?>" role="button">More players »</a></p>
       </div>
        <div class="col-md-4">
          <h2>Leagues</h2>
          
          
          <table class="table table-striped">
	          
	        <tr>
	          	<th>Leagues</th>
	        </tr>  
	          
	        <?php foreach($database->getAllCompetitions() as $competition) { ?>
		    <tr>
		    		<td><a href="<?php echo SITE_URL . 'competition/' . $competition->getId(); ?>"><?php echo $competition->getName(); ?></a></td>
		    	</tr>
          	<?php } ?>
          
          

              
          </table>
          
        </div>
      </div>

      
</div>