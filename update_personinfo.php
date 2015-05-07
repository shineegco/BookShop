<?php
    //include
    require_once('include/config.inc.php');
    
    // Include required functions file 
    require_once('include/functions.inc.php'); 

    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $birthdate = $_POST['birthday'];
    $id = $_POST['uid'];
    
    //echo $name."  <br>".$surname."  <br>".$email."  <br>".$address."  <br>".$phone."  <br>".$birthdate;///////////try///////////
    
    //connect Database
    $link = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD) or die("Could not connect to host");
    mysqli_select_db($link, DB_DATABASE) or die("Could not find database");

    $sql_person = "UPDATE `personinfo` SET `name`='".$name."', `surname`='".$surname."', `birthday`='".$birthdate."', `address`='".$address."'"
                .", `phone`='".$phone."', `email`='".$email."' WHERE `id`=".$id;
    
    //echo $sql_person."<br>";////////////try/////////
   
    try{
        // insert to table
        $result = mysqli_query($link, $sql_person);
        
        redirect('profile.php'); 
    }catch(Exception $e){
        
?>
    <script> alert('Have a problem in process. Please try again.');</script>
    
<?php  
        redirect('profile.php'); 
        echo "fail";
    }
    
    //close connect
    mysqli_close($link);

    echo "success";

?>
