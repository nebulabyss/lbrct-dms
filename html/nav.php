<nav class="navbar navbar-expand-md navbar-light bg-light border-bottom shadow-sm">
    <a class="navbar-brand" href="../index.php">LBRCT <small class="text-muted d-sm-none d-md-inline d-none">Data Management System</small></a>
    <?php if (isset($_SESSION['user_id'])): ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse mr-auto mt-2 mt-lg-0" id="navbarSupportedContent">
        <span class="navbar-text ml-auto mr-2">Signed in as <span class="text-dark" style="font-weight: bold"><?=$_SESSION['user_name'];?></span></span>
        <a type="button" href='../logout.php' class="btn btn-secondary ml-2 text-white">Sign out</a>
    </div>
    <?php endif; ?>
</nav>

<?php if (isset($_SESSION['user_id'])): ?>
<nav class="">
    <ul class="nav bg-light p-2 border-bottom">
        <li class="nav-item dropdown mr-2">
            <a class="nav-link btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" href="#" id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false">
                Compliance
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="../boatpatrols_add.php">Add boat inspection</a>
                <a class="dropdown-item" href="../c_slipway_add.php">Add slipway inspection</a>
                <a class="dropdown-item" href="../c_zone_count_add.php">Add zone usage count</a>
            </div>
        </li>

        <li class="nav-item dropdown mr-2">
            <a class="nav-link btn btn-outline-success dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Conservation
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="../bird_count_add.php">Add bird count</a>
                <a class="dropdown-item" href="../marine_debris_add.php">Add marine debris</a>
                <a class="dropdown-item" href="#">Add water quality</a>
            </div>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link btn btn-outline-info dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Reports
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">Bird counts</a>
                <a class="dropdown-item" href="#">Water quality</a>
                <a class="dropdown-item" href="#">Marine debris</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Boat inspections</a>
                <a class="dropdown-item" href="#">Slipway inspections</a>
                <a class="dropdown-item" href="#">Area usage count</a>
            </div>
        </li>
    </ul>
</nav>
<?php endif; ?>