<?php
//
// A very simple PHP example that sends a HTTP POST to a remote site
//    1. Render a random json payload to be used
//    2. Post it to http://localhost:8000/process/trade-message

function renderPhpFile($filename) {
  ob_start();
  include $filename;
  return ob_get_clean();
}

// usage
$content = renderPhpFile('random-json.php');
$ch = curl_init("http://localhost:8000/process/trade-message");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $content);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($content))                                                                       
);                                                                                                                   
                                                                                                                     
$result = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
echo "Server Request\n";
echo "===================== SERVER REQUEST  =======================================================\n";
echo $content;
echo "===================== SERVER RESPONSE =======================================================\n";
echo "HTTP Code: ", $httpcode, "\n";
if ($result && $result[0] == '{') {
  $result = json_encode(json_decode($result), JSON_PRETTY_PRINT);
}
echo "HTTP Body:\n", $result, "\n";