<?php
require 'pdo.php';
session_start();
?>

<?php
require_once "./html/header.php";


$stmt = $pdo->prepare('SELECT description FROM compliance_zones');
$stmt->execute(array());
$zones = $stmt->fetchAll(PDO::FETCH_COLUMN );

?>

</head>
<body>
<div class="container-fluid">
    <?php require_once "./html/nav.php";?>
    <div>
        <h3 class="text-muted mt-2">Zone count</h3>
        <form>
            <div class="form-row mb-2">
                <div class="col-1">
                    <input type="text" class="form-control bg-warning text-dark" placeholder="Batch Date" id="datepicker" name="date" required>
                </div>
            </div>
            <fieldset disabled>
                    <div class="form-row font-weight-bold">
                        <label class="col-form-label d-inline-block" style="width: 250px;"></label>
                        <div class="col col-form-label">Boats in transit</div>
                        <div class="col col-form-label">Boats moored</div>
                        <div class="col col-form-label">Boats skiing</div>
                        <div class="col col-form-label">Boats fishing</div>
                        <div class="col col-form-label">Other</div>
                        <div class="col col-form-label">Shore anglers</div>
                        <div class="col col-form-label">Bait collectors</div>
                    </div>
                        <?php
                        $rowCount = 0;
                        foreach($zones as $k):
                        echo ('
                    <div class="form-row mb-2">
                        <label class="col-form-label d-inline-block" style="width: 250px;">' . $k . '</label>
                        <div class="col">
                            <input type="text" class="form-control" name="[row' . $rowCount . '][transit]" required>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" name="[row' . $rowCount . '][moored]" required>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" name="[row' . $rowCount . '][skiing]" required>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" name="[row' . $rowCount . '][fishing]" required>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" name="[row' . $rowCount . '][other]" required>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" name="[row' . $rowCount . '][angler]" required>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" name="[row' . $rowCount . '][bait]" required>
                        </div>
                    </div>
                    ');
                        $rowCount ++;
                        endforeach; ?>
                </div>
            </fieldset>
            <div class="float-right">
                <button type="button" class="btn btn-danger">Cancel</button>
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </form>
    <script>
        $(document).ready(function () {
            $('#datepicker').datepicker({
                dateFormat: "yy-mm-dd"
            });

            $('#datepicker').change(function () {
                $('fieldset').prop('disabled', false);
                $('input[name="[row0][transit]"]').focus();
            });
        });
    </script>
</div>

<?php require_once "./html/footer.php";?>
</body>

