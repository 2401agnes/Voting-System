<?php
include 'protect_files.php';
require 'connect.php';
$sql = "SELECT position.name, COUNT(user.names) AS MyCount, user.names, user.photo, candidate.user_id, votes.position_id, votes.vote_date FROM user, position, candidate, votes WHERE candidate.id = votes.candidate_id and user.id = candidate.user_id and position.id = candidate.position_id and position.name = 'Vice Chairperson'
GROUP BY  user.names
ORDER BY COUNT(votes.id) DESC";
$result = mysqli_query($con, $sql) or die(mysqli_error($con));
$rows = mysqli_fetch_all($result, 1);

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

<?php if (isset($_COOKIE['message'])): ?>
    <div class="alert alert-primary">
        <?= $_COOKIE['message'] ?>
    </div>
<?php endif; ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-sm-8">

            <div class="col-sm-4 mt-1 ml-5 mb-3">
                <button class="btn btn-dark" onclick="window.location.href='vote.php'">Back</button>
            </div>

            <table class="table" id="example" id="tableA">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>CANDIDATE PHOTO</th>
                    <th>FULL NAMES</th>
                    <th>POSITION NAME</th>
                    <th>VOTE COUNT</th>
                </tr>
                </thead>
                <tbody>

                <?php $counter = 1 ?>
                <?php foreach ($rows as $chairperson): ?>
                    <tr>
                        <td><?= $counter++ ?></td>
                        <td><img src="<?= $chairperson['photo'] ?>" width="60" height="60" alt="<?= $chairperson["names"] ?>"></td>
                        <td><?= $chairperson["names"] ?></td>
                        <td><?= $chairperson["name"] ?></td>
                        <td><b><?= $chairperson["MyCount"] ?></b></td>
                        </td>
                    </tr>

                <?php endforeach; ?>
                </tbody>

            </table>

        </div
    </div>


    <?php include 'footer.php'?>
</body>
</html>

