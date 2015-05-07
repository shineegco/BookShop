<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- This file has been downloaded from Bootsnipp.com. Enjoy! -->
    <title>Book Store</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
        body {
    padding-top: 90px;
}
.panel-login {
	border-color: #ccc;
	-webkit-box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
	-moz-box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
	box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
}
.panel-login>.panel-heading {
	color: #00415d;
	background-color: #fff;
	border-color: #fff;
	text-align:center;
}
.panel-login>.panel-heading a{
	text-decoration: none;
	color: #666;
	font-weight: bold;
	font-size: 15px;
	-webkit-transition: all 0.1s linear;
	-moz-transition: all 0.1s linear;
	transition: all 0.1s linear;
}
.panel-login>.panel-heading a.active{
	color: #9E5417;
	font-size: 18px;
}
.panel-login>.panel-heading hr{
	margin-top: 10px;
	margin-bottom: 0px;
	clear: both;
	border: 0;
	height: 1px;
	background-image: -webkit-linear-gradient(left,rgba(0, 0, 0, 0),rgba(0, 0, 0, 0.15),rgba(0, 0, 0, 0));
	background-image: -moz-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
	background-image: -ms-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
	background-image: -o-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
}
.panel-login input[type="text"],.panel-login input[type="email"],.panel-login input[type="password"] {
	height: 45px;
	border: 1px solid #ddd;
	font-size: 16px;
	-webkit-transition: all 0.1s linear;
	-moz-transition: all 0.1s linear;
	transition: all 0.1s linear;
}
.panel-login input:hover,
.panel-login input:focus {
	outline:none;
	-webkit-box-shadow: none;
	-moz-box-shadow: none;
	box-shadow: none;
	border-color: #ccc;
}
.btn-login {
	background-color: #9E5417;
	outline: none;
	color: #fff;
	font-size: 14px;
	height: auto;
	font-weight: normal;
	padding: 14px 0;
	text-transform: uppercase;
	border-color: #9E5420;
}
.btn-login:hover,
.btn-login:focus {
	color: #fff;
	background-color: #6A3F1B;
	border-color: #53A3CD;
}
.forgot-password {
	text-decoration: underline;
	color: #888;
}
.forgot-password:hover,
.forgot-password:focus {
	text-decoration: underline;
	color: #666;
}

.btn-register {
	background-color: #9E5417;
	outline: none;
	color: #fff;
	font-size: 14px;
	height: auto;
	font-weight: normal;
	padding: 14px 0;
	text-transform: uppercase;
	border-color: #9E5420;
}
.btn-register:hover,
.btn-register:focus {
        color: #fff;
	background-color: #6A3F1B;
	border-color: #53A3CD;
}

    </style>
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
</head>
<body style="background-color: #9E5417;">
    
    
    
<div class="container">
    	<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-login">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-6">
								<a href="#" class="active" id="login-form-link">Login</a>
							</div>
							<div class="col-xs-6">
								<a href="#" id="register-form-link">Register</a>
							</div>
						</div>
						<hr>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
                                                            
                                                            <center>    <img src="image/logo3.jpg"></center> 
								<form id="login-form" action="include/login.inc.php" method="post" role="form" style="display: block;">
									<div class="form-group">
										<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="" autofocus>
									</div>
									<div class="form-group">
										<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password" value="">
									</div>
                                                                    <br>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Log In">
											</div>
										</div>
									</div>
                                                                    <br>
								</form>
								<form id="register-form" action="register.php" method="post" role="form" style="display: none;">
									<div class="form-group">
                                                                            <input type="text" name="username" id="username" tabindex="1" required="" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$" class="form-control" placeholder="Username" value="" autofocus>
									</div>
									<div class="form-group">
                                                                            <input type="email" name="email" id="email" tabindex="1" required="" class="form-control" placeholder="Email Address" value="">
									</div>
									<div class="form-group">
                                                                            <input type="password" name="pass" id="pass" tabindex="2" required="" pattern="^[a-zA-Z0-9]+" class="form-control" placeholder="Password (Alphabic or Number only)" value="">
									</div>
									<div class="form-group">
                                                                            <input type="password" name="confirm_password" id="confirm_password" required="" pattern="^[a-zA-Z0-9]+" tabindex="2" class="form-control" onchange="checkPassword()" placeholder="Confirm Password" value="">
									</div>
                                                                        <div class="form-group">
										<input type="text" name="firstname" id="firstname" tabindex="3" required="" pattern="^[a-zA-Z]+" class="form-control" placeholder="FirstName" value="">
									</div>
                                                                        <div class="form-group">
										<input type="text" name="lastname" id="lastname" tabindex="3" required="" pattern="^[a-zA-Z]+" class="form-control" placeholder="LastName" value="">
									</div>
                                                                        <div class="form-group">
										<input type="date" name="birthdate" id="birthdate" tabindex="3" required="" class="form-control" placeholder="Date of Birth" value="">
									</div>
                                                                        <div class="form-group">
                                                                            <textarea rows="4" cols="50" name="address" id="address" tabindex="3" required="" pattern="[a-zA-Z0-9 .-_/]+" class="form-control" placeholder="Address" value=""></textarea>
									</div>
                                                                        <div class="form-group">
										<input type="text" name="phone" id="phone" tabindex="3" class="form-control" required="" pattern="[0-9]{10}" placeholder="Phone no. (ex. 08xxxxxxxx)" value="">
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
                                                                                            <input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Register Now">
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<script type="text/javascript">
    $(function() {

        $('#login-form-link').click(function(e) {
                    $("#login-form").delay(100).fadeIn(100);
                    $("#register-form").fadeOut(100);
                    $('#register-form-link').removeClass('active');
                    $(this).addClass('active');
                    e.preventDefault();
            });
            $('#register-form-link').click(function(e) {
                    $("#register-form").delay(100).fadeIn(100);
                    $("#login-form").fadeOut(100);
                    $('#login-form-link').removeClass('active');
                    $(this).addClass('active');
                    e.preventDefault();
            });

    });
    
    function checkPassword() {
        var password = $('#pass').val();
        var password_conf = $('#confirm_password').val();
        
        //alert("password  "+password+"  repass  "+password_conf);/////////try///////////
        
        if(password != password_conf && password != "" && password_conf != "") {
            alert("Please check confirm password");
            $('#confirm_password').focus();
        }
    }
/*    
    function register() {
        var patt = new RegExp("[a-zA-Z0-9]");
        var patt_phone = new RegExp("[0-9]{10}");
        var patt_user = new RegExp("^[a-zA-Z0-9-_]{1,20}$");
        var patt_name = new RegExp("[a-zA-Z]+");
        var patt_addr = new RegExp("[#$%^*?!~`]");
        var error = "";
        
        var username = $('#username').val();
        alert("user  "+username+"  "+patt_user.test(username));////////////try/////////
        if(!patt_user.test(username)) {
            error = error + " username";
        }
        
        var password = $('#password').val();
        alert("password  "+password+"  "+patt.test(password));////////////try/////////
        if(!patt.test(password)) {
            error = error + " password";
        }
        
        var password_conf = $('#confirm_password').val;
        if(!password_conf) {
            error = error + " confirm password"
        }
        
        var email = $('#email').val();
        if(!email) {
            error = error + " email";
        }
        
        var name = $('#firstname').val();
        alert("name  "+name+"  "+patt_name.test(name));////////////try/////////
        if(!patt_name.test(name)) {
            error = error + " name";
        }
        
        var surname = $('#lastname').val();
        alert("surname  "+surname+"  "+patt_name.test(surname));////////////try/////////
        if(!patt_name.test(surname)) {
            error = error + " surname";
        }
        
        var birthdate = $('#birthdate').val();
        if(!birthdate) {
            error = error + " birthdate";
        }
        
        var address = $('#address').val();
        alert("address  "+address+"  "+patt_addr.test(address));////////////try/////////
        if(patt_addr.test(address)) {
            error = error + " address";
        }
        
        var phone = $('#phone').val();
        alert("phone  "+phone+"  "+patt_phone.test(phone));////////////try/////////
        if(!patt_phone.test(phone)) {
            error = error + " phone";
        }
        
        if(error == "") {
            if(password == password_conf) {
                var parameter = "username="+username;
                    parameter = parameter + "&password"+password;
                    parameter = parameter + "&email"+email;
                    parameter = parameter + "&name"+name;
                    parameter = parameter + "&surname"+surname;
                    parameter = parameter + "&birthdate"+birthdate;
                    parameter = parameter + "&address"+address;
                    parameter = parameter + "&phone"+phone;
                    
                alert("parameter  "+parameter);///////////////try/////////////
                
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
                        result = xmlhttp.responseText;
                        if(result == "success") {
                            alert("Success");
                            location.reload();
                        }
                        else {
                            alert("Have problem in process. please try again.");
                        }
                    }
                }
                //xmlhttp.open("POST","register.php?"+parameter,true);
                //xmlhttp.send();
            }
            else {
                alert("Please re check password and confirm password");
            }
        }
        else {
            alert("Please fill in "+error);
        }
    }
*/
</script>
</body>
</html>
