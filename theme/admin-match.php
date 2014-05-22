<?php
/*
Template part for match page

Created: February 2014
*/
?>

<?php include(dirname(__FILE__) . '/admin.php');

if(isAdmin()){
?>

<script>
    function setTeamCoach(teamId) {
        $('#selected-team-coach').val(teamId);
    }


    function searchCoaches() {
        $.ajax({
            dataType: "json",
            url: '<?php echo SITE_URL; ?>core/ajax/coach.php',
            data: {'search': $('#coach-name').val()},
            success: function(data) {
                var html = '';
                for(var i in data) {
                    html += '<option value="' + data[i].id + '">';
                    html += data[i].firstName + ' ' + data[i].lastName;
                    html += '</option>';
                }

                $('#coach-list').html(html);
            }
        });
    }

    function searchReferees() {
        $.ajax({
            dataType: "json",
            url: '<?php echo SITE_URL; ?>core/ajax/referee.php',
            data: {'search': $('#referee-name').val()},
            success: function(data) {
                var html = '';
                for(var i in data) {
                    html += '<option value="' + data[i].id + '">';
                    html += data[i].firstName + ' ' + data[i].lastName;
                    html += '</option>';
                }

                $('#referee-list').html(html);
            }
        });
    }
</script>

<div class="container">

    <h2 id="title-match"><?php echo $this->match->getTeamA()->getName() ?> - <?php echo $this->match->getTeamB()->getName() ?></h2>
<a href="<?php echo SITE_URL . 'admin/match/' . $this->match->getId() . '/delete'; ?>" class="btn-xs btn btn-danger title-btn">Delete</a>



    <div class="row">

        <!-- Information panel -->
        <div class="col-md-4">

            <div class="panel panel-default">


                <div class="panel-heading">

                    <h3 class="panel-title">Information <a class="btn-xs btn btn-primary lightbox-click" data-id="edit-meta">Edit</a></h3>


                </div>



                <div class="panel-body">

                    <ul class="list-group">

                        <li class="list-group-item">
                            Final score: <?php try { echo $this->match->getScore(); } catch(exception $e) {} ?>
                        </li>


                        <li class="list-group-item">
                            Competition: <a href="<?php echo SITE_URL . 'competition/' . $this->match->getTournament()->getCompetition()->getId(); ?>">
                                <?php echo $this->match->getTournament()->getCompetition()->getName(); ?></a>
                        </li>

                        <li class="list-group-item">Date: <?php echo date('d-m-Y', $this->match->getDate()); ?></li>

                        <li class="list-group-item">
                            <span class="badge"><?php echo $this->match->getTotalCards(); ?></span>
                            Cards
                        </li>

                        <li class="list-group-item">
                            Referee:
                            <?php if($referee = $this->match->getReferee()) { ?>
                                <a href="<?php echo SITE_URL . 'referee/' . $this->match->getReferee()->getId(); ?>"><?php echo $this->match->getReferee()->getName(); ?></a>
                            <?php } else { ?>
                                Not found
                            <?php } ?> <a class="btn-xs btn btn-primary lightbox-click" data-id="edit-referee">Edit</a>
                        </li>
                    </ul>


                </div>

            </div>



        </div>

        <div id="edit-referee" class="lightbox">
            <div class="lightbox-content">
                <h3>Edit referee</h3>
                <form class="form-horizontal" role="form" method="post" action="<?php echo SITE_URL . 'admin/match/' . $this->match->getId() . '/edit-referee/'; ?>">
                  <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="referee-name" placeholder="">
                    </div>
                    <div class="col-sm-4">
                      <button type="submit" onclick="searchReferees(); return false;" class="btn btn-default">Search</button>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Referees</label>
                    <div class="col-sm-10">
                        <select id="referee-list" class="form-control" name="refereeId">
                        </select>
                    </div>
                  </div>


                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-default">Update</button>
                    </div>
                  </div>
                </form>
            </div>
        </div>


        <!-- Goals -->


        <div class="col-md-8">

            <h4>Goals <a class="btn-xs btn btn-primary lightbox-click" data-id="add-goal">Add goal</a></h4>

            <table class="goals table table-striped">
                <?php foreach($this->goals as $goal) {

                    if($goal->getTeamId() == $this->match->getTeamA()->getId()) {
                        $gClass = 'team-a';
                    }
                    else {
                        $gClass = 'team-b';
                    }

                ?>
                <tr class="goal">

                    <td class="<?php echo $gClass; ?>">
                        <a href="<?php echo SITE_URL . 'player/' . $database->getPlayerById($goal->getPlayerId())->getId(); ?>"><?php echo $database->getPlayerById($goal->getPlayerId())->getName(); ?></a>
                        <span class="football-icon"></span>
                    </td>

                    <td><span class="badge"><?php echo $goal->getTime(); ?>'</span></td>

                    <td class="<?php echo $gClass; ?>">
                        <span class="football-icon"></span>
                        <a href="<?php echo SITE_URL . 'player/' . $database->getPlayerById($goal->getPlayerId())->getId(); ?>">
                            <?php echo $database->getPlayerById($goal->getPlayerId())->getName(); ?>
                        </a>
                    </td>


                    <td class="button"><a href="<?php echo SITE_URL . 'admin/match/' . $this->match->getId() . '/delete-goal/' . $goal->getId(); ?>" class="btn-xs btn btn-danger">Delete</a></td>





                </tr>

                <?php } ?>
            </table>

        </div>






        <!-- Cards -->

        <div class="col-md-8">

            <h4>Cards <a class="btn-xs btn btn-primary lightbox-click" data-id="add-card">Add card</a></h4>

            <table class="cards table table-striped">
                <?php foreach($this->cards as $card) {


                    if($card->getTeamId() == $this->match->getTeamA()->getId()) {
                        $gClass = 'team-a';
                    }
                    else {
                        $gClass = 'team-b';
                    }



                    if($card->getColor() == 1) {
                        $color = 'yellow';
                    }
                    else if($card->getColor() == 2) {
                        $color = 'red';
                    }
                    else {
                        $color = 'yellow-red';
                    }

                ?>
                <tr class="goal">

                    <td class="<?php echo $gClass; ?>">
                        <a href="<?php echo SITE_URL . 'player/' . $database->getPlayerById($card->getPlayerId())->getId(); ?>"><?php echo $database->getPlayerById($card->getPlayerId())->getName(); ?></a>
                        <span class="card-icon <?php echo $color; ?>"></span>
                    </td>

                    <td><span class="badge"><?php echo $card->getTime(); ?>'</span></td>

                    <td class="<?php echo $gClass; ?>">
                        <span class="card-icon <?php echo $color; ?>"></span>
                        <a href="<?php echo SITE_URL . 'player/' . $database->getPlayerById($card->getPlayerId())->getId(); ?>"><?php echo $database->getPlayerById($card->getPlayerId())->getName(); ?></a>
                    </td>

                    <td class="button"><a href="<?php echo SITE_URL . 'admin/match/' . $this->match->getId() . '/delete-card/' . $card->getId(); ?>" class="btn-xs btn btn-danger">Delete</a></td>

                </tr>

                <?php } ?>
            </table>

        </div>






    </div>




    <div class="row">


        <!-- Team A -->
        <div class="col-md-6">
            <div class="panel panel-default">


                <div class="panel-heading">

                    <h3 class="panel-title"><a href="<?php echo SITE_URL . 'team/' . $this->match->getTeamA()->getId(); ?>"><?php echo $this->match->getTeamA()->getName() ?></a> <a class="btn-xs btn btn-primary lightbox-click" data-id="add-player-team-a">Add player</a></h3>


                </div>



                <div class="panel-body">


                    <table class="table table-striped">

                        <tbody>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th></th>
                            </tr>


                            <?php
                            foreach($this->match->getPlayersTeamA() as $player) {
                            ?>
                             <tr>
                                <td><?php if($player->number > 0) echo $player->number; ?></td>
                                <td><a href="<?php echo SITE_URL . 'player/' . $player->getId(); ?>"><?php echo $player->getName(); ?></a></td>
                                <td><a href="<?php echo SITE_URL . 'admin/match/' . $this->match->getId() . '/delete-player/' . $player->getId(); ?>" class="btn-xs btn btn-danger">Delete</a></td>
                             </tr>

                             <?php
                             } //end foreach
                             ?>

                        </tbody>
                    </table>


                </div>



                <div class="panel-footer">
                        Coach:
                        <?php if($coach = $this->match->getTeamA()->getCoachForMatch($this->match->getId())) { ?>
                            <a href="<?php echo SITE_URL . 'coach/' . $coach->getId(); ?>"><?php echo $coach->getName(); ?></a>
                        <?php } else { ?>
                            Not found
                        <?php } ?> <a onclick="setTeamCoach(<?php echo $this->match->getTeamAId(); ?>);" class="btn-xs btn btn-primary lightbox-click" data-id="edit-coach">Edit</a>
                </div>


            </div>

        </div>





        <!-- Team B -->
        <div class="col-md-6">

            <div class="panel panel-default">


                <div class="panel-heading">

                    <h3 class="panel-title"><a href="<?php echo SITE_URL . 'team/' . $this->match->getTeamB()->getId(); ?>"><?php echo $this->match->getTeamB()->getName() ?></a> <a class="btn-xs btn btn-primary lightbox-click" data-id="add-player-team-b">Add player</a></h3>


                </div>



                <div class="panel-body">

                    <table class="table table-striped">

                        <tbody>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th></th>
                            </tr>


                            <?php
                            foreach($this->match->getPlayersTeamB() as $player) {
                            ?>

                             <tr>
                                <td><?php if($player->number > 0) echo $player->number; ?></td>
                                <td><a href="<?php echo SITE_URL . 'player/' . $player->getId(); ?>"><?php echo $player->getName(); ?></a></td>
                                <td><a href="<?php echo SITE_URL . 'admin/match/' . $this->match->getId() . '/delete-player/' . $player->getId(); ?>" class="btn-xs btn btn-danger">Delete</a></td>
                             </tr>

                             <?php
                             } //end foreach
                             ?>

                        </tbody>
                    </table>


                </div>



                <div class="panel-footer">
                        Coach:
                        <?php if($coach = $this->match->getTeamB()->getCoachForMatch($this->match->getId())) { ?>
                            <a href="<?php echo SITE_URL . 'coach/' . $coach->getId(); ?>"><?php echo $coach->getName(); ?></a>
                        <?php } else { ?>
                            Not found
                        <?php } ?> <a onclick="setTeamCoach(<?php echo $this->match->getTeamBId(); ?>);" class="btn-xs btn btn-primary lightbox-click" data-id="edit-coach">Edit</a>
                </div>

                <div id="edit-coach" class="lightbox">
                    <div class="lightbox-content">
                        <h3>Edit coach</h3>
                        <form class="form-horizontal" role="form" method="post" action="<?php echo SITE_URL . 'admin/match/' . $this->match->getId() . '/edit-coach/'; ?>">
                            <input type="hidden" id="selected-team-coach" name="teamId">
                          <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control" id="coach-name" placeholder="">
                            </div>
                            <div class="col-sm-4">
                              <button type="submit" onclick="searchCoaches(); return false;" class="btn btn-default">Search</button>
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Coaches</label>
                            <div class="col-sm-10">
                                <select id="coach-list" class="form-control" name="coachId">
                                </select>
                            </div>
                          </div>


                          <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                              <button type="submit" class="btn btn-default">Update</button>
                            </div>
                          </div>
                        </form>
                    </div>
                </div>


            </div>

        </div>

    </div>


    <p>
        <?php generateTweetButton() ?>
    </p>

    <p>
        <?php generateLikeButton(SITE_URL . 'match/' . $this->match->getId()); ?>
    </p>



</div>


<div id="edit-meta" class="lightbox">

    <div class="lightbox-content">


        <h3>Edit Match Meta</h3>



        <form class="form-horizontal" role="form" method="POST" action="<?php echo SITE_URL . 'admin/match/' . $this->match->getId() . '/edit-meta/'; ?>">
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Date</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="date" name="date" placeholder="02-11-1994" value="<?php echo date('d-m-Y', $this->match->getDate()); ?>">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Score</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="score" name="score" placeholder="2-1" value="<?php try { echo $this->match->getScore(); } catch(exception $e) {} ?>">
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-default">Update</button>
            </div>
          </div>
        </form>



    </div>

</div>





<div id="add-player-team-a" class="lightbox">

    <div class="lightbox-content">


        <h3>Add player: <?php echo $this->match->getTeamA()->getName(); ?></h3>



        <form class="form-horizontal" role="form" method="POST" action="<?php echo SITE_URL . 'admin/match/' . $this->match->getId() . '/add-player/'; ?>">


          <input name="team-id" type="hidden" value="<?php echo $this->match->getTeamA()->getID(); ?>">

          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Player</label>
            <div class="col-sm-10">

                <select name="player-list" class="form-control">
                  <?php
                  foreach($this->match->getTeamA()->getPlayers() as $player) {
                  ?>
                  <option value="<?php echo $player->getId(); ?>"><?php echo $player->getName(); ?></option>
                  <?php } ?>
                </select>


            </div>
          </div>


          <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Number</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="score" name="number" placeholder="1">
            </div>
          </div>


          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-default">Add</button>
            </div>
          </div>
        </form>



    </div>

</div>





<div id="add-player-team-b" class="lightbox">

    <div class="lightbox-content">


        <h3>Add player: <?php echo $this->match->getTeamB()->getName(); ?></h3>



        <form class="form-horizontal" role="form" method="POST" action="<?php echo SITE_URL . 'admin/match/' . $this->match->getId() . '/add-player/'; ?>">

            <input name="team-id" type="hidden" value="<?php echo $this->match->getTeamB()->getID(); ?>">

          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Player</label>
            <div class="col-sm-10">

                <select name="player-list" class="form-control">
                  <?php
                  foreach($this->match->getTeamB()->getPlayers() as $player) {
                  ?>
                  <option value="<?php echo $player->getId(); ?>"><?php echo $player->getName(); ?></option>
                  <?php } ?>
                </select>


            </div>
          </div>


          <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Number</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="score" name="number" placeholder="1">
            </div>
          </div>


          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-default">Add</button>
            </div>
          </div>
        </form>



    </div>

</div>






<div id="add-goal" class="lightbox">

    <div class="lightbox-content">


        <h3>Add goal</h3>



        <form class="form-horizontal" role="form" method="POST" action="<?php echo SITE_URL . 'admin/match/' . $this->match->getId() . '/add-goal/'; ?>">

          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Player</label>
            <div class="col-sm-10">

                <select name="player-list" class="form-control">
                    <optgroup label="<?php echo $this->match->getTeamA()->getName() ?>">
                        <?php
                        foreach($this->match->getPlayersTeamA() as $player) {
                        ?>
                        <option value="<?php echo $player->getId(); ?>"><?php echo $player->getName(); ?></option>
                        <?php } ?>
                    </optgroup>

                    <optgroup label="<?php echo $this->match->getTeamB()->getName() ?>">
                        <?php
                        foreach($this->match->getPlayersTeamB() as $player) {
                        ?>
                        <option value="<?php echo $player->getId(); ?>"><?php echo $player->getName(); ?></option>
                        <?php } ?>
                    </optgroup>


                </select>


            </div>
          </div>


          <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Time</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="name" name="time" placeholder="60">
            </div>
          </div>


          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-default">Add</button>
            </div>
          </div>
        </form>



    </div>

</div>





<div id="add-card" class="lightbox">

    <div class="lightbox-content">


        <h3>Add card</h3>



        <form class="form-horizontal" role="form" method="POST" action="<?php echo SITE_URL . 'admin/match/' . $this->match->getId() . '/add-card/'; ?>">

          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Player</label>
            <div class="col-sm-10">

                <select name="player-list" class="form-control">
                    <optgroup label="<?php echo $this->match->getTeamA()->getName() ?>">
                        <?php
                        foreach($this->match->getTeamA()->getPlayers() as $player) {
                        ?>
                        <option value="<?php echo $player->getId(); ?>"><?php echo $player->getName(); ?></option>
                        <?php } ?>
                    </optgroup>

                    <optgroup label="<?php echo $this->match->getTeamB()->getName() ?>">
                        <?php
                        foreach($this->match->getTeamB()->getPlayers() as $player) {
                        ?>
                        <option value="<?php echo $player->getId(); ?>"><?php echo $player->getName(); ?></option>
                        <?php } ?>
                    </optgroup>


                </select>


            </div>
          </div>


          <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Type</label>
            <div class="col-sm-10">
              <select name="type" class="form-control">
                <option value="1">Yelow card</option>
                <option value="2">Red card</option>
                <option value="3">Second yellow card</option>
              </select>
            </div>
            </div>


            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Time</label>
                <div class="col-sm-10">
                  <input type="text" name="time" class="form-control" id="score" placeholder="60">
                </div>
             </div>


          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-default">Add</button>
            </div>
          </div>
        </form>



    </div>

</div>












<?php } ?>
