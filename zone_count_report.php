<?php
include 'pdo.php';
include 'classes/DatabaseController.php';
session_start();

/**
 * @var $pdo
 */
$database_controller = new DatabaseController($pdo);
$title = 'Zone usage count report';
if (isset($_POST['start_date'])) {
    $table_columns = array(
        array('compliance_zones', 'description'));

    $zones = $database_controller->SelectColumn($table_columns[0]);
    $zone_count = $database_controller->zoneCountReportSum($_POST['start_date'], $_POST['end_date']);
    $zone_max_per_day = $database_controller->zoneCountReportMax($_POST['start_date'], $_POST['end_date']);
}

include 'includes/header.php';
include 'views/zone_count_report.html.php';
include 'includes/footer.php';

