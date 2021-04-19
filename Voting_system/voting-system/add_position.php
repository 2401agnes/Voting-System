
<?php
include 'protect_files.php';
if ( isset($_REQUEST["name"]) )
{
    $name = $_REQUEST["name"];

    require 'connect.php';

    $sql =     "INSERT INTO `position`(`id`, `name`) VALUES (null,'$name')";
    mysqli_query($con, $sql) or die(mysqli_error($con));
    header("location:fetch_position.php");
    setcookie('message', 'the position has been added successfully', time()+3);
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<?php include 'nav.php'?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-sm-5">
            <h4>Add a New Position</h4>
            <form action="add_position.php" method="post" enctype="multipart/form-data">

                <div class="form-group">
                    <label>Position Name</label>
                    <select name="name" class="form-control">
                        <option value="">Select Position to add</option>
                        <option value="Chairperson">Chairperson</option>
                        <option value="Vice Chairperson">Vice Chairperson</option>
                        <option value="Secretary">Secretary</option>
                    </select>
                </div>
                <button class="btn btn-success">Add Position</button>

            </form>
        </div>
    </div>
</div>


<?php include 'footer.php'?>
</body>
</html>