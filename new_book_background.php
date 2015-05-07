<?php

    require_once('include/config.inc.php');
    
    $date = new DateTime();
    $file_name = $date->getTimestamp();
    $temp = explode(".",$_FILES["fileToUpload"]["name"]);
    $target_dir = "image/cover/";
    $target_file = $target_dir.$file_name.'.'.end($temp);
    echo $target_file;
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
            
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
   $book_name =   $_POST['book_name'];
   $book_acthor = $_POST['book_author'];
   $book_detail = $_POST['book_detail'];
   $book_catagory_id = $_POST['catagory'];
   $book_price = $_POST['book_price'];
   $book_amount = $_POST['book_amount'];
   $book_picture = $target_file;
   
   echo "</br>".$book_name ."</br>";
   echo $book_acthor ."</br>";
   echo $book_detail ."</br>";
   echo $book_catagory_id ."</br>";
   echo $book_price ."</br>";
   echo $book_amount ."</br>";
   echo $book_picture."</br>";
   
   
   
   $link = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD) or die("Could not connect to host");
    mysqli_select_db($link, DB_DATABASE) or die("Could not find database");
    
    $sql_book = " INSERT INTO `book`(`name`, `author`, `id_category`,".
                "`detail`, `price`, `amount`, `picture`) ".
                " VALUES ('".$book_name."','".$book_acthor."','".$book_catagory_id."','".
                $book_detail."','".$book_price."','".$book_amount."','".
                $book_picture."')";
    
    
    echo "</br> sql_book".$sql_book;
    
    try{
        // insert to table
        $result = mysqli_query($link, $sql_book);
    }catch(Exception $e){
        echo "fail";
    }
    
    //close connect
    mysqli_close($link);

    echo "success add to Table";
   
?>

