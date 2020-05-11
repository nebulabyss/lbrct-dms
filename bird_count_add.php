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
        </form>
        <div class="float-right">
            <button type="button" class="btn btn-danger">Cancel</button>
            <button type="button" class="btn btn-success">Submit</button>
        </div>

    </div>

    <script>
        var fieldCount = 0;
        function generateForm(fc) {
            formHtml = '<div class="form-row mb-2"> \
                          <div class="col"> \
                            <input id="c_name" type="text" class="form-control" placeholder="Common Name" name="name_' + fc + '"> \
                      </div> \
                      <div class="col"> \
                        <input type="text" class="form-control" placeholder="Count" name="count_' + fc + '"> \
                      </div> \
                      \<div class="col"> \
                        <input type="text" class="form-control" placeholder="Behaviour" name="behave_' + fc + '"> \
                      </div> \
                      \<div class="col"> \
                        <input type="text" class="form-control" placeholder="Habitat" name="hab_' + fc + '"> \
                      </div> \
                      \<div class="col"> \
                        <input type="text" class="form-control" placeholder="Latitude" name="lat_' + fc + '"> \
                      </div> \
                      \<div class="col"> \
                        <input type="text" class="form-control" placeholder="Longitude" name="long_' + fc + '"> \
                      </div> \
                      <div class="col"> \
                        <input type="text" class="form-control" placeholder="Zone" name="zone_' + fc + '" id="zone"> \
                      </div> \
            </div>'
            return formHtml;
        }
        $(document).ready(function () {


            $( '.form-body' ).append(
                generateForm(fieldCount)
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

                    $( '.form-body' ).append(
                        generateForm(fieldCount)
                    );
                    $(this).focus();
                };
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

