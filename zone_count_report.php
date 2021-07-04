<?php
include './includes/auth.php';
include 'pdo.php';
include 'classes/DatabaseController.php';

/**
 * @var $pdo
 */
$database_controller = new DatabaseController($pdo);
$title = 'Zone usage count report';
$form_action = basename(__FILE__);

if (isset($_POST['start_date'])) {
    if ($_POST['start_date'] <= "2021-06-30" && $_POST['end_date'] > "2021-06-30") {
        $report_error = 1;

    } elseif ($_POST['start_date'] > "2021-06-30") {
        $table_columns = array(
            array('compliance_zones_2021', 'description'));

        $zones = $database_controller->SelectColumn($table_columns[0]);
        $zone_count = $database_controller->zoneCountReportSum($_POST['start_date'], $_POST['end_date']);
        $zone_max_per_day = $database_controller->zoneCountReportMax($_POST['start_date'], $_POST['end_date']);

    } else {
        $table_columns = array(
            array('compliance_zones', 'description'));

        $zones = $database_controller->SelectColumn($table_columns[0]);
        $zone_count = $database_controller->zoneCountReportSum($_POST['start_date'], $_POST['end_date']);
        $zone_max_per_day = $database_controller->zoneCountReportMax($_POST['start_date'], $_POST['end_date']);
    }
}

include 'includes/header.php';
include 'views/zone_count_report.html.php';
include 'includes/footer.php';

