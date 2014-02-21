<?php
/*
Logout file allowing users to log out
*/

session_start();
session_unset();
session_destroy();
header('Location: ../');

?>
