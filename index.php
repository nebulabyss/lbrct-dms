<?php
include './includes/auth.php';
include 'pdo.php';
include 'classes/FormProcessor.php';
include 'classes/DatabaseController.php';

if (isset($_SESSION['TEMP'])) {
    unset($_SESSION['TEMP']);
}

if (!isset($_SESSION['USER_ID'])) {
    header('Location: login.php');
    exit;
}

include './includes/header.php';
$database_controller = new DatabaseController($pdo);
$boat_trans = $database_controller->CheckForTransgressions();
?>
    <body>
<div class="container-fluid">
    <?php include './includes/nav.php'; ?>
    <?php if ($boat_trans): ?>
        <div>
            <h4 class="text-danger mt-5 text-center">There are transgressions to be processed</h4>
        </div>
    <?php endif; ?>
</div>
<?php include './includes/footer.php'; ?>