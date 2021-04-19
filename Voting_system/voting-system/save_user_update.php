<?php

if(isset($_POST["id"]))//$_POST, $_GET, $_REQUEST
{
    $id = $_POST["id"];
    $national_id = $_POST["national_id"];
    $names = $_POST["names"];
    $email = $_POST["email"];
    $phone_no = $_POST["phone_no"];
    $locality = $_POST["locality"];

    require 'connect.php';
    $sql = "update user set national_id ='$national_id', names='$names', email='$email', phone_no='$phone_no', locality='$locality' where id=$id";
    mysqli_query($con, $sql) or die(mysqli_error($con));
    setcookie('message', "The user $names  has been updated  successfully", time()+3);

}
header("location:fetch_user.php");



//products (id, name, description, quantity, price)



