<?php
include 'pdo.php';
include 'classes/DatabaseController.php';
session_start();

/**
 * @var $pdo
 */
$database_controller = new DatabaseController($pdo);
$title = 'Boat patrol report';
if (isset($_POST['start_date'])) {
    $table_columns = array(
        array('compliance_zones', 'description'));

    $patrols = $database_controller->boatPatrolReport($_POST['start_date'], $_POST['end_date']);
}

include 'includes/header.php';
include 'views/boat_patrol_report.html.php';
include 'includes/footer.php';