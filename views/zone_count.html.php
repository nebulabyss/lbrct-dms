<body>
<div class="container-fluid">
    <?php require_once "./includes/nav.php";?>
        <h3 class="text-muted mt-2">Zone usage count</h3>
        <form action="../zone_count.php" method="post">
            <div class="form-row">
                <div class="col-1">
                    <label for="datepicker" class="ui-helper-hidden"></label>
                    <input type="text" class="form-control bg-warning text-dark" placeholder="Batch Date" id="datepicker" name="date" required>
                </div>
            </div>
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
                <fieldset disabled>
                <?php
                $rowCount = 0;
                if (isset($zones)) {
                    foreach($zones as $k):
                        echo ('                    
                        <div class="form-row mb-2" id="validationBlock">
                            <label class="col-form-label d-inline-block" style="width: 250px;">' . $k . '</label>
                            <div class="col">
                                <input type="number" id="next" class="form-control validate" name="row[' . $rowCount . '][transit]">
                            </div>
                            <div class="col">
                                <input type="number" class="form-control validate" name="row[' . $rowCount . '][moored]">
                            </div>
                            <div class="col">
                                <input type="number" class="form-control validate" name="row[' . $rowCount . '][skiing]">
                            </div>
                            <div class="col">
                                <input type="number" class="form-control validate" name="row[' . $rowCount . '][fishing]">
                            </div>
                            <div class="col">
                                <input type="number" class="form-control validate" name="row[' . $rowCount . '][other]">
                            </div>
                            <div class="col">
                                <input type="number" class="form-control validate" name="row[' . $rowCount . '][angler]">
                            </div>
                            <div class="col">
                                <input type="number" class="form-control validate" name="row[' . $rowCount . '][bait]">
                            </div>
                        </div>
                        ');
                        $rowCount ++;
                    endforeach;
                } ?>
                </fieldset>
            <div class="float-right">
            <?php include './includes/cancel_button.php'?>
            <button type="submit" class="btn btn-success" id="submit">Submit</button>
            </div>
        </form>
</div>
<script>
    <?php include './js/date.js.php'?>
    <?php include './js/area_count_validate.js.php'?>
</script>
