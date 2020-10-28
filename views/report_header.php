<body>
<div class="container-fluid">
    <?php require_once "./includes/nav.php"; ?>
    <h3 class="text-muted mt-2"><?= $title ?></h3>
    <form action="./<?= $form_action ?>" method="post">
        <div class="form-row">
            <div class="form-inline">
                <label for="start_date" class="col-form-label col text-muted">Date Range</label>
                <div class="input-group">
                    <input type="text" class="form-control datepicker" placeholder="From date"
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
            <div class="form-inline ml-lg-n3">
                <label for="end_date" class="col-form-label col ui-helper-hidden"></label>
                <div class="input-group">
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
                    <div class="form-check ml-3 my-2">
                        <input class="form-check-input big-checkbox"
                               type="checkbox" id="chart_checkbox" name="chart_checkbox">
                        <label class="form-check-label ml-2" for="chart_checkbox">Show chart</label>
                    </div>
                    <div class="form-check pl-3 my-2">
                        <input class="form-check-input big-checkbox"
                               type="checkbox"<?php if (isset($_POST['newsletter']) && $_POST['newsletter'] === 'on'): ?>
                               checked <?php endif; ?>id="newsletter" name="newsletter">
                        <label class="form-check-label ml-2" for="newsletter">Newsletter chart table</label>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </form>
