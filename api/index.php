<?php

require_once(dirname(__FILE__) . '/../core/database.php');
require_once(dirname(__FILE__) . '/../core/config.php');
require_once(dirname(__FILE__) . '/../core/Selector.php');
require_once(dirname(__FILE__) . '/../core/gluephp/glue.php');

require_once(dirname(__FILE__) . '/controller/Player.php');

$urls = array(
	INSTALL_DIR . 'api/' . 'player(\?.*)?' => 'Controller\player',
);

$database = new Database;

$controller = glue::stick($urls);

$controller->template();

?>
