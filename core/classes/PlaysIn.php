<?php
/*
Playsin Class
*/


/**
@brief PlaysIn Class

The class contains the following information:
- id
- playerId
- teamId
*/
class PlaysIn {
    private $id;
    private $playerId;
    private $teamId;
    private $db;

    /**
    Constructor
    @param id
    */
    public function __construct($id, $playerId, $teamId, &$db) {
        $this->id = $id;
        $this->playerId = $playerId;
        $this->teamId = $teamId;
        $this->db = &$db;
    }

    /**
    Get the ID of the coach
    @return id
    */
    public function getId() {
        return $this->id;
    }

    public function getPlayer() {
        return $this->db->getPlayerById($this->playerId);
    }

    public function getPlayerId() {
        return $this->playerId;
    }

    public function getTeam() {
        return $this->db->getTeamById($this->teamId);
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