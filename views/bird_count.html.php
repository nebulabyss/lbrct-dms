<body>
<div class="container-fluid">
    <?php require_once "./includes/nav.php";?>
    <div>
        <h3 class="text-muted mt-2">Bird count</h3>
        <form>
            <div class="form-row">
                <div class="col-1">
                    <label for="datepicker" class="ui-helper-hidden"></label>
                    <input type="text" class="form-control bg-warning text-dark" placeholder="Batch Date" id="datepicker" name="date" required>
                </div>

                <fieldset class="form-row" disabled>
                    <div class="col">
                        <label>
                            <select class="form-control bg-warning text-dark custom-select" id="zone" name="zone" required><option selected value="">Zone</option>
                                <?php
                                if (isset($zones)) {
                                    foreach($zones as $k => $v):
                                        echo ('<option value="' . $k . '">' . $v . '</option>');
                                    endforeach;
                                }
                                ?>
                            </select>
                        </label>
                    </div>
                    <div class="form-group row">
                        <label for="time" class="col col-form-label">Start Time:</label>
                    </div>
                    <div class="col">
                        <label>
                            <input type="time" class="form-control bg-warning text-dark" name="time_start" required>
                        </label>
                    </div>
                    <div class="form-group row">
                        <label for="time" class="col col-form-label">End Time:</label>
                    </div>
                    <div class="col">
                        <label>
                            <input type="time" class="form-control bg-warning text-dark" name="time_end" required>
                        </label>
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
                                <label>
                                    <input type="text" class="form-control" name="species_name" placeholder="Common Name">
                                </label>
                            </div>
                            <div class="form-group col">
                                <label for="inputState" class="ui-helper-hidden"></label>
                                <select id="inputState" name="species_type" class="form-control">
                                    <option value="1" selected>Water-associated</option>
                                    <option value="2">Terrestrial</option>
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
                            <input id="species" type="text" class="form-control" placeholder="Species Name" name="row[' + rc + '][species]" required> \
                      </div> \
                      <div class="col"> \
                        <input type="text" class="form-control" placeholder="Count" name="row[' + rc + '][count]" required> \
                      </div> \
                      <div class="col"> \
                        <select class="form-control custom-select" name="row[' + rc + '][behavior]"><option selected value="">Behaviour</option> \ <?php
                if (isset($behavior_codes)) {
                    foreach($behavior_codes as $k => $v):
                        echo ('<option value="' . $k . '">' . $v . '</option>');
                    endforeach;
                }
                ?>
                        </select> \
                      </div> \
                      <div class="col"> \
                        <select class="form-control custom-select" name="row[' + rc + '][habitat]"><option selected value="">Habitat</option> \ <?php
                if (isset($habitat_codes)) {
                    foreach($habitat_codes as $k => $v):
                        echo ('<option value="' . $k . '">' . $v . '</option>');
                    endforeach;
                }
                ?>
                      </select> \
                      </div> \
                      <div class="col"> \
                        <input type="text" class="form-control" placeholder="Latitude" name="row[' + rc + '][lat]"> \
                      </div> \
                      <div class="col"> \
                        <input type="text" id="longt" class="form-control" placeholder="Longitude" name="row[' + rc + '][longt]"> \
                      </div> \
            </div>'
            return formHtml;
        }

        $(document).ready(function () {

            $( '.form-body' ).append(
                generateForm(rowCount, lineNum)
            );

            $( document ).on( 'keydown', '#species', function() {
                $(this).autocomplete({
                    source: 'bird_c_name.php'
                });
            });
            $( document ).on( 'keydown', '#longt', function( event ) {
                let keyCode = event.keyCode || event.which;
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
            $('#zone').focus();
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