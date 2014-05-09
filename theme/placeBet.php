<?php
/*
 Place a bet template

 Created March 2014
 */
 ?>
	<div class="container">

		<div class="col-md-12">
			<h1>Place a bet</h1>
		</div>
		
		
		
		<?php
		if(!loggedIn()){
		// User is not logged in
	
		?>
		<div class="alert alert-danger">
			<strong>You are not logged in.</strong>
		</div>
		<?php
		}
		if($this->stop()){
			?>
		<div class="alert alert-danger">
			<strong>Either the match does not exist or has already been played.</strong>
		</div>
		<?php
		}

		else{
		if(strlen($this->getErrorMessage())>0){
		// there were errors, let's display them
		?>
		<div class="alert alert-danger">
			<strong> <?php
			echo nl2br($this -> getErrorMessage());
			?></strong>
		</div>
	
		<?php
		}
		if(strlen($this->getSuccessMessage())>0){
		// at least one thing succeeded, let's display what
		?>
		<div class="alert alert-success">
			<strong> <?php
			echo nl2br($this -> getSuccessMessage());
			?></strong>
		</div>
		
	<?php
	}
	else{
	// Display 'add bet' form
?>
	
	
	<div class="col-md-6">
	
		<div class="well">
			
			<SCRIPT LANGUAGE="JavaScript">
				<!--
				function check1() {

					if (document.betForm.checkScore1.checked) {
						document.betForm.score1.disabled = false;
					} else {
						document.betForm.score1.disabled = true;
					}
				}

				function check2() {

					if (document.betForm.checkScore2.checked) {
						document.betForm.score2.disabled = false;
					} else {
						document.betForm.score2.disabled = true;
					}
				}

				function check3() {

					if (document.betForm.checkFirstGoal.checked) {
						document.betForm.firstGoal.disabled = false;
					} else {
						document.betForm.firstGoal.disabled = true;
					}
				}

				function check4() {

					if (document.betForm.checkRedCards.checked) {
						document.betForm.redCards.disabled = false;
					} else {
						document.betForm.redCards.disabled = true;
					}
				}

				function check5() {

					if (document.betForm.checkYellowCards.checked) {
						document.betForm.yellowCards.disabled = false;
					} else {
						document.betForm.yellowCards.disabled = true;
					}
				}

				//-->
			</SCRIPT>
			<form id="changeSettings" class="form-horizontal" role="form" method="post" name="betForm" action="<?php echo SITE_URL ?>place-bet/<?php echo $this->getMatchId()?>">
				
				<input type="hidden" name="matchId" id="matchId" value=<?php echo $this->getMatchId()?> />
				
				<b>I want to bet on:</b>
				<table style="width:200px">
					<tr>
  						<td>Score 1</td>
					  	<td><input type="checkbox" onclick="check1()" name="checkScore1" value="ON"></td>
					</tr>
					<tr>
  						<td>Score 2</td>
					  	<td><input type="checkbox" onclick="check2()" name="checkScore2" value="ON"></td>
					</tr>
					<tr>
  						<td>Player that makes first goal</td>
					  	<td><input type="checkbox" onclick="check3()" name="checkFirstGoal" value="ON"></td>
					</tr>
					<tr>
  						<td>Red cards</td>
					  	<td><input type="checkbox" onclick="check4()" name="checkRedCards" value="ON"></td>
					</tr>
					<tr>
  						<td>Yellow cards</td>
					  	<td><input type="checkbox" onclick="check5()" name="checkYellowCards" value="ON"></td>
					</tr>

				</table> 
				<div class="form-group">
					<label class="control-label col-sm-4">Score <?php echo $this->getMatch()->getTeamA()->getName() ?></label>
					<div class="controls col-sm-8">
						
						<div class="input-group">
							<span class="add-on input-group-addon"> <span class="glyphicon glyphicon-arrow-right"></span> </span>
							<input type="number" disabled class="form-control input-xlarge" id="score1" name="score1" placeholder="">
							
						</div>
						
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-4">Score <?php $this->getMatch()->getTeamB()->getName() ?></label>
					<div class="controls col-sm-8">
						<div class="input-group">
							<span class="add-on input-group-addon"> <span class="glyphicon glyphicon-arrow-right"></span> </span>
							<input type="number" disabled class="form-control input-xlarge" id="score2" name="score2" placeholder="">
						</div>
					</div>
				</div>
			
				<div class="form-group">
				<label class="control-label col-sm-4">Player that makes first goal</label>
				<div class="controls col-sm-8">
					<div class="input-group">
						<span class="add-on input-group-addon"> <span class="glyphicon glyphicon-user"></span> </span>
						<select class="form-control" name="firstGoal",id="firstGoal" disabled>
							<?php
	
							
							foreach($this->getPlayers() as $player){
								?>
									<option value="<?php echo $player->getId() ?>"><?php echo $player->getName() ?></option>
								<?php
								}

							?>
						</select>
					</div>
				</div>
			    </div>
				
				
				
				
				
				<div class="form-group">
					<label class="control-label col-sm-4">Red cards</label>
					<div class="controls col-sm-8">
						<div class="input-group">
							<span class="add-on input-group-addon"> <span class="glyphicon glyphicon-arrow-right"></span> </span>
							<input type="number" disabled class="form-control input-xlarge" id="redCards" name="redCards" placeholder="">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-4">Yellow cards</label>
					<div class="controls col-sm-8">
						<div class="input-group">
							<span class="add-on input-group-addon"> <span class="glyphicon glyphicon-arrow-right"></span> </span>
							<input type="number" disabled class="form-control input-xlarge" id="yellowCards" name="yellowCards" placeholder="">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-4">Amount of money</label>
					<div class="controls col-sm-8">
						<div class="input-group">
							<span class="add-on input-group-addon"> <span class="glyphicon glyphicon-euro"></span> </span>
							<input type="number" class="form-control input-xlarge" id="money" name="money" placeholder="">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-4"></label>
					<div class="controls col-sm-8">
						<button type="submit" class="btn btn-success" >
							Place
						</button>
	
					</div>
				</div>
			</form>
		</div>
	</div>
	
	
	<div class="col-md-6">
		
		
		<div class="panel panel-default">
		
			<div class="panel-heading">
				<h3 class="panel-title">Information</h3>
			</div>
			
			
			
			<div class="panel-body">
				
				
				<ul class="list-group">
					
					<li class="list-group-item">
						<?php  echo $this->getMatch() -> getTeamA() -> getName() . ' vs ' . $this->getMatch() -> getTeamB() -> getName();?>
					</li>
					
					<li class="list-group-item">
						Date: <?php echo date('d-m-Y', $this->getMatch() -> getDate()); ?>
					</li>
					
					<li class="list-group-item">
						Prognose: 
						<?php $prognose = $this->getMatch()->getPrognose();
						echo $prognose[0] . '-' . $prognose[1]?>
					</li>
					
				</ul>
				
			</div>
		
		
		</div>
		
	</div>

	<?php
	}
	}
?>

</div>