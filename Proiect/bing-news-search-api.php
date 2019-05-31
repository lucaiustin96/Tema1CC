<?php

// NOTE: Be sure to uncomment the following line in your php.ini file.
// ;extension=php_openssl.dll

// **********************************************
// *** Update or verify the following values. ***
// **********************************************

// Replace the accessKey string value with your valid access key.

include("translate-text.php");

function BingNewsSearch ($query) {
    $accessKey = 'a2acc02433c541f9a97eaae476a9881e';
    $endpoint = 'https://api.cognitive.microsoft.com/bing/v7.0/news/search';
    //$term = 'Microsoft';
    // Prepare HTTP request
    // NOTE: Use the key 'http' even if you are making an HTTPS request. See:
    // https://php.net/manual/en/function.stream-context-create.php
    $headers = "Ocp-Apim-Subscription-Key: $accessKey\r\n";
    $options = array ('http' => array (
                          'header' => $headers,
                          'method' => 'GET' ));

    // Perform the Web request and get the JSON response
    $context = stream_context_create($options);
    $result = file_get_contents($endpoint . "?q=" . urlencode($query), false, $context);

    // Extract Bing HTTP headers
    $headers = array();
    foreach ($http_response_header as $k => $v) {
        $h = explode(":", $v, 2);
        if (isset($h[1]))
            if (preg_match("/^BingAPIs-/", $h[0]) || preg_match("/^X-MSEdge-/", $h[0]))
                $headers[trim($h[0])] = trim($h[1]);
    }

    //return array($headers, $result);
    $news = json_decode($result);
    foreach($news->value as $mydata)
    {
        
        echo '<h3>' . TranslateText($mydata->name) . '</h3><br>'; 
        echo '<p>' . TranslateText($mydata->description) . '</p><br>';  
        echo '<a class = "right" href = "' . $mydata->url . '">Read more...</a><br><hr>';   
    }        

    //echo json_encode(json_decode($result), JSON_PRETTY_PRINT);
}


// function NewsSearch ($endpoint, $accessKey, $term)
// {
//     list($headers, $json) = BingNewsSearch($endpoint, $accessKey, $term);

//     print "\nRelevant Headers:\n\n";
//     foreach ($headers as $k => $v) {
//         print $k . ": " . $v . "\n";
//     }

//     print "\nJSON Response:\n\n";
//     echo json_encode(json_decode($json), JSON_PRETTY_PRINT);
// }
?>