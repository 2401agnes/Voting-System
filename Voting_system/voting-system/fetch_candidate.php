<?php
include 'protect_files.php';
require 'connect.php';
$sql = "SELECT user.names, user.national_id, position.name, candidate.user_id, candidate.id, candidate.position_id FROM position, user, candidate WHERE position.id = candidate.position_id and user.id = candidate.user_id";
$result = mysqli_query($con, $sql) or die(mysqli_error($con));

$rows = mysqli_fetch_all($result, 1);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fetch candidate </title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<?php include 'nav.php'?>

<div class="container mt-4">
    <div class="col-sm-4">
        <button class="btn btn-info" onclick="window.location.href='add_candidate.php'">Add Candidate</button>
    </div>
</div>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-sm-6">

            <?php if (isset($_COOKIE['message'])): ?>
                <div class="alert alert-primary">
                    <?= $_COOKIE['message'] ?>
                </div>
            <?php endif; ?>

            <table class="table" id="example">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>CANDIDATE NATIONAL ID</th>
                    <th>CANDIDATE NAME</th>
                    <th>POSITION NAME</th>
                    <th>DELETE</th>
                    <th>UPDATE</th>
                </tr>
                </thead>
                <tbody>

                <?php $counter = 1 ?>
                <?php foreach ($rows as $candidate): ?>
                    <tr>
                        <td><?= $counter++ ?></td>
                        <td><?= $candidate["national_id"] ?></td>
                        <td><?= $candidate["names"] ?></td>
                        <td><?= $candidate["name"] ?></td>
                        <td><a class="btn btn-danger btn-sm" href="delete_candidate.php?id=<?= $candidate["id"] ?>">Delete</a></td>
                        <td><a class="btn btn-primary btn-sm" href="update_candidate.php?id=<?= $candidate["id"] ?>">UPDATE </a>
                        </td>
                    </tr>

                <?php endforeach; ?>
                </tbody>
            </table>
            <p>&nbsp;</p><br>
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



