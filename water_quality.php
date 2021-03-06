<?php
include './includes/auth.php';
include 'pdo.php';
include 'classes/VuSituXHTML.php';
include 'classes/FormProcessor.php';
include 'classes/DatabaseController.php';

/**
 * @var $pdo
 */
$database_controller = new DatabaseController($pdo);
if (isset($_FILES['userfile'])) {
    $upload = new VuSituXHTML($_FILES);
    $wq_data = $upload->ParseXHTML();
    $_SESSION['TEMP']['wq_data'] = $wq_data;
    if (isset($_POST['override'])) $_SESSION['TEMP']['override'] = true;
}

if (isset($_POST['row'])) {
    $allow_duplicate_batch = false;
    if (isset($_SESSION['TEMP']['override'])) {
        $allow_duplicate_batch = true;
        unset($_SESSION['TEMP']['override']);
    }

    $marked = array_keys($_POST['row']);
    $form_processor = new FormProcessor($_SESSION['TEMP']['wq_data']);
    $form_processor->WQMarkedElementCleanUp($marked);

    $batch_table = 'water_quality_batch';
    $db_table = 'water_quality';
    $form_processor->ProcessForm($database_controller, $batch_table, $db_table, $allow_duplicate_batch);

    unset($_SESSION['TEMP']);
    header('Location: ' . basename(__FILE__));
    exit();
}

if (isset($_POST['wq']) && !isset($_POST['row'])) {
    $_SESSION['error_message'] = 'No rows marked';

    unset($_SESSION['TEMP']);
    header('Location: ' . basename(__FILE__));
    exit();
}
/*
 * Use an array of arrays.
 * The first element per array is the database table.
 * Subsequent elements are the relevant columns.
 */
if (empty($_POST)) {
    unset($_SESSION['TEMP']);
    $table_columns = array(
        array('water_quality_sites', 'id', 'description')
    );
    $sites = $database_controller->SelectKeyPairs($table_columns[0]);
}
include 'includes/header.php';
include 'views/water_quality.html.php';
include 'includes/footer.php';
