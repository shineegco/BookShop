<?php
    //get id 
    $id = $_GET['id'];
    
    //echo $id."<br>";/////////////try//////////
    
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    //include
    require_once('include/config.inc.php');
    
   //connect Database
    $link = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD) or die("Could not connect to host");
    mysqli_select_db($link, DB_DATABASE) or die("Could not find database");
    
   // find book in DB
    $sql_book = "SELECT * FROM category C, book B WHERE C.id_category=B.id_category AND C.id_category=".$id;
    $result_book = mysqli_query($link, $sql_book);
    
    
    //echo $sql."<br>";////////////////try////////////
    
    $result = mysqli_query($link, $sql_book);
    
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
