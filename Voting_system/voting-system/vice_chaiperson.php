<?php
include 'protect_files.php';
require 'connect.php';
$sql = "SELECT user.names, user.national_id, user.photo, position.name, candidate.position_id, candidate.id as candidate_id FROM user, position, 
candidate WHERE user.id = candidate.user_id and position.id = candidate.position_id and position.name = 'Vice Chairperson'";
$result = mysqli_query($con, $sql) or die(mysqli_error($con));
$rows = mysqli_fetch_all($result, 1);
//var_dump($rows[0]);
//die();

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
        <div class="col-sm-12">
            <h3 class="text-center"> Position: Vice ChairPerson</h3>
            <table class="table" id="example">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>CANDIDATE NATIONAL ID</th>
                    <th>CANDIDATE NAME</th>
                    <th>POSITION NAME</th>
                    <th>PHOTO</th>
                    <th>VOTE</th>
                </tr>
                </thead>
                <tbody>

                <?php $counter = 1 ?>
                <?php foreach ($rows as $chair): ?>
                    <tr>
                        <td><?= $counter++ ?></td>
                        <td><?= $chair["national_id"] ?></td>
                        <td><?= $chair["names"] ?></td>
                        <td><?= $chair["name"] ?></td>
                        <td><img src="<?= $chair['photo'] ?>" width="90" height="70" alt="<?= $chair["names"] ?>"></td>
                        <td>

                            <a href="save_vote.php?position=<?=$chair["position_id"]?>&candidate=<?=$chair["candidate_id"]?>
"><img src="uploads/download.png" height="70px" width="70px" alt="" onclick="javascript: this.disabled = true;"></a>
                        </td>
                    </tr>

                <?php endforeach; ?>
                </tbody>

            </table>

        </div>
    </div>
</div>

<?php include 'footer.php'?>
</body>
</html>
