<?php
    // Start session
    session_start(); 

    // Include required functions file 
    require_once('include/functions.inc.php'); 

    // Check login status... if not logged in, redirect to login screen 
    if (check_login_status() == false) { 
             redirect('login.php'); 
    } 
    
     //include
    require_once('include/config.inc.php');
    
    // get value post
    $uid = $_POST['uid'];
    $total_item = $_POST['total_item'];
    $total_price = $_POST['total_price'];
    $num = $_POST['num'];
    $currency = $_POST['currency'];
    
    //connect Database
    $link = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD) or die("Could not connect to host");
    mysqli_select_db($link, DB_DATABASE) or die("Could not find database");
    
    $sql = "SELECT  username, name, surname, birthday, address, phone, email, U.id "
           ." FROM username U, personinfo P "
           ." WHERE U.id=P.id AND U.id=".$uid;
    
    $result = mysqli_query($link, $sql);
    
    $row = mysqli_fetch_array($result); 
    
    $name = $row['name'];
    $surname = $row['surname'];
    $address = $row['address'];
    $phone = $row['phone'];   
    
    // get current date
    $date = date("Y-m-d");
    
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
        <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    
    <script src="js/jspdf.js"></script>
    
    <script>
        $(function(){
            var doc = new jsPDF();
            var specialElementHandlers = {
                '#editor': function (element, renderer) {
                    return true;
                }
            };

            $('#ok').click(function () {

                 doc.fromHTML($('#bill').get(0), 15, 15, {
                        'width': 170, 
                        'elementHandlers': specialElementHandlers
                });
            });
         });
    </script>

</head>

<body>
    
<center>
    <input type="hidden" id="uid" value="<?php echo $uid; ?>">
    <input type="hidden" id="total_item" value="<?php echo $total_item; ?>">
    <input type="hidden" id="total_price" value="<?php echo $total_price; ?>">
    <input type="hidden" id="num" value="<?php echo $num; ?>">
    
    <div id="bill" style="width: 1000px;">
        <h2>Receive</h2>
        <br>
        <br>
        <table style="border: 0" class="table table-striped table-bordered table-hover" id="dataTables-example">
            <tr>
                <td>
                    First name:
                </td>
                <td>
                   <?php echo $name; ?>
                </td>
                <td>
                    Last name:
                </td>
                <td>
                   <?php echo $surname; ?>
                </td>
            </tr>
            
            <tr>
                <td>
                    Address:
                </td>
                <td colspan="3">
                   <?php echo $address; ?>
                </td>
            </tr>
            <tr>
                <td>
                    Phone:
                </td>
                <td colspan="3">
                   <?php echo $phone; ?>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    Order:
                </td>
            </tr>
            <tr>
                <td>
                </td>
                <td>
                   Book's name
                </td>
                <td>
                   Amount
                </td>
                <td>
                   Price
                </td>
            </tr>
<?php
        for($i=0; $i<$num; $i++) {
            $bid_n = (string)"bid".$i;
            $bid = $_POST[$bid_n];
            
            $bname_n = (string)"bname".$i;
            $bname = $_POST[$bname_n];
            
            $bamount_n = (string)"bamount".$i;
            $bamount = $_POST[$bamount_n];
            
            $bprice_n = (string)"bprice".$i;
            $bprice = $_POST[$bprice_n];
            
            $btotal_price_n = (string)"btotal_price".$i;
            $btotal_price = $_POST[$btotal_price_n];
            
            $bstock_n = (string)"bstock".$i;
            $bstock = $_POST[$bstock_n];
            
            $price_temp = (string)$currency.$bprice;
            
            //save transaction into DB
            $sql_tran = "INSERT INTO `transaction`(`id`, `id_book`, `amount`, `price`, `date`)"
                    . "VALUES (".$uid.", ".$bid.", ".$bamount.", '".$price_temp."', '".$date."')";
            
            $result_tran = mysqli_query($link, $sql_tran);
            
            //update book in stock
            $sql_book = "UPDATE `book` SET `amount`=".$bstock." WHERE `id_book`=".$bid;
            
            $result_tran = mysqli_query($link, $sql_book);
            
?>
            <input type="hidden" id="id_book<?php echo $i;?>" value="<?php echo $bid; ?>">
            <input type="hidden" id="b_total_price<?php echo $i;?>" value="<?php echo $btotal_price; ?>">
            <input type="hidden" id="b_amount<?php echo $i;?>" value="<?php echo $bamount; ?>">
            <input type="hidden" id="b_stock<?php echo $i;?>" value="<?php echo $bstock; ?>">
            <tr>
                <td>
                    <?php echo $i+1; ?>
                </td>
                <td>
                   <?php echo $bname; ?>
                </td>
                <td>
                   <?php echo $bamount; ?>
                </td>
                <td id="cart_total_price<?php echo $i; ?>">
                   <?php echo $currency.$btotal_price; ?>
                </td>
            </tr>
<?php
        }
?>
            <tr>
                <td>
                </td>
                <td>
                </td>
                <td id="cart_total_item">
                   <?php echo $total_item; ?>
                </td>
                <td id="cart_total_price">
                   <?php echo $currency.$total_price; ?>
                </td>
            </tr>
      
        </table>
        
        <div class="pull-right">
            <a id="ok">OK</a>
            &nbsp;&nbsp;
            <a href="home.php">Cancel</a>
        </div>
    </div>
    
    
</center>
</body>
</html>