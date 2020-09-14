<?php
session_start();

$salt = '+Aqr2jwFfD-nSQ4J';

if (isset($_POST['email'])) {
    $_SESSION['user_name'] = "Signed in user";
    $_SESSION['user_id'] = 1;
    header("Location: index.php");
    return;
}
?>

<?php
require_once "./html/header.php";
?>
<style>
        .form-signin {
        width: 100%;
        max-width: 330px;
        padding: 15px;
        margin: auto;
    }
    .form-signin .form-control {
        position: relative;
        box-sizing: border-box;
        height: auto;
        padding: 10px;
        font-size: 16px;
    }
    .form-signin .form-control:focus {
        z-index: 2;
    }
    .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }
    .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }

</style>
</head>
<body>
<div class="container-fluid">
    <?php require_once "./html/nav.php";?>
    <form method="post" class="form-signin mt-5">
        <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    </form>
</div>

<?php require_once "./html/footer.php";?>

</body>
