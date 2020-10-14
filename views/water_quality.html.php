<?php if (isset($wq_data)):?>
    <div class="container-fluid">
    <?php include "includes/nav.php";?>
    <form action="../water_quality.php" method="post">
        <table class="table table-bordered mt-2">
            <thead>
            <tr>
                <th scope="col">Mark</th>
                <th scope="col">Depth (m)</th>
                <th scope="col">Date</th>
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
            <?php include './includes/cancel_button.php'?>
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
    <?php include "includes/nav.php";?>
    <div>
        <h3 class="text-muted mt-2">Water quality</h3>
        <form action="../water_quality.php" method="post" enctype="multipart/form-data">
            <fieldset class="form-group">
            <div class="form-row mb-2">
                <div class="col-2">
                    <label>
                        <select class="form-control custom-select bg-warning" name="site" id="site" required><option selected value="">Site</option>
                            <?php
                            if (isset($sites)) {
                                foreach($sites as $k => $v):
                                    echo ('<option value="' . $k . '">' . $k . ' - ' .$v . '</option>');
                                endforeach;
                            }
                            ?>
                        </select>
                    </label>
                </div>
            </div>
                <div class="custom-file col-4">
                    <input type="file" name="userfile" class="custom-file-input" id="customFile" required>
                    <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
            </fieldset>
        <div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </div>
        </form>
    </div>
    <script>
        <?php include './js/wq_file_upload.js.php'?>
    </script>
</div>
<?php endif ?>