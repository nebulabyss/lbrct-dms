<?php
$currentYear = date("Y");
$currentMonth = date("m");
$previousYear = $currentYear - 1;
$currentFinYearStart = 0;
$currentFinYearEnd = 0;
$previousFinYearStart = 0;
$previousFinYearEnd = 0;

if ($currentMonth >= 7) {
    $currentFinYearStart = $currentYear;
    $currentFinYearEnd = $currentYear + 1;
    $previousFinYearStart = $currentYear - 1;
    $previousFinYearEnd = $currentYear;
}

if ($currentMonth <= 6) {
    $currentFinYearStart = $currentYear - 1;
    $currentFinYearEnd = $currentYear;
    $previousFinYearStart = $currentYear - 2;
    $previousFinYearEnd = $currentYear - 1;
}
?>
<body>
<div class="container-fluid">
    <?php require_once "./includes/nav.php"; ?>
    <h3 class="text-muted mt-2"><?= $title ?></h3>
    <form action="./<?= $form_action ?>" method="post">
        <div class="form-row">
            <div class="form-inline">
                <label for="range-selector" class="col-form-label text-muted ui-helper-hidden"></label>
                <div id="range-selector">
                    <select class="form-control custom-select mr-3 col-auto" id="range-options">
                        <option selected value="">Select date range</option>
                        <option value="0">Q1: July to September <?= $currentFinYearStart ?></option>
                        <option value="1">Q2: October to December <?= $currentFinYearStart ?></option>
                        <option value="2">Q3: January to March <?= $currentFinYearEnd ?></option>
                        <option value="3">Q4: April to July <?= $currentFinYearEnd ?></option>
                        <option value="4">Current Financial Year: <?= $currentFinYearStart ?>
                            - <?= $currentFinYearEnd ?></option>
                        <option value="5">Previous Financial Year: <?= $previousFinYearStart ?>
                            - <?= $previousFinYearEnd ?></option>
                    </select>
                </div>
                <div class="input-group start_date">
                    <input type="text" class="form-control start_datepicker ml-n1" placeholder="From date"
                           name="start_date" <?php if (isset($_POST['start_date'])) {
                        echo "value=\"" . $_POST["start_date"] . "\" ";
                    } else {
                        echo "value=\"" . date('Y-m-01') . "\" ";
                    } ?> id="start_date" required>
                    <div class="input-group-append" id="start">
                        <button class="input-group-text btn btn-outline-secondary" type="button">
                            <svg width="1.3em" height="1.3em" viewBox="0 0 16 16"
                                 class="bi bi-calendar4" fill="currentColor"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v1h14V3a1 1 0 0 0-1-1H2zm13 3H1v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V5z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="form-inline ml-n3">
                <label for="end_date" class="col-form-label col ui-helper-hidden"></label>
                <div class="input-group end_date">
                    <input type="text" class="form-control datepicker" placeholder="To date"
                           name="end_date" <?php if (isset($_POST['end_date'])) {
                        echo "value=\"" . $_POST["end_date"] . "\" ";
                    } else {
                        echo "value=\"" . date('Y-m-t') . "\" ";
                    } ?> id="end_date" required>
                    <div class="input-group-append" id="end">
                        <button class="input-group-text btn btn-outline-secondary" type="button">
                            <svg width="1.3em" height="1.3em" viewBox="0 0 16 16"
                                 class="bi bi-calendar4" fill="currentColor"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v1h14V3a1 1 0 0 0-1-1H2zm13 3H1v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V5z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="form-inline ml-2">
                <div class="ml-2">
                    <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                    <?php include './includes/cancel_button.php' ?>
                </div>
                <?php if (isset($newsletter_option)): ?>
                    <div>
                        <select class="form-control custom-select col-auto ml-3" name="chart-type"
                                id="chart-type"<?php if ($no_dates == false || !isset($_POST['start_date'])) {
                            echo ' disabled';
                        } ?>>
                            <option selected value="">Select chart</option>
                            <option value="0">Salinity</option>
                            <option value="1">Temperature</option>
                        </select>
                    </div>
                    <div class="form-check ml-3 my-2">
                        <input class="form-check-input big-checkbox"
                               type="checkbox" id="chart_checkbox" name="chart_checkbox" disabled>
                        <label class="form-check-label ml-2" for="chart_checkbox">Show chart</label>
                    </div>
                    <div class="form-check ml-3 my-2">
                        <input class="form-check-input big-checkbox"
                               type="checkbox"<?php if (isset($_POST['newsletter']) && $_POST['newsletter'] === 'on'): ?>
                               checked <?php endif; ?>id="newsletter" name="newsletter">
                        <label class="form-check-label ml-2" for="newsletter">Newsletter chart table</label>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </form>
