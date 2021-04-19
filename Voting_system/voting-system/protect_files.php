<?php
session_start();
//protects the code one has to login first
if(! isset($_SESSION["logged_in"]))
{
    header("location:index.php");
}

//checking if the session does not exist, take the user to login page