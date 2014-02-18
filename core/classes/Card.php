<?php
/*
Card Class
*/


/**
@brief Card Class

The class contains the following information:
- player id
- match id
- time
- type
*/
class Card {

	const yellow = 1;
    const red = 2;

    private $id;
    private $playerId;
    private $matchId;
    private $time;
    private $type;

	/**
	Constructor
	@param player id
	@param match id
	@param time
	@param type
	*/
	public function __construct($id, $playerId, $matchId, $time, $type) {
		$this->id = $id;
		$this->playerId = $playerId;
		$this->matchId = $matchId;
		$this->time = $time;
		$this->type = $type;
	}

	/**
	Get the ID of the player
	@return player id
	*/
	public function getPlayerId() {
		return $this->playerId();
	}

	/**
	Get the ID of the match
	@return match id
	*/
	public function getMatchId() {
		return $this->matchId();
	}

	/**
	Get the time at which the card was given
	@return time
	*/
	public function getTime() {
		return $this->time();
	}

	/**
	Get the id
	@return time
	*/
	public function getId() {
		return $this->id;
	}

	/**
	Get the type of the card
	@return type
	*/
	public function getType() {
		return $this->type();
	}

}
