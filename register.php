<?php
    //include
    require_once('include/config.inc.php');
    
    // Include required functions file 
    require_once('include/functions.inc.php');

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
    
    $sql = "SELECT username FROM username WHERE username='".$username."'";
    
    $result = mysqli_query($link, $sql);
    
    $num_row = mysqli_num_rows($result);
    
    if($num_row == 0) {
        $sql_user = "INSERT INTO `username`(`username`, `password`) VALUES ('".$username."', '".md5($password)."')";
    
        echo $sql_user;/////try/////

        try {
            $result = mysqli_query($link, $sql_user);

            // get auto-generated id
            $id = mysqli_insert_id($link); 

            echo $id;////////try///////

            $sql_person = "INSERT INTO `personinfo`(`id`, `name`, `surname`, `birthday`, `address`, `phone`, `email`)"
                        ."VALUES (".$id.", '".$name."', '".$surname."', '".$birthdate."', '".$address."', '".$phone."', '".$email."')";

            echo $sql_person;////////try///////

            try {
                $result2 = mysqli_query($link, $sql_person);
        ?>
                    <script>
                            alert("Success");
                    </script>
         <?php       
                header("location:login.php");

            }catch(Exception $e){
                echo "fail";
         ?>
            <script>
                    alert("Have a problem in process. Please try again.");
            </script>
        <?php
            }
        }catch(Exception $e){
               // echo "fail";
        ?>
            <script>
                    alert("Have a problem in process. Please try again.");
            </script>
        <?php
        }
    } 
    else {
            echo "fail";
      ?>
            <script>
                    alert("Username is available. Please try again.");
            </script>
        <?php
        
    }
    
    
    
    //close connect
    mysqli_close($link);
    
    header("location:login.php");
?>
