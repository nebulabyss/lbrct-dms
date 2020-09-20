<body>
<div class="container-fluid">
    <?php include "./html/nav.php";?>
    <div>
        <h3 class="text-muted mt-2">Boat patrol inspection</h3>
        <form action="../boat_patrols.php" method="post">
            <div class="form-row mb-2">
                    <div class="col-1">
                        <label for="datepicker" class="ui-helper-hidden"></label><input type="text" class="form-control bg-warning" placeholder="Batch Date" id="datepicker" name="date" required>
                    </div>
                    <div>
                        <label for="start_time" class="col ml-1 col-form-label">Start Time:</label>
                    </div>
                    <div class="col-1">
                        <input type="time" class="form-control bg-warning" id="start_time" name="start_time" required>
                    </div>
                    <div>
                        <label for="end_time" class="col col-form-label">End Time:</label>
                    </div>
                    <div class="col-1">
                        <input type="time" class="form-control bg-warning" id="end_time" name="end_time" required>
                    </div>
            </div>
            <fieldset disabled>
                <div class="form-body">

                </div>
            </fieldset>
            <div class="float-right">
                <button type="button" class="btn btn-danger">Cancel</button>
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </form>
    </div>
    <script>
        let formHtml = '';
        let lineNum = 1;
        let rowCount = 0;
        function generateForm(rc, ln) {
            formHtml = '<div class="form-row mb-2"> \
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
                        <input type="text" class="form-control" placeholder="Engine size" name="row[' + rc + '][size]"> \
                      </div> \
                      <div class="form-check big-checkbox my-auto ml-2 mr-1"> \
                      <input class="form-check-input" type="checkbox" id="gridCheck" name="row[' + rc + '][twin]"> \
                      <label class="form-check-label font-weight-bold ml-1" for="gridCheck">Twin</label> \
                      </div> \
                      <div class="form-check big-checkbox my-auto ml-2 mr-1"> \
                      <input class="form-check-input" type="checkbox" id="gridCheck" name="row[' + rc + '][fine]"> \
                      <label class="form-check-label font-weight-bold ml-1" for="gridCheck">Fine</label> \
                      </div> \
                      <div class="form-check big-checkbox my-auto ml-2 mr-1"> \
                      <input class="form-check-input" type="checkbox" id="gridCheck" name="row[' + rc + '][warn]"> \
                      <label class="form-check-label font-weight-bold ml-1" for="gridCheck">Warning</label> \
                      </div> \
                      <div class="col"> \
                      <select class="form-control custom-select" name="row[' + rc + '][trans]" id="trans"><option selected value="">Transgression</option> \ <?php
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

        $(document).ready(function () {

            $( '.form-body' ).append(
                generateForm(rowCount, lineNum)
            );

            $( document ).on( 'keydown', '#trans', function( event ) {
                $(this).attr('id', '');
                const keyCode = event.keyCode || event.which;
                if (keyCode === 9) {
                    rowCount++;
                    lineNum++;

                    $( '.form-body' ).append(
                        generateForm(rowCount, lineNum)
                    );
                    $(this).focus();
                }
            });
        });
        let date_picker = $( '#datepicker' );
        date_picker.datepicker({
            dateFormat:  "yy-mm-dd"
        });

        date_picker.change( function () {
            $('fieldset').prop('disabled', false);
            $('input[name="time_start"]').focus();
        });
    </script>
</div>