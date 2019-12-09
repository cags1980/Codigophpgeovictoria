<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://apiv3.geovictoria.com/api/User/List",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_HTTPHEADER => array(
    "authorization: OAuth oauth_consumer_key=\"1dd229\",oauth_signature_method=\"HMAC-SHA256\",oauth_timestamp=\"1575601142\",oauth_nonce=\"e9Ty1m\",oauth_version=\"1.0\",oauth_signature=\"fsMALAUkX%2BapP3MiKeAHWAOwRShoe1HVpO97NgjkYMA%3D\"",
    "cache-control: no-cache",
    "content-type: application/x-www-form-urlencoded",
    "postman-token: f7af1f67-fdd2-ac95-f296-b987a0ba0b64"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
?>