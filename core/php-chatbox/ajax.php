<?php


if(isset($_POST['group'])) {

    $file = 'chat-' . $_POST['group'] . '.json';

    if (file_exists($file)) {
            $jsonAr = json_decode(file_get_contents($file), true);
    }
    else {
        $jsonAr = [];
    }

    if (isset($_POST) && isset($_POST['author']) && (strlen($_POST['author']) > 0) && (strlen($_POST['text'])> 0)) {
            $author = htmlentities(strip_tags($_POST['author']), ENT_QUOTES);
            $text = stripslashes(htmlentities(strip_tags($_POST['text']), ENT_QUOTES));
        $chat = array("author" => $author, "text" => $text, "timestamp" => date('H:i:s',time()), "size" => sizeof($jsonAr));
        $jsonAr[] = $chat;
    }


    $jsonAr = array_slice($jsonAr, sizeof($jsonAr) - 70);

    file_put_contents($file, json_encode($jsonAr));

    echo json_encode($jsonAr);

}
else {
    echo 'no group given';
}

?>