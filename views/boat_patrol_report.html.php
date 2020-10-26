<?php include 'report_header.php' ?>
<?php if (isset($patrols) && $patrols[0] == false): ?>
    <div>
        <h4 class="text-danger mt-5 text-center">No records for selected dates</h4>
    </div>
<?php elseif (!empty($_POST)): ?>
<div class="table-responsive">
    <table class="table table-sm table-bordered mt-3" id="data-table">
        <thead class="thead-light">
        <tr>
            <th>Type of patrol</th>
            <th>Number of inspections</th>
        </tr>
        </thead>
        <tbody id="clipboard">
        <tr>
            <td>Recreational river boats</td>
            <?php
            if (isset($patrols)) {
                echo '<td>' . $patrols[0] . '</td>';
            }
            ?>
        </tr>
        </tbody>
    </table>
    <?php include './includes/report_buttons.php' ?>
    <?php endif; ?>
</div>
<?php include 'report_footer.php' ?>
