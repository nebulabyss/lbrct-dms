<body>
<div class="container-fluid">
    <?php require_once "./includes/nav.php"; ?>
    <h3 class="text-muted mt-2"><?= $title ?></h3>
    <form action="../zone_count_report.php" method="post">
        <div class="form-row form-row">
            <div class="form-inline">
                <label for="start_date" class="col-form-label col">From</label>
                <input type="text" class="form-control datepicker" placeholder="From date" id="start_date"
                       name="start_date" <?php if (isset($_POST['start_date'])) {
                    echo "value=\"" . $_POST["start_date"] . "\" ";
                } else {
                    echo "value=\"" . date('Y-m-d', strtotime("first day of -1 month")) . "\" ";
                }?>required>
            </div>
            <div class="form-inline">
                <label for="end_date" class="col-form-label col">To</label>
                <input type="text" class="form-control datepicker" placeholder="To date" id="end_date" name="end_date"
                       <?php if (isset($_POST['end_date'])) {
                           echo "value=\"" . $_POST["end_date"] . "\" ";
                       } else {
                           echo "value=\"" . date('Y-m-d', strtotime("last day of -1 month")) . "\" ";
                       } ?>required>
            </div>
            <div class="ml-3">
                <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                <?php include './includes/cancel_button.php' ?>
            </div>
        </div>
    </form>