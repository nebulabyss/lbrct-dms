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
        $_POST['row'][$counter] += ['zone' => $counter + 1];
        $counter++;
    }
    $form_processor = new FormProcessor($_POST);
    $form_processor->FormElementCleanUp();

    $batch_table = 'compliance_zones_batch';
    $db_table = 'compliance_zone_counts';
    $form_processor->ProcessForm($database_controller, $batch_table, $db_table, $allow_duplicate_batch);

    header('Location: ' . basename(__FILE__) );
    exit();
}

$table_columns = array(
    array('compliance_zones_2021', 'description'));

$zones = $database_controller->SelectColumn($table_columns[0]);

include 'includes/header.php';
include 'views/zone_count.html.php';
include 'includes/footer.php';

