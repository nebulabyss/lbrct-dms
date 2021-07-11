<?php include 'report_header.php' ?>
<?php if (isset($report_error)): ?>
    <div>
        <h4 class="text-danger mt-5 text-center">Data model mismatch - Select dates either before or after
            2021-07-01</h4>
    </div>
<?php elseif (isset($area_count) && $area_count[0][0][0] == false): ?>
    <div>
        <h4 class="text-danger mt-5 text-center">No records for selected dates</h4>
    </div>
<?php elseif (!empty($_POST)): ?>
<div class="table-responsive">
    <table class="table table-sm table-bordered mt-3" id="data-table">
        <thead class="thead-light">
        <tr>
            <th scope="col">Area</th>
            <th scope="col">Boats in transit</th>
            <th scope="col">Boats at mooring</th>
            <th scope="col">Boats skiing</th>
            <th scope="col">Boats fishing</th>
            <th scope="col">Non-motorized water sport (Kite surfing, sailing)</th>
            <th scope="col">Shore anglers</th>
            <th scope="col">Bait collectors</th>
        </tr>
        </thead>
        <tbody id="clipboard">
        <?php
        $counter = 0;
        while ($counter < count($areas)) {
            echo '<tr>';
            echo '<td>' . $areas[$counter] . '</td>';
            for ($i = 0; $i < count($area_count[$counter][0]); $i++) {
                echo '<td>' . $area_count[$counter][0][$i] . '</td>';
            }
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
