<body>
<div class="container-fluid">
    <?php include "./includes/nav.php";?>
    <div>
        <h3 class="text-muted mt-2">Marine debris</h3>
        <form action="../marine_debris.php" method="post">
            <div class="form-row mb-2">
                <div class="col-1">
                    <label for="datepicker" class="ui-helper-hidden"></label>
                    <input type="text" class="form-control bg-warning text-dark" placeholder="Batch Date" id="datepicker" name="date" required>
                </div>

                <fieldset class="form-row" disabled>
                <div class="col">
                    <label>
                        <select class="form-control bg-warning text-dark custom-select" name="zone" id="zone" required><option selected value="">Zone</option>
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
        let formHtml = '';
        let lineNum = 1;
        let rowCount = 0;
        let triggerID = 'final';
        function generateForm(rc, ln) {
            formHtml = '<div class="form-row mb-2"> \
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

        function formInstance() {
            $( '.form-body' ).append(
                generateForm(rowCount, lineNum)
            );
        }

        $(document).ready(function() {
            formInstance();
        });

        $(document).on( 'keydown', ('#' + triggerID), function( event ) {
            let keyCode = event.keyCode || event.which;
            if (keyCode === 9) {
                rowCount++;
                lineNum++;
                formInstance();
                let mod = triggerID + (rowCount - 1);
                $(this).attr('id', mod);
                $(this).focus();
            }
        });

        $('#removeRow').click(function() {
            let lastFormDiv = '#row' + rowCount;
            if (rowCount === 0){
                $(lastFormDiv).remove();
                formInstance();
            }
            if (rowCount > 0) {
                $(lastFormDiv).fadeOut();
                rowCount--;
                lineNum--;
                let mod = '#' + triggerID + (rowCount);
                $(mod).attr('id', triggerID);
            }
        });

        let date_picker = $('#datepicker');
        date_picker.datepicker({
            dateFormat:  "yy-mm-dd"
        });

        date_picker.change(function() {
            $('fieldset').prop('disabled', false);
            $('#zone').focus();
        });
    </script>
</div>