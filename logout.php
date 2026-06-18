<?php

session_start();
include 'nav.php';
session_destroy();

header("Location: login.php");
exit();

?>