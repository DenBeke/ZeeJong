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
          
          <table class="table table-striped">
          
          	<tr>
          		<th colspan="2">Country</th>
          		<th>Date</th>
          	</tr>
          
	          <tr>
	          	<td>Belgium</td>
	          	<td>Scotland</td>
	          	<td>13 February</td>
	          </tr>
	          
	          <tr>
	          	<td>France</td>
	          	<td>Germany</td>
	          	<td>14 March</td>
	          </tr>
	          
	          <tr>
	          	<td>Anderlecht</td>
	          	<td>AA Gent</td>
	          	<td>23 March</td>
	          </tr>
	          
	          <tr>
	          	<td>Club Brugge</td>
	          	<td>Standard Liège</td>
	          	<td>23 April</td>
	          </tr>
	          
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