<?php
include 'protect_files.php';
if(isset($_REQUEST["id"])){
    $id = $_REQUEST["id"];
    require 'connect.php';
    $sql = "select * from position where id = $id";
    $result = mysqli_query($con, $sql) or die(mysqli_error($con));
    if(mysqli_num_rows($result)==0)
    {
        header("location:fetch_position.php");
    }
    $position = mysqli_fetch_assoc($result);
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
    <title>update position</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<?php include 'nav.php'?>

<h3> Edit Position name </h3>
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-sm-5">
            <form action="save_position_update.php" method="post">
                <input type="hidden" name="id" value="<?=$position["id"]?>">

                <div class="form-group">
                    <label>Position Name</label>
                    <input type="text" value="<?=$position['name']?>" class="form-control" name="national_id" required>
                </div>

                <button class="btn btn-dark">Update Position</button>

            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'?>
</body>
</html>

