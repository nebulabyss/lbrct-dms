<?php
session_start();
?>

<?php
require_once "./html/header.php";
?>

</head>
<body>
<div class="container">
    <?php require_once "./html/nav.php";?>
    <div>
        <h3 class="text-muted mt-2">Bird count</h3>
        <form class="form">
            <div class="form-row mb-2">
                <div class="col-2">
                    <input type="text" class="form-control" placeholder="Batch Date" id="datepicker" name="date">
                </div>
            </div>
            <div class="form-row mb-2">
                <div class="col">
                    <input type="text" class="form-control" placeholder="Common Name" name="name_0">
                </div>
                <div class="col">
                    <input type="text" class="form-control" placeholder="Count" name="count_0">
                </div>
                <div class="col">
                    <input type="text" class="form-control" placeholder="Area" name="area_0" id="area">
                </div>
            </div>
        </form>

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
                      <div class="col"> \
                        <input type="text" class="form-control" placeholder="Area" name="area_' + fieldCount + '" id="area"> \
                      </div> \
            </div>'
                    );
                    $(this).focus();
                };
            });
        });

        $( "#datepicker" ).datepicker({
            dateFormat:  "yy-mm-dd"
        });
    </script>
    </div>
</div>

<?php require_once "./html/footer.php";?>
</body>

