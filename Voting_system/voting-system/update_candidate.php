<?php
include 'protect_files.php';
if(isset($_REQUEST["id"])){
    $id = $_REQUEST["id"];
    require 'connect.php';
    $sql = "select * from candidate where id = $id";
    $result = mysqli_query($con, $sql) or die(mysqli_error($con));
    if(mysqli_num_rows($result)==0)
    {
        header("location:fetch_candidate.php");
    }
    $candidate = mysqli_fetch_assoc($result);
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
    <title>update form</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<?php include 'nav.php'?>
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-sm-5">
            <form action="save_candidate_update.php" method="post">
                <input type="hidden" name="id" value="<?=$candidate["id"]?>">

                <div class="form-group">
                    <label>User ID</label>
                    <input type="text" value="<?=$candidate['user_id']?>" class="form-control" name="user_id" required>
                </div>


                <div class="form-group">
                    <label>Position ID</label>
                    <input type="text" value="<?=$candidate['position_id']?>" class="form-control" name="position_id" required>
                </div>



                <button class="btn btn-dark">Update Candidate</button>

            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'?>
</body>
</html>

