<?php
    $url = "http://www.webservicex.net/CurrencyConvertor.asmx/ConversionRate?FromCurrency=USD&ToCurrency=THB";
    
    $client = new SoapClient($url);
    $fcs = $client->__getFunctions();
    debug($fcs);
    echo $fcs;
?>
