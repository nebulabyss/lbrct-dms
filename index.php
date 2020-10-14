<?php
session_start();
include "./includes/header.php";

unset($_SESSION['wq_data']);

if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    return;
}
?>
<body>
<div class="container-fluid">
<?php include "./includes/nav.php";?>
</div>
<?php include "./includes/footer.php";?>