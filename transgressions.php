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
    $boat_id = $_SESSION['TEMP']['boat_patrol_id'];
    for ($i = 0; $i < count($_POST['row']); $i++) {
        $_POST['row'][$i]['boat_patrol_id'] = $boat_id;
        $_POST['row'][$i]['user'] = $_SESSION['USER_ID'];
    }

    $form_processor = new FormProcessor($_POST);
    $form_processor->FormElementCleanUp();
    $form_processor->ProcessRows($database_controller, 'transgressions', 0);
    $database_controller->UpdateTransgression($boat_id);

    header('Location: ' . basename(__FILE__) );
    exit();

} elseif (isset($_GET['id'])) {
    $_SESSION['TEMP']['boat_patrol_id'] = $_GET['id'];
    $boat_trans = $database_controller->SelectBoatId($_GET['id']);
    $table_columns = array(
        array('transgression_types', 'transgression_id', 'section')
    );
    $trans = $database_controller->SelectKeyPairs($table_columns[0]);

} else {
    $table_columns = array(
        array('boat_patrol', 'boat_patrol_id', 'date', 'breede', 'licence', 'bname', 'samsa', 'size'));

    $boat_trans = $database_controller->SelectTransgressions($table_columns[0]);
}

include 'includes/header.php';
include 'views/transgressions.html.php';
include 'includes/footer.php';
