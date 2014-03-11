<?php
/*
PHP Unit Tes framework

Author: Mathias Beke
Url: http://denbeke.be
Date: March 2014
*/


require_once( dirname(__FILE__) . '/unit-test.php' );
require_once( dirname(__FILE__) . '/preprocess.php');

$t = new \UnitTest\UnitTest;

preprocess();

foreach (glob(dirname(__FILE__) . '/tests/preprocessed/*.php') as $file) {
	require_once($file);
}


$t->run();




include(dirname(__FILE__) . '/theme/header.php');

$t->write();

include(dirname(__FILE__) . '/theme/footer.php');

?>