<?PHP
$pageTitle = "- IRC Webchat";
include ("includes/header.php");
?>
<iframe src="http://<?php echo $ircserverwebchat ?>?channels=<?php echo $chatroom ?>&uio=d4" width="800" height="400"></iframe>
