<?php
session_start();

if (isset($_SESSION['wq_data'])) {
    unset($_SESSION['wq_data']);
}

if (!isset($_SESSION['user_name'])) {
    header('Location: login.php');
    exit;
}
include './includes/header.php';
?>
<body>
<div class="container-fluid">
<?php include './includes/nav.php';?>
</div>
<?php include './includes/footer.php';?>