<?php
/*
Class representing a website page
*/


class Page {
	
	private $content;
	private $title;
	private $id;
	
	
	public function __construct($id, $title, $content) {
		
		$this->id = $id;
		$this->title = $title;
		$this->content = $content;
		
	}
	
	
	public function getId() {
		return $this->id;
	}
	
	
	public function getTitle() {
		return $this->title;
	}
	
	
	public function getContent() {
		return $this->content;
	}
	
	
	
}

?>