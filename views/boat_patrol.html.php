<body>
<div class="container-fluid">
    <?php include "includes/nav.php";?>
    <div>
        <h3 class="text-muted mt-2">Boat patrols</h3>
        <form action="../boat_patrol.php" method="post">
            <div class="form-row mb-2">
                    <div class="col-1">
                        <label for="datepicker" class="ui-helper-hidden"></label><input type="text" class="form-control bg-warning" placeholder="Batch Date" id="datepicker" name="date" required>
                    </div>
                    <div>
                        <label for="start_time" class="col ml-1 col-form-label">Start Time:</label>
                    </div>
                    <div>
                        <input type="time" class="form-control bg-warning" id="start_time" value="08:00" name="start_time" required>
                    </div>
                    <div>
                        <label for="end_time" class="col col-form-label">End Time:</label>
                    </div>
                    <div>
                        <input type="time" class="form-control bg-warning" id="end_time" value="16:00" name="end_time" required>
                    </div>
            </div>
            <fieldset disabled>
                <div class="form-body">

                </div>
            </fieldset>
            <button type="button" class="btn btn-danger font-weight-bold" id="removeRow">&nbsp;&#45;&nbsp;</button>
            <div class="float-right">
                <button type="button" class="btn btn-danger">Cancel</button>
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </form>
    </div>
    <script>
        <?php include './js/form_variables.js.php'?>
        function generateForm(rc, ln) {
            formHtml = '<div class="form-row mb-2" id="row' + rowCount + '"> \
                       <label class="col-form-label d-inline-block text-center" style="width: 30px;">' + ln + '</label> \
                          <div class="col"> \
                        <select class="form-control custom-select" name="row[' + rc + '][zone]" id="zone"><option selected value="">Zone</option> \ <?php
                if (isset($zones)) {
                    foreach ($zones as $k => $v):
                        echo('<option value="' . $k . '">' . $v . '</option>');
                    endforeach;
                }
                ?> </select> \
                    </div> \
                      <div> \
                      <input id="c_name" type="text" class="form-control" placeholder="Breede Reg." name="row[' + rc + '][breede]"> \
                      </div> \
                      <div class="col"> \
                        <input type="text" class="form-control" placeholder="Licence No." name="row[' + rc + '][licence]"> \
                      </div> \
                      <div class="col"> \
                        <input type="text" class="form-control" placeholder="SAMSA" name="row[' + rc + '][samsa]"> \
                      </div> \
                      <div class="col"> \
                        <input type="text" class="form-control" placeholder="Boat Name" name="row[' + rc + '][bname]"> \
                      </div> \
                      <div class="col"> \
                        <input type="text" class="form-control" placeholder="Engine size" name="row[' + rc + '][size]"> \
                      </div> \
                      <div class="form-check my-auto ml-2 mr-1"> \
                      <input class="form-check-input big-checkbox" type="checkbox" id="gridCheck" name="row[' + rc + '][twin]"> \
                      <label class="form-check-label font-weight-bold ml-1" for="gridCheck">Twin</label> \
                      </div> \
                      <div class="form-check my-auto ml-2 mr-1"> \
                      <input class="form-check-input big-checkbox" type="checkbox" id="gridCheck" name="row[' + rc + '][fine]"> \
                      <label class="form-check-label font-weight-bold ml-1" for="gridCheck">Fine</label> \
                      </div> \
                      <div class="form-check my-auto ml-2 mr-1"> \
                      <input class="form-check-input big-checkbox" type="checkbox" id="gridCheck" name="row[' + rc + '][warn]"> \
                      <label class="form-check-label font-weight-bold ml-1" for="gridCheck">Warning</label> \
                      </div> \
                      <div class="col"> \
                      <select class="form-control custom-select" name="row[' + rc + '][trans]" id="final"><option selected value="">Transgression</option> \ <?php
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
        <?php include './js/form.js.php'?>
        <?php include './js/date.js.php'?>
    </script>
</div>