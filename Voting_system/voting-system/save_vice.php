<?php
session_start();
require 'connect.php';
if ( isset($_REQUEST["position"]) and isset($_REQUEST["candidate"]) )
{
    $candidate_id = $_REQUEST["candidate"];
    $position_id = $_REQUEST["position"];
    $user_id = $_SESSION["id"];
    $date  = date('Y-m-d h:i:s');
    $sql = "INSERT INTO `votes`(`id`, `candidate_id`, `position_id`, `user_id`, `vote_date`) 
VALUES (null ,'$candidate_id','$position_id','$user_id','$date')";
    mysqli_query($con, $sql) or die(mysqli_error($con));
    header("location:vote.php");
    setcookie('message', 'you have placed your vote successfully', time()+3);
}
