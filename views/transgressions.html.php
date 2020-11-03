<body>
<div class="container-fluid">
    <?php require_once "./includes/nav.php"; ?>
    <?php if ($boat_trans == false): ?>
        <div>
            <h4 class="text-success mt-5 text-center">All transgressions processed</h4>
        </div>
    <?php elseif (isset($_GET['id'])): ?>
        <h3 class="text-muted mt-2">Process transgression</h3>
        <table class="table table-striped table-sm col-6">
            <thead>
            <tr>
                <th>Date</th>
                <th>Breede</th>
                <th>Licence</th>
                <th>Boat name</th>
                <th>SAMSA</th>
                <th>Size</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (isset($boat_trans)) {
                for ($i = 0;
                     $i < count($boat_trans);
                     $i++) {
                    echo '<tr>';
                    foreach ($boat_trans[$i] as $k => $v) {
                        if ($k == 'boat_patrol_id') {
                            continue;
                        } else {
                            echo '<td class="align-middle">' . $v . '</td>';
                        }
                    }
                }
            }
            ?>
            </tbody>
        </table>
        <form action="./transgressions.php" method="post">
            <div class="form-row mb-2">
            </div>
            <fieldset>
                <div class="form-body">

                </div>
            </fieldset>
            <?php include './includes/remove_row_botton.php' ?>
            <div class="float-right">
                <?php include './includes/cancel_button.php' ?>
                <button type="submit" class="btn btn-success" id="submit">Submit</button>
            </div>
        </form>
        <script>
            <?php include './js/form_variables.js.php'?>
            function generateFormRow(rc, ln) {
                formHtml = '<div class="form-row mb-2 col-4" id="row' + rowCount + '"> \
                <div class="form-check my-auto ml-2 mr-1"> \
                  <input class="form-check-input big-checkbox validate" type="checkbox" id="warning" name="row[' + rc + '][warning]"> \
                  <label class="form-check-label font-weight-bold ml-1" for="warning">Warning</label> \
                  </div> \
                 <div class="form-check my-auto ml-2 mr-1"> \
                  <input class="form-check-input big-checkbox validate" type="checkbox" id="fine" name="row[' + rc + '][fine]"> \
                  <label class="form-check-label font-weight-bold ml-1" for="fine">Fine</label> \
                  </div> \
                <div class="col"> \
            <select class="form-control custom-select validate" name="row[' + rc + '][trans_type]" id="final" required><option selected value="">Transgression</option> \ <?php
                    if (isset($trans)) {
                        foreach ($trans as $k => $v):
                            echo('<option value="' . $k . '">' . $v . '</option>');
                        endforeach;
                    }
                    ?> </select> \
        </div> \
    </div>'

                return formHtml;
            }
            <?php include './js/form.js.php' ?>
            <?php include './js/toggle.js.php' ?>
            <?php include './js/last_row_validate.js.php' ?>
        </script>
    <?php else: ?>
        <h3 class="text-muted mt-2">Transgressions</h3>
        <table class="table table-striped table-sm col-6">
            <thead>
            <tr>
                <th></th>
                <th>Date</th>
                <th>Breede</th>
                <th>Licence</th>
                <th>Boat name</th>
                <th>SAMSA</th>
                <th>Size</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (isset($boat_trans)) {
                for ($i = 0; $i < count($boat_trans); $i++) {
                    echo '<tr>';
                    foreach ($boat_trans[$i] as $k => $v) {
                        if ($k == 'boat_patrol_id') {
                            echo '<td>' . '<a type="button" class="btn btn-info" id="process" href="./transgressions.php?id=' . $v . '">Process</a>' . '</td>';
                        } else {
                            echo '<td class="align-middle">' . $v . '</td>';
                        }
                    }
                    echo '</tr>';
                }
            }
            ?>
            </tbody>
        </table>
        <div class="float-right mb-3">
            <?php include './includes/cancel_button.php' ?>
        </div>
    <?php endif ?>
</div>