<?php

if(isset($_POST["id"]))
{
    $id = $_POST["id"];
    $user_id = $_POST["user_id"];
    $position_id = $_POST["position_id"];

    require 'connect.php';
    $sql = "UPDATE `candidate` SET `id`='$id',`user_id`='$user_id',`position_id`='$position_id' where id=$id";
    mysqli_query($con, $sql) or die(mysqli_error($con));
    setcookie('message', "The candidate has been updated  successfully", time()+3);

}
header("location:fetch_candidate.php");





