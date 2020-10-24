<?php
include 'pdo.php';
include 'classes/DatabaseController.php';
session_start();

/**
 * @var $pdo
 */
$database_controller = new DatabaseController($pdo);

if (isset($_POST['start_date'])) {
    $table_columns = array(
        array('compliance_zones', 'description'));

    $bird_count = $database_controller->birdCountReport($_POST['start_date'], $_POST['end_date']);
    $total = $database_controller->birdGrandTotalReport($_POST['start_date'], $_POST['end_date']);
}

include 'includes/header.php';
include 'views/bird_count_report.html.php';
include 'includes/footer.php';

