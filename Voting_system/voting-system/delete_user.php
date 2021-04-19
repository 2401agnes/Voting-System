<?php
if (isset($_REQUEST["id"])) {
    $id = $_REQUEST["id"];

    require 'connect.php';
    $sql = "delete from user where id = $id";
    $result = mysqli_query($con, $sql) or die(mysqli_error($con));
    setcookie('message', 'the user has been deleted successfully', time()+3); //this message will disappear after 3 seconds
}
header("location:fetch_user.php");


