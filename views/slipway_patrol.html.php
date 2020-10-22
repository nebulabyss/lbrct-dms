<body>
<div class="container-fluid">
    <?php include "includes/nav.php";?>
    <div>
        <h3 class="text-muted mt-2">Slipway inspection</h3>
        <form action="../slipway_patrol.php" method="post">
            <div class="form-row mb-2">
                <div class="col-1">
                    <label for="datepicker" class="ui-helper-hidden"></label>
                    <input type="text" class="form-control bg-warning" placeholder="Batch Date" id="datepicker" name="date" required>
                </div>
                <fieldset class="form-row" disabled>
                 <div class="col">
                     <label for="next" class="ui-helper-hidden"></label>
                     <select class="form-control custom-select bg-warning" name="slipway" id="next" required><option selected value="">Slipway</option>
                            <?php
                            if (isset($slipways)) {
                                foreach($slipways as $k => $v):
                                    echo ('<option value="' . $k . '">' . $v . '</option>');
                                endforeach;
                            }
                            ?>
                     </select>
                 </div>
                    <div>
                        <label for="start_time" class="col-form-label">Start Time:</label>
                    </div>
                    <div class="col">
                        <input type="time" class="form-control bg-warning" id="start_time" value="08:00" name="start_time" required>
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
                      <div class=""> \
                        <label for="time" class="col col-form-label font-weight-bold">Time:</label> \
                      </div> \
                      <div class="col-auto"> \
                        <input type="time" class="form-control validate" name="row[' + rc + '][time]"> \
                      </div> \
                      <div class="col"> \
                      <select class="form-control custom-select validate" name="row[' + rc + '][activity]"><option selected value="">Activity</option> \ <?php
                        if (isset($activity)) {
                            foreach ($activity as $k => $v):
                                echo('<option value="' . $k . '">' . $v . '</option>');
                            endforeach;
                        }
                ?> </select> \
                        </div> \
                      <div class="col"> \
                        <input type="text" class="form-control validate" placeholder="Vehicle Reg." name="row[' + rc + '][vreg]"> \
                      </div> \
                      <div class="col"> \
                        <input type="text" class="form-control validate" placeholder="Trailer Reg." name="row[' + rc + '][treg]"> \
                      </div> \
                      <div class="col"> \
                        <input type="text" class="form-control validate" placeholder="SAMSA" name="row[' + rc + '][samsa]"> \
                      </div> \
                      <div class="col"> \
                        <input type="text" class="form-control validate" placeholder="Boat Name" name="row[' + rc + '][bname]"> \
                      </div> \
                      <div class="col"> \
                        <input type="text" class="form-control validate" placeholder="Engine size" name="row[' + rc + '][size]"> \
                      </div> \
                      <div class="form-check my-auto ml-2 mr-1"> \
                        <input class="form-check-input big-checkbox validate" type="checkbox" id="gridCheck" name="row[' + rc + '][twin]"> \
                        <label class="form-check-label font-weight-bold ml-1" for="gridCheck">Twin</label> \
                      </div> \
                      <div class="col"> \
                        <input type="text" class="form-control validate" placeholder="Licence No." name="row[' + rc + '][licence]"> \
                      </div> \
                      <div class="col"> \
                        <input type="text" id="final" class="form-control validate" placeholder="Breede No." name="row[' + rc + '][breede]"> \
                      </div> \
            </div>'
            return formHtml;
        }
        <?php include './js/form.js.php'?>
        <?php include './js/date.js.php'?>
        <?php include './js/last_row_validate.js.php'?>
    </script>
</div>