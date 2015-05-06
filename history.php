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
    
    <center>
    <div id="page-wrapper" style="width: 1000px;">
    <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">History</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php echo "Username: ". $_SESSION['username']; ?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Order id</th>
                                            <th>Book's name</th>
                                            <th>Author</th>
                                            <th>Amount</th>
                                            <th>Price</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody id="result">
                                        
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
        
     <!--   <div id="test"></div>   -->
    </center>

  
    <!-- jQuery -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                    responsive: true
            });
        });
        
        function load_data(id) {
            // AJAX
        /*    $.post('history_background.php',
            {
                id: id   
            }).done(function(result){
                alert(result);//////////try/////////
                
                var jsonObj = JSON.parse(result);
                
                alert(jsonObj.length);//////////try/////////
                
                for(var i = 0; i < jsonObj.length; i++) {
                    text = '<tr class="odd gradeX">'
                        + '<td>'+jsonObj[i].id_transaction+'</td>'
                        + '<td>'+jsonObj[i].name+'</td>'
                        + '<td>'+jsonObj[i].author+'</td>'
                        + '<td class="center">'+jsonObj[i].amount+'</td>'
                        + '<td class="center">'+jsonObj[i].price+'</td>'
                        + '<td class="center">'+jsonObj[i].date+'</td>'
                        + '</tr>';
                
                    alert(text);//////////try/////////
                    
                    $('#result').append(text);
                }
                
            });
        */
       
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
                             text = '<tr class="odd gradeX">'
                                + '<td>'+jsonObj[i].id_transaction+'</td>'
                                + '<td>'+jsonObj[i].name+'</td>'
                                + '<td>'+jsonObj[i].author+'</td>'
                                + '<td class="center">'+jsonObj[i].amount+'</td>'
                                + '<td class="center">'+jsonObj[i].price+'</td>'
                                + '<td class="center">'+jsonObj[i].date+'</td>'
                                + '</tr>';

                            //alert(text);//////////try/////////

                            $('#result').append(text);
                        }
                    }
                }
            }
            xmlhttp.open("POST","history_background.php?id="+id,true);
            xmlhttp.send();
        }
    </script>
    
     <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Shiro Store Co,.Ltd 2014</p>
                </div>
            </div>
        </footer>
</body>
</html>