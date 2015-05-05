<?php
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
        
        if($username == "admin") {
            redirect('home.php');
        }
    }
    
    //include
    require_once('include/config.inc.php');

    //connect Database
    $link = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD) or die("Could not connect to host");
    mysqli_select_db($link, DB_DATABASE) or die("Could not find database");

    $sql = "SELECT  username, name, surname, birthday, address, phone, email, U.id "
           ." FROM username U, personinfo P "
           ." WHERE U.id=P.id AND username='".$username."' AND U.id=".$uid;

    
    //echo $sql;/////////////try///////////
    
    $result = mysqli_query($link, $sql);
    
    $num_row = mysqli_num_rows($result);
    
    $row = mysqli_fetch_array($result);   
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

<!--    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet"> -->
    <style type="text/css">
        .user-row {
            margin-bottom: 14px;
        }

        .user-row:last-child {
            margin-bottom: 0;
        }

        .dropdown-user {
            margin: 13px 0;
            padding: 5px;
            height: 100%;
        }

        .dropdown-user:hover {
            cursor: pointer;
        }

        .table-user-information > tbody > tr {
            border-top: 1px solid rgb(221, 221, 221);
        }

        .table-user-information > tbody > tr:first-child {
            border-top: 0;
        }


        .table-user-information > tbody > tr > td {
            border-top: 0;
        }
        .toppad
        {margin-top:20px;
        }
        
        /* button */
        .btn-sample { 
            color: #ffffff; 
            background-color: #BD411B; 
            border-color: #9E461E; 
            border-top-left-radius: 5px 5px;
            border-bottom-left-radius: 5px 5px;
            border-bottom-right-radius: 5px 5px;
            border-top-right-radius: 5px 5px;
          } 

          .btn-sample:hover, 
          .btn-sample:focus, 
          .btn-sample:active, 
          .btn-sample.active, 
          .open .dropdown-toggle.btn-sample { 
            color: #ffffff; 
            background-color: #F7A071; 
            border-color: #9E461E; 
          } 

          .btn-sample:active, 
          .btn-sample.active, 
          .open .dropdown-toggle.btn-sample { 
            background-image: none; 
          } 

          .btn-sample.disabled, 
          .btn-sample[disabled], 
          fieldset[disabled] .btn-sample, 
          .btn-sample.disabled:hover, 
          .btn-sample[disabled]:hover, 
          fieldset[disabled] .btn-sample:hover, 
          .btn-sample.disabled:focus, 
          .btn-sample[disabled]:focus, 
          fieldset[disabled] .btn-sample:focus, 
          .btn-sample.disabled:active, 
          .btn-sample[disabled]:active, 
          fieldset[disabled] .btn-sample:active, 
          .btn-sample.disabled.active, 
          .btn-sample[disabled].active, 
          fieldset[disabled] .btn-sample.active { 
            background-color: #BD411B; 
            border-color: #9E461E; 
          } 

          .btn-sample .badge { 
            color: #BD411B; 
            background-color: #ffffff; 
          }   
          
          /* button2 */
          .btn-sample2 { 
            color: #ffffff; 
            background-color: #F07041; 
            border-color: #E37E3B; 
            border-top-left-radius: 5px 5px;
            border-bottom-left-radius: 5px 5px;
            border-bottom-right-radius: 5px 5px;
            border-top-right-radius: 5px 5px;
          } 

          .btn-sample2:hover, 
          .btn-sample2:focus, 
          .btn-sample2:active, 
          .btn-sample2.active, 
          .open .dropdown-toggle.btn-sample2 { 
            color: #ffffff; 
            background-color: #F2BA77; 
            border-color: #E37E3B; 
          } 

          .btn-sample2:active, 
          .btn-sample2.active, 
          .open .dropdown-toggle.btn-sample2 { 
            background-image: none; 
          } 

          .btn-sample2.disabled, 
          .btn-sample2[disabled], 
          fieldset[disabled] .btn-sample2, 
          .btn-sample2.disabled:hover, 
          .btn-sample2[disabled]:hover, 
          fieldset[disabled] .btn-sample2:hover, 
          .btn-sample2.disabled:focus, 
          .btn-sample2[disabled]:focus, 
          fieldset[disabled] .btn-sample2:focus, 
          .btn-sample2.disabled:active, 
          .btn-sample2[disabled]:active, 
          fieldset[disabled] .btn-sample2:active, 
          .btn-sample2.disabled.active, 
          .btn-sample2[disabled].active, 
          fieldset[disabled] .btn-sample2.active { 
            background-color: #F07041; 
            border-color: #E37E3B; 
          } 

          .btn-sample2 .badge { 
            color: #F07041; 
            background-color: #ffffff; 
          }
    </style>
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

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
    
    <div class="container">
      <div class="row">
          <div class="col-md-5  toppad  pull-right col-md-offset-3 ">
             
           </div>
       <br>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
   
   
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title"> <?php echo $row['username']; ?> </h3>
            </div>
            <div class="panel-body">
                <div class="row">
                
                <div class=" col-md-9 col-lg-9 "> 
                    <table class="table table-user-information">
                    <tbody>
                      <tr>
                        <td>First name</td>
                        <td><input type="text" id="name" name="name" required="" pattern="^[a-zA-Z]+" value="<?php echo $row['name']; ?>" readonly ></td>
                      </tr>
                      <tr>
                        <td>Last name</td>
                        <td><input type="text" id="surname" name="surname" required="" pattern="^[a-zA-Z]+" value="<?php echo $row['surname']; ?>" readonly ></td>
                      </tr>
                      <tr>
                        <td>Date of Birth</td>
                        <td><input type="date" id="birthday" name="birthday" value="<?php echo $row['birthday']; ?>" readonly ></td>
                      </tr>
                      <tr>
                        <td>Email</td>
                        <td><input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" readonly ></td>
                      </tr>
                      <tr>
                        <td>Address</td>
                        <td><textarea rows="4" cols="50" id="address" name="address" required="" pattern="[a-zA-Z0-9 .-_/]+" readonly ><?php echo $row['address']; ?></textarea></td>
                      </tr>
                        <td>Phone Number</td>
                        <td><input type="text" id="phone" name="phone" required="" pattern="[0-9]{10}" value="<?php echo $row['phone']; ?>" readonly ></td>
                        <input type="hidden" id="uid" name="uid" value="<?php echo $row['id']; ?>"> 
                      </tr>
                     
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
                 <div class="panel-footer">                     
                        <span class="pull-right">
                            <input type="button" id="save" value="save" class="btn-sample" onclick="save()">
                            <input type="button" id="cancel" value="cancel" class="btn-sample2" onclick="cancel()">
                            <a data-original-title="Edit this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-warning" onclick="edit()"><i class="glyphicon glyphicon-edit"></i></a>
                            <a href="include/logout.inc.php" data-original-title="Logout" data-toggle="tooltip" type="button" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
                        </span>
                     
                        <br>
                 </div>
            
           <!--   <div id="test"></div>     -->
          </div>
        </div>
      </div>
    </div>
    
    <script type="text/javascript">
        $(document).ready(function() {
            var panels = $('.user-infos');
            var panelsButton = $('.dropdown-user');
            panels.hide();
            
            $('#save').hide();
            $('#cancel').hide();

            //Click dropdown
            panelsButton.click(function() {
                //get data-for attribute
                var dataFor = $(this).attr('data-for');
                var idFor = $(dataFor);

                //current button
                var currentButton = $(this);
                idFor.slideToggle(400, function() {
                    //Completed slidetoggle
                    if(idFor.is(':visible'))
                    {
                        currentButton.html('<i class="glyphicon glyphicon-chevron-up text-muted"></i>');
                    }
                    else
                    {
                        currentButton.html('<i class="glyphicon glyphicon-chevron-down text-muted"></i>');
                    }
                })
            });


            $('[data-toggle="tooltip"]').tooltip();

            $('button').click(function(e) {
                e.preventDefault();
                alert("This is a demo.\n :-)");
            });
        });
        
        function edit() {
            $('#name').attr("readonly", false);
            $('#surname').attr("readonly", false);
            $('#birthday').attr("readonly", false);
            $('#email').attr("readonly", false);
            $('#address').attr("readonly", false);
            $('#phone').attr("readonly", false);
            
            $('#name').focus();
            $('#save').show();
            $('#cancel').show();
        }
        
        function cancel() {
            $('#name').attr("readonly", true);
            $('#surname').attr("readonly", true);
            $('#birthday').attr("readonly", true);
            $('#email').attr("readonly", true);
            $('#address').attr("readonly", true);
            $('#phone').attr("readonly", true);
            
            $('#save').hide();
            $('#cancel').hide();
        }
        
        function save() {
            var name = $('#name').val();
            var surname = $('#surname').val();
            var birthday = $('#birthday').val();
            var email = $('#email').val();
            var address = $('#address').val();
            var phone = $('#phone').val();
            var id = $('#uid').val();
            
            var parameter = "name"+name;
                    parameter = parameter + "&surname="+surname;
                    parameter = parameter + "&birthday="+birthday;
                    parameter = parameter + "&address="+address;
                    parameter = parameter + "&phone="+phone;
                    parameter = parameter + "&email="+email;
                    parameter = parameter + "&id="+id;
            //alert("parameter  "+parameter);////////////try/////////
            // AJAX
           /* if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    result = xmlhttp.responseText;
                    
                    alert("result "+result);//////////try/////////
                    if(result == "success") {
                        alert("Success");
                        location.reload();
                    }
                    else {
                        alert("Have problem in process. please try again.");
                    }
                }
            }
            xmlhttp.open("POST","update_personinfo.php?"+parameter,true);
            xmlhttp.send();
          */
         
            $.post('update_personinfo.php',
            {
                name: name,
                surname: surname,
                birthday: birthday,
                address: address,
                phone: phone,
                email: email,
                id: id   
            }).done(function(result){
                //alert("result "+result);//////////try/////////
               // $('#test').html(result);
                
                if(result == "success") {
                    alert("Success");
                    location.reload();
                }
                else {
                    alert("Have problem in process. please try again.");
                }
            });
        }
    </script>
    
</body>
</html>

