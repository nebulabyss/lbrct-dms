<body>
<div class="container-fluid">
    <?php include "./includes/nav.php";?>
    <div>
        <h3 class="text-muted mt-2">Marine debris</h3>
        <form action="./marine_debris.php" method="post">
            <div class="form-row mb-2">
                <?php include './includes/date_picker.php' ?>
                <fieldset class="form-row" disabled>
                <div class="col">
                    <label for="next" class="ui-helper-hidden"></label>
                        <select class="form-control bg-warning text-dark custom-select" name="zone" id="next" required><option selected value="">Zone</option>
                            <?php
                            if (isset($zones)) {
                                foreach($zones as $k => $v):
                                    echo ('<option value="' . $k . '">' . $v . '</option>');
                                endforeach;
                            }
                            ?>
                        </select>
                </div>
                </fieldset>
            </div>
            <fieldset disabled>
                <div class="form-body">

                </div>
            </fieldset>
            <?php include './includes/remove_row_botton.php'?>
        <div class="float-right">
            <?php include './includes/cancel_button.php'?>
            <button type="submit" class="btn btn-success">Submit</button>
        </div>
        </form>
    </div>
    <script>
        <?php include "./js/form_variables.js.php";?>
        function generateFormRow(rc, ln) {
            formHtml = '<div class="form-row mb-2" id="row' + rowCount + '"> \
                       <label class="col-form-label d-inline-block text-center" style="width: 30px;">' + ln + '</label> \
                                                <div class="col"> \
                        <select class="form-control custom-select" name="row[' + rc + '][item]" required><option selected value="">Item</option> \ <?php
                if (isset($item_codes)) {
                    foreach($item_codes as $a):
                        echo ('<option value="' . $a['marine_debris_minor_categories_id'] . '">' . $a['code'] . ' - ' . $a['description'][0].  ' - ' . $a['description'][1].'</option>');
                    endforeach;
                }
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
                        <input type="text" id="final" class="form-control" placeholder="Longitude" name="row[' + rc + '][longt]"> \
                      </div> \
            </div>'
            return formHtml;
        }
        <?php include './js/form.js.php'?>
        <?php include './js/date.js.php'?>
    </script>
</div>