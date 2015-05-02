<?php
    //include
    require_once('include/config.inc.php');

    $username = $_POST['username'];
    $password = $_POST['pass'];
    $name = $_POST['firstname'];
    $surname = $_POST['lastname'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $birthdate = $_POST['birthdate'];
    
    //echo $username."  <br>".$password."  <br>".$name."  <br>".$surname."  <br>".$email."  <br>".$address."  <br>".$phone."  <br>".$birthdate;///////////try///////////
    
    //connect Database
    $link = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD) or die("Could not connect to host");
    mysqli_select_db($link, DB_DATABASE) or die("Could not find database");
    
    $sql_user = "INSERT INTO `username`(`username`, `password`) VALUES ('".$username."', '".md5($password)."')";
    $result = mysqli_query($link, $sql_user) or die("Data not found");
    // get auto-generated id
    $id = mysqli_insert_id($link); 

    $sql_person = "INSERT INTO `personinfo`(`id`, `username`, `name`, `surname`, `birthday`, `address`, `phone`, `email`)"
                ."VALUES ('".$id."', ".$username."', '".$name."', '".$surname."', '".$birthdate."', '".$address."', '".$phone."', '".$email."')";
    $result2 = mysqli_query($link, $sql_person) or die("Data not found");
    
    //close connect
    mysqli_close($con);

    header("location:login.php");
?>
