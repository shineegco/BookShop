<?php
    // Start session
    session_start(); 

    // Include required functions file 
    require_once('include/functions.inc.php'); 

    // Check login status... if not logged in, redirect to login screen 
    if (check_login_status() == false) { 
             redirect('login.php'); 
    } 
    
    //get username & id 
    //$username = $_POST['username'];
    $id = $_GET['id'];
    
    //echo $id."<br>";/////////////try//////////
    
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    //include
    require_once('include/config.inc.php');
    
   //connect Database
    $link = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD) or die("Could not connect to host");
    mysqli_select_db($link, DB_DATABASE) or die("Could not find database");
    
    if($id == 0) {
         $sql = "SELECT id_transaction, B.name, B.author, T.amount, T.price, T.date "
           ." FROM username U, transaction T, book B "
           ." WHERE U.id=T.id AND T.id_book=B.id_Book";
    }
    else {
        $sql = "SELECT id_transaction, B.name, B.author, T.amount, T.price, T.date "
               ." FROM username U, transaction T, book B "
               ." WHERE U.id=T.id AND T.id_book=B.id_Book AND U.id=".$id; // AND U.username='".$username."'
    }
    
    //echo $sql."<br>";////////////////try////////////
    
    $result = mysqli_query($link, $sql);
    
    $num_row = mysqli_num_rows($result);
    
        $rows = array();
        
        while($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }
        
        //JSON
        print json_encode($rows);

    //close connect
    mysqli_close($link);
?>
