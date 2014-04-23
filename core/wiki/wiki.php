<?php 
header('Content-Type: text/html; charset=UTF-8');
require_once(dirname(__FILE__) . '/wikidrain/api.php');
require_once(dirname(__FILE__) . '/../simple_html_dom.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

class Wiki {

	private $site;
	private $article;
	private $sections;
	private $wiki;

	public function __construct() {

		$this->site = "http://en.wikipedia.org";
		$this->sections = "About";
		$this->wiki = new wikidrain("wikidrain/1.0 (" . "$this->site" . ")");

	}

	private function run() {

		$this->sections = "about";

		$search = $this->wiki->Search($this->article, 1);

		if(sizeof($search) == 0) {

			return false;
		}

		$results = $this->wiki->getSections($this->article);		
		if(!$this->fullpage) {

			$text = $this->wiki->getText("$this->article", "{$results[0]['title']}");
			return "$text" . "<br>";			
		}

		else {

			$text = $this->wiki->getText("$this->article", "{$results[0]['title']}");

			foreach ($results as $section) {

				$tempText = $text . $this->wiki->getText("$this->article", "{$section['index']}");
				$text = $tempText;
			}
		}
	}

	private function searchCorrectArticleName() {

		$searchLocation = $this->site . "/w/index.php?search=";
		for($i = 0; $i < strlen($this->article); $i++) {

			if($this->article[$i] == '_') {

				$searchLocation = $searchLocation . "+";
			} 

			else {

				$searchLocation = $searchLocation . $this->article[$i];
			}
		}

		$html = $this->loadPage($searchLocation);

		$searchResults = $html->find('.mw-search-results' , 0);
		$searchResultElement = $searchResults->first_child()->first_child()->first_child();
		$this->article = $searchResultElement->getAttribute('title');
	}



	/**
	Load a page, but take the one from the cache when already loaded.

	@param url of the page

	@return DOM object
	*/
	private function loadPage($url) {

		$page = file_get_contents($url);
		return str_get_html($page);
	}

	/**
	*Get the text of the player's wiki page
	*
	*@param playerName The player's name
	*@param $fullpage Get the full page or just the intro. Default value is false (get just the intro)
	*
	*@returns wiki page in text format, without references, external links and images
	*
	*/
	public function getPlayerWiki($playerName, $fullpage = false) {

		$this->article = "";

		for($i = 0; $i < strlen($playerName); $i++) {

			if($playerName[$i] == " ") {

				$this->article = $this->article . "_";
			}

			else {

				$this->article = $this->article . $playerName[$i];
			}
		}

		$this->fullpage = $fullpage;
		$wiki = $this->run();


		if($wiki == false) {

			$this->searchCorrectArticleName();
			$wiki = $this->run();
			if($wiki != false) {

				return $wiki;
			}

			else{

				return "Player does not have wiki page";
			}

		}

		else {
			return $wiki;
		}
	}		
}



?>