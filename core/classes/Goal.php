<?php
/*
Goal Class
*/


/**
@brief Goal Class

The class contains the following information:
- id
- time
*/
class Goal {
    private $id;
    private $playerId;
    private $matchId;
    private $time;
    private $db;
    private $teamId;

    /**
    Constructor
    @param id
    */
    public function __construct($id, $playerId, $matchId, $time, $teamId, &$db) {
        $this->id = $id;
        $this->playerId = $playerId;
        $this->matchId = $matchId;
        $this->time = $time;
        $this->teamId = $teamId;
        $this->db = $db;
    }

    /**
    Get the ID of the goal
    @return id
    */
    public function getId() {
        return $this->id;
    }



    public function getTime() {
        return $this->time;
    }

    public function getMatch() {
        return $this->db->getMatchById($this->matchId);
    }

    public function getMatchId() {
        return $this->matchId;
    }

    public function getPlayer() {
        return $this->db->getPlayerById($this->playerId);
    }

    public function getPlayerId() {
        return $this->playerId;
    }

    public function getTeamId() {
        return $this->teamId;
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