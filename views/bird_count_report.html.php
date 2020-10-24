<body>
<div class="container-fluid">
    <?php require_once "./includes/nav.php"; ?>
    <h3 class="text-muted mt-2">Bird count report</h3>
    <form action="../bird_count_report.php" method="post">
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
                <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                <?php include './includes/cancel_button.php' ?>
            </div>
        </div>
    </form>
    <?php if (isset($bird_count) && $bird_count == false): ?>
        <div>
            <h4 class="text-danger mt-5 text-center">No records for selected dates.</h4>
        </div>
    <?php elseif (!empty($_POST)): ?>
    <div class="table-responsive">
        <table class="table table-sm table-bordered mt-3" id="data-table">
            <thead class="thead-light">
            <tr>
                <th>Species</th>
                <th>Count</th>
                <th>&#37;</th>
            </tr>
            </thead>
            <tbody id="clipboard">
                    <?php
                    foreach ($bird_count as $k => $v) {
                        echo '<tr>';
                        echo '<td>' . $k . '</td>';
                        echo '<td>' . $v . '</td>';
                        echo '<td>' . round($v / $total[0], 4) * 100 . '&#37;</td>';
                        echo '</tr>';
                    }
                    ?>
                    <tr class="font-weight-bolder">
                        <td>Total</td>
                        <td><?=$total[0]?></td>
                        <td>100&#37;</td>
                    </tr>
            </tbody>
        </table>
        <?php include './includes/report_buttons.php'?>
        <?php endif; ?>
    </div>
</div>
<script>
    <?php include './js/clipboard.js.php'?>
    <?php include './js/report.js.php'?>
    <?php include './js/csv.js.php'?>
</script>
