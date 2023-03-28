<?php
// Begin session
session_start();

// Reset session var
$_SESSION = array();
session_destroy();

header("location: /");
exit;
