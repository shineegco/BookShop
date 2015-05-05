<?php
    // Start session
    session_start(); 
    
    // Include required functions file 
    require_once('include/functions.inc.php'); 
    
    $username = "null";
    
    // check login
    if (check_login_status() == true) { 
        // get username from session
        $username = $_SESSION['username'];

        // get uid from session
        $uid = $_SESSION['uid'];
    }
    
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

    <title>Shiro Store</title>

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
    
    <script>
        // show list of book
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
                                    + '<img src="http://placehold.it/320x150" alt="" style="cursor: pointer" onclick="show_detail('+jsonObj[i].id_book+')">'
                                    + '<div class="caption">'
                                    + '<h4 style="cursor: pointer" onclick="show_detail('+jsonObj[i].id_book+')">'+jsonObj[i].name+'</h4>'
                                    + '<h5>Author: '+jsonObj[i].author+'</h5>'
                                    + '<h5>category: '+jsonObj[i].name_cate+'</h5>'
                                    + '<h4 class="pull-right"> $'+jsonObj[i].price+'</h4>'
                                    + '<h5>In stock: '+jsonObj[i].amount+'</h5>'
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
        
        // show book detail
        function show_detail(id) {
            if($('#book').find('div').length > 0) {
                $('#book').find('div').remove();
            }
            
            var username = $('#username').val();
            
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
                             text =  '<div class="simpleCart_shelfItem">'
                                    + '<div class="pull-left">'
                                    + '<img src="http://placehold.it/320x150" alt="">'
                                    + '</div>'
                                    + '<div class="pull-right">';
                            
                            if(username == "admin"){
                                text = text+ '<h2 class="item_name"><input type="text" id="bname" value="'+jsonObj[i].name+'" readonly></h2>'
                                    + '<h4>Author: <input type="text" id="bauthor" value="'+jsonObj[i].author+'" readonly></h4>'
                                    + '<h4>category: '+jsonObj[i].name_cate+'</h4>'
                                    + '<h4>In stock: <input type="number"  min="1" max="999" id="bamount" value="'+jsonObj[i].amount+'" readonly></h4> <br>'
                                    + '<h4><textarea rows="4" cols="40" id="bdetail" readonly>'+jsonObj[i].detail+'</textarea></h4> <br>'
                                    + '<h4><span class="item_price"> $<input type="text" size="4" id="bprice" value="'+jsonObj[i].price+'" readonly></span>'
                                    + '&nbsp;&nbsp;<input type="button" id="edit" value="Edit" onclick="edit(\''+jsonObj[i].id_book+'\')">'
                                    + '&nbsp;&nbsp;<input type="button" id="delete" value="Delete" onclick="bdelete(\''+jsonObj[i].id_book+'\',\''+jsonObj[i].name+'\')">'
                                    + '&nbsp;&nbsp;<div id="bsave"></div>';
                            }
                            else {
                                text = text + '<h2 class="item_name">'+jsonObj[i].name+'</h2>'
                                    + '<h4>Author: '+jsonObj[i].author+'</h4>'
                                    + '<h4>category: '+jsonObj[i].name_cate+'</h4>'
                                    + '<h4>In stock: '+jsonObj[i].amount+'</h4> <br>'
                                    + '<h4>'+jsonObj[i].detail+'</h4> <br>'
                                    + '<h4><span class="item_price"> $'+jsonObj[i].price+'</span>'
                                    + '&nbsp;&nbsp;&nbsp;<input type="number" class="item_quantity" min="1" max="'+jsonObj[i].amount+'" onchange="cal_price(this.value,'+jsonObj[i].price+')">'
                                    + '&nbsp;&nbsp;&nbsp;Price: <input type="text" id="price" size="5" value="" readonly>'
                                    + '&nbsp;&nbsp;<input type="button" id="change" value="Change to Bath" onclick="change_bath()">'
                                    + '&nbsp;&nbsp;<a class="item_add">Add to cart</a>';
                            }
                                    
                                text = text + '</h4>'
                                    + '</div>'
                                    + '</div>';

                            //alert(text);//////////try/////////

                            $('#book').append(text);
                        }
                    }
                }
            }
            xmlhttp.open("POST","search_book_detail.php?id="+id,true);
            xmlhttp.send();
        }
        
        // calculate price
        function cal_price(amount,price) {
            //alert("amount "+amount+"  price  "+price);///////try////////
            
            var sum = parseInt(amount)*parseInt(price);
            
            $('#price').val('$'+sum);
        }
        
        // change $ to ฿
        function change_bath() {
            // AJAX
    /*        if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    var result = xmlhttp.responseText;
                    
                    alert(result);///////////////try//////////////

                }
            }
            xmlhttp.open("GET","http://www.webservicex.net/CurrencyConvertor.asmx/ConversionRate?FromCurrency=USD&ToCurrency=THB",true);
            xmlhttp.send();
    */
            $.get('http://www.webservicex.net/CurrencyConvertor.asmx/ConversionRate?FromCurrency=USD&ToCurrency=THB',
            {
                 
            }).done(function(result){
                alert(result);//////////try/////////
                           
            });
        }
        
        function edit(id) {
            $('#bname').attr("readonly", false);
            $('#bauthor').attr("readonly", false);
            $('#bamount').attr("readonly", false);
            $('#bdetail').attr("readonly", false);
            $('#bprice').attr("readonly", false);
            
            text = '<input type="button" id="save" value="Save" onclick="save(\''+id+'\')">'
                + '&nbsp;&nbsp;<input type="button" id="cancel" value="Cancel" onclick="cancel()">'
        
            $('#bsave').append(text);
        }
        
        function cancel() {
            $('#bname').attr("readonly", true);
            $('#bauthor').attr("readonly", true);
            $('#bamount').attr("readonly", true);
            $('#bdetail').attr("readonly", true);
            $('#bprice').attr("readonly", true);
            
            $('#save').hide();
            $('#cancel').hide();
        }
        
        function bdelete(id,name) {
            if (confirm("Do you want to delete " + name) == true) {
                $.get('delete_book.php',
               {
                    id: id
               }).done(function(result){
                   //alert(result);//////////try/////////

                   if(result == "success") {
                       alert("Success");
                       location.reload();    
                   }
                   else {
                       alert("Have problem in process. please try again.");
                   }

               });
            }
        }
        
        function save(id) {
            var name = $('#bname').val();
            var author = $('#bauthor').val();
            var amount = $('#bamount').val();
            var detail = $('#bdetail').val();
            var price = $('#bprice').val();
            
            //alert("name  "+name+"  author  "+author+"  amount  "+amount+"  detail  "+detail+"  price  "+price);//////try/////
            
            $.post('update_book.php',
            {
                name: name,
                author: author,
                amount: amount,
                detail: detail,
                price: price,
                id: id   
            }).done(function(result){
                //alert("result "+result);//////////try/////////
                
                if(result == "success") {
                    alert("Success");
                    cancel();
                    //location.reload();
                }
                else {
                    alert("Have problem in process. please try again.");
                }
            });
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
           
                <br><br>
                
           <?php
                  if($username != "admin" && $username != "null") {
           ?>
                <div class="">
                    Cart: <span class="simpleCart_total"></span> (<span class="simpleCart_quantity"></span> items) <br/>
                    <a href="javascript:;" class="simpleCart_empty">Empty Cart</a> 
                    <a href="view_cart.php" class="viewcart">Viewcart</a>
                    <div class="clear"></div>
                </div>
            <?php
                }
            ?>
            </div>

            <div class="col-md-9">

                <input type="hidden" id="username" value="<?php echo $username; ?>">

                <div class="row" id="book">
            <?php
                while ($row = mysqli_fetch_array($result_book)) {
            ?>
                    <div class="col-sm-4 col-lg-4 col-md-4">
                        <div class="thumbnail">
                            <img src="http://placehold.it/320x150" alt="" style="cursor: pointer" onclick="show_detail(<?php echo $row['id_book']; ?>)">
                            <div class="caption">
                                <h4 style="cursor: pointer" onclick="show_detail(<?php echo $row['id_book']; ?>)"><?php echo $row['name']; ?></h4>
                                <h5>Author: <?php echo $row['author']; ?></h5>
                                <h5>category: <?php echo $row['name_cate']; ?></h5>
                                <h4 class="pull-right"> $<?php echo $row['price']; ?> </h4>
                                <h5>In stock: <?php echo $row['amount']; ?></h5>
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
        
        <div>
            <!-- test -->
        </div>
    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>