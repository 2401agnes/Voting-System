<?php

if (isset($_REQUEST["password"])) {
    $national_id = $_REQUEST["national_id"];
    $password = $_REQUEST["password"];
    require 'connect.php';
    $query = mysqli_prepare($con, "select * from user where national_id = ?");
    mysqli_stmt_bind_param($query, "s", $national_id) or die(mysqli_stmt_error($query)); //execute query
    mysqli_stmt_execute($query);
    $result = mysqli_stmt_get_result($query);
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        $hash = $user["password"];
        if (password_verify($password, $hash)) {
            session_start();
            $_SESSION["names"] = $user["names"];
            $_SESSION["id"] = $user["id"];
            $_SESSION["admin"] = $user["admin"];

            $_SESSION["logged_in"] = true;
            header("Location:vote.php");
        } else {
            setcookie("error", "wrong username or password", time() + 3);
        }

    }
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<?php include 'nav.php' ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-sm-5">
            <?php if (isset($_COOKIE['message'])): ?>
                <div class="alert alert-primary">
                    <?= $_COOKIE['message'] ?>
                </div>
            <?php endif; ?>

            <h4>Sign In</h4>
            <form action="index.php" method="post">

                <div class="form-group">
                    <label>ID Number</label>
                    <input type="number" class="form-control" name="national_id" minlength="1" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>

                <button class="btn btn-block btn-success">Sign In</button>

                    <button class="btn btn-block btn-danger" onclick="window.location.href='add_user1.php'">Don't Have an
                        account? Register Here
                    </button>

                </div>
    </div>

            </form>
        </div>
    </div>
</div>


</body>
</html>