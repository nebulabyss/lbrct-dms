<?php if (isset($wq_data)):?>
    <div class="container-fluid">
    <?php include "includes/nav.php";?>
    <table class="table table-bordered mt-2">
        <thead>
        <tr>
            <th scope="col">Mark</th>
            <th scope="col">Date / Time</th>
            <th scope="col">Time</th>
            <th scope="col">RDO Concentration (mg/L)</th>
            <th scope="col">RDO Saturation (%Sat)</th>
            <th scope="col">Temperature (°C)</th>
            <th scope="col">Specific Conductivity (mS/cm)</th>
            <th scope="col">Salinity (PSU)</th>
            <th scope="col">Depth (m)</th>
            <th scope="col">pH (pH)</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $i = 0;
        foreach ($wq_data as $k):
            if (!empty($marked)) {
                if (in_array($i, $marked)) {
                    echo '<tr class="text-white bg-info">';
                } else {
                    echo '<tr>';
                }
            }
            echo '<td>';
            echo '<input class="form-check-input mx-auto" type="checkbox" id="gridCheck" name="row[' . $i . ']">';
            echo '</td>';

            foreach ($k as $v):
                echo '<td>' . $v . '</td>';
            endforeach;
            echo '</tr>';
            $i++;
        endforeach;
        ?>
        </tbody>
    </table>
    </div>
<?php else: ?>
<body>
<div class="container-fluid">
    <?php include "includes/nav.php";?>
    <div>
        <h3 class="text-muted mt-2">Water quality</h3>
        <form action="../water_quality.php" method="post" enctype="multipart/form-data">
            <div class="form-row mb-2">
                    <div class="col-1">
                        <label for="datepicker" class="ui-helper-hidden"></label><input type="text" class="form-control bg-warning" placeholder="Batch Date" id="datepicker" name="date" required>
                    </div>
                    <div>
                        <label for="start_time" class="col ml-1 col-form-label">Start Time:</label>
                    </div>
                    <div class="col-1">
                        <input type="time" class="form-control bg-warning" id="start_time" name="start_time" required>
                    </div>
                    <div>
                        <label for="end_time" class="col col-form-label">End Time:</label>
                    </div>
                    <div class="col-1">
                        <input type="time" class="form-control bg-warning" id="end_time" name="end_time" required>
                    </div>
            </div>
            <div class="custom-file col-4">
                <input type="file" name="userfile" class="custom-file-input" id="customFile">
                <label class="custom-file-label" for="customFile">Choose file</label>
            </div>
            <div>
                <button type="submit" class="btn btn-primary mt-2">Upload</button>
            </div>
        </form>

        <script>
            // Name of the file appears on select
            $(".custom-file-input").on("change", function() {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });
            let date_picker = $( '#datepicker' );
            date_picker.datepicker({
                dateFormat:  "yy-mm-dd"
            });

            date_picker.change( function () {
                $('fieldset').prop('disabled', false);
                $('#start_time').focus();
            });
        </script>
    </div>
<?php endif ?>