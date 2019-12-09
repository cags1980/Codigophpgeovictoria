<?php
include_once('OAuth.php');
$base_feed='https://apiv3.geovictoria.com/api/AttendanceBook/GetAttendance';
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
$params=array();
$postData2= json_encode( array("Range"=>"currentDay"));
$postData1= json_encode( array("Range"=>"customRange",
"from"=>"20191203050000",
"to"=>"20191205235900",
"includeAll"=>0
));
$postData1="'".$postData1."'";
print_r( $postData1);
$postData='{"Range":"customRange","from":"20191203050000","to":"20191205235900"}';
$postData3='{"Range":"currentWeek"}';
$postData='{"Range":"173020465","from":"20191203050000","to":"20191203235900","includeAll":0}';
$postDatax="{\"Range\":\"173020465\",\"from\":\"20191203050000\",\"to\":\"20191203235900\",\"includeAll\":0}";
//$postData=NULL;

$request = OAuthRequest::from_consumer_and_token($consumer, NULL, 'POST', $base_feed, $params);
//print_r($request);
// Sign the constructed OAuth request using HMAC-SHA1
$request->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $consumer, NULL);

$autorizacion=$request->to_header();

//print_r($autorizacion);
//$autorizacionh=str_replace("\"","\\\"",$autorizacion);


//print_r($autorizacion);
$header = array("authorization"=>$autorizacion,
                "content-type"=>"application/json",      
);


    $headerj   =json_encode($header);
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $base_feed,
  CURLOPT_RETURNTRANSFER => true,
/*   CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30, */
  //CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => $postData3,
  CURLOPT_HTTPHEADER => array(  "authorization:".$autorizacion." " ,
  "cache-control: no-cache",
  "content-type: application/json",
 
),
));


$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
 // echo $response;
}

$resultados=json_decode($response,true);

print_r($resultados);
foreach ($resultados as  $resul)
{
    con
    echo $resul['Identifier'];
    echo '<br>';
}


?>