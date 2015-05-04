<?php
    //include
    require_once('include/config.inc.php');

    $name = $_POST['name'];
    $author = $_POST['author'];
    $amount = $_POST['amount'];
    $detail = $_POST['detail'];
    $price = $_POST['price'];
    $id = $_POST['id'];
        
    //connect Database
    $link = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD) or die("Could not connect to host");
    mysqli_select_db($link, DB_DATABASE) or die("Could not find database");

    $sql = "UPDATE `book` SET `name`='".$name."', `author`='".$author."', `price`='".$price."'"//, `detail`='".$detail."'
                .", `amount`='".$amount."' WHERE `id_book`=".$id;
    
    //echo $sql."<br>";////////////try/////////
   
    try{
    // insert to table
        $result = mysqli_query($link, $sql);
    }catch(Exception $e){
        echo "fail";
    }
    
    //close connect
    mysqli_close($link);

    echo "success";

?>
