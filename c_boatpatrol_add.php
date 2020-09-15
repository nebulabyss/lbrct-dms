<?php
require 'pdo.php';
session_start();
?>

<?php
require_once "./html/header.php";


$stmt = $pdo->prepare('SELECT compliance_zones_id, description FROM compliance_zones');
$stmt->execute(array());
$zones = $stmt->fetchAll(PDO::FETCH_KEY_PAIR );

?>

<body>
<div class="container-fluid">
    <?php require_once "./html/nav.php";?>
    <div>
        <h3 class="text-muted mt-2">Boat patrol inspection</h3>
        <form>
            <div class="form-row mb-2">
                <div class="col-1">
                    <input type="text" class="form-control bg-warning text-dark" placeholder="Batch Date" id="datepicker" name="date" required>
                </div>

                <fieldset class="form-row" disabled>

                    <div class="form-group row">
                        <label for="time" class="col ml-1 col-form-label">Start Time:</label>
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
                          <div class="col"> \
                        <select class="form-control custom-select" name="row[' + rc + '][zone]" id="zone"><option selected value="">Zone</option> \ <?php
                foreach($zones as $k => $v):
                    echo ('<option value="' . $k . '">' . $v . '</option>');
                endforeach;
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
                      <div class="col"> \
                        <input type="text" class="form-control" placeholder="Offence" name="row[' + rc + '][offence]"> \
                      </div> \
                      <div class="col"> \
                        <input type="text" class="form-control" placeholder="Warning" name="row[' + rc + '][warning]"> \
                      </div> \
                      <div class="col"> \
                        <input type="text" id="final" class="form-control" placeholder="Fine" name="row[' + rc + '][fine]"> \
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
            $('input[name="time_start"]').focus();
        });
    </script>
</div>

<?php require_once "./html/footer.php";?>
</body>

