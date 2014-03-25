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
		public $feeds;
	
		public function __construct() {
			$this->theme = 'news.php';
			
			//decode json file containing all the sites
			$sites = json_decode(file_get_contents(dirname(__FILE__) . '/../feeds.json'));
			
			//loop through all sites and fetch the rss
			foreach ($sites as $site) {
				$feed = [
				
				'title' => $site->title,
				'url' => $site->url,
				'items' => $this->getFeed($site->rss)
				
				];
				
				$this->feeds[] = $feed;
			}
					
		}
		
		
		/**
		Call GET methode with parameters
		
		@param params
		*/
		public function GET($args) {
		}
	
	
	
		private function getFeed($url) {
			// Create a new instance of the SimplePie object
			$feed = new \SimplePie();
			
			// Set feed
			$feed->set_feed_url($url);
			
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
			
			
			return $feed->get_items(0,10);;

		}
	
	
	}

}

?>