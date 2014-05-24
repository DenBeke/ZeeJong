<?php
/*
Template part for match page

Created: February 2014
*/
?>


<div class="container">

    <h2 id="title-match"><?php echo $this->match->getTeamA()->getName() ?> - <?php echo $this->match->getTeamB()->getName() ?></h2>



    <div class="row">

        <!-- Information panel -->
        <div class="col-md-4">

            <div class="panel panel-default">


                <div class="panel-heading">

                    <h3 class="panel-title">Information</h3>


                </div>



                <div class="panel-body">

                    <ul class="list-group">


                        <li class="list-group-item">
                            Prognose: <?php $prognose = $this->match->getPrognose(); echo $prognose[0] . '-' . $prognose[1]; ?>
                        </li>


                        <li class="list-group-item">
                            Competition: <a href="<?php echo SITE_URL . 'competition/' . $this->match->getTournament()->getCompetition()->getId(); ?>">
                                <?php echo $this->match->getTournament()->getCompetition()->getName(); ?></a>
                        </li>

                        <li class="list-group-item">Date: <?php echo date('d-m-Y', $this->match->getDate()); ?></li>
                        
                        <li class="list-group-item">Kick-off: <?php echo date('H:i', $this->match->getDate()); ?></li>

                        <li class="list-group-item">Total bet: <?php echo $this->totalBet; ?></li>

                    </ul>


                </div>

            </div>





            <div class="col-md-12 bet-button-container container">
                    <a href="<?php echo SITE_URL . 'place-bet/' . $this->match->getId(); ?>" class="btn btn-success btn-lg">Place Bet</a>

            </div>



        </div>



        <div class="col-md-8 football-player">

            <h2><?php echo floor(($this->match->getDate() - strtotime(date('d M Y', time()))) / 86400 ); ?> days left</h2>

        </div>






</div>
