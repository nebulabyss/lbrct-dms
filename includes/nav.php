<nav class="navbar navbar-expand-md navbar-light bg-light border-bottom shadow-sm">
    <a class="navbar-brand" href="./index.php">LBRCT <small class="text-muted d-sm-none d-md-inline d-none">Data
            Management System</small></a>
    <?php if (isset($_SESSION['USER_ID'])): ?>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse mr-auto mt-2 mt-lg-0" id="navbarSupportedContent">
            <span class="navbar-text ml-auto mr-2">Signed in as <span class="text-dark"
                                                                      style="font-weight: bold"><?= $_SESSION['USER_NAME']; ?></span></span>
            <a href='./logout.php' class="btn btn-secondary ml-2 text-white">Sign out</a>
        </div>
    <?php endif; ?>
</nav>
<?php if (isset($_SESSION['USER_ID'])): ?>
    <nav>
        <ul class="nav bg-light p-2 border-bottom">
            <li class="nav-item dropdown mr-2">
                <a class="nav-link btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" href="#"
                   id="compliance" role="button" aria-haspopup="true" aria-expanded="false">
                    Compliance
                </a>
                <div class="dropdown-menu" aria-labelledby="compliance">
                    <a class="dropdown-item" href="./boat_patrol.php">Add boat inspection</a>
                    <a class="dropdown-item" href="./slipway_patrol.php">Add slipway inspection</a>
                    <a class="dropdown-item" href="./zone_count.php">Add zone usage count</a>
                </div>
            </li>
            <li class="nav-item dropdown mr-2">
                <a class="nav-link btn btn-outline-success dropdown-toggle" href="#" id="conservation" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Conservation
                </a>
                <div class="dropdown-menu" aria-labelledby="conservation">
                    <a class="dropdown-item" href="./bird_count.php">Add bird count</a>
                    <a class="dropdown-item" href="./marine_debris.php">Add marine debris</a>
                    <a class="dropdown-item" href="./water_quality.php">Add water quality</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link btn btn-outline-info dropdown-toggle" href="#" id="reports" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Reports
                </a>
                <div class="dropdown-menu" aria-labelledby="reports">
                    <a class="dropdown-item" href="./bird_count_report.php">Bird counts</a>
                    <a class="dropdown-item" href="./marine_debris_report.php">Marine debris</a>
                    <a class="dropdown-item" href="./water_quality_report.php">Water quality</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="./boat_patrol_report.php">Boat inspections</a>
                    <a class="dropdown-item" href="./slipway_patrol_report.php">Slipway inspections</a>
                    <a class="dropdown-item" href="./zone_count_report.php">Zone usage count</a>
                </div>
            </li>
            <li class="nav-item ml-auto mr-2" style="cursor: not-allowed;">
                    <a href='#' class="nav-link btn btn-outline-danger dropdown-toggle disabled" id="settings" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Settings
                    </a>
                <div class="dropdown-menu" aria-labelledby="settings">
                    <a class="dropdown-item" href="#">Users</a>
                    <a class="dropdown-item" href="#">Compliance data</a>
                    <a class="dropdown-item" href="#">Conservation data</a>
                </div>
            </li>
        </ul>
    </nav>
<?php endif; ?>
<?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>ERROR:</strong> <?= $_SESSION['error_message'] ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>
<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>BATCH ID: &gt; <?= $_SESSION['bid'] ?> &lt;</strong> <?= $_SESSION['success_message'] ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php unset($_SESSION['success_message']); ?>
    <?php unset($_SESSION['bid']); ?>
<?php endif; ?>