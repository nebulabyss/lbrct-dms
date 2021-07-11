<?php
include './includes/auth.php';
include 'pdo.php';
include 'classes/DatabaseController.php';

/**
 * @var $pdo
 */
$database_controller = new DatabaseController($pdo);
$title = 'Area usage pressure';
$form_action = basename(__FILE__);

if (isset($_POST['start_date'])) {
    if ($_POST['start_date'] <= "2021-06-30") {
        $report_error = 1;

    } else {
        $table_rows = array(
            array('compliance_zones_2021', 'description'));

        $areas = $database_controller->SelectColumn($table_rows[0]);
        $area_count = array();
        for ($i = 1; $i < count($areas) + 1; $i++) {
            $area_count[] = $database_controller->areaCountReportSum($_POST['start_date'], $_POST['end_date'], $i);
        }
    }
}

include 'includes/header.php';
include 'views/area_count_report.html.php';
include 'includes/footer.php';

