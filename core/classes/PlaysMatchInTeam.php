<?php
/*
PlaysMatchInTeam Class
*/


/**
@brief PlaysMatchInTeam Class

The class contains the following information:
- id
- playerId
- teamId
- matchId
- number
*/
class PlaysMatchInTeam {
    private $id;
    private $playerId;
    private $teamId;
    private $matchId;
    private $number;
    private $db;

    /**
    Constructor
    @param id
    */
    public function __construct($id, $playerId, $teamId, $matchId, $number, &$db) {
        $this->id = $id;
        $this->playerId = $playerId;
        $this->teamId = $teamId;
        $this->matchId = $matchId;
        $this->number = $number;
        $this->db = &$db;
    }

    /**
    Get the ID of the playsmatchinteam relation
    @return id
    */
    public function getId() {
        return $this->id;
    }

    /**
    Get the player of the playsmatchinteam relation
    @return player
    */
    public function getPlayer() {
        return $this->db->getPlayerById($this->playerId);
    }


    /**
    Get the player ID of the playsmatchinteam relation
    @return id
    */
    public function getPlayerId() {
        return $this->playerId;
    }

    /**
    Get the team of the playsmatchinteam relation
    @return team
    */
    public function getTeam() {
        return $this->db->getTeamById($this->teamId);
    }


    /**
    Get the team ID of the playsmatchinteam relation
    @return id
    */
    public function getTeamId() {
        return $this->teamId;
    }

    /**
    Get the match of the playsmatchinteam relation
    @return match
    */
    public function getMatch() {
        return $this->db->getMatchById($this->matchId);
    }


    /**
    Get the match ID of the playsmatchinteam relation
    @return id
    */
    public function getMatchId() {
        return $this->matchId;
    }

    /**
    Get the shirtnumber of the player in the match
    @return id
    */
    public function getNumber() {
        return $this->number;
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