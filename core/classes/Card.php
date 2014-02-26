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
	public function __construct($id) {
		$this->id = $id;
	}

	/**
	Get the player
	@return player id
	*/
	public function getPlayer() {
		return $this->playerId();
	}

	/**
	Get the match
	@return match id
	*/
	public function getMatch() {
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
