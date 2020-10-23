<body>
<div class="container-fluid">
    <?php require_once "./includes/nav.php"; ?>
    <h3 class="text-muted mt-2">Zone usage count report</h3>
    <form action="../zone_count_report.php" method="post">
        <div class="form-row form-row">
            <div class="form-inline">
                <label for="start_date" class="col-form-label col">From</label>
                <input type="text" class="form-control datepicker" placeholder="From date" id="start_date"
                       name="start_date" <?php if (isset($_POST['start_date'])) {
                    echo "value=\"" . $_POST["start_date"] . "\" ";
                } ?>required>
            </div>
            <div class="form-inline">
                <label for="end_date" class="col-form-label col">To</label>
                <input type="text" class="form-control datepicker" placeholder="To date" id="end_date" name="end_date"
                       <?php if (isset($_POST['end_date'])) {
                           echo "value=\"" . $_POST["end_date"] . "\" ";
                       } ?>required>
            </div>
            <div class="ml-3">
                <button type="submit" class="btn btn-info" id="submit">Submit</button>
                <?php include './includes/cancel_button.php' ?>
            </div>
        </div>
    </form>
    <?php if (isset($zone_count) && $zone_count[0][0] == false): ?>
        <div>
            <h4 class="text-danger mt-5 text-center">No records for selected dates.</h4>
        </div>
    <?php elseif (!empty($_POST)): ?>
    <div class="table-responsive">
        <table class="table table-sm table-bordered mt-3">
            <thead class="thead-light">
            <tr>
                <th>Recreational activity</th>
                <th>Total count</th>
                <th>Peak number of users per day</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $row_names = array('Boats in transit', 'Boats at mooring', 'Boats skiing', 'Boats fishing', 'Non-motorized water sport (Kite surfing, sailing)', 'Shore anglers', 'Bait collectors');
            $counter = 0;
            while ($counter < count($row_names)) {
                echo '<tr><td>' . $row_names[$counter] . '</td>';
                echo '<td>' . $zone_count[0][$counter] . '</td>';
                echo '<td>' . $zone_max_per_day[0][$counter] . '</td>';
                $counter++;
            }
            echo '</tr>';
            ?>
            </tbody>
        </table>

        <button type="button" class="btn btn-success float-right" id="submit">Export as CSV</button>
        <?php endif; ?>
    </div>
</div>
<script>
    <?php include './js/report.js.php'?>
</script>
