<?php
session_start();
?>

<?php
include "./includes/header.php";

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

</body>

