<?php
include 'pdo.php';
include 'classes/WQFormProcessor.php';
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
        $row = [];
        $counter = 0;
        foreach ($tr->getElementsByTagName("td") as $td) {
            if ($counter == 0) {
                // $pieces = explode(' ', trim($td->textContent));
                $string = trim($td->textContent);
                $token = strpos($string, ' ');
                $row[$keys[$counter]] = substr($string, $token);
                $counter++;
                continue;
            }
            $row[$keys[$counter]] = trim($td->textContent);
            $counter++;
        }
        $wq_data[] = $row;

    }
    $_SESSION['date'] = $_POST['date'];
    $_SESSION['site'] = $_POST['site'];
    $_SESSION['wq_data'] = $wq_data;

    unlink($uploadfile);

} elseif (isset($_POST['row'])) {
    $counter = 0;
    while ($counter < count($_SESSION['wq_data'])) {
        $_SESSION['wq_data'][$counter]['marked'] = NULL;
        $counter++;
    }

    $marked = array_keys($_POST['row']);
    foreach ($marked as $key) {
        $_SESSION['wq_data'][$key]['marked'] = 1;
    }

    $batch_table = 'water_quality_batch';
    $db_table = 'water_quality';
    $WQform_processor = new WQFormProcessor($_SESSION);
    $WQform_processor->WQprocessForm($database_controller, $batch_table, $db_table);

    unset($_SESSION['wq_data']);
    unset($_SESSION['site']);
    unset($_POST['row']);

}
/*
 * Use an array of arrays.
 * The first element per array is the database table.
 * Subsequent elements are the relevant columns.
 */
if(empty($_POST) && empty($_FILES)) {
    $table_columns = array(
        array('water_quality_sites', 'id', 'description')
    );
    $sites = $database_controller->SelectKeyPairs($table_columns[0]);
}
include 'includes/header.php';
include 'views/water_quality.html.php';
include 'includes/footer.php';
