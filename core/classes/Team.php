<?php
/*
Team Class
*/


/**
@brief Team Class

The class contains the following information:
- id
- name
- country
*/
class Team implements JsonSerializable {
    private $id;
    private $name;
    private $countryId;
    private $db;

    /**
    Constructor
    @param id
    */
    public function __construct($id, $name, $countryId, &$db) {
        $this->id = $id;
        $this->name = $name;
        $this->countryId = $countryId;
        $this->db = &$db;
    }

    /**
    Get the ID of the team
    @return id
    */
    public function getId() {
        return $this->id;
    }


    public function getName() {
        return $this->name;
    }

    public function getCountry() {
        return $this->db->getCountryById($this->countryId);
    }


    public function getCountryId() {
        return $this->countryId;
    }


    public function getPlayers() {
        return $this->db->getPlayersInTeam($this->id);
    }


    public function getPlayersForMatch($matchId) {
        return $this->db->getTeamInMatch($this->id, $matchId);
    }


    public function getCoach() {
        return $this->db->getCoachForTeam($this->id);
    }


    public function getCoachForMatch($matchId) {
        try {
            return $this->db->getCoachForTeamAndMatch($this->id, $matchId);
        } catch (exception $e) {
            return false;
        }
    }

    public function getTotalWonMatches() {
        return $this->db->getTotalMatchesWonByTeam($this->id);
    }

    public function getTotalPlayedMatches() {
        return $this->db->getTotalMatchesPlayedByTeam($this->id);
    }

    public function getOverallStats() {

        $months = getAllMonths($this->db->getMatchDateBorderTeam($this->getId(), true), $this->db->getMatchDateBorderTeam($this->getId(), false));
        $matches = [];
        $matches_won = [];

        $count = 1;
        foreach ($months as $month => $timestamp) {
            if($count < sizeof($months)) {
                $matches[$timestamp] = $this->db->getTotalNumberOfTeamMatchesInterval($this->getId(), array_values($months)[$count-1], array_values($months)[$count]);
                $matches_won[$timestamp] = $this->db->getTotalMatchesWonByTeamInterval($this->getId(), array_values($months)[$count-1], array_values($months)[$count]);
                //var_dump(array_slice($months, $count-1, 1));
                //echo '<br>';
            }
            $count++;
        }


        return ['Matches' => $matches, 'Matches won' => $matches_won];

    }

    /**
    String function
    @return string
    */
    public function __toString() {
        return "ID: $this->id";
    }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'countryId' => $this->countryId
        ];
    }

}
?>
