<?php include 'report_header.php'?>
    <?php if (isset($bird_count) && $bird_count == false): ?>
        <div>
            <h4 class="text-danger mt-5 text-center">No records for selected dates.</h4>
        </div>
    <?php elseif (!empty($_POST)): ?>
    <div class="table-responsive">
        <table class="table table-sm table-bordered mt-3" id="data-table">
            <thead class="thead-light">
            <tr>
                <th>Species</th>
                <th>Count</th>
                <th>&#37;</th>
            </tr>
            </thead>
            <tbody id="clipboard">
                    <?php
                    foreach ($bird_count as $k => $v) {
                        echo '<tr>';
                        echo '<td>' . $k . '</td>';
                        echo '<td>' . $v . '</td>';
                        echo '<td>' . round($v / $total[0], 4) * 100 . '&#37;</td>';
                        echo '</tr>';
                    }
                    ?>
                    <tr class="font-weight-bolder">
                        <td>Total</td>
                        <td><?=$total[0]?></td>
                        <td>100&#37;</td>
                    </tr>
            </tbody>
        </table>
        <?php include './includes/report_buttons.php'?>
        <?php endif; ?>
    </div>
<?php include 'report_footer.php'?>
