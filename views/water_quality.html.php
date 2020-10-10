<?php if (isset($wq_data)):?>
    <div class="container-fluid">
    <?php include "includes/nav.php";?>
    <form action="../water_quality.php" method="post">
        <table class="table table-bordered mt-2">
            <thead>
            <tr>
                <th scope="col">Mark</th>
                <th scope="col">Depth (m)</th>
                <th scope="col">Time</th>
                <th scope="col">RDO Concentration (mg/L)</th>
                <th scope="col">RDO Saturation (%Sat)</th>
                <th scope="col">Temperature (°C)</th>
                <th scope="col">Specific Conductivity (mS/cm)</th>
                <th scope="col">Salinity (PSU)</th>
                <th scope="col">pH</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $rowCounter = 0;
            foreach ($wq_data as $k):
                if ($k['marked'] == 'Marked') {
                    echo '<tr class="text-black bg-warning">';
                } else {
                    echo '<tr>';
                }
                echo '<td style="text-align: center;">';
                echo '<input class="big-checkbox" type="checkbox" name="row[' . $rowCounter . ']">';
                echo '</td>';
                echo '<td>' . $k['depth'] . '</td>';
                echo '<td>' . $k['time'] . '</td>';
                echo '<td>' . $k['rdocon'] . '</td>';
                echo '<td>' . $k['rdosat'] . '</td>';
                echo '<td>' . $k['temp'] . '</td>';
                echo '<td>' . $k['cond'] . '</td>';
                echo '<td>' . $k['sal'] . '</td>';
                echo '<td>' . $k['ph'] . '</td>';
                echo '</tr>';
                $rowCounter++;
            endforeach;
            ?>
            </tbody>
        </table>
        <div class="float-right mb-4">
            <button type="button" class="btn btn-danger">Cancel</button>
            <button type="submit" class="btn btn-success">Submit</button>
        </div>
    </form>
        <script>
            $('input[type=checkbox').on('click', function (){
                if ($(this).closest('tr').hasClass('bg-warning')) {
                    $(this).closest('tr').removeClass('text-black bg-warning');
                }
                    $(this).closest('tr').toggleClass('text-white bg-success');
            });
        </script>
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
                    <label for="datepicker" class="ui-helper-hidden"></label>
                    <input type="text" class="form-control bg-warning" placeholder="Batch Date" id="datepicker" name="date"
                    <?php if (isset($_SESSION['date'])) echo 'value="' . $_SESSION['date'] . '"' ?> required>
                </div>
                <div class="col-2">
                    <label>
                        <select class="form-control custom-select bg-warning" name="site" required><option selected value="">Site</option>
                            <?php
                            if (isset($sites)) {
                                foreach($sites as $k => $v):
                                    echo ('<option value="' . $k . '">' . $k . ' - ' .$v . '</option>');
                                endforeach;
                            }
                            ?> </select>
                    </label>
                </div>
            </div>
            <div class="custom-file col-4">
                <input type="file" name="userfile" class="custom-file-input" id="customFile" required>
                <label class="custom-file-label" for="customFile">Choose file</label>
            </div>
            <div>
                <button type="submit" class="btn btn-primary mt-2">Upload</button>
            </div>
        </form>

        <script>
            // Name of the file appears on select
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
            });
            let date_picker = $( '#datepicker' );
            date_picker.datepicker({
                dateFormat:  'yy-mm-dd'
            });

            date_picker.change( function () {
                $('fieldset').prop('disabled', false);
                $('#start_time').focus();
            });
        </script>
    </div>
<?php endif ?>