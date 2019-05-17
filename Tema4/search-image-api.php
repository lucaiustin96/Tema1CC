<?php
$accessKey = '802380c085a9477cbed190d49b905133';
$endpoint = 'https://westeurope.api.cognitive.microsoft.com/bing/v7.0/images/search';


function BingWebSearch ($url, $key, $query) {
    $headers = "Ocp-Apim-Subscription-Key: $key\r\n";
    $options = array ('http' => array (
                          'header' => $headers,
                           'method' => 'GET'));
    $context = stream_context_create($options);
    $result = file_get_contents($url . "?q=" . urlencode($query), false, $context);
    $headers = array();
    foreach ($http_response_header as $k => $v) {
        $h = explode(":", $v, 2);
        if (isset($h[1]))
            if (preg_match("/^BingAPIs-/", $h[0]) || preg_match("/^X-MSEdge-/", $h[0]))
                $headers[trim($h[0])] = trim($h[1]);
    }
    //return array($headers, $result);
    $result = json_decode($result);
    return $result->value[0]->contentUrl; 
}


// if (strlen($accessKey) == 32) {
//     //print "Searching the Web for: " . $term . "\n";
//     list($headers, $json) = BingWebSearch($endpoint, $accessKey, $term);
//     //print "\nRelevant Headers:\n\n";
//     foreach ($headers as $k => $v) {
//         print $k . ": " . $v . "\n";
//     }
//     //print "\nJSON Response:\n\n";

//     $user = json_decode($json);
//     return $user->value[0]->contentUrl;   
    
//    } else {
//     //print("Invalid Bing Search API subscription key!\n");
//     //print("Please paste yours into the source code.\n");
//     return "Eroare!!!";
// }
?>