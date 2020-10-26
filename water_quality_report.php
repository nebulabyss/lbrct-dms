<?php
include 'pdo.php';
include 'classes/DatabaseController.php';
session_start();

/**
 * @var $pdo
 */
$database_controller = new DatabaseController($pdo);
$title = 'Zone usage count report';
$form_action = basename(__FILE__);

if (isset($_POST['start_date'])) {
    $table_columns = array(
        array('compliance_zones', 'description'));

    $water_quality = $database_controller->WaterQuality($_POST['start_date'], $_POST['end_date']);
}

include 'includes/header.php';
include 'views/water_quality_report.html.php';
include 'includes/footer.php';

