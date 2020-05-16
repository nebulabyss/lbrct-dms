<?php
require 'pdo.php';
session_start();
?>

<?php
require_once "./html/header.php";


$stmt = $pdo->prepare('SELECT slipways_id, description FROM slipways');
$stmt->execute(array());
$zones = $stmt->fetchAll(PDO::FETCH_KEY_PAIR );

?>

</head>
<body>
<div class="container-fluid">
    <?php require_once "./html/nav.php";?>
    <div>
        <h3 class="text-muted mt-2">Slipway inspection</h3>
        <form>
            <div class="form-row mb-2">
                <div class="col-1">
                    <input type="text" class="form-control bg-warning text-dark" placeholder="Batch Date" id="datepicker" name="date" required>
                </div>

                <fieldset class="form-row" disabled>
                    <div class="col-auto">
                        <select class="form-control bg-warning" name="slipway" id="zone"><option selected value="">Slipway</option>
                            <?php
                            foreach($zones as $k => $v):
                                echo ('<option value="' . $k . '">' . $v . '</option>');
                            endforeach;
                            ?> </select>
                    </div>
                    <div class="form-group row">
                        <label for="time" class="col col-form-label">Start Time:</label>
                    </div>
                    <div class="col">
                        <input type="time" class="form-control bg-warning text-dark" name="time_start" required>
                    </div>
                    <div class="form-group row">
                        <label for="time" class="col col-form-label">End Time:</label>
                    </div>
                    <div class="col">
                        <input type="time" class="form-control bg-warning text-dark" name="time_end" required>
                    </div>
                </fieldset>
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
                        <input type="time" class="form-control text-dark" name="time" required> \
                        </div> \
                      <div class="col"> \
                      <input id="c_name" type="text" class="form-control" placeholder="Activity" name="row[' + rc + '][activity]"> \
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
                        <input type="text" class="form-control" placeholder="Licence No." name="row[' + rc + '][licence]"> \
                      </div> \
                      <div class="col"> \
                        <input type="text" class="form-control" placeholder="Engine size" name="row[' + rc + '][size]"> \
                      </div> \
                      <div class="form-check big-checkbox my-auto ml-2 mr-1"> \
                      <input class="form-check-input" type="checkbox" id="gridCheck" name="row[' + rc + '][twin]"> \
                      <label class="form-check-label font-weight-bold ml-1" for="gridCheck">Twin</label> \
                      </div> \
                      <div class="col"> \
                        <input type="text" id="final" class="form-control" placeholder="Boat Name" name="row[' + rc + '][bname]"> \
                      </div> \
            </div>'
            return formHtml;
        }

        $(document).ready(function () {

            $( '.form-body' ).append(
                generateForm(rowCount, lineNum)
            );

            $( document ).on( 'keydown', '#c_name', function() {
                $(this).autocomplete({
                    source: 'bird_c_name.php'
                });
            });
            $( document ).on( 'keydown', '#final', function( event ) {
                var keyCode = event.keyCode || event.which;
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

        $( '#datepicker' ).datepicker({
            dateFormat:  "yy-mm-dd"
        });

        $( '#datepicker' ).change( function () {
            $('fieldset').prop('disabled', false);
            $('select[name="slipway"]').focus();
        });
    </script>
</div>

<?php require_once "./html/footer.php";?>
</body>

