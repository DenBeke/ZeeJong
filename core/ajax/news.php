<?php
/*
Returns JSON objects for the 'News' page.

Created February 2014
*/

require_once(dirname(__FILE__) . '/../controller/News.php');


$controller = new \Controller\News;



if(isset($_GET['feed'])) {

    try {

        $feed = $controller->getFeed(intval($_GET['feed']));
        $output = [];

        foreach ($feed as $item) {
            $outputItem = [
                'title' => $item->get_title(),
                'content' => strip_tags($item->get_content()),
                'url' => $item->get_permalink(),
                'date' => $item->get_date('j M Y, g:i a')
            ];

            $output[] = $outputItem;

        }


    }
    catch(exception $e) {

        $output['error'] = 'Feed does not exist';

    }


}
else {
    $output['error'] = 'No feed given';
}



if(isset($_GET['debug'])) {
    echo '<pre>' . json_encode($output, JSON_PRETTY_PRINT) . '</pre>';
}
else {
    echo json_encode($output, JSON_PRETTY_PRINT);
}


?>

