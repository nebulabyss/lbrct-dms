<?php include 'report_header.php' ?>
<?php if ($report_error): ?>
    <div>
        <h4 class="text-danger mt-5 text-center">Data model mismatch - Select dates either before or after
            2021-07-01</h4>
    </div>
<?php elseif (isset($zone_count) && $zone_count[0][0] == false): ?>
    <div>
        <h4 class="text-danger mt-5 text-center">No records for selected dates</h4>
    </div>
<?php elseif (!empty($_POST)): ?>
<div class="table-responsive">
    <table class="table table-sm table-bordered mt-3" id="data-table">
        <thead class="thead-light">
        <tr>
            <th>Recreational activity</th>
            <th>Total count</th>
            <th>Peak number of users per day</th>
        </tr>
        </thead>
        <tbody id="clipboard">
        <?php
        $row_names = array('Boats in transit', 'Boats at mooring', 'Boats skiing', 'Boats fishing', 'Non-motorized water sport (Kite surfing, sailing)', 'Shore anglers', 'Bait collectors');
        $counter = 0;
        while ($counter < count($row_names)) {
            echo '<tr><td>' . $row_names[$counter] . '</td>';
            echo '<td>' . $zone_count[0][$counter] . '</td>';
            echo '<td>' . $zone_max_per_day[0][$counter] . '</td>';
            $counter++;
        }
        echo '</tr>';
        ?>
        </tbody>
    </table>
    <?php include './includes/report_buttons.php' ?>
    <?php endif; ?>
</div>
<?php include 'report_footer.php' ?>
