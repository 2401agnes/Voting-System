<?php
include 'protect_files.php';
if(isset($_REQUEST["id"])){
    $id = $_REQUEST["id"];
    require 'connect.php';
    $sql = "select * from user where id = $id";
    $result = mysqli_query($con, $sql) or die(mysqli_error($con));
    if(mysqli_num_rows($result)==0)
    {
        header("location:fetch_user.php");
    }
    $user = mysqli_fetch_assoc($result);
    // var_dump($user);

}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>update user</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<?php include 'nav.php'?>
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-sm-5">
            <form action="save_user_update.php" method="post">
                <input type="hidden" name="id" value="<?=$user["id"]?>">

                <div class="form-group">
                    <label>National ID</label>
                    <input type="text" value="<?=$user['national_id']?>" class="form-control" name="national_id" required>
                </div>


                <div class="form-group">
                    <label>Full Names</label>
                    <input type="text" value="<?=$user['names']?>" class="form-control" name="names" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" value="<?=$user['email']?>" class="form-control" name="email" required>
                </div>

                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" value="<?=$user['phone_no']?>" class="form-control" name="phone_no" required>
                </div>


                <div class="form-group">
                    <label>Locality</label>
                    <input type="text" value="<?=$user['locality']?>" class="form-control" name="locality" required>
                </div>


                <button class="btn btn-dark">Update User</button>

            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'?>
</body>
</html>

