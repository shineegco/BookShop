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
    $sql_book = "SELECT * FROM category C, book B WHERE C.id_category=B.id_category AND C.id_category=1 AND remove=0";
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
    

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <script>
        var num_item = 0;
       
        // show list of book
        function show_book(id) {
            // clear list book old
            if($('#book').find('div').length > 0) {
                $('#book').find('div').remove();
            }
            // clear view cart
            if($('#book').find('table').length > 0){
                $('#book').find('table').remove();
                $('#book').find('h4').remove();
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
                            if(jsonObj[i].amount > 0) {
                                text =  '<div class="col-sm-4 col-lg-4 col-md-4">'
                                       + '<div class="thumbnail">'
                                       + '<img src="'+jsonObj[i].picture+'" height="500px" width="330px" alt="" style="cursor: pointer; max-width: 100%; max-height: 100%; background-size: contain;" onclick="show_detail('+jsonObj[i].id_book+')">'
                                       + '<div class="caption">'
                                       + '<h4 style="cursor: pointer" onclick="show_detail('+jsonObj[i].id_book+')">'+jsonObj[i].name+'</h4>'
                                       + '<h5>Author: '+jsonObj[i].author+'</h5>'
                                       + '<h5>category: '+jsonObj[i].name_cate+'</h5>'
                                       + '<h4 class="pull-right"> $'+jsonObj[i].price+'</h4>'
                                       + '<h5>In stock: '+jsonObj[i].amount+'</h5>'
                                       + '</div>'
                                       + '</div>'
                                       + '</div>';
                            }
                            else {
                                text =  '<div class="col-sm-4 col-lg-4 col-md-4">'
                                       + '<div class="thumbnail">'
                                       + '<img src="'+jsonObj[i].picture+'" height="500px" width="330px" alt="" style="cursor: pointer; max-width: 100%; max-height: 100%; background-size: contain;" onclick="show_detail('+jsonObj[i].id_book+')">'
                                       + '<div class="caption">'
                                       + '<h4 style="cursor: pointer" onclick="show_detail('+jsonObj[i].id_book+')">'+jsonObj[i].name+'</h4>'
                                       + '<h5>Author: '+jsonObj[i].author+'</h5>'
                                       + '<h5>category: '+jsonObj[i].name_cate+'</h5>'
                                       + '<h4 class="pull-right"> $'+jsonObj[i].price+'</h4>'
                                       + '<h4 style="color: red">SOLD OUT</h4>'
                                       + '</div>'
                                       + '</div>'
                                       + '</div>';
                            }

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
            // clear list book old
            if($('#book').find('div').length > 0) {
                $('#book').find('div').remove();
            }
            // clear view cart
            if($('#book').find('table').length > 0){
                $('#book').find('table').remove();
                $('#book').find('h4').remove();
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
                                    + '<div class="">'
                                    + '<img src="'+jsonObj[i].picture+'" alt="" height="500px" width="330px" style="max-width: 100%; max-height: 100%; background-size: contain;">'
                                    + '</div>'
                                    + '<div class=""> <br>';
                            
                            if(username == "admin"){
                                text = text+ '<h2 class="item_name"><input type="text" id="bname" value="'+jsonObj[i].name+'" readonly></h2>'
                                    + '<h4>Author: <input type="text" id="bauthor" value="'+jsonObj[i].author+'" readonly></h4>'
                                    + '<h4>category: '+jsonObj[i].name_cate+'</h4>'
                                    + '<h4>In stock: <input type="number"  min="1" max="999" id="bamount" value="'+jsonObj[i].amount+'" readonly></h4> <br>'
                                    + '<h4><textarea rows="6" cols="80" id="bdetail" readonly>'+jsonObj[i].detail+'</textarea></h4> <br>'
                                    + '<h4><span class="item_price"> $<input type="text" size="4" id="bprice" value="'+jsonObj[i].price+'" readonly></span>'
                                    + '&nbsp;&nbsp;<input type="button" id="edit" value="Edit" onclick="edit(\''+jsonObj[i].id_book+'\')">'
                                    + '&nbsp;&nbsp;<input type="button" id="delete" value="Delete" onclick="bdelete(\''+jsonObj[i].id_book+'\',\''+jsonObj[i].name+'\')">'
                                    + '<br>&nbsp;&nbsp;&nbsp;&nbsp;<div id="bsave"></div>';
                            }
                            else if(username != "admin" && username != "null") {
                                if(jsonObj[i].amount > 0) {
                                    text = text + '<h2 class="" id="book_name">'+jsonObj[i].name+'</h2>'
                                        + '<input type="hidden" id="book_id" value="'+jsonObj[i].id_book+'">'
                                        + '<h4 >Author: '+jsonObj[i].author+'</h4>'
                                        + '<h4>category: '+jsonObj[i].name_cate+'</h4>'
                                        + '<h4>In stock: <span id="book_stock">'+jsonObj[i].amount+'</span></h4> <br>'
                                        + '<h4>'+jsonObj[i].detail+'</h4> <br>'
                                        + '<h4><span class="" id="book_price"> $'+jsonObj[i].price+'</span>'
                                        + '&nbsp;&nbsp;&nbsp;Amount: <input type="number" class="" id="book_amount" min="1" max="'+jsonObj[i].amount+'" onchange="cal_price(this.value,'+jsonObj[i].price+')">'
                                        + '&nbsp;&nbsp;&nbsp;Price: <input type="text" id="book_total_price" size="5" value="" readonly>'
                                        + '&nbsp;&nbsp;<input type="button" class="" value="Add to cart" onclick="add_to_cart()">';
                                }
                                else {
                                    text = text + '<h2 class="" id="book_name">'+jsonObj[i].name+'</h2>'
                                        + '<input type="hidden" id="book_id" value="'+jsonObj[i].id_book+'">'
                                        + '<h4 >Author: '+jsonObj[i].author+'</h4>'
                                        + '<h4>category: '+jsonObj[i].name_cate+'</h4>'
                                        + '<h4>'+jsonObj[i].detail+'</h4> <br>'
                                        + '<h4><span class="" id="book_price"> $'+jsonObj[i].price+'</span>'
                                        + '<h2 style="color: red">SOLD OUT</h2>';
                                }
                            }
                            else {
                                if(jsonObj[i].amount > 0) { 
                                    text = text + '<h2 class="" id="book_name">'+jsonObj[i].name+'</h2>'
                                       + '<input type="hidden" id="book_id" value="'+jsonObj[i].id_book+'">'
                                       + '<h4 >Author: '+jsonObj[i].author+'</h4>'
                                       + '<h4>category: '+jsonObj[i].name_cate+'</h4>'
                                       + '<h4>In stock: <span id="book_stock">'+jsonObj[i].amount+'</span></h4> <br>'
                                       + '<h4>'+jsonObj[i].detail+'</h4> <br>'
                                       + '<h4><span class="" id="book_price"> $'+jsonObj[i].price+'</span>';
                               }
                               else {
                                   text = text + '<h2 class="" id="book_name">'+jsonObj[i].name+'</h2>'
                                       + '<input type="hidden" id="book_id" value="'+jsonObj[i].id_book+'">'
                                       + '<h4 >Author: '+jsonObj[i].author+'</h4>'
                                       + '<h4>category: '+jsonObj[i].name_cate+'</h4>'
                                       + '<h4>'+jsonObj[i].detail+'</h4> <br>'
                                       + '<h4><span class="" id="book_price"> $'+jsonObj[i].price+'</span>'
                                       + '<h2 style="color: red">SOLD OUT</h2>';
                               }
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
            
            $('#book_total_price').val('$'+sum);
        }
        
        function edit(id) {
            $('#bname').attr("readonly", false);
            $('#bauthor').attr("readonly", false);
            $('#bamount').attr("readonly", false);
            $('#bdetail').attr("readonly", false);
            $('#bprice').attr("readonly", false);
            
            $('#bsave').html('');
            
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
            
            location.reload();  
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
            var error = "";
            
            var name = $('#bname').val();
            if(!name) {
                error = error + " Book's name ";
            }
            if(!(/^[a-zA-Z0-9- ']*$/.test(name))) {
                error = error + " Book's name ";
            }
            
            var author = $('#bauthor').val();
            if(!author) {
                error = error + " Author ";
            }
            if(!(/^[a-zA-Z0-9- ']*$/.test(author))) {
                error = error + " Author ";
            }
            
            var amount = $('#bamount').val();
            
            var detail = $('#bdetail').val();
            if(!detail) {
                error = error + " Author ";
            }
            if(!(/^[a-zA-Z0-9- '?.&,()]*$/.test(detail))) {
                error = error + " Detail ";
            }
            
            var price = $('#bprice').val();
            if(!price) {
                error = error + " Price ";
            }
            if(parseInt(price) != price || price <= 0) {
                error = error + " Price ";
            }
            
            
            //salert(error);////////try//////
            //alert("name  "+name+"  author  "+author+"  amount  "+amount+"  detail  "+detail+"  price  "+price);//////try/////
            
            if(error != "") {
                alert("Please recheck "+error);
            }
            else {
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
        }
        
        // clear item in cart
        function empty_cart(){
            // clear cart list old
            if($('#cart_list').find('input').length > 0) {
                $('#cart_list').find('input').remove();
            }
            // clear table view cart old
            if($('#book').find('table').length > 0){
                $('#book').find('table').remove();
                $('#book').find('h4').remove();
            }
            
            $('#total_price').html("0");
            $('#total_item').html("0");
            $('#sum').val("0");
            
            num_item = 0;
        }
        
        // add item into cart
        function add_to_cart() {
            var error = "";
            
            var b_id = $('#book_id').val();
            var b_name = $('#book_name').html();            
            var b_price = $('#book_price').html();
            b_price = b_price.substr(b_price.indexOf('$')+1);
                                
            var b_amount = $('#book_amount').val();
            if(!b_amount) {
                error = error + " amount ";
            }
            else {
                b_amount = parseInt($('#book_amount').val());
                
                var b_total_price = $('#book_total_price').val();
                b_total_price = parseInt(b_total_price.substr(b_total_price.indexOf('$')+1));
                
            }
            var stock = parseInt($('#book_stock').html());
            alert
            var stock_new = stock - b_amount;
            
            if(error != "") {
                alert("Please choose"+error+"of book to order");
            }
            else {
                //alert("b_id  "+b_id+"  b_name  "+b_name+"  b_total_price  "+b_total_price+"  b_amount  "+b_amount+"  b_price  "+b_price);/////try//////

                // check order 
                for(i=0; i<num_item; i++) {
                    $('#b_id'+i).val() == b_id) {
                        var tp = parseInt($('#b_total_price'+i).val());
                        $('#b_total_price'+i).val();
                        
                    }
                    else {
                        text = '<input type="hidden" id="b_id'+num_item+'" name="b_id'+num_item+'" value="'+b_id+'">'
                            + '<input type="hidden" id="b_name'+num_item+'" name="b_name'+num_item+'" value="'+b_name+'">'
                            + '<input type="hidden" id="b_total_price'+num_item+'" name="b_total_price'+num_item+'" value="'+b_total_price+'">'
                            + '<input type="hidden" id="b_amount'+num_item+'" name="b_amount'+num_item+'" value="'+b_amount+'">'
                            + '<input type="hidden" id="b_price'+num_item+'" name="b_price'+num_item+'" value="'+b_price+'">'
                            + '<input type="hidden" id="b_stock'+num_item+'" name="b_stock'+num_item+'" value="'+stock_new+'">';

                        // add item to cart list
                        $('#cart_list').append(text);
                    }
                }
                
                // show total price and total item to order
                var tot_p = parseInt($('#total_price').html());
                $('#total_price').html(tot_p+b_total_price);
                
                var tot_i = parseInt($('#total_item').html());
                $('#total_item').html(tot_i+b_amount);
                
                var sum = parseInt($('#sum').val());
                $('#sum').val(sum+1);
                
                num_item++;
            }
        }
        
        // view all item of order
        function view_cart() {
            // clear list book old
            if($('#book').find('div').length > 0) {
                $('#book').find('div').remove();
            }
            // clear table view cart old
            if($('#book').find('table').length > 0){
                $('#book').find('table').remove();
            }
            
            head = '<table class="table table-striped table-bordered table-hover" id="dataTables-example">'
                 + '<thead>'
                 + '<tr>'
                 + '<th></th>'
                 + '<th>Book\'s name</th>'
                 + '<th>Amount</th>'
                 + '<th>Price</th>'
                 + '<th></th>'
                 + '</tr>'
                 + '</thead>'
                 + '<tbody id="result">';
         
            //$('#book').append(head);
           
            for(i=0; i<num_item; i++) {
                text = "<tr id=\"cart"+i+"\">"
                    + "<td id=\"cart_id"+i+"\">"+(i+1)+"</td>"
                    + "<td>"+$('#b_name'+i).val()+"</td>"
                    + "<td>"+$('#b_amount'+i).val()+"</td>"
                    + "<td id=\"cart_total_price"+i+"\">$"+$('#b_total_price'+i).val()+"</td>"
                    + "<td style=\" text-align: center; \"><img src=\"image/remove-icon.png\" onclick=\"delete_cart('"+i+"')\" style=\"cursor: pointer; width: 20px; height: 20px;\"></td>"
                    + "</tr>";
         
                 head = head + text;
            }
            
            head = head +"<tr>"
                    + "<td></td>"
                    + "<th>Total</th>"
                    + "<td id=\"cart_total_item\">"+$('#total_item').html()+"</td>"
                    + "<td id=\"cart_total_price\">$"+$('#total_price').html()+"</td>";
            
            if(num_item > 0) {
                head = head + '<td id="change_currency" style="text-align: center"><a onclick="change_to_baht()" style="cursor: pointer">Change to Baht</a></td>';
            }
            else {
                 head = head + "<td></td>"
            }
                 head = head + "</tr>"
                    + "</tbody>"
                    + "</table>";
            
            $('#book').append(head);
            
            if(num_item > 0) {
                span = '<h4><a class="pull-right" style="cursor: pointer;" onclick="check_out()">Checkout</a></h4>';

                $('#book').append(span);
            }
        }
        
        // delete item in order
        function delete_cart(id){
            //alert("delete row "+id);//////try////
            
            // get total price and amount of item before delete
            var d_total_price = parseInt($('#b_total_price'+id).val());
            var d_amount = parseInt($('#b_amount'+id).val());
            
            // change total price and total item to order
            var tot_p = parseInt($('#total_price').html());
            $('#total_price').html(tot_p-d_total_price);
            $('#cart_total_price').html("$"+(tot_p-d_total_price));

            var tot_i = parseInt($('#total_item').html());
            $('#total_item').html(tot_i-d_amount);
            $('#cart_total_item').html(tot_i-d_amount);
            
            // delete item
            $('#b_id'+id).remove();
            $('#b_name'+id).remove();
            $('#b_total_price'+id).remove();
            $('#b_amount'+id).remove();
            $('#b_price'+id).remove();
            $('#b_stock'+id).remove();
            
            // delete row in table
            $('#cart'+id).remove();


            for(var i=num_item-1; i>id; i--) {		
                var b_id = document.getElementById("b_id"+i);
                b_id.id = "b_id"+(i-1);  // using element properties
                b_id.setAttribute("name", "b_id"+(i-1));  // using .setAttribute() method

                var b_name = document.getElementById("b_name"+i);
                b_name.id = "b_name"+(i-1);  // using element properties
                b_name.setAttribute("name", "b_name"+(i-1));  // using .setAttribute() method

                var b_total_price = document.getElementById("b_total_price"+i);
                b_total_price.id = "b_total_price"+(i-1);  // using element properties
                b_total_price.setAttribute("name", "b_total_price"+(i-1));  // using .setAttribute() method

                var b_amount = document.getElementById("b_amount"+i);
                b_amount.id = "b_amount"+(i-1);  // using element properties
                b_amount.setAttribute("name", "b_amount"+(i-1));  // using .setAttribute() method

                var b_price = document.getElementById("b_price"+i);
                b_price.id = "b_price"+(i-1);  // using element properties
                b_price.setAttribute("name", "b_price"+(i-1));  // using .setAttribute() method
                
                var b_stock = document.getElementById("b_stock"+i);
                b_stock.id = "b_stock"+(i-1);  // using element properties
                b_stock.setAttribute("name", "b_stock"+(i-1));  // using .setAttribute() method

                $('#cart_id'+i).html(i);

            }

            num_item--;

            var elem = document.getElementById("sum");
            elem.value = num_item;
        }
        
        // checkout item
        function check_out() {
            var form = document.createElement("form");
                form.setAttribute("method", "post");
                form.setAttribute("action", "bill.php");
                
            var uid = $('#uid').val();
            var total_item = $('#total_item').html();
            var total_price = $('#total_price').html();
            var currency = $('#currency').val();
            
            var hiddenField = document.createElement("input");
                hiddenField.setAttribute("type", "hidden");
                hiddenField.setAttribute("name", "uid");
                hiddenField.setAttribute("id","uid");
                hiddenField.setAttribute("value", uid);
                
            var hiddenField2 = document.createElement("input");
                hiddenField2.setAttribute("type", "hidden");
                hiddenField2.setAttribute("name", "total_item");
                hiddenField2.setAttribute("id","total_item");
                hiddenField2.setAttribute("value", total_item);
                
            var hiddenField3 = document.createElement("input");
                hiddenField3.setAttribute("type", "hidden");
                hiddenField3.setAttribute("name", "total_price");
                hiddenField3.setAttribute("id","total_price");
                hiddenField3.setAttribute("value", total_price);
                
           var hiddenField9 = document.createElement("input");
                hiddenField9.setAttribute("type", "hidden");
                hiddenField9.setAttribute("name", "num");
                hiddenField9.setAttribute("id","num");
                hiddenField9.setAttribute("value", num_item);
                
           var hiddenField11 = document.createElement("input");
                hiddenField11.setAttribute("type", "hidden");
                hiddenField11.setAttribute("name", "currency");
                hiddenField11.setAttribute("id","currency");
                hiddenField11.setAttribute("value", currency);
            
            form.appendChild(hiddenField);
            form.appendChild(hiddenField2);
            form.appendChild(hiddenField3);
            form.appendChild(hiddenField9);
            form.appendChild(hiddenField11);
            
            //var parameter = "uid="+uid+"&total_item="+total_item+"&total_price="+total_price+"&num="+num_item;
            
            for(i=0; i<num_item; i++) {
                var id =  $('#b_id'+i).val();
                var name =  $('#b_name'+i).val();
                var amount = $('#b_amount'+i).val();
                var price = $('#b_price'+i).val();
                var total_price = $('#b_total_price'+i).val();
                var stock = $('#b_stock'+i).val();
            /*
                parameter = parameter + '&bid'+i+'='+id
                        + '&bname'+i+'='+name
                        + '&bamount'+i+'='+amount
                        + '&bprice'+i+'='+price
                        + '&btotal_price'+i+'='+total_price;
            */
           
                var bid = "bid"+i;
                var hiddenField4 = document.createElement("input");
                hiddenField4.setAttribute("type", "hidden");
                hiddenField4.setAttribute("name", bid);
                hiddenField4.setAttribute("id", bid);
                hiddenField4.setAttribute("value", id);
                
                form.appendChild(hiddenField4);
                
                var bname = "bname"+i;
                var hiddenField5 = document.createElement("input");
                hiddenField5.setAttribute("type", "hidden");
                hiddenField5.setAttribute("name", bname);
                hiddenField5.setAttribute("id", bname);
                hiddenField5.setAttribute("value", name);
                
                form.appendChild(hiddenField5);
                
                var bamount = "bamount"+i;
                var hiddenField6 = document.createElement("input");
                hiddenField6.setAttribute("type", "hidden");
                hiddenField6.setAttribute("name", bamount);
                hiddenField6.setAttribute("id", bamount);
                hiddenField6.setAttribute("value", amount);
                
                form.appendChild(hiddenField6);
                
                var bprice = "bprice"+i;
                var hiddenField7 = document.createElement("input");
                hiddenField7.setAttribute("type", "hidden");
                hiddenField7.setAttribute("name", bprice);
                hiddenField7.setAttribute("id", bprice);
                hiddenField7.setAttribute("value", price);
                
                form.appendChild(hiddenField7);
                
                var btotal_price = "btotal_price"+i;
                var hiddenField8 = document.createElement("input");
                hiddenField8.setAttribute("type", "hidden");
                hiddenField8.setAttribute("name", btotal_price);
                hiddenField8.setAttribute("id", btotal_price);
                hiddenField8.setAttribute("value", total_price);
                
                form.appendChild(hiddenField8);
                
                var bstock = "bstock"+i;
                var hiddenField10 = document.createElement("input");
                hiddenField10.setAttribute("type", "hidden");
                hiddenField10.setAttribute("name", bstock);
                hiddenField10.setAttribute("id", bstock);
                hiddenField10.setAttribute("value", stock);
                
                form.appendChild(hiddenField10);
            }
            
            //alert(parameter);//////////try///////////
            
            document.body.appendChild(form);
            form.submit();    
        }
                
        // change $ to ฿
        function change_to_baht() {
            $.post('change_to_baht.php',
            { 
            }).done(function(result){
                //alert(result);/////////try///////
                
                result = parseInt(result);
                                
                for(i=0; i<num_item; i++) {
                    var tot_p = parseInt($('#b_total_price'+i).val());
                    $('#b_total_price'+i).val(tot_p*result);
                    $('#cart_total_price'+i).html("฿"+(tot_p*result));
                    
                    var pr = parseInt($('#b_price'+i).val());
                    $('#b_price'+i).val(pr*result);
                }
                
                var tot_p = parseInt($('#total_price').html());
                $('#cart_total_price').html('฿'+(tot_p*result));
                
                $('#currency').val('฿');
                
                $('#sp_currency').html('฿');
                var t =  parseInt($('#total_price').html());
                $('#total_price').html(t*result);
                
                $('#change_currency').html('<a onclick="change_to_dollar()" style="cursor: pointer">Change to Dollar</a>');
            });
        }
        
                // change ฿ to $
        function change_to_dollar() {
            $.post('change_to_baht.php',
            { 
            }).done(function(result){
                //alert(result);/////////try///////
                
                result = parseInt(result);
                                
                for(i=0; i<num_item; i++) {
                    var tot_p = parseInt($('#b_total_price'+i).val());
                    $('#b_total_price'+i).val(tot_p/result);
                    $('#cart_total_price'+i).html("$"+(tot_p/result));
                    
                    var pr = parseInt($('#b_price'+i).val());
                    $('#b_price'+i).val(pr/result);
                }
                
                var tot_p = parseInt($('#total_price').html());
                $('#cart_total_price').html('$'+(tot_p/result));
                
                $('#currency').val('$');
                
                $('#sp_currency').html('$');
                var t =  parseInt($('#total_price').html());
                $('#total_price').html(t/result);
                
                $('#change_currency').html('<a onclick="change_to_baht()" style="cursor: pointer">Change to Baht</a>');
            });
        }
    </script>

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="background-color: #9e5417;">
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
                <div class="" id="cart">
                    <img src="image/cart1.png" width="60" height="50">
                    Cart: <span id="sp_currency">$</span><span class="" id="total_price">0</span> (<span class="" id="total_item">0</span> items) <br/>
                    
                    <form method="post" action="" id="show_cart">
                        <input type="hidden" id="uid" name="uid" value="<?php echo $uid; ?>">
                        
                        <div id="cart_list"></div>
                        
                        <input type="hidden" id="sum" name="sum" value="0">
                        <input type="hidden" id="currency" name="currency" value="$">
                        
                        <a onclick="empty_cart()" style="cursor: pointer" value="Empty Cart" class="">Empty Cart</a>
                        &nbsp;
                        <a onclick="view_cart()" style="cursor: pointer" value="View Cart" class="">View Cart</a>
                    </form>
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
                            <img src="<?php echo $row['picture']; ?>" height="500px" width="330px" alt="" style="cursor: pointer; max-width: 100%; max-height: 100%; background-size: contain;" onclick="show_detail(<?php echo $row['id_book']; ?>)">
                            <div class="caption">
                                <h4 style="cursor: pointer" onclick="show_detail(<?php echo $row['id_book']; ?>)"><?php echo $row['name']; ?></h4>
                                <h5>Author: <?php echo $row['author']; ?></h5>
                                <h5>category: <?php echo $row['name_cate']; ?></h5>
                                <h4 class="pull-right"> $<?php echo $row['price']; ?> </h4>
                     <?php
                            if($row['amount'] > 0) {
                     ?>
                                <h5>In stock: <?php echo $row['amount']; ?></h5>
                     <?php
                            }
                            else {
                     ?>
                                <h4 style="color: red">SOLD OUT</h4>
                     <?php
                            }
                     ?>
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

</body>

</html>
