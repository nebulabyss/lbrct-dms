<?php include 'report_header.php' ?>
<?php if (isset($transgressions) && $transgressions == false): ?>
    <div>
        <h4 class="text-danger mt-5 text-center">No records for selected dates</h4>
    </div>
<?php elseif (!empty($_POST)): ?>
<div class="table-responsive">
    <table class="table table-sm table-bordered mt-3" id="data-table">
        <thead class="thead-light">
        <tr>
            <th>Type of transgression</th>
            <th>No. of warnings</th>
            <th>No. of fines issued</th>
        </tr>
        </thead>
        <tbody id="clipboard">
        <?php
        if (isset($transgressions)) {
            $counter = 0;
            while ($counter < count($transgressions)) {
                echo '<tr>';
                foreach ($transgressions[$counter] as $k => $v) {
                    if ($k === NULL) {
                        echo '<td>' . '' . '</td>';
                    } else {
                        echo '<td>' . $transgressions[$counter][$k] . '</td>';
                    }
                }
                echo '</tr>';
                $counter++;
            }
        }
        ?>
        </tbody>
    </table>
    <?php include './includes/report_buttons.php' ?>
    <?php endif; ?>
</div>
<?php include 'report_footer.php' ?>
