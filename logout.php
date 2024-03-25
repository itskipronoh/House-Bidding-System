<?php
 session_start();
 unset($_SESSION['username']);
 unset($_SESSION['uid']);
 unset($_SESSION['type']);
 header("Location: login.php");
?>
