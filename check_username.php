<?php
    //include
    require_once('include/config.inc.php');
    
    //get data from post
    $username = $_POST['username'];
    
    //echo $username;//////////////////try///////////////
    
    //connect Database
    $link = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD) or die("Could not connect to host");
    mysqli_select_db($link, DB_DATABASE) or die("Could not find database");

    $sql = "SELECT username FROM username WHERE username='".$username."'";
    
    $result = mysqli_query($link, $sql);
    
    $num_row = mysqli_num_rows($result);
    
    if($num_row == 0) {
        echo "success";
    } 
    else {
        echo "fail";
    }
?>
