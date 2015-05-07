<?php
    /* add new book from admin */

    // Start session
    session_start(); 

    // Include required functions file 
    require_once('include/functions.inc.php'); 

    // Check login status... if not logged in, redirect to login screen 
    if (check_login_status() == false) { 
             redirect('login.php'); 
    } 
    else {
        // get username from session
        $username = $_SESSION['username'];

        // get uid from session
        $uid = $_SESSION['uid'];
        
        if($username != "admin") {
            redirect('home.php');
        }
    }
?>

<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Shiro Store</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/shop-homepage.css" rel="stylesheet">

    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet">
       </style>
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="add_book/formoid1/formoid-solid-orange.css" type="text/css" />
    <script type="text/javascript" src="add_book/formoid1/jquery.min.js"></script>

</head>

<body onload="load_data(<?php echo $uid ?>)">
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="background-color: #9e5417">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="home.php">Shiro Store</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav pull-right">
          <?php
                 if (check_login_status() == true && $username != "admin") { 
          ?>
                    <li>
                        <a href="profile.php">Profile</a>
                    </li>
          <?php
                 }
                 else if (check_login_status() == true && $username == "admin") { 
          ?> 
                    <li>
                        <a href="new_book.php">New book</a>
                    </li>
           <?php
                 }
           ?>
                    <li>
                        <a href="history.php">History</a>
                    </li>
                    <li>
                        <a href="contact.php">Contact</a>
                    </li>
          <?php
                 if (check_login_status() == false) { 
          ?>
                    <li>
                        <a href="login.php">Login</a>
                    </li>
         <?php
                 }
                 else {
         ?> 
                    <li>
                        <a> <?php echo "Username: ". $_SESSION['username']; ?> </a>
                    </li>
                    <li>
                        <a href="include/logout.inc.php">Logout</a>
                    </li>
         <?php
                 }
         ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    <form method="post" action="new_book.php" enctype="multipart/form-data" class="formoid-solid-orange" style="background-color:#FFFFFF;font-size:14px;font-family:'Roboto',Arial,Helvetica,sans-serif;color:#34495E;max-width:480px;min-width:150px" method="post">
        <div class="title" style="background-color: #c35c08"><h2>Add New Book</h2></div>
        
	<div class="element-input">
            <label class="title"></label>
            <div class="item-cont">
                <input class="large" type="text" id="book_name"  name="book_name" required pattern="^[a-zA-Z0-9' &]+" placeholder="Book Name"/>
                <span class="icon-place"></span>
            </div>
        </div>
        
	<div class="element-input">
            <label class="title"></label>
            <div class="item-cont">
                <input class="large" type="text" id="book_author" name="book_author" required pattern="^[a-zA-Z' ]+" placeholder="Author"/>
                <span class="icon-place"></span>
            </div>
        </div>
        
	<div class="element-textarea">
            <label class="title"></label>
            <div class="item-cont">
                <textarea class="medium" id="book_detail"  name="book_detail" cols="20" rows="5" required pattern="^[a-zA-Z0-9 ',?&()-.]+" placeholder="Detail"></textarea>
                <span class="icon-place"></span>
            </div>
        </div>
        
	<div class="element-multiple">
            <label class="title"></label>
            <div class="item-cont">
                <div class="large">
                    <select data-no-selected="Nothing selected" id="catagory" name="catagory">
                        <option value="1">Food & Drink</option>
                        <option value="2">History</option>
                        <option value="3">Horror</option>
                        <option value="4">Education Studies & Teaching</option>   
                    </select>
                    <span class="icon-place"></span>
                </div>
            </div>
        </div>
        
	<div class="element-input">
            <label class="title"></label>
            <div class="item-cont">
                <input class="large" type="number" id="book_price" name="book_price" min="1" required pattern="^[0-9]+" placeholder="Price"/>
                <span class="icon-place"></span>
            </div>
        </div>
        
	<div class="element-input">
            <label class="title"></label>
            <div class="item-cont">
                <input class="large" type="number" id="book_amount" name="book_amount" min="1" required pattern="^[0-9]+" placeholder="Amount"/>
                <span class="icon-place"></span>
            </div>
        </div>
        
	<div class="element-file">
            <label class="title"></label>
            <div class="item-cont">
                <label class="large" >
                    <div class="button" style="background-color: #c35c08">Choose File</div>
                    <input type="file" class="file_input" id="fileToUpload" required  name="fileToUpload" id="fileToUpload" />
                    <div class="file_text">Attach Cover</div><span class="icon-place"></span>
                </label>
            </div>
        </div>
        
        <div class="submit">
            <input type="submit" style="background-color: #c35c08" value="Submit"/>
        </div>
    
    </form>
    
    <p class="frmd"><a href="http://formoid.com/v29.php">javascript form validation</a> Formoid.com 2.9</p>
    
    <script type="text/javascript" src="add_book/formoid1/formoid-solid-orange.js"></script>
<!-- Stop Formoid form-->
    
<br>

<script>
    function submit() {
        var book_name = $('#book_name').val();
        var book_author = $('#book_author').val();
        var book_price = $('#book_price').val();
        var book_amount = $('#book_amount').val();
        var book_detail = $('#book_detail').val();
        var fileToUpload = $('#fileToUpload').val();
        var catagory = $('#catagory').val();
        var submit = "submit";
        
       $.post( "new_book_background.php", { 
           book_name: book_name, 
           book_author: book_author,
           book_price: book_price,
           book_amount: book_amount,
           book_detail: book_detail,
           fileToUpload: fileToUpload,
           catagory: catagory,
           submit: submit,
       })
      .done(function(result) {
            alert(result );////try///
      });
    }
</script>


<?php

        require_once('include/config.inc.php');
        if (!empty($_POST)){
            $date = new DateTime();
            $file_name = $date->getTimestamp();
            $temp = explode(".",$_FILES["fileToUpload"]["name"]);
            $target_dir = "image/cover/";
            $target_file = $target_dir.$file_name.'.'.end($temp);
           // echo $target_file;
            $uploadOk = 1;
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            // Check if image file is a actual image or fake image
            if(isset($_POST["submit"])) {
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if($check !== false) {
             //       echo "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
            //        echo "File is not an image.";
                    $uploadOk = 0;
                }
            }
            // Check if file already exists
            if (file_exists($target_file)) {
             //   echo "Sorry, file already exists.";
                $uploadOk = 0;
            }
            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 500000) {
            //    echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
             //   echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
            //    echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
              //      echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";

                } else {
             //       echo "Sorry, there was an error uploading your file.";
                }
            }
           $book_name =   $_POST['book_name'];
           $book_acthor = $_POST['book_author'];
           $book_detail = $_POST['book_detail'];
           $book_catagory_id = $_POST['catagory'];
           $book_price = $_POST['book_price'];
           $book_amount = $_POST['book_amount'];
           $book_picture = $target_file;

    //       echo "</br>".$book_name ."</br>";
    //       echo $book_acthor ."</br>";
    //       echo $book_detail ."</br>";
    //       echo $book_catagory_id ."</br>";
     //      echo $book_price ."</br>";
     //      echo $book_amount ."</br>";
     //      echo $book_picture."</br>";



           $link = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD) or die("Could not connect to host");
            mysqli_select_db($link, DB_DATABASE) or die("Could not find database");

            $sql_book = " INSERT INTO `book`(`name`, `author`, `id_category`,".
                        "`detail`, `price`, `amount`, `picture`) ".
                        " VALUES ('".$book_name."','".$book_acthor."','".$book_catagory_id."','".
                        $book_detail."','".$book_price."','".$book_amount."','".
                        $book_picture."')";


            //echo "</br> sql_book".$sql_book;

            try{
                // insert to table
                $result = mysqli_query($link, $sql_book);

                //echo "success add to Table";
    ?>
            <script>
                    alert("Success");
            </script>
    <?php
            }catch(Exception $e){
                //echo "fail";
    ?>
        <script>
                alert("Have a problem in process. Please try again.");
        </script>
    <?php
            }

            //close connect
            mysqli_close($link);
        }

?>     

    
</body>
</html>
