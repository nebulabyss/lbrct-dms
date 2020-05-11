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
        <form class="form">
            <div class="form-row mb-2">
                <div class="col-2">
                    <input type="text" class="form-control bg-warning text-dark" placeholder="Batch Date" id="datepicker" name="date">
                </div>
            </div>
            <fieldset disabled>
            <div class="form-row mb-2">
                <div class="col">
                    <input type="text" class="form-control" placeholder="Common Name" name="name_0">
                </div>
                <div class="col">
                    <input type="text" class="form-control" placeholder="Count" name="count_0">
                </div>
                <div class="col">
                    <input type="text" class="form-control" placeholder="Behaviour" name="behave_0">
                </div>
                <div class="col">
                    <input type="text" class="form-control" placeholder="Habitat" name="hab_0">
                </div>
                <div class="col">
                    <input type="text" class="form-control" placeholder="Latitude" name="lat_0">
                </div>
                <div class="col">
                    <input type="text" class="form-control" placeholder="Longitude" name="long_0">
                </div>
                <div class="col">
                    <input type="text" class="form-control" placeholder="Area" name="area_0" id="area">
                </div>
            </div>
            </fieldset>
        </form>
        <div class="float-right">
            <button type="button" class="btn btn-danger">Cancel</button>
            <button type="button" class="btn btn-success">Submit</button>
        </div>

    </div>

    <script>
        $(document).ready(function () {
            fieldCount = 0;
            $( document ).on( "keydown", "#area", function(e) {
                var keyCode = e.keyCode || e.which;
                if (keyCode === 9) {
                    fieldCount++;

                    $( ".form" ).append(
                        '<div class="form-row mb-2"> \
                                  <div class="col"> \
                                    <input type="text" class="form-control" placeholder="Common Name" name="name_' + fieldCount + '"> \
                      </div> \
                      <div class="col"> \
                        <input type="text" class="form-control" placeholder="Count" name="count_' + fieldCount + '"> \
                      </div> \
                      \<div class="col"> \
                        <input type="text" class="form-control" placeholder="Behaviour" name="behave_' + fieldCount + '"> \
                      </div> \
                      \<div class="col"> \
                        <input type="text" class="form-control" placeholder="Habitat" name="hab_' + fieldCount + '"> \
                      </div> \
                      \<div class="col"> \
                        <input type="text" class="form-control" placeholder="Latitude" name="lat_' + fieldCount + '"> \
                      </div> \
                      \<div class="col"> \
                        <input type="text" class="form-control" placeholder="Longitude" name="long_' + fieldCount + '"> \
                      </div> \
                      <div class="col"> \
                        <input type="text" class="form-control" placeholder="Area" name="area_' + fieldCount + '" id="area"> \
                      </div> \
            </div>'
                    );
                    $(this).focus();
                };
            });
        });

        $( '#datepicker' ).datepicker({
            dateFormat:  "yy-mm-dd"
        });
        $('#datepicker').change( function () {
            $('fieldset').prop('disabled', false);
            $('input[name="name_0"]').focus();
        });
    </script>
    </div>
</div>

<?php require_once "./html/footer.php";?>
</body>

