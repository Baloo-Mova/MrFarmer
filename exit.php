<?php 
session_start();
unset($_SESSION["user"]);
unset($_SESSION["user_id"]);
unset($_SESSION["admin"]);
@session_destroy();
Header("Location: /");
?>
	