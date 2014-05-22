<?php include(dirname(__FILE__) . '/admin.php'); ?>
<?php
if(isAdmin()){
?>

<script>
function deleteMatch(elem, id) {
    $.ajax({
        url: "<?php echo SITE_URL . 'admin/match/" + id + "/delete'; ?>",
        success: function() {
            $(elem).parent().parent().remove();
        }
    });
}
</script>



<script>
    
    
    
    function searchTeamA() {
        $.ajax({
            dataType: "json",
            url: '<?php echo SITE_URL; ?>core/ajax/team.php',
            data: {'name': $('#inputIdA').val()},
            success: function(data) {
                var html = '';
                for(var i in data) {
                    html += '<option value="' + data[i].id + '">';
                    html += data[i].name;
                    html += '</option>';
                }
    
                $('#team-a-list').html(html);
            }
        });
    }
    
    
    function searchTeamB() {
        $.ajax({
            dataType: "json",
            url: '<?php echo SITE_URL; ?>core/ajax/team.php',
            data: {'name': $('#inputIdB').val()},
            success: function(data) {
                var html = '';
                for(var i in data) {
                    html += '<option value="' + data[i].id + '">';
                    html += data[i].name;
                    html += '</option>';
                }
    
                $('#team-b-list').html(html);
            }
        });
    }
    
    
    
    
    
    
    var tournament;
    
    function setTournament(id) {
        $('#selected-tournament').val(id);
    }
</script>




<p></p>

<div class="container">

    <?php foreach($this->competitions as $competition) { ?>
    <div class="competitions panel panel-default">
        <div class="panel-heading hidden-click">
            <h3 class="panel-title"><?php echo $competition->getName(); ?></h3>
        </div>

        <div class="competition-content hidden-content panel-body">


            <?php foreach($competition->getTournaments() as $tournament) { ?>
            <div class="panel panel-default">

                <div class="panel-heading hidden-click tournament-click">

                    <h3 class="panel-title"><?php echo $tournament->getName(); ?> <a class="btn-xs btn btn-primary lightbox-click" data-id="add-match" onclick="setTournament(<?php echo $tournament->getId(); ?>)">Add match</a></h3>

                </div>

                <div class="hidden-content panel-body" data-url="<?php echo SITE_URL . 'tournament/' . $tournament->getId(); ?>">

                        <div class="loader-container"><div class="loader"></div>loading</div>

                </div>

            </div>

            <?php } ?>


        </div>

    </div>

    <?php } ?>

</div>



<div id="add-match" class="lightbox">

    <div class="lightbox-content">
        
        <h3>Add match</h3>
        <form class="form-horizontal" role="form" method="post" action="<?php echo SITE_URL . 'admin/match/add'; ?>">
            <input type="hidden" id="selected-tournament" name="tournamentId">
          
          <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Team A</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="inputIdA" placeholder="">
            </div>
            <div class="col-sm-4">
              <button type="submit" onclick="searchTeamA(); return false;" class="btn btn-default">Search</button>
            </div>
          </div>
          
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Teams</label>
            <div class="col-sm-10">
                <select id="team-a-list" class="form-control" name="teamAId">
                </select>
            </div>
          </div>
          
          
          
          <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Team B</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" id="inputIdB" placeholder="">
            </div>
            <div class="col-sm-4">
              <button type="submit" onclick="searchTeamB(); return false;" class="btn btn-default">Search</button>
            </div>
          </div>
          

          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Teams</label>
            <div class="col-sm-10">
                <select id="team-b-list" class="form-control" name="teamBId">
                </select>
            </div>
          </div>
        
        
        <div class="form-group">
          <label for="inputEmail3" class="col-sm-2 control-label">Date</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="date" name="date" placeholder="02-11-1994">
          </div>
        </div>
        
        
        <div class="form-group">
          <label for="inputEmail3" class="col-sm-2 control-label">Final Type</label>
          <div class="col-sm-10">
              <input type="text" class="form-control" id="date" name="finalType" placeholder="Final">
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
