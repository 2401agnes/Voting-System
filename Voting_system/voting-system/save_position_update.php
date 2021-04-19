<?php

if(isset($_POST["id"]))
{
    $id = $_POST["id"];
    $name = $_POST["name"];

    require 'connect.php';
    $sql = "update position set name ='$name' where id=$id";

    mysqli_query($con, $sql) or die(mysqli_error($con));
    setcookie('message', "The user $name  has been updated  successfully", time()+3);
}
header("location:fetch_position.php");




