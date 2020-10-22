<?php
session_start();

$salt = '+Aqr2jwFfD-nSQ4J';
$login = true;

if (isset($_POST['email'])) {
    $_SESSION['user_name'] = "Signed in user";
    $_SESSION['user_id'] = 1;
    header("Location: index.php");
    return;
}

include './includes/header.php';
?>
<body>
<div class="container-fluid">
    <?php require_once "./includes/nav.php";?>
    <form method="post" class="form-signin mt-5">
        <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    </form>
</div>
<?php include "./includes/footer.php";?>