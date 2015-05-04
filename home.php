<?php
    // Start session
    session_start(); 
    
    // Include required functions file 
    require_once('include/functions.inc.php'); 
    
    // get username from session
    $username = $_SESSION['username'];
    
    // get uid from session
    $uid = $_SESSION['uid'];
    
    //include
    require_once('include/config.inc.php');

    //connect Database
    $link = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD) or die("Could not connect to host");
    mysqli_select_db($link, DB_DATABASE) or die("Could not find database");

    // find category in DB
    $sql_cat = "SELECT * FROM `category`"; 
    $result = mysqli_query($link, $sql_cat);
    
    // find book in DB
    $sql_book = "SELECT * FROM category C, book B WHERE C.id_category=B.id_category AND C.id_category=1";
    $result_book = mysqli_query($link, $sql_book);
?>

<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Book Store</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/shop-homepage.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <script>
        function show_book(id) {
            if($('#book').find('div').length > 0) {
                $('#book').find('div').remove();
            }
            
            // AJAX
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    var jsonObj = JSON.parse(xmlhttp.responseText);
                    
                    if(jsonObj.length == 0) {
                       alert("Data not found");
                    }
                    else{
                        //alert("HAVE");//////////try/////////
                    
                        for(i in jsonObj) {
                             text =  '<div class="col-sm-4 col-lg-4 col-md-4">'
                                    + '<div class="thumbnail">'
                                    + '<img src="http://placehold.it/320x150" alt="">'
                                    + '<div class="caption">'
                                    + '<h4>'+jsonObj[i].name+'</h4>'
                                    + '<h5>Author: '+jsonObj[i].author+'</h5>'
                                    + '<h5>category: '+jsonObj[i].name_cate+'</h5>'
                                    + '<h4 class="pull-right"> $'+jsonObj[i].price+'</h4>'
                                    + '<h5>Amount: '+jsonObj[i].amount+'</h5>'
                                    + '</div>'
                                    + '</div>'
                                    + '</div>';

                            //alert(text);//////////try/////////

                            $('#book').append(text);
                        }
                    }
                }
            }
            xmlhttp.open("POST","search_book.php?id="+id,true);
            xmlhttp.send();
        }
    </script>

</head>

<body>

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
                <a class="navbar-brand" href="#">Shiro Store</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav pull-right">
                    <li>
                        <a href="profile.php">Profile</a>
                    </li>
                    <li>
                        <a href="history.php">History</a>
                    </li>
                    <li>
                        <a href="contact.php">Contact</a>
                    </li>
                    <li>
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

    <!-- Page Content -->
    <div class="container">

        <div class="row">
            
            <div class="row carousel-holder">

                <div class="col-md-12">
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="item active">
                                <img class="slide-image" src="image/banner1.png" alt="">
                            </div>
                            <div class="item">
                                <img class="slide-image" src="image/banner2.png" alt="">
                            </div>
                            <div class="item">
                                <img class="slide-image" src="image/banner3.png" alt="">
                            </div>
                        </div>
                        <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                        </a>
                        <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                        </a>
                    </div>
                </div>

            </div>

            <div class="col-md-3">
             <!--   <p class="lead">Shop Name</p>   -->
                <div class="list-group">
            <?php
                while ($row = mysqli_fetch_array($result)) {
            ?>
                    <a onclick="show_book(<?php echo $row['id_category']; ?>)" style="cursor: pointer" class="list-group-item"><?php echo $row['name_cate']; ?></a>
            <?php
                }
            ?>
                </div>
            </div>

            <div class="col-md-9">

                

                <div class="row" id="book">
            <?php
                while ($row = mysqli_fetch_array($result_book)) {
            ?>
                    <div class="col-sm-4 col-lg-4 col-md-4">
                        <div class="thumbnail">
                            <img src="http://placehold.it/320x150" alt="">
                            <div class="caption">
                                <h4><?php echo $row['name']; ?></h4>
                                <h5>Author: <?php echo $row['author']; ?></h5>
                                <h5>category: <?php echo $row['name_cate']; ?></h5>
                                <h4 class="pull-right"> $<?php echo $row['price']; ?> </h4>
                                <h5>Amount: <?php echo $row['amount']; ?></h5>
                            </div>
                        </div>
                    </div>
            <?php
                }
            ?>
                </div>
                <!-- end div class row -->
            </div>

        </div>

    </div>
    <!-- /.container -->

    <div class="container">

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Shiro Store Co,.Ltd 2014</p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
