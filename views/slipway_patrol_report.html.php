<?php include 'report_header.php' ?>
<?php if (isset($recreational) && $recreational[0] == false): ?>
    <div>
        <h4 class="text-danger mt-5 text-center">No records for selected dates</h4>
    </div>
<?php elseif (!empty($_POST)): ?>
    <div class="table-responsive">
        <table class="table table-sm table-bordered mt-3" id="data-table">
            <thead class="thead-light">
            <tr>
                <th>Type of inspection</th>
                <th>Number of boats inspected</th>
            </tr>
            </thead>
            <tbody id="clipboard">
            <tr>
                <td>Recreational river boats</td>
                <?php
                if (isset($recreational)) {
                    echo '<td>' . $recreational[0] . '</td>';
                }
                ?>
            </tr>
            <tr>
                <td>Commercial boats</td>
                <?php
                if (isset($commercial)) {
                    echo '<td>' . $commercial[0] . '</td>';
                }
                ?>
            </tr>
            </tbody>
        </table>
    </div>
    <?php include './includes/report_buttons.php' ?>
<?php endif; ?>
<?php include 'report_footer.php' ?>