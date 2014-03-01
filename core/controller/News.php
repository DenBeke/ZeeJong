<?php
/*
News Controller

Created February 2014
*/


namespace Controller {

require_once(dirname(__FILE__) . '/Controller.php');
require_once(dirname(__FILE__) . '/../simplepie/autoloader.php');


	class News extends Controller {
	
		public $page = 'news';
		public $items;
	
		public function __construct() {
			$this->theme = 'news.php';
			
			// Create a new instance of the SimplePie object
			$feed = new \SimplePie();
			
			// Set feed
			$feed->set_feed_url('http://www.football.co.uk/news/rss.xml');
			
			// Allow us to change the input encoding from the URL string if we want to. (optional)
			if (!empty($_GET['input']))
			{
				$feed->set_input_encoding($_GET['input']);
			}
			
			// Allow us to choose to not re-order the items by date. (optional)
			if (!empty($_GET['orderbydate']) && $_GET['orderbydate'] == 'false')
			{
				$feed->enable_order_by_date(false);
			}
			
			// Trigger force-feed
			if (!empty($_GET['force']) && $_GET['force'] == 'true')
			{
				$feed->force_feed(true);
			}
			
			
			$feed->set_cache_location( dirname(__FILE__) . '/../cache/' );
			
			$feed->init();
			
			
			$this->items = $feed->get_items(0,10);
			
		}
		
		
		/**
		Call GET methode with parameters
		
		@param params
		*/
		public function GET($args) {
		}
	
	
	}

}

?>