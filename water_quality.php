<?php
include 'pdo.php';
include 'classes/FormProcessor.php';
include 'classes/DatabaseController.php';
session_start();

/**
 * @var $pdo
 */
$database_controller = new DatabaseController($pdo);

if (isset($_FILES['userfile'])) {
    $uploaddir = __DIR__ . '/uploads/';
    $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

    move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);

    $dom = new DomDocument();
    $dom->loadHTMLFile($uploadfile, LIBXML_NOERROR);

    $wq_data = array();
    $keys = array('time', 'rdocon', 'rdosat', 'temp', 'cond', 'sal', 'depth', 'ph', 'marked');
    $finder = new DomXPath($dom);
    $classnames = ['data', 'data-marked'];

    $trList = $dom->getElementsByTagName('tr');
    $trList = $finder->query("//tr[contains(concat(' ', normalize-space(@class), ' '), ' $classnames[0] ') or contains(concat(' ', normalize-space(@class), ' '), ' $classnames[1] ')]");

    foreach ($trList as $tr) {
        $row = ['site' => $_POST['site']];
        $counter = 0;
        foreach ($tr->getElementsByTagName("td") as $td) {
            $string = trim($td->textContent);
            if ($counter == 0) {
                $token = strpos($string, ' ');
                if (!isset($wq_data['date'])) {
                    $wq_data['date'] = substr($string, 0, $token);
                }
                $row[$keys[$counter]] = substr($string, $token);
                $counter++;
                continue;
            }

            if ($string == '') $string = NULL;
            if ($string == 'Marked') $string = 1;

            $row[$keys[$counter]] = $string;
            $counter++;
        }
        $wq_data['row'][] = $row;

    }

    $_SESSION['wq_data'] = $wq_data;
    unlink($uploadfile);

} elseif (isset($_POST['row'])) {
    $marked = array_keys($_POST['row']);
    $form_processor = new FormProcessor($_SESSION['wq_data']);
    $form_processor->WQMarkedElementCleanUp($marked);

    $batch_table = 'water_quality_batch';
    $db_table = 'water_quality';

    $form_processor->ProcessForm($database_controller, $batch_table, $db_table);

    unset($_SESSION['wq_data']);
    unset($_POST['row']);
}
/*
 * Use an array of arrays.
 * The first element per array is the database table.
 * Subsequent elements are the relevant columns.
 */
if (empty($_POST) && empty($_FILES)) {
    $table_columns = array(
        array('water_quality_sites', 'id', 'description')
    );
    $sites = $database_controller->SelectKeyPairs($table_columns[0]);
}
include 'includes/header.php';
include 'views/water_quality.html.php';
include 'includes/footer.php';
