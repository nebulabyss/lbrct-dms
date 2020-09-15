<?php
require 'pdo.php';
session_start();
?>

<?php
require_once "./html/header.php";

if (isset($_POST['row'])) {
    print("<pre>".print_r($_POST,true)."</pre>");
} else {
    if (isset($pdo)) {
        $stmt = $pdo->prepare('SELECT compliance_zones_id, description FROM compliance_zones');
        $stmt->execute(array());
        $zones = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

        $stmt = $pdo->prepare('SELECT transgression_id, section FROM transgression_types');
        $stmt->execute(array());
        $trans = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

        include 'boat_patrols.html.php';
        include 'html/footer.php';

    } else {
        echo 'Unable to connect to the database server';
        die();
    }
}
