<?php
require 'pdo.php';
session_start();
?>

<?php
require_once "./html/header.php";


$stmt = $pdo->prepare('SELECT bird_behaviours_id, code FROM birds_behaviours');
$stmt->execute(array());
$behavior_codes = $stmt->fetchAll(PDO::FETCH_KEY_PAIR );

$stmt = $pdo->prepare('SELECT birds_habitats_id, code FROM birds_habitats');
$stmt->execute(array());
$habitat_codes = $stmt->fetchAll(PDO::FETCH_KEY_PAIR );

$stmt = $pdo->prepare('SELECT birds_minor_zones_id, code FROM birds_minor_zones');
$stmt->execute(array());
$zones = $stmt->fetchAll(PDO::FETCH_KEY_PAIR );
?>

</head>
<body>
<div class="container-fluid">
    <?php require_once "./html/nav.php";?>
    <div>
        <h3 class="text-muted mt-2">Bird count</h3>
        <form>
            <div class="form-row mb-2">
                <div class="col-1">
                    <input type="text" class="form-control bg-warning text-dark" placeholder="Batch Date" id="datepicker" name="date" required>
                </div>

                <fieldset class="form-row" disabled>
                <div class="col">
                    <select class="form-control bg-warning text-dark custom-select" name="zone" required><option selected value="">Zone</option>
                        <?php
                        foreach($zones as $k => $v):
                            echo ('<option value="' . $k . '">' . $v . '</option>');
                        endforeach;
                        ?>
                    </select>
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

        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addSpeciesModal">Add species</button>
        <div class="float-right">
            <button type="button" class="btn btn-danger">Cancel</button>
            <button type="submit" class="btn btn-success">Submit</button>
        </div>
        </form>
    </div>
    <!-- Modal Start -->
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save changes</button>
                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal End -->
    <script>
        let lineNum = 1;
        let rowCount = 0;
        function generateForm(rc, ln) {
            formHtml = '<div class="form-row mb-2"> \
                       <label class="col-form-label d-inline-block text-center" style="width: 30px;">' + ln + '</label> \
                          <div class="col"> \
                            <input id="s_name" type="text" class="form-control" placeholder="Species Name" name="row[' + rc + '][s_name]" required> \
                      </div> \
                      <div class="col"> \
                        <input type="text" class="form-control" placeholder="Count" name="row[' + rc + '][count]" required> \
                      </div> \
                      <div class="col"> \
                        <select class="form-control custom-select" name="row[' + rc + '][behavior]"><option selected value="">Behaviour</option> \ <?php
                foreach($behavior_codes as $k => $v):
                    echo ('<option value="' . $k . '">' . $v . '</option>');
                endforeach;
                ?>
                        </select> \
                      </div> \
                      <div class="col"> \
                        <select class="form-control custom-select" name="row[' + rc + '][habitat]"><option selected value="">Habitat</option> \ <?php
                foreach($habitat_codes as $k => $v):
                    echo ('<option value="' . $k . '">' . $v . '</option>');
                endforeach;
                ?>
                      </select> \
                      </div> \
                      <div class="col"> \
                        <input type="text" class="form-control" placeholder="Latitude" name="row[' + rc + '][lat]"> \
                      </div> \
                      <div class="col"> \
                        <input type="text" id="long" class="form-control" placeholder="Longitude" name="row[' + rc + '][long]"> \
                      </div> \
            </div>'
            return formHtml;
        }

        $(document).ready(function () {

            $( '.form-body' ).append(
                generateForm(rowCount, lineNum)
            );

            $( document ).on( 'keydown', '#s_name', function() {
                $(this).autocomplete({
                    source: 'bird_c_name.php'
                });
            });
            $( document ).on( 'keydown', '#long', function( event ) {
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
            $('select[name="zone"]').focus();
        });

        $( '#addSpecies' ).submit(function( event ) {
            event.preventDefault();
            let request = $.ajax({
                type: "POST",
                url: 'add_species.php',
                data: $(this).serialize(),
            })

            request.done(function () {
                $('#addSpeciesModal').modal('toggle');
                $('input[name="species_name"').val('');
                $('#inputState').prop("selectedIndex", 0);
            });
        })
    </script>
</div>

<?php require_once "./html/footer.php";?>

