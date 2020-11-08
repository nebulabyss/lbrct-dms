<?php
include './includes/auth.php';
include 'pdo.php';
include 'classes/FormProcessor.php';
include 'classes/DatabaseController.php';

/**
 * @var $pdo
 */
$database_controller = new DatabaseController($pdo);

if (isset($_POST['row'])) {
    $allow_duplicate_batch = true;
    $counter = 0;
    while ($counter < count($_POST['row'])) {
        $_POST['row'][$counter] += ['wq_quality_site_id' => $counter + 1];
        $counter++;
    }

    $batch_table = 'water_quality_batch';
    $db_table = 'secchi_depth';
    $rowCount = 0;

    while ($rowCount < $counter) {
        $secchi_data = [];
        $secchi_data['date'] = $_POST['date'];
        $secchi_data['site'] = $_POST['row'][$rowCount]['wq_quality_site_id'];
        $secchi_data['row'][0] = $_POST['row'][$rowCount];

        $form_processor = new FormProcessor($secchi_data);
        $form_processor->FormElementCleanUp();
        $form_processor->ProcessForm($database_controller, $batch_table, $db_table, $allow_duplicate_batch);
        $rowCount++;
    }

    header('Location: ' . basename(__FILE__));
    exit();
}

$table_columns = array(
    array('water_quality_sites', 'description'));

$sites = $database_controller->SelectColumn($table_columns[0]);
$dates = $database_controller->WaterQualityDates();

include 'includes/header.php';
include 'views/secchi_depth.html.php';
include 'includes/footer.php';

