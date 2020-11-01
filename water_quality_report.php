<?php
include './includes/auth.php';
include 'pdo.php';
include 'classes/DatabaseController.php';

/**
 * @var $pdo
 */
$database_controller = new DatabaseController($pdo);
$title = 'Water quality report';
$form_action = basename(__FILE__);
$no_dates = false;

if (isset($_POST['start_date'])) {
    $table_columns = array(
        array('compliance_zones', 'description'));

    $water_quality = $database_controller->WaterQuality($_POST['start_date'], $_POST['end_date']);
    $no_dates = $water_quality;
}

include 'includes/header.php';
include 'views/water_quality_report.html.php';
include 'includes/footer.php';

