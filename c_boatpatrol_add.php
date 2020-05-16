<?php
require 'pdo.php';
session_start();
?>

<?php
require_once "./html/header.php";


$stmt = $pdo->prepare('SELECT description FROM compliance_zones');
$stmt->execute(array());
$zones = $stmt->fetchAll(PDO::FETCH_COLUMN );

?>

</head>
<body>
<div class="container-fluid">
    <?php require_once "./html/nav.php";?>
    <div>
        <h3 class="text-muted mt-2">Boat patrol inspection</h3>
        <form>
            <div class="form-row mb-2">
                <div class="col-2">
                    <input type="text" class="form-control bg-warning text-dark" placeholder="Batch Date" id="datepicker" name="date">
                </div>
            </div>
            <fieldset disabled>
                <div class="form-body">

                </div>
            </fieldset>
        </form>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="addSpeciesModal" tabindex="-1" role="dialog" aria-labelledby="addSpeciesModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-muted" id="addSpeciesModalTitle">Add bird species</h5>
                </div>
                <div class="modal-body">
                    <form id="addSpecies" method="post">
                        <div class="form-row">
                            <div class="col">
                                <input type="text" class="form-control" name="species_name" placeholder="Common Name">
                            </div>
                            <div class="form-group col">
                                <select id="inputState" name="species_type" class="form-control">
                                    <option selected>Water-associated</option>
                                    <option>Terrestrial</option>
                                </select>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        let lineNum = 1;
        let fieldCount = 0;
        function generateForm(fc, ln) {
            formHtml = '<div class="form-row mb-2"> \
                       <label class="col-form-label d-inline-block text-center" style="width: 30px;">' + ln + '</label> \
                          <div class="col"> \
                            <input id="c_name" type="text" class="form-control" placeholder="Breede Reg." name="row[' + fc + '][breede]"> \
                      </div> \
                      <div class="col"> \
                        <input type="text" class="form-control" placeholder="Licence No." name="row[' + fc + '][licence]"> \
                      </div> \
                      <div class="col"> \
                        <input type="text" class="form-control" placeholder="SAMSA" name="row[' + fc + '][samsa]"> \
                      </div> \
                      <div class="col"> \
                        <input type="text" class="form-control" placeholder="Engine size" name="row[' + fc + '][size]"> \
                      </div> \
                      <div class="form-check big-checkbox my-auto ml-2 mr-1"> \
                      <input class="form-check-input" type="checkbox" id="gridCheck" name="row[' + fc + '][twin]"> \
                      <label class="form-check-label font-weight-bold ml-1" for="gridCheck">Twin</label> \
                      </div> \
                      <div class="col"> \
                        <input type="text" class="form-control" placeholder="Offence" name="row[' + fc + '][offence]"> \
                      </div> \
                      <div class="col"> \
                        <input type="text" class="form-control" placeholder="Warning" name="row[' + fc + '][warning]"> \
                      </div> \
                      <div class="col"> \
                        <input type="text" class="form-control" placeholder="Fine" name="row[' + fc + '][fine]"> \
                      </div> \
                      <div class="col"> \
                        <select class="form-control" name="row[' + fc + '][zone]" id="zone"><option selected value="">Zone</option> \ <?php
                foreach($zones as $k => $v):
                    echo ('<option value="' . $k . '">' . $v . '</option>');
                endforeach;
                ?>
                </select> \
                      </div> \
            </div>'
            return formHtml;
        }

        $(document).ready(function () {

            $( '.form-body' ).append(
                generateForm(fieldCount, lineNum)
            );

            $( document ).on( 'keydown', '#c_name', function() {
                $(this).autocomplete({
                    source: 'bird_c_name.php'
                });
            });
            $( document ).on( 'keydown', '#zone', function( event ) {
                var keyCode = event.keyCode || event.which;
                if (keyCode === 9) {
                    fieldCount++;
                    lineNum++;

                    $( '.form-body' ).append(
                        generateForm(fieldCount, lineNum)
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
            $('input[name="name_0"]').focus();
        });
    </script>
</div>

<?php require_once "./html/footer.php";?>
</body>

