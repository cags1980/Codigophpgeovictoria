<?php
include_once('OAuth.php');
//$base_feed='https://apiv3.geovictoria.com/api/AttendanceBook/GetAttendance';
//$base_feed='https://apiv3.geovictoria.com/api/Group/ListGroup';
//$base_feed='https://apiv3.geovictoria.com/api/Group/Paths';
$base_feed='http://apiv3.geovictoria.com/api/User/List';	
//$base_feed='https://apiv3.geovictoria.com/api/Punch/List';
//$base_feed='https://apiv3.geovictoria.com/api/Activity/GetActivities';
//$consumer=(object) array("key"=>"s3efec","secret"=>"d4da93e$");
$CONSUMER_KEY = '1dd229'; 
$CONSUMER_SECRET = '43dd1bb2'; 
$consumer_url='/AttendanceBook/GetAttendance';
$consumer = new OAuthConsumer($CONSUMER_KEY, $CONSUMER_SECRET, $consumer_url);

//print_r($consumer);
$params= array('Content-Type' => 'application/json' ,
'Accept' => 'application/json' 
);
//$params= array('Range' => 'currentWeek', 'from' => '', 'to' => '' );
//$params= array('Range' => 'currentWeek','from' => null, 'to' =>null  );
//$params= array('Range' => 'currentWeek' );Content-Type:application/json
//$params= json_encode($params);
$params=null;

$postData='{"Range":"customRange","from":"20191203050000","to":"20191205235900"}';
$postData="{\"Range\":\"173020465\",\"from\":\"20191203050000\",\"to\":\"20191203235900\",\"includeAll\":0}";

$params=null;
$request = OAuthRequest::from_consumer_and_token($consumer, NULL, 'POST', $base_feed, $params);
//print_r($request);
// Sign the constructed OAuth request using HMAC-SHA1
$request->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $consumer, NULL);
// Make signed OAuth request to the Contacts API server
$url = $base_feed . '?' . implode_assoc('=', '&', $params);

print_r($request->to_header());
echo send_request($request->get_normalized_http_method(), $url, $request->to_header(),$postData);
/**
* Makes an HTTP request to the specified URL
* @param string $http_method The HTTP method (GET, POST, PUT, DELETE)
* @param string $url Full URL of the resource to access
* @param string $auth_header (optional) Authorization header
* @param string $postData (optional) POST/PUT request body
* @return string Response body from the server
*/


function send_request($http_method, $url, $auth_header=null, $postData=null) {
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FAILONERROR, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
switch($http_method) {
case 'GET':
if ($auth_header) {
curl_setopt($curl, CURLOPT_HTTPHEADER, array($auth_header));
}
break;
case 'POST':
/* curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type' => 'application/json',
$auth_header));
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $postData); */
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type' => 'application/json',
$auth_header));
 // curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
 curl_setopt($curl, CURLOPT_POSTFIELDS, "{\"Range\":\"173020465\",\"from\":\"20191203050000\",\"to\":\"20191203235900\",\"includeAll\":0}");
break;
case 'PUT':
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/atom+xml',
$auth_header));
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $http_method);
curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
break;
case 'DELETE':
curl_setopt($curl, CURLOPT_HTTPHEADER, array($auth_header));
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $http_method);
break;
}
$response = curl_exec($curl);
//print_r($auth_header);
echo $response ;
if (!$response) {
$response = curl_error($curl);
}
curl_close($curl);
return $response;
}
/**
* Joins key:value pairs by inner_glue and each pair together by outer_glue
* @param string $inner_glue The HTTP method (GET, POST, PUT, DELETE)
* @param string $outer_glue Full URL of the resource to access
* @param array $array Associative array of query parameters
* @return string Urlencoded string of query parameters
*/
function implode_assoc($inner_glue, $outer_glue, $array) {
$output = array();
foreach($array as $key => $item) {
$output[] = $key . $inner_glue . urlencode($item);
}
return implode($outer_glue, $output);
}
?>