<body>
<div class="container-fluid">
    <?php require_once "./includes/nav.php"; ?>
    <h3 class="text-muted mt-2">Zone usage count</h3>
    <form action="./secchi_depth.php" method="post">
        <div class="form-row">
            <div class="col-auto">
                <div class="input-group">
                    <label for="datepicker" class="ui-helper-hidden"></label>
                    <select class="form-control custom-select bg-warning" id="datepicker" name="date" required>
                        <option selected value="">Select date</option>
                        <?php
                        if (isset($dates)) {
                            foreach ($dates as $k => $v):
                                echo('<option value="' . $v . '">' . $v . '</option>');
                            endforeach;
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <fieldset>
            <div class="mt-3">
            <?php
            $rowCount = 0;
            if (isset($sites)) {
                foreach ($sites as $k):
                    echo('                    
                        <div class="form-row mb-1" id="validationBlock">
                            <label class="col-form-label d-inline-block" style="width: 250px;">' . $k . '</label>
                            <div class="col-1">
                                <input type="text" id="next" class="form-control validate" name="row[' . $rowCount . '][depth]">
                            </div>
                        </div>
                        ');
                    $rowCount++;
                endforeach;
            } ?>
                </div>
        </fieldset>
        <div class="float-right">
            <?php include './includes/cancel_button.php' ?>
            <button type="submit" class="btn btn-success" id="submit">Submit</button>
        </div>
    </form>
</div>
<script>
    <?php include './js/zone_count_validate.js.php'?>
</script>
