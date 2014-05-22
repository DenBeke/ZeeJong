<?php
/*
Match Class
*/



require_once(dirname(__FILE__) . '/Team.php');
require_once(dirname(__FILE__) . '/Score.php');
require_once(dirname(__FILE__) . '/Referee.php');
require_once(dirname(__FILE__) . '/Tournament.php');


/**
@brief Match Class

The class contains the following information:
- id
- date
- place
*/
class Match {
    private $id;
    private $teamA;
    private $teamB;
    private $tournamentId;
    private $refereeId;
    private $date;
    private $scoreId;
    private $db;


    /**
    Constructor
    @param id
    */
    public function __construct($id, $teamA, $teamB, $tournamentId, $refereeId, $date, $scoreId, $type, &$db) {
        $this->id = $id;
        $this->teamA = $teamA;
        $this->teamB = $teamB;
        $this->tournamentId = $tournamentId;
        $this->refereeId = $refereeId;
        $this->date = $date;
        $this->scoreId = $scoreId;
        $this->type = $type;
        $this->db = &$db;
    }

    /**
    Get the ID of the match
    @return id
    */
    public function getId() {
        return $this->id;
    }



    public function getTeamA() {
        return $this->db->getTeamById($this->teamA);
    }


    public function getTeamAId() {
        return $this->teamA;
    }


    public function getTeamB() {
        return $this->db->getTeamById($this->teamB);
    }


    public function getTeamBId() {
        return $this->teamB;
    }


    public function getScore() {
        return $this->db->getScoreById($this->scoreId);
    }


    public function getScoreId() {
        return $this->scoreId;
    }


    public function getReferee() {
        try {
            return $this->db->getRefereeById($this->refereeId);
        }   catch (exception $e) {
            return false;
        }
    }


    public function getRefereeId() {
        return $this->refereeId;
    }


    public function getTournament() {
        return $this->db->getTournamentById($this->tournamentId);
    }


    public function getTournamentId() {
        return $this->tournamentId;
    }


    public function getDate() {
        return $this->date;
    }

    public function getType() {
        return $this->type;
    }

    public function getPlayersTeamA() {
        return $this->getTeamA()->getPlayersForMatch($this->id);
    }

    public function getPlayersTeamB() {
        return $this->getTeamB()->getPlayersForMatch($this->id);
    }

    public function getFirstScorer() {
        return $this->db->getFirstScorerInMatch($this->getId());
    }

    public function getTotalCards() {
        return $this->db->getTotalCardsInMatch($this->getId());
    }

    public function getTotalYellowCards(){
        return $this->db->getTotalYellowCardsInMatch($this->id);
    }

    public function getTotalRedCards(){
        return $this->db->getTotalRedCardsInMatch($this->id);
    }

    public function getPrognose() {

        $matchesWonByTeamA[0] = $this->db->getLatestWonMatches($this->getTeamAId(), 30);
        $matchesWonByTeamA[1] = $this->db->getLatestWonMatches($this->getTeamAId(), 10);
        $matchesWonByTeamA[2] = $this->db->getLatestWonMatches($this->getTeamAId(), 3);

        $matchesWonByTeamB[0] = $this->db->getLatestWonMatches($this->getTeamBId(), 30);
        $matchesWonByTeamB[1] = $this->db->getLatestWonMatches($this->getTeamBId(), 10);
        $matchesWonByTeamB[2] = $this->db->getLatestWonMatches($this->getTeamBId(), 3);

        $matchesBetweenTeams[0] = $this->db->getLatestMatchesBetweenTeams($this->getTeamAId(), $this->getTeamBId(), 5);
        $matchesBetweenTeams[1] = $this->db->getLatestMatchesBetweenTeams($this->getTeamAId(), $this->getTeamBId(), 3);
        $matchesBetweenTeams[2] = $this->db->getLatestMatchesBetweenTeams($this->getTeamAId(), $this->getTeamBId(), 1);

        $earlierScoreTeamA = array();
        $earlierScoreTeamB = array();
        for ($i = 0; $i < 3; $i++) {
            $earlierScoreTeamA[$i]['our'] = 0;
            $earlierScoreTeamA[$i]['opponent'] = 0;
            $earlierScoreTeamB[$i]['our'] = 0;
            $earlierScoreTeamB[$i]['opponent'] = 0;
            $earlierScoreBetweenTeams[$i]['A'] = 0;
            $earlierScoreBetweenTeams[$i]['B'] = 0;

            foreach ($matchesWonByTeamA[$i] as $matchesWon) {
                $earlierScoreTeamA[$i]['our'] += $matchesWon['our'] / sizeof($matchesWonByTeamA[$i]);
                $earlierScoreTeamA[$i]['opponent'] += $matchesWon['opponent'] / sizeof($matchesWonByTeamA[$i]);
            }
            foreach ($matchesWonByTeamB[$i] as $matchesWon) {
                $earlierScoreTeamB[$i]['our'] += $matchesWon['our'] / sizeof($matchesWonByTeamB[$i]);
                $earlierScoreTeamB[$i]['opponent'] += $matchesWon['opponent'] / sizeof($matchesWonByTeamB[$i]);
            }
            foreach ($matchesBetweenTeams[$i] as $match) {
                $earlierScoreBetweenTeams[$i]['A'] += $match['A'] / sizeof($matchesBetweenTeams[$i]);
                $earlierScoreBetweenTeams[$i]['B'] += $match['B'] / sizeof($matchesBetweenTeams[$i]);
            }

            if (sizeof($matchesBetweenTeams[$i]) == 0) {
                $earlierScoreBetweenTeams[$i]['A'] = $earlierScoreTeamA[$i]['our'];
                $earlierScoreBetweenTeams[$i]['B'] = $earlierScoreTeamB[$i]['our'];
            }
        }

        $scoreTeamA =  0.59 * ($earlierScoreTeamA[2]['our'] + $earlierScoreTeamB[2]['opponent'] + $earlierScoreBetweenTeams[2]['A']) / 3
                     + 0.31 * ($earlierScoreTeamA[1]['our'] + $earlierScoreTeamB[1]['opponent'] + $earlierScoreBetweenTeams[1]['A']) / 3
                     + 0.10 * ($earlierScoreTeamA[0]['our'] + $earlierScoreTeamB[0]['opponent'] + $earlierScoreBetweenTeams[0]['A']) / 3;

        $scoreTeamB =  0.59 * ($earlierScoreTeamB[2]['our'] + $earlierScoreTeamA[2]['opponent'] + $earlierScoreBetweenTeams[2]['B']) / 3
                     + 0.31 * ($earlierScoreTeamB[1]['our'] + $earlierScoreTeamA[1]['opponent'] + $earlierScoreBetweenTeams[1]['B']) / 3
                     + 0.10 * ($earlierScoreTeamB[0]['our'] + $earlierScoreTeamA[0]['opponent'] + $earlierScoreBetweenTeams[0]['B']) / 3;

        if ($scoreTeamA < 2 && $scoreTeamA > 1.38) {
            $scoreTeamA = 2;
        }
        if ($scoreTeamA < 0.62) {
            $scoreTeamA = 0;
        }

        if ($scoreTeamB < 2 && $scoreTeamB > 1.38) {
            $scoreTeamB = 2;
        }
        if ($scoreTeamB < 0.62) {
            $scoreTeamB = 0;
        }

        $prognose = array(round($scoreTeamA), round($scoreTeamB));

        return $prognose;
    }

    /**
     Get the total amount of money bet on this match

     @return the total amount of money bet on this match
     */
    public function getTotalMoneyBetOn(){
        return $this->db->getAmountBetOnMatch($this->id);
    }


    /**
    String function
    @return string
    */
    public function __toString() {
        return "ID: $this->id";
    }

}
?>
