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
        <p>ZeeJong is the ultimate betting website! With over 1000 players in the database, 500 matches and 10 competitions, ZeeJong covers most of the matches in the world of soccer!</p>
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
          
          <p><a class="btn btn-default" href="#" role="button">View details »</a></p>
        </div>
        <div class="col-md-4">
          <h2>Players</h2>
         
         
         <table class="table table-striped">
         
         	<tr>
         		<th colspan="2">Name</th>
         		<th>Goals</th>
         	</tr>
         
             <tr>
             	<td>Luis</td>
             	<td>Suarez</td>
             	<td>23</td>
             </tr>
             
             <tr>
             	<td>Cristiano</td>
             	<td>Ronaldo</td>
             	<td>22</td>
             </tr>
             
             <tr>
             	<td>Zlatan</td>
             	<td>Ibrahimovic</td>
             	<td>22</td>
             </tr>
             
             <tr>
             	<td>Alfreð</td>
             	<td>Finnbogason</td>
             	<td>21</td>
             </tr>
             
         </table>
         
         
          <p><a class="btn btn-default" href="#" role="button">View details »</a></p>
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
          
          
          <p><a class="btn btn-default" href="#" role="button">View details »</a></p>
        </div>
      </div>

      
</div>