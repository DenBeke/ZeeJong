<?php
/*
Template part for header when logged in

Created: February 2014
*/
$user = new User($_SESSION['userID']);
echo "<li><a> Hi ";
echo $user->getUserName();
echo "</a></li>";
?>
<html>
<li><a href="core/logout.php">Logout</a></li>
</html>

	
