<?php
session_start();
if (!isset($_SESSION['USER_ID'])){
    session_unset();     // unset $_SESSION variable for the run-time
    session_destroy();   // destroy session data in storage
    header('Location: ./login.php');
    exit;
}
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 7200)) {
    // last request was more than 2 hours ago
    session_unset();     // unset $_SESSION variable for the run-time
    session_destroy();   // destroy session data in storage
    header('Location: ./login.php?expired');
    exit;
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

if (!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
} else if (time() - $_SESSION['CREATED'] > 3600) {
    // session started more than 1 hours ago
    session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
    $_SESSION['CREATED'] = time();  // update creation time
}