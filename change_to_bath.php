<?php
    $url = "http://www.webservicex.net/CurrencyConvertor.asmx/ConversionRate?FromCurrency=USD&ToCurrency=THB";
    
    $doc = new DOMDocument();
    $doc->load($url);
    
    $doc->saveXML();
    
    /*get textContent from result node*/
    $bath = $doc->firstChild->firstChild->textContent;
    
    echo $bath;
?>
