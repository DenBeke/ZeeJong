<?php
/*
Functions for mailing notifications to users
*/


//Set default time zone
date_default_timezone_set('Europe/Brussels');


require(dirname(__FILE__) . '/config.php');
require(dirname(__FILE__) . '/database.php');
iconv_set_encoding("internal_encoding", "UTF-8");

function sendMail($subject, $to, $from, $message) {

    if (($from == '') || ($to == '')) {
        return;
    }

    if( mail(($to), ($subject), ($message), 'From: ' . ($from)."\nContent-Type: text/html; charset=UTF-8\nContent-Transfer-Encoding: 8bit\n") ) {
        echo "<p>Sent a message to: $to</p>";   
    }
    else {
        echo "<p>Could not send email</p>";
    }
    

}



function matchesToString($matches) {

    $output = "<ul>";


    foreach ($matches as $match) {
        $output = $output . '<li><a href="' . SITE_URL . 'match/' . $match->getId() . '">' . $match->getTeamA()->getName() . ' - ' . $match->getTeamB()->getName() . '</a> (' . date('d-m-Y', $match->getDate()) . ')' . '</li>';
    }

    $output = $output . "</ul>";

    return $output;

}



function notifyUsers($time = 604800) {

    $database = new Database;

    foreach ($database->getAllUsers() as $user) {

        $matches = $database->getUnbetMatches($user->getId(), $time);

        $message = '<p>Dear ' . $user->getUserName() . ', you haven\'t yet placed any bets for the following upcoming events. Don\'t forget to take your chance!</p>' . matchesToString($matches) . '<p>Greetings, the ZeeJong team.</p>';

        sendMail('ZeeJong - Upcoming Events', $user->getMail(), 'no-reply@zeejong.eu', $message);


    }

}

notifyUsers();


?>
