<body>
<div class="container-fluid">
    <?php require_once "./includes/nav.php";?>
        <h3 class="text-muted mt-2">Zone usage count report</h3>
        <form action="../zone_count_report.php" method="post">
            <div class="form-row form-row">
                <div class="form-inline">
                    <label for="start_date" class="col-form-label col">From</label>
                    <input type="text" class="form-control datepicker" placeholder="From date" id="start_date" name="start_date" <?php if (isset($_POST['start_date'])) {
                        echo "value=\"" . $_POST["start_date"] . "\" ";} ?>required>
                </div>
                <div class="form-inline">
                    <label for="end_date" class="col-form-label col">To</label>
                    <input type="text" class="form-control datepicker" placeholder="To date" id="end_date" name="end_date" <?php if (isset($_POST['end_date'])) {
                        echo "value=\"" . $_POST["end_date"] . "\" ";} ?>required>
                </div>
                <div class="ml-3">
                    <button type="submit" class="btn btn-info" id="submit">Submit</button>
                    <?php include './includes/cancel_button.php'?>
                </div>
            </div>
        </form>
    <?php if (!empty($_POST)):?>
    <div class="table-responsive">
                <table class="table table-sm table-bordered mt-3">
                    <thead>
                    <tr>
                        <th>Area</th>
                        <th>Boats in transit</th>
                        <th>Boats moored</th>
                        <th>Boats skiing</th>
                        <th>Boats fishing</th>
                        <th>Other</th>
                        <th>Shore anglers</th>
                        <th>Bait collectors</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($zones)) {
                            $counter = 0;
                            while ($counter < count($zones)) {
                                echo '<tr><td>' . $zones[$counter] . '</td>';
                                if (isset($zone_count)) {
                                    foreach ($zone_count[$counter] as $k => $v){
                                        echo '<td>' . $v . '</td>';
                                    }
                                }
                                echo '</tr>';
                                $counter++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
    <?php endif;?>
    </div>
    <button type="button" class="btn btn-success float-right" id="submit">Export as CSV</button>
</div>
<script>
    <?php include './js/date_report.js.php'?>
</script>
