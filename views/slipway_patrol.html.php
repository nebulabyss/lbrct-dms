<body>
<div class="container-fluid">
    <?php include "includes/nav.php";?>
    <div>
        <h3 class="text-muted mt-2">Slipway inspection</h3>
        <form action="../slipway_patrol.php" method="post">
            <div class="form-row mb-2">
                <div class="col-1">
                    <label for="datepicker" class="ui-helper-hidden"></label><input type="text" class="form-control bg-warning text-dark" placeholder="Batch Date" id="datepicker" name="date" required>
                </div>
                 <div class="col-1">
                        <label for="slipway" class="ui-helper-hidden"></label><select class="form-control custom-select bg-warning" name="slipway" id="slipway" required><option selected value="">Slipway</option>
                            <?php
                            if (isset($slipways)) {
                                foreach($slipways as $k => $v):
                                    echo ('<option value="' . $k . '">' . $v . '</option>');
                                endforeach;
                            }
                            ?> </select>
                    </div>
                    <div>
                        <label for="start_time" class="col ml-1 col-form-label">Start Time:</label>
                    </div>
                    <div>
                            <input type="time" class="form-control bg-warning text-dark" id="start_time" value="08:00" name="start_time" required>
                    </div>
                    <div>
                        <label for="end_time" class="col col-form-label">End Time:</label>
                    </div>
                    <div>
                            <input type="time" class="form-control bg-warning text-dark" id="end_time" value="16:00" name="end_time" required>
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
        let lineNum = 1;
        let rowCount = 0;
        function generateForm(rc, ln) {
            formHtml = '<div class="form-row mb-2"> \
                      <label class="col-form-label d-inline-block text-center" style="width: 30px;">' + ln + '</label> \
                      <div class=""> \
                        <label for="time" class="col col-form-label font-weight-bold">Time:</label> \
                      </div> \
                      <div class="col-auto"> \
                        <input type="time" class="form-control text-dark" name="row[' + rc + '][time]"> \
                      </div> \
                      <div class="col"> \
                      <select class="form-control custom-select" name="row[' + rc + '][activity]"><option selected value="">Activity</option> \ <?php
                        if (isset($activity)) {
                            foreach ($activity as $k => $v):
                                echo('<option value="' . $k . '">' . $v . '</option>');
                            endforeach;
                        }
                ?> </select> \
                        </div> \
                      <div class="col"> \
                        <input type="text" class="form-control" placeholder="Vehicle Reg." name="row[' + rc + '][vreg]"> \
                      </div> \
                      <div class="col"> \
                        <input type="text" class="form-control" placeholder="Trailer Reg." name="row[' + rc + '][treg]"> \
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
                      <div class="col"> \
                        <input type="text" class="form-control" placeholder="Licence No." name="row[' + rc + '][licence]"> \
                      </div> \
                      <div class="col"> \
                        <input type="text" id="final" class="form-control" placeholder="Breede No." name="row[' + rc + '][breede]"> \
                      </div> \
            </div>'
            return formHtml;
        }

        $(document).ready(function () {

            $( '.form-body' ).append(
                generateForm(rowCount, lineNum)
            );

            $( document ).on( 'keydown', '#final', function( event ) {
                const keyCode = event.keyCode || event.which;
                if (keyCode === 9) {
                    rowCount++;
                    lineNum++;

                    $( '.form-body' ).append(
                        generateForm(rowCount, lineNum)
                    );
                    $(this).attr('id', '');
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
            $('#slipway').focus();
        });
    </script>
</div>