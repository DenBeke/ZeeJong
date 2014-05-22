<?php
require_once(dirname(__FILE__) . '/wiki.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

$wi = new Wiki();
echo $wi->getPlayerWiki("Maarten Stekelenburg"), "<br><br>";
echo $wi->getPlayerWiki("Ronaldo"), "<br><br>";
echo $wi->getPlayerWiki("Avraam Papadopoulos"), "<br><br>";

?>