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
    
    // Logo
    $pdf->Image('image/logo3.jpg',10,6,30);
         
    // contact
    $pdf->SetFont('Arial','',22);
    $pdf->SetTextColor(158, 84, 23);
    $pdf->Cell(40);
    $pdf->Cell(10,10,'Shiro Store',0,0,'L');
    $pdf->Ln(10);
    
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(40);
    $pdf->Cell(10,10,'Faculty of Engineering,Mahidol University 25/25 Phutthamomthon 4 Rd.Salaya,,',0,0,'L');
    $pdf->Ln(10);
    
    $pdf->Cell(40);
    $pdf->Cell(10,10,'Nakhon Pathom 73170,Thailand  089-665-6656, 081-426-5458',0,0,'L');
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
            
            //update book in stock
            $sql_selece_b = "SELECT amount FROM book WHERE id_book=".$bid;
            $result_select_b = mysqli_query($link, $sql_selece_b);
            
            $row_s_b = mysqli_fetch_array($result_select_b);
            
            // check order and in stock
            if($row_s_b['amount'] < $bamount) {
    ?>
                <script>alert("Cannot checkout. Please recheck your order in stock.")</script>
                
     <?php
                    redirect('home.php');                             
            }
            else {
                $sql_book = "UPDATE `book` SET `amount`=".$bstock." WHERE `id_book`=".$bid;

                //echo $sql_book;/////////////try////////////

                try {
                    $result_book = mysqli_query($link, $sql_book);

                    //save transaction into DB
                    $sql_tran = "INSERT INTO `transaction`(`id`, `id_book`, `amount`, `price`, `date`)"
                        . "VALUES (".$uid.", ".$bid.", ".$bamount.", ".$btotal_price.", '".$date."')";

             //       echo $sql_tran;//////////////try/////////
                    
                    try {
                        $result_tran = mysqli_query($link, $sql_tran);

                    } catch (Exception $ex) {
        ?>
                    <script>alert("Cannot checkout. Please recheck your order in stock.")</script>

         <?php
                        redirect('home.php');                 
                    }

                } catch(Exception $e) {
         ?>
                    <script>alert("Cannot checkout. Please recheck your order in stock.")</script>

         <?php
                    redirect('home.php'); 
                }// end try cath


/*
                if($currency != '$') {
                    $currency = "Baht";
                }
*/
 /*               echo $i;//////////////try/////////
                echo $bname;//////////////try/////////
                echo $bamount;//////////////try/////////
                echo ($currency.$btotal_price);//////////////try/////////
 */               
                // item
                $pdf->SetFont('Arial','',16);
                $pdf->Cell(10);
                $pdf->Cell(10,10,($i+1),0,0,'L');
                $pdf->Cell(10);
                $pdf->Cell(50,10,$bname,0,0,'L');
                $pdf->Cell(55);
                $pdf->Cell(10,10,$bamount,0,0,'L');
                $pdf->Cell(20);
                $pdf->Cell(10,10,($currency.$btotal_price),0,0,'L');

                // Line break
                $pdf->Ln(15);
        }//end else
    }//end for
/*
    echo $total_item;//////////////try/////////
    echo $currency.$total_price;//////////////try/////////
*/  
    // summary
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(40);
    $pdf->Cell(10,10,"Total",0,0,'L');
    $pdf->SetFont('Arial','',16);
    $pdf->Cell(85);
    $pdf->Cell(10,10,$total_item,0,0,'L');
    $pdf->Cell(20);
    $pdf->Cell(10,10,($currency.$total_price),0,0,'L');

    $pdf->Output();
     
?>