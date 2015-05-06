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
      
    //include fpdf
    require('fpdf/fpdf.php');
    
    // create pdf file
    $pdf = new FPDF();
    $pdf->AddPage();
    
    //set font
    $pdf->SetFont('Arial','B',24);
    
    // head
    $pdf->Cell(92);
    $pdf->Cell(10,10,'Receipt',0,0,'C');
    // Line break
    $pdf->Ln(20);
    
    //firstname
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(10);
    $pdf->Cell(10,10,'First name:',0,0,'L');
    $pdf->Cell(38);
    $pdf->SetFont('Arial','',16);
    $pdf->Cell(10,10,$name,0,0,'C');
    
    //lasttname
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(30);
    $pdf->Cell(10,10,'Last name:',0,0,'L');
    $pdf->Cell(25);
    $pdf->SetFont('Arial','',16);
    $pdf->Cell(10,10,$surname,0,0,'L');
    
    // Line break
    $pdf->Ln(15);
    
    //address
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(10);
    $pdf->Cell(10,10,'Address:',0,0,'L');
    $pdf->Cell(20);
    $pdf->SetFont('Arial','',16);
    $pdf->Cell(10,10,$address,0,0,'L');
    
    // Line break
    $pdf->Ln(15);
    
    //address
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(10);
    $pdf->Cell(10,10,'Phone:',0,0,'L');
    $pdf->Cell(15);
    $pdf->SetFont('Arial','',16);
    $pdf->Cell(10,10,$phone,0,0,'L');
    
    // Line break
    $pdf->Ln(20);
    
    // order
    $pdf->SetFont('Arial','B',20);
    $pdf->Cell(20);
    $pdf->Cell(10,10,'Order:',0,0,'L');
    
    // Line break
    $pdf->Ln(15);
    
    // order title
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(40);
    $pdf->Cell(10,10,'Book\'s name',0,0,'L');
    $pdf->Cell(75);
    $pdf->Cell(10,10,'Amount',0,0,'L');
    $pdf->Cell(30);
    $pdf->Cell(10,10,'Price',0,0,'L');
    
    // Line break
    $pdf->Ln(15);
    
    // item in order
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
            
            $price_temp = (string)$currency.$btotal_price;
            
            //save transaction into DB
            $sql_tran = "INSERT INTO `transaction`(`id`, `id_book`, `amount`, `price`, `date`)"
                    . "VALUES (".$uid.", ".$bid.", ".$bamount.", '".$price_temp."', '".$date."')";
            
            $result_tran = mysqli_query($link, $sql_tran);
            
            //update book in stock
            $sql_book = "UPDATE `book` SET `amount`=".$bstock." WHERE `id_book`=".$bid;
            
            $result_tran = mysqli_query($link, $sql_book);
            
            // item
            $pdf->SetFont('Arial','',16);
            $pdf->Cell(10);
            $pdf->Cell(10,10,($i+1),0,0,'L');
            $pdf->Cell(10);
            $pdf->Cell(50,10,$bname,0,0,'L');
            $pdf->Cell(55);
            $pdf->Cell(10,10,$bamount,0,0,'L');
            $pdf->Cell(20);
            $pdf->Cell(10,10,$price_temp,0,0,'L');
            
            // Line break
            $pdf->Ln(15);
            
     }
     
     // summary
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(40);
    $pdf->Cell(10,10,"Total",0,0,'L');
    $pdf->SetFont('Arial','',16);
    $pdf->Cell(85);
    $pdf->Cell(10,10,$total_item,0,0,'L');
    $pdf->Cell(20);
    $pdf->Cell(10,10,($currency.$total_price),0,0,'L');

    // Line break
    $pdf->Ln(30);
    
    // contact
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(105);
    $pdf->Cell(10,10,'Shiro Store  Faculty of Engineering,Mahidol University,',0,0,'L');
    $pdf->Ln(10);
    
    $pdf->Cell(35);
    $pdf->Cell(10,10,'25/25 Phutthamomthon 4 Rd.Salaya,Nakhon Pathom 73170,Thailand  089-665-6656, 081-426-5458',0,0,'L');
    $pdf->Ln(10);
 /*   
    $pdf->Cell(135);
    $pdf->Cell(10,10,'25/25 Phutthamomthon 4 Rd.,',0,0,'L');
    $pdf->Ln(10);
    
    $pdf->Cell(135);
    $pdf->Cell(10,10,'Salaya,Nakhon Pathom 73170,Thailand',0,0,'L');
    $pdf->Ln(10);
 */   
    $pdf->Cell(145);
    $pdf->Cell(10,10,'',0,0,'L');
    
    $pdf->Output();
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
