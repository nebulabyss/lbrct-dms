<?php
session_start();
include 'pdo.php';
include './classes/DatabaseController.php';

$salt = '+Aqr2jwFfD-nSQ4J'; // use a random salt in production
$login = true;


if (isset($_POST['email']) && isset($_POST['password'])) {
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['TEMP']['error_message'] = "Invalid email";
        header("Location: login.php");
        exit;
    }

    $database_controller = new DatabaseController($pdo);
    $password_auth = $database_controller->EmailAuthentication($_POST['email']);

    if (password_verify($_POST["password"], $password_auth[0]["pwd"])) {
        $_SESSION['USER_ID'] = $password_auth[0]['user_id'];
        $_SESSION['USER_NAME'] = $password_auth[0]['fname'] . ' ' . $password_auth[0]['lname'];
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['TEMP']['error_message'] = "Authentication failed. Try again";
        header("Location: login.php");
        exit;
    }
}

if (isset($_POST['login'])) {
    $_SESSION['TEMP']['error_message'] = "Complete all fields";
    header("Location: login.php");
    exit;
}

if (isset($_GET['expired'])) {
    $_SESSION['TEMP']['error_message'] = 'Session expired, log in again';
}
include './includes/header.php';
?>
    <body>
<div class="container-fluid">
    <?php require_once "./includes/nav.php"; ?>
    <?php if (isset($_SESSION['TEMP']['error_message'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>ERROR:</strong> <?= $_SESSION['TEMP']['error_message'] ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php unset($_SESSION['TEMP']['error_message']); ?>
    <?php endif; ?>
    <form action="login.php" method="post" class="form-signin mt-5">
        <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required
               autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit" value="login">Sign in</button>
    </form>
</div>
<?php include "./includes/footer.php"; ?>