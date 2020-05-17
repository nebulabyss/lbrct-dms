<?php
require 'pdo.php';
session_start();
?>

<?php
require_once "./html/header.php";

$stmt = $pdo->prepare('SELECT marine_debris_minor_categories.marine_debris_minor_categories_id, marine_debris_minor_categories.code, marine_debris_minor_categories.description, marine_debris_major_categories.description FROM marine_debris_minor_categories INNER JOIN marine_debris_major_categories WHERE marine_debris_minor_categories.marine_debris_major_categories_id = marine_debris_major_categories.marine_debris_major_categories_id;
');
$stmt->execute(array());
$item_codes = $stmt->fetchAll(PDO::FETCH_NAMED);

$stmt = $pdo->prepare('SELECT marine_debris_zones_id, description FROM marine_debris_zones');
$stmt->execute(array());
$zones = $stmt->fetchAll(PDO::FETCH_KEY_PAIR );
?>

</head>
<body>
<div class="container-fluid">
    <?php require_once "./html/nav.php";?>
    <div>
        <h3 class="text-muted mt-2">Marine debris</h3>
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
                        <select class="form-control custom-select" name="row[' + rc + '][item]" required><option selected value="">Item</option> \ <?php
                foreach($item_codes as $a):
                    echo ('<option value="' . $a[marine_debris_minor_categories_id] . '">' . $a[code] . ' - ' . $a[description][0].  ' - ' . $a[description][1].'</option>');
                endforeach;
                ?>
                        </select> \
                      </div> \
                      <div class="col"> \
                        <input type="text" class="form-control" placeholder="Count" name="row[' + rc + '][count]" required> \
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

            $('.form-body').append(
                generateForm(rowCount, lineNum)
            );

            $(document).on('keydown', '#long', function (event) {
                var keyCode = event.keyCode || event.which;
                if (keyCode === 9) {
                    rowCount++;
                    lineNum++;

                    $('.form-body').append(
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
    </script>
</div>

<?php require_once "./html/footer.php";?>

