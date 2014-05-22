
<?php
//header('Content-Type: text/html; charset=UTF-8');
require_once(dirname(__FILE__) . '/wikidrain/api.php');
require_once(dirname(__FILE__) . '/../simple_html_dom.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

function getInfoboxJsonUrl($term)
{
   //$term = utf8_encode($term);
   //echo "<br>", $term, "<br>";
   $format = 'json';

   $query =
   "PREFIX dbpedia: <http://dbpedia.org/resource/>
    PREFIX dbpprop: <http://dbpedia.org/property/>

    SELECT ?property ?value
    WHERE {
    dbpedia:".$term." ?property ?value
    filter( strstarts(str(?property),str(dbpprop:)) )
    }";

   $searchUrl = 'http://dbpedia.org/sparql?'
      .'query='.urlencode($query)
      .'&format='.$format;

   return $searchUrl;
}

function getImgAndAbstract($term) {

   //$term = utf8_encode($term);
   //echo "<br>", $term, "<br>";
   $format = 'json';

   $query =
   "PREFIX dbp: <http://dbpedia.org/resource/>
   PREFIX dbp2: <http://dbpedia.org/ontology/>

   SELECT *
   WHERE {
      dbp:".$term." dbp2:abstract ?abstract .
      dbp:".$term." dbp2:thumbnail ?img .
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
   if(sizeof($reducedArray) == 0)  {

    return [];
   }
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

function searchCorrectArticleName($article) {

    $searchLocation = "http://en.wikipedia.org/w/index.php?search=";
    for($i = 0; $i < strlen($article); $i++) {

        if($article[$i] == '_') {

            $searchLocation = $searchLocation . "+";
        }

        else {

            $searchLocation = $searchLocation . $article[$i];
        }
    }
   $redirectUrl = get_final_url($searchLocation);

   $wikiUrl = "";

   if($redirectUrl == $searchLocation) {

    $html = loadPage($searchLocation);
    $searchResults = $html->find('.mw-search-results' , 0);

    $searchResultElement = $searchResults->first_child()->first_child()->first_child();

      $newArticleName = $searchResultElement->getAttribute('title');

      for($i = 0; $i < strlen($newArticleName); $i++) {

         if($newArticleName[$i] == ' ') {

            $wikiUrl = $wikiUrl . "_";
         }

         else {

            $wikiUrl = $wikiUrl . $newArticleName[$i];
         }
      }

      $wikiUrl = "http://wikipedia.org/wiki/".$wikiUrl;
   }

   else {

      $wikiUrl = $redirectUrl;
   }


   $html = loadPage($wikiUrl);
   $titleNode = $html->find('.firstHeading' , 0);
   $title = $titleNode->first_child()->plaintext;

   $correctArticle = "";

   for($i = 0; $i < strlen($title)-1; $i++) {

      if($title[$i] == ' ') {

         $correctArticle = $correctArticle . "_";
      }

      else {

         $correctArticle = $correctArticle . $title[$i];
      }
   }

   $correctArticle = searchCorrectDBPediaArticle($correctArticle);
   return $correctArticle;

}

function searchCorrectDBPediaArticle($article) {

   $dbpediaUrl = "http://dbpedia.org/page/".$article;
   $correctUrl = urldecode(get_final_url($dbpediaUrl));
   $tempArticle = removeLink($correctUrl);

   $correctDBPediaArticle = "";

   for($i = 0; $i < strlen($tempArticle); $i++) {

      if($tempArticle[$i] == ' ') {

         $correctDBPediaArticle = $correctDBPediaArticle . "_";
      }

      else {

         $correctDBPediaArticle = $correctDBPediaArticle . $tempArticle[$i];
      }
   }
   return $correctDBPediaArticle;
}

function loadPage($url) {

   $page = file_get_contents($url);
   return str_get_html($page);
}

//This code was written by: http://w-shadow.com/blog/2008/07/05/how-to-get-redirect-url-in-php/
/**
 * get_redirect_url()
 * Gets the address that the provided URL redirects to,
 * or FALSE if there's no redirect.
 *
 * @param string $url
 * @return string
 */
function get_redirect_url($url){
    $redirect_url = null;
    $url_parts = @parse_url($url);

    if (!$url_parts) return false;
    if (!isset($url_parts['host'])) return false; //can't process relative URLs
    if (!isset($url_parts['path'])) $url_parts['path'] = '/';

    $sock = fsockopen($url_parts['host'], (isset($url_parts['port']) ? (int)$url_parts['port'] : 80), $errno, $errstr, 30);
    if (!$sock) return false;

    $request = "HEAD " . $url_parts['path'] . (isset($url_parts['query']) ? '?'.$url_parts['query'] : '') . " HTTP/1.1\r\n";
    $request .= 'Host: ' . $url_parts['host'] . "\r\n";
    $request .= "Connection: Close\r\n\r\n";
    fwrite($sock, $request);
    $response = '';
    while(!feof($sock)) $response .= fread($sock, 8192);
    fclose($sock);
      //We lose UTF8 here

    if (preg_match('/^Location: (.+?)$/m', $response, $matches)){
        if ( substr($matches[1], 0, 1) == "/" )
            return $url_parts['scheme'] . "://" . $url_parts['host'] . trim($matches[1]);
        else
            return trim($matches[1]);

    } else {
        return false;
    }

}

//This code was written by: http://w-shadow.com/blog/2008/07/05/how-to-get-redirect-url-in-php/
/**
 * get_all_redirects()
 * Follows and collects all redirects, in order, for the given URL.
 *
 * @param string $url
 * @return array
 */
function get_all_redirects($url){
    $redirects = array();
    while ($newurl = get_redirect_url($url)){
        if (in_array($newurl, $redirects)){
            break;
        }
        $redirects[] = $newurl;
        $url = $newurl;
    }
    return $redirects;
}

//This code was written by: http://w-shadow.com/blog/2008/07/05/how-to-get-redirect-url-in-php/
/**
 * get_final_url()
 * Gets the address that the URL ultimately leads to.
 * Returns $url itself if it isn't a redirect.
 *
 * @param string $url
 * @return string
 */
function get_final_url($url){
    $redirects = get_all_redirects($url);
    if (count($redirects)>0){
        return array_pop($redirects);
    } else {

        return $url;
    }
}




function getPlayerArticle($player) {

   $article = "";

   for($i = 0; $i < strlen($player); $i++) {

      if($player[$i] == " ") {

         $article = $article . "_";
      }

      else {

         $article = $article . $player[$i];
      }
   }

   return $article;
}

//Get the final url to which is redirected
function getRedirectUrl ($url) {
    stream_context_set_default(array(
        'http' => array(
            'method' => 'HEAD'
        )
    ));
    $headers = get_headers($url, 1);
    if ($headers !== false && isset($headers['Location'])) {
        return $headers['Location'];
    }
    return false;
}


/*
function articleExists($article) {



   $ch = curl_init('http://en.wikipedia.org/w/index.php?search='.$article);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   curl_exec($ch);
   $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
   if (($code == 301) || ($code == 302)) {
     return true;
   }
   else {
      return false;;
   }
}*/

/**
* Gets the wiki page of a player
*
* @param $player The full name of a player
*
* @return Returns an array, with every key being the name of the dbpprop, the img key giving the image url, and abstract key giving the introduction of the player
*
*/
function getWiki($player) {

   $article = getPlayerArticle($player);
   $article = searchCorrectArticleName($article);


   $result = getReducedArrayProp(json_decode(request(getInfoboxJsonUrl($article)), true)) +
   getReducedArrayImgAndAbstract(json_decode(request(getImgAndAbstract($article)), true));
   /*foreach ($result as $key => $propList) {
      echo $key, " => ";
      foreach($propList as $prop) {

         echo " ".$prop." ";
      }
      echo "<br>";
   } */
   return $result;
}



?>