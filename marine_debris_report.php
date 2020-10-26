<?php
include 'pdo.php';
include 'classes/DatabaseController.php';
session_start();

/**
 * @var $pdo
 */
$database_controller = new DatabaseController($pdo);
$title = 'Marine debris report';
$form_action = basename(__FILE__);

if (isset($_POST['start_date'])) {
    $table_columns = array(
        array('compliance_zones', 'description'));

    $debris_count = $database_controller->MarineDebrisCountReport($_POST['start_date'], $_POST['end_date']);
    $total = $database_controller->MarineDebrisGrandTotalReport($_POST['start_date'], $_POST['end_date']);
}

include 'includes/header.php';
include 'views/marine_debris_report.html.php';
include 'includes/footer.php';

