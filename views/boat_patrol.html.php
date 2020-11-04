<body>
<div class="container-fluid">
<?php include "includes/nav.php";?>
<h3 class="text-muted mt-2">Boat patrols</h3>
    <form action="./boat_patrol.php" method="post">
        <div class="form-row mb-2">
            <?php include './includes/date_picker.php' ?>
            <fieldset class="form-row" disabled>
                <div class="col">
                    <label for="next" class="col-form-label">Start Time:</label>
                </div>
                <div class="col">
                    <input type="time" class="form-control bg-warning" id="next" value="08:00" name="start_time" required>
                </div>
                <div>
                    <label for="end_time" class="col-form-label">End Time:</label>
                </div>
                <div class="col">
                    <input type="time" class="form-control bg-warning" id="end_time" value="16:00" name="end_time" required>
                </div>
            </fieldset>
        </div>
        <fieldset disabled>
            <div class="form-body">

            </div>
        </fieldset>
        <?php include './includes/remove_row_botton.php'?>
        <div class="float-right">
            <?php include './includes/cancel_button.php'?>
            <button type="submit" class="btn btn-success" id="submit">Submit</button>
        </div>
    </form>
</div>
<script>
    <?php include './js/form_variables.js.php'?>
    function generateFormRow(rc, ln) {
        formHtml = '<div class="form-row mb-2" id="row' + rowCount + '"> \
                   <label class="col-form-label d-inline-block text-center" style="width: 30px;">' + ln + '</label> \
                      <div class="col"> \
                    <select class="form-control custom-select validate" name="row[' + rc + '][zone]" id="zone"><option selected value="">Zone</option> \ <?php
            if (isset($zones)) {
                foreach ($zones as $k => $v):
                    echo('<option value="' . $k . '">' . $v . '</option>');
                endforeach;
            }
            ?> </select> \
                </div> \
                  <div> \
                  <input id="c_name" type="text" class="form-control validate" placeholder="Breede Reg." maxlength="5" name="row[' + rc + '][breede]"> \
                  </div> \
                  <div class="col"> \
                    <input type="text" class="form-control validate" placeholder="Licence No." maxlength="4" name="row[' + rc + '][licence]"> \
                  </div> \
                  <div class="col"> \
                    <input type="text" class="form-control validate" placeholder="SAMSA" maxlength="20" name="row[' + rc + '][samsa]"> \
                  </div> \
                  <div class="col"> \
                    <input type="text" class="form-control validate" placeholder="Boat Name" maxlength="30" name="row[' + rc + '][bname]"> \
                  </div> \
                  <div class="col"> \
                    <input type="text" class="form-control validate" placeholder="Engine size" maxlength="3" name="row[' + rc + '][size]"> \
                  </div> \
                  <div class="form-check my-auto ml-2 mr-1"> \
                  <input class="form-check-input big-checkbox  validate" type="checkbox" id="twin" name="row[' + rc + '][twin]"> \
                  <label class="form-check-label font-weight-bold ml-1" for="twin">Twin</label> \
                  </div> \
                  <div class="form-check my-auto ml-2 mr-1"> \
                  <input class="form-check-input big-checkbox validate" type="checkbox" id="trans" name="row[' + rc + '][trans]"> \
                  <label class="form-check-label font-weight-bold ml-1" for="trans">Transgression</label> \
                  </div> \
                </div>'
        return formHtml;
    }
    <?php include './js/form.js.php'?>
    <?php include './js/date.js.php'?>
    <?php include './js/last_row_validate.js.php'?>
</script>