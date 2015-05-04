<?php
    // Start session
    session_start(); 

    // Include required functions file 
    require_once('include/functions.inc.php'); 

    // Check login status... if not logged in, redirect to login screen 
    if (check_login_status() == false ) { 
             redirect('login.php'); 
    }
    else {
        // check user is admin
        $username = $_SESSION['username'];
        if($username != "admin") {
            redirect('home.php'); 
        }
    }
    
    //get id 
    $id = $_GET['id'];
    
    //include
    require_once('include/config.inc.php');
    
     //connect Database
    $link = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD) or die("Could not connect to host");
    mysqli_select_db($link, DB_DATABASE) or die("Could not find database");
    
    $sql = "UPDATE `book` SET `remove`=1 WHERE id_book=".$id;
    
    //echo $sql."<br>";////////////////try////////////
    
    try{
        $result = mysqli_query($link, $sql) or die(mysqli_error($link));
    }catch(Exception $e){
        echo "fail";
    }
    
    //close connect
    mysqli_close($link);
            
    echo "success";

?>
