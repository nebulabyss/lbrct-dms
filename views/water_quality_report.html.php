<?php $newsletter_option = true; ?>
<?php include 'report_header.php' ?>
<?php if (isset($water_quality) && $water_quality == false): ?>
    <div>
        <h4 class="text-danger mt-5 text-center">No records for selected dates</h4>
    </div>
<?php elseif (!empty($_POST)): ?>
    <div class="table-responsive overflow-hidden">
        <table class="table table-sm table-bordered mt-3" id="data-table">
            <thead class="thead-light">
            <tr>
                <th>Site Name</th>
                <th>Salinity (PSU)</th>
                <th>Temperature (&degC)</th>
            </tr>
            </thead>
            <tbody id="clipboard">
            <?php
            $counter = 0;
            while ($counter < count($water_quality)) {
                echo '<tr>';
                foreach ($water_quality[$counter] as $k => $v) {
                    echo '<td>' . $v . '</td>';
                }
                echo '</tr>';
                $counter++;
            }
            ?>
            </tbody>
        </table>
    </div>
        <div id="chart-div">

        </div>
    <?php include './includes/report_buttons.php' ?>
<?php endif; ?>
<?php include 'report_footer.php' ?>