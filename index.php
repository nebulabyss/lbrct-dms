<?php
session_start();
?>

<?php
require_once "./html/header.php";

if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    return;
}
?>
</head>
<body>
<div class="container-fluid">
<?php require_once "./html/nav.php";?>

</div>

<?php require_once "./html/footer.php";?>

</body>

