<?php
session_start();
?>

<?php
require_once "./html/header.php";
?>

</head>
<body>
<div class="container-fluid">
    <?php require_once "./html/nav.php";?>
    <div>
        <h3 class="text-muted mt-2">Bird count</h3>
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

        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addSpeciesModal">Add species</button>
        <div class="float-right">
            <button type="button" class="btn btn-danger">Cancel</button>
            <button type="button" class="btn btn-success">Submit</button>
        </div>
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
                            <input id="c_name" type="text" class="form-control" placeholder="Common Name" name="row[' + fc + '][c_name]"> \
                      </div> \
                      <div class="col"> \
                        <input type="text" class="form-control" placeholder="Count" name="row[' + fc + '][count]"> \
                      </div> \
                      \<div class="col"> \
                        <input type="text" class="form-control" placeholder="Behaviour" name="row[' + fc + '][behavior]"> \
                      </div> \
                      \<div class="col"> \
                        <input type="text" class="form-control" placeholder="Habitat" name="row[' + fc + '][habitat]"> \
                      </div> \
                      \<div class="col"> \
                        <input type="text" class="form-control" placeholder="Latitude" name="row[' + fc + '][lat]"> \
                      </div> \
                      \<div class="col"> \
                        <input type="text" class="form-control" placeholder="Longitude" name="row[' + fc + '][long]"> \
                      </div> \
                      <div class="col"> \
                        <input type="text" class="form-control" placeholder="Zone" name="row[' + fc + '][zone]" id="zone"> \
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
</body>

