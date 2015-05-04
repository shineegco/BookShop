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
   $sql_book = "SELECT * FROM category C, book B WHERE C.id_category=B.id_category AND C.id_category=".$id." AND B.remove=0";    
    
    //echo $sql_book."<br>";////////////////try////////////
    
    $result = mysqli_query($link, $sql_book);
    
    $rows = array();

    while($r = mysqli_fetch_assoc($result)) {
        $row_arr['name'] = $r['name'];
        $row_arr['author'] = $r['author'];
        $row_arr['name_cate'] = $r['name_cate'];
        $row_arr['price'] = $r['price'];
        $row_arr['id_book'] = $r['id_book'];
        $row_arr['picture'] = $r['picture'];
        $row_arr['amount'] = $r['amount'];
        
        array_push($rows, $row_arr);
    }
    //var_dump($rows);
    //JSON
    print json_encode($rows);

    //close connect
    mysqli_close($link);
?>
