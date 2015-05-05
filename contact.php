<?php
    // Start session
    session_start(); 
    
    // Include required functions file 
    require_once('include/functions.inc.php'); 
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
    
    <link href="css/five.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,400italic,700,600,600italic" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
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
                 if (check_login_status() == true) { 
          ?>
                    <li>
                         <a href="history.php">History</a>
                    </li>
          <?php
                 }
          ?> 
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

        <section id="contact">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
        <h2 class="section-heading">Contact</h2>
        <div class="line"></div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <h5><i class="fa fa-map-marker"></i> Address</h5>
        <p>The Faculty of Engineering,Mahidol University 25/25 Phutthamomthon 4 Rd., Salaya,Nakhon Pathom 73170,Thailand</p>
      </div>
      <div class="col-md-4">
        <h5><i class="fa fa-envelope-o"></i> Email</h5>
        <p>kewalee.ass@student.mahidol.edu</p>
        <p>arnun.sho@student.mahidol.edu</p>
      </div>
      <div class="col-md-4">
        <h5><i class="fa fa-phone"></i> Phone</h5>
      <p>089-665-6656</p>
        081-426-5458
      </div>
    </div>
    <div class="row">
      <div class="col-lg-8 col-lg-offset-2 text-center">
        <p class="contact text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut eaque, laboriosam veritatis, quos non quis ad perspiciatis, totam corporis ea, alias ut unde.</p>
      </div>
    </div>
  
  </div>
</section>
        
       
    </div>
    <!-- /.container -->

    <div class="container">

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row pull-left">
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
