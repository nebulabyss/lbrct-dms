<?php if (isset($wq_data)): ?>
<body>
    <div class="container-fluid">
        <?php include "includes/nav.php"; ?>
        <form action="../water_quality.php" method="post">
            <table class="table table-bordered mt-2">
                <thead class="thead-dark">
                <tr>
                    <th style="position: sticky; top: 0; z-index: 100;">Mark</th>
                    <th style="position: sticky; top: 0;">Depth (m)</th>
                    <th style="position: sticky; top: 0;">Date</th>
                    <th style="position: sticky; top: 0;">Time</th>
                    <th style="position: sticky; top: 0;">RDO Concentration (mg/L)</th>
                    <th style="position: sticky; top: 0;">RDO Saturation (%Sat)</th>
                    <th style="position: sticky; top: 0;">Temperature (°C)</th>
                    <th style="position: sticky; top: 0;">Specific Conductivity (mS/cm)</th>
                    <th style="position: sticky; top: 0;">Salinity (PSU)</th>
                    <th style="position: sticky; top: 0;">pH</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $rowCounter = 0;
                foreach ($wq_data['row'] as $k):
                    if ($k['marked'] == 'Marked') {
                        echo '<tr class="text-black bg-warning">';
                    } else {
                        echo '<tr>';
                    }
                    echo '<td style="text-align: center;">';
                    echo '<input class="big-checkbox" type="checkbox" name="row[' . $rowCounter . ']">';
                    echo '</td>';
                    echo '<td>' . $k['depth'] . '</td>';
                    echo '<td>' . $wq_data['date'] . '</td>';
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
                <?php include './includes/cancel_button.php' ?>
                <button type="submit" class="btn btn-success" name="wq" value="wq">Submit</button>
            </div>
        </form>
        <script>
            <?php include './js/wq_check_marked.js.php';?>
        </script>
    </div>
<?php else: ?>
<body>
    <div class="container-fluid">
        <?php include "includes/nav.php"; ?>
        <div>
            <h3 class="text-muted mt-2">Water quality</h3>
            <form action="../water_quality.php" method="post" enctype="multipart/form-data">
                <fieldset class="form-group">
                    <div class="form-row mb-2">
                        <div class="col-auto">
                            <label>
                                <select class="form-control custom-select bg-warning" name="site" id="site" required>
                                    <option selected value="">Site</option>
                                    <?php
                                    if (isset($sites)) {
                                        foreach ($sites as $k => $v):
                                            echo('<option value="' . $k . '">' . $k . ' - ' . $v . '</option>');
                                        endforeach;
                                    }
                                    ?>
                                </select>
                            </label>
                        </div>
                        <div class="form-check ml-2 my-2">
                            <input class="form-check-input big-checkbox" type="checkbox" id="gridCheck" name="override">
                            <label class="form-check-label ml-1" for="gridCheck">Override</label>
                        </div>
                    </div>
                    <div class="custom-file col-4">
                        <input type="file" name="userfile" class="custom-file-input" id="customFile" required>
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                </fieldset>
                <div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                    <?php include './includes/cancel_button.php' ?>
                </div>
            </form>
        </div>
        <script>
            <?php include './js/wq_file_upload.js.php'?>
        </script>
    </div>
<?php endif ?>