<?php
include 'protect_files.php';
require 'connect.php';
$sql = "SELECT position.name, COUNT(user.names) AS MyCount, user.names, user.photo, candidate.user_id, votes.position_id, votes.vote_date FROM user, position, candidate, votes WHERE candidate.id = votes.candidate_id and user.id = candidate.user_id and position.id = candidate.position_id and position.id = 4
GROUP BY  user.names
ORDER BY COUNT(votes.id) DESC";
$result = mysqli_query($con, $sql) or die(mysqli_error($con));
$rows = mysqli_fetch_all($result, 1);

$sql = "SELECT COUNT(user.names) as myCount, user.names, position.name, votes.vote_date FROM user, position, candidate, votes WHERE candidate.id = votes.candidate_id and user.id = candidate.user_id and position.id = candidate.position_id and position.id = '4' and candidate.user_id = '13'";
$result1 = mysqli_query($con, $sql) or die(mysqli_error($con));
$rows1 = mysqli_fetch_all($result1, 1);
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

<div class="row mt-5">
    <div class="col-sm-2">
        <h6 class="text-center text-dark align-content-justify ml-2"><i>Click on below buttons to vote for the respective positions</i></h6>
        <br>

        <div class="col-sm-4 ml-3">
            <button class="btn btn-info" onclick="window.location.href='chairperson.php'">Chairperson</button>
        </div>

        <div class="col-sm-4 mt-5 ml-3">
            <button class="btn btn-info" onclick="window.location.href='vice_chaiperson.php'">Vice Chairperson</button>
        </div>

        <div class="col-sm-4 mt-5 ml-3">
            <button class="btn btn-info" onclick="window.location.href='secretary_position.php'">Secretary</button>
        </div>

    </div>


    <div class="col-sm-6">
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-sm-8 mr-4">
                    <h6 class="text-center text-dark align-content-justify ml-4"><i>Click on below buttons to View the Vote Progress of different candidates</i></h6>
                    <br>
                    <div class="col-sm-4 ml-5">
                        <button class="btn btn-info" onclick="window.location.href='vote_chair.php'">Chairperson Progress</button>
                    </div>

                    <div class="col-sm-4 mt-5 ml-5">
                        <button class="btn btn-info" onclick="window.location.href='vote_viceChair.php'">Vice Chair Progress</button>
                    </div>

                    <div class="col-sm-4 mt-5 ml-5">
                        <button class="btn btn-info" onclick="window.location.href='voteSec.php'">Secretary Progress</button>
                    </div>


                </div>

            </div>
        </div>
    </div>


    <div class="col-sm-4 justify-content-center" >
        <h3>Voting Guidelines</h3>


        <p class="text-danger"><i>Read the instructions keenly before going ahead to vote</i></p>
        <ul class="mr-2">
            <li>You must have an account before placing a vote.</li>
            <li>You cannot vot for the same person twice.</li>
            <li>Once you have placed your vote for one candidate, you cannot undo the voting action.</li>
            <li>Be careful and fully decisive when choosing a candidate of your choice.</li>
            <li>Choose wisely! Every vote <img src="uploads/download.png" height="100px" width="100px">counts</li>
        </ul>

    </div>
</div>



<?php include 'footer.php'?>
</body>
</html>

