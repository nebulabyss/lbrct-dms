<body>
<div class="container-fluid">
    <?php require_once "./includes/nav.php"; ?>
    <h3 class="text-muted mt-2">Slipway inspection report</h3>
    <form action="../slipway_patrol_report.php" method="post">
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
    <?php if (isset($recreational) && $recreational[0][0] == false): ?>
        <div>
            <h4 class="text-danger mt-5 text-center">No records for selected dates.</h4>
        </div>
    <?php elseif (!empty($_POST)): ?>
    <div class="table-responsive">
        <table class="table table-sm table-bordered mt-3">
            <thead class="thead-light">
            <tr>
                <th>Type of inspection</th>
                <th>Number of boats inspected</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Recreational river boats</td>
                <?php
                if (isset($recreational)) {
                    echo '<td>' . $recreational[0][0] . '</td>';
                }
                ?>
            </tr>
            <tr>
                <td>Commercial boats</td>
                <?php
                if (isset($commercial)) {
                    echo '<td>' . $commercial[0][0] . '</td>';
                }
                ?>
            </tr>
            </tbody>
        </table>
        <button type="button" class="btn btn-success float-right" id="submit">Export as CSV</button>
        <?php endif; ?>
    </div>
</div>
<script>
    <?php include './js/report.js.php'?>
</script>
