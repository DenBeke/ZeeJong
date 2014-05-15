
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

function getInfoboxJsonUrl($term)
{
   $format = 'json';

   $query = 
   "PREFIX dbpedia: <http://dbpedia.org/resource/>
	PREFIX dbpprop: <http://dbpedia.org/property/>

	SELECT ?property ?value 
	WHERE {
  	dbpedia:Maarten_Stekelenburg ?property ?value
  	filter( strstarts(str(?property),str(dbpprop:)) )
	}";

   $searchUrl = 'http://dbpedia.org/sparql?'
      .'query='.urlencode($query)
      .'&format='.$format;

   return $searchUrl;
}

function getImgAndAbstract($term) {

   $format = 'json';

   $query =
   "PREFIX dbp: <http://dbpedia.org/resource/>
   PREFIX dbp2: <http://dbpedia.org/ontology/>
   PREFIX dbp3: <http://dbpedia.org/property/>
 
   SELECT *
   WHERE {
      dbp:".$term." dbp2:abstract ?abstract .
      dbp:".$term." dbp2:thumbnail ?img .
      dbp:".$term." dbp3:* ?properties .
      FILTER langMatches(lang(?abstract), 'en')
   }";

   $searchUrl = 'http://dbpedia.org/sparql?'
      .'query='.urlencode($query)
      .'&format='.$format;

   return $searchUrl;   
}

function request($url){
 
   // is curl installed?
   if (!function_exists('curl_init')){
      die('CURL is not installed!');
   }
   
   // get curl handle
   $ch= curl_init();

   // set request url
   curl_setopt($ch,
      CURLOPT_URL,
      $url);

   // return response, don't print/echo
   curl_setopt($ch,
      CURLOPT_RETURNTRANSFER,
      true);
 
   /*
   Here you find more options for curl:
   http://www.php.net/curl_setopt
   */    

   $response = curl_exec($ch);
   
   curl_close($ch);
   
   return $response;
}


function printArray($array, $spaces = "") {
   $retValue = "";
   
   if(is_array($array))
   { 
      $spaces = $spaces
         ."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

      $retValue = $retValue."<br/>";

      foreach(array_keys($array) as $key)
      {
         $retValue = $retValue.$spaces
            ."<strong>".$key."</strong>"
            .printArray($array[$key],
               $spaces);
      }    
      $spaces = substr($spaces, 0, -30);
   }
   else $retValue =
      $retValue." - ".$array."<br/>";
   
   return $retValue;
}


function getReducedArrayImgAndAbstract($array) {


   $reducedArray = $array["results"]["bindings"];
   $newArray = [
      "abstract" => [$reducedArray[0]["abstract"]["value"]],
      "img" => [$reducedArray[0]["img"]["value"]]
   ];



   return $newArray;

}

function getReducedArrayProp($array) {


   $reducedArray = $array["results"]["bindings"];
   $newArray = [];

   foreach ($reducedArray as $property) {

      $propName = substr($property["property"]["value"], 28);
      $propValue = $property["value"]["value"];
      if(array_key_exists($propName, $newArray)) {

         $newArray[$propName][] = removeLink($propValue);
      }
      else {

         $newArray[$propName] = [removeLink($propValue)];
      }
      
   }

   return $newArray;

}

function removeLink($link) {

   $index = strpos($link, "/");
   while($index !== false) {

      $link = substr($link, $index+1);
      $index = strpos($link, "/");
   }

   $newLink = "";

   for($i = 0; $i < strlen($link); $i++) {

         if($link[$i] == "_") {
            $newLink = $newLink . " ";
         }
         else {
            $newLink = $newLink . $link[$i];
         }
      }

   return $newLink;
}

private function searchCorrectArticleName($article) {

	$searchLocation = $this->site . "http://en.wikipedia.org/w/index.php?search=";
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


function getWiki($player) {

   $result = getReducedArrayProp(json_decode(request(getInfoboxJsonUrl("Maarten_Stekelenburg")), true)) + 
   getReducedArrayImgAndAbstract(json_decode(request(getImgAndAbstract("Maarten_Stekelenburg")), true));
   foreach ($result as $key => $propList) {
      echo $key, " => ";
      foreach($propList as $prop) {

         echo " ".$prop." ";
      }
      echo "<br>";
   }   
   return $result;
}



?>