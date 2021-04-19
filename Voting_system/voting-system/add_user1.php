<?php
if ( isset($_REQUEST["password"]) )
{
    $national_id = $_REQUEST["national_id"];
    $names = $_REQUEST["names"];
    $password = $_REQUEST["password"];
    $password = password_hash($password, PASSWORD_BCRYPT);
    $email = $_REQUEST["email"];
    $phone_no = $_REQUEST["phone_no"];
    $locality = $_REQUEST["locality"];
    $target_dir = "uploads/";
    $target_file = $target_dir . rand(1000000, 10000000) . "_" . basename($_FILES["photo"]["name"]);
    $file_extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
        //echo "Uploaded";
        $upload_status = 1;
    }
    require 'connect.php';

    $sql =     "INSERT INTO `user`(`id`, `national_id`, `names`, `password`, `email`, `phone_no`, `locality`, `photo`)
    VALUES (null,'$national_id','$names','$password','$email',' $phone_no','$locality', '$target_file')";
    mysqli_query($con, $sql) or die(mysqli_error($con));
    header("location:index.php");
    setcookie('message', 'Registration successful, you can now proceed to login', time()+3);
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add User</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<?php include 'nav.php'?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-5">
            <h4>Register Here</h4>
            <form action="add_user.php" method="post" enctype="multipart/form-data">

                <div class="form-group">
                    <label>ID Number</label>
                    <input type="number" class="form-control" name="national_id" minlength="6" maxlength="6" required>
                </div>

                <div class="form-group">
                    <label>Full Names</label>
                    <input type="text" class="form-control" name="names" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>

                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" class="form-control" name="email" required>
                </div>

                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" class="form-control" name="phone_no" required>
                </div>

                <div class="form-group">
                    <label>Locality</label>
                    <input type="text" class="form-control" name="locality" required>
                </div>

                <!--upload photo img-->
                <div class="form-group">
                    <label>Photo</label>
                    <input type="file" accept="images/*" class="form-control-file border" name="photo" required>
                </div>

                <button class="btn btn-success">Submit</button>

            </form>
        </div>
    </div>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>

<?php include 'footer.php'?>
</body>
</html>