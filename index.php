<?php
include './includes/auth.php';

if (isset($_SESSION['TEMP'])) {
    unset($_SESSION['TEMP']);
}

if (!isset($_SESSION['USER_ID'])) {
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