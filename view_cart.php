<?php
    // Start session
    session_start(); 

    // Include required functions file 
    require_once('include/functions.inc.php'); 

    // Check login status... if not logged in, redirect to login screen 
    if (check_login_status() == false) { 
             redirect('login.php'); 
    } 
     
    // get username from session
    $username = $_SESSION['username'];
    
    // get uid from session
    $uid = $_SESSION['uid'];
    
    //include
    require_once('include/config.inc.php');
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
    
    
    <script type="text/javascript" src="js/simpleCart.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <script type="text/javascript">
        simpleCart({
            // array representing the format and columns of the cart,
            // see the cart columns documentation
            cartColumns: [
                {attr: "name", label: "Product"},
                {view: "currency", attr: "price", label: "Price"},
                {view: "decrement", label: "Decrease"},
                {attr: "quantity", label: "Quantity"},
                {view: "increment", label: "Increase"},
                {view: "currency", attr: "total", label: "SubTotal"},
                {view: "remove", text: "Remove", label: false}
            ],
            // "div" or "table" - builds the cart as a 
            // table or collection of divs
            cartStyle: "table",
            // how simpleCart should checkout, see the 
            // checkout reference for more info 
            checkout: {
                type: "PayPal",
                email: "you@yours.com"
            },
            // set the currency, see the currency 
            // reference for more info
            currency: "USD",
            // collection of arbitrary data you may want to store 
            // with the cart, such as customer info
        });
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
         ?> 
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
    
    <center>
        <div class="section group" id="section-group">
           <div class="simpleCart_items" id="cartItem">
           </div>
                <div style="clear:left"></div>            
                SubTotal: <span class="simpleCart_total" id="subtotal"></span> <br />
        </div>
        <a href="javascript:;" onclick="extractData()">checkout</a><br/>
    </center>

</body>

</html>