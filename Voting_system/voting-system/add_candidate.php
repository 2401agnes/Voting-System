<?php
include 'protect_files.php';
require 'connect.php';
$sql = "select * from position";
$result = mysqli_query($con, $sql) or die(mysqli_error($con));
$rows = mysqli_fetch_all($result, 1);

$sql = "select * from user";
$outcome = mysqli_query($con, $sql) or die(mysqli_error($con));
$row = mysqli_fetch_all($outcome, 1);


if ( isset($_REQUEST["user_id"]) )
{
$user_id = $_REQUEST["user_id"];
$position_id = $_REQUEST["position_id"];
$sql = "INSERT INTO `candidate`(`id`, `user_id`, `position_id`) VALUES (null,'$user_id', '$position_id')";
mysqli_query($con, $sql) or die(mysqli_error($con));
header("location:fetch_candidate.php");
setcookie('message', 'the candidate has been added successfully', time()+3);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add candidate </title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<?php include 'nav.php'?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-sm-6">

            <?php if (isset($_COOKIE['message'])): ?>
                <div class="alert alert-primary">
                    <?= $_COOKIE['message'] ?>
                </div>
            <?php endif; ?>




            <form action="add_candidate.php" method="post">

                <div class="form-group">
                    <label>Candidate Name</label>

                    <select name="user_id" class="form-control">
                        <option value="">Select the Candidates Name</option>
                        <?php foreach ($row as $user): ?>
                            <option value="<?= $user["id"] ?>"><?= $user["names"] ?></option><?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Position Name</label>
                    <select name="position_id" class="form-control">
                        <option value="">Select the Position Name</option>
                        <?php foreach ($rows as $position): ?>
                        <option value="<?= $position["id"] ?>"><?= $position["name"] ?></option><?php endforeach; ?>
                    </select>
                </div>

                <button class="btn btn-success">Add Candidate</button>

            </form>




        </div>

    </div>
</div>

<?php include 'footer.php'?>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>
</body>
</html>



