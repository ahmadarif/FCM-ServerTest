<?php
function sendMessage($data, $target){
	//FCM api URL
	$url = 'https://fcm.googleapis.com/fcm/send';

	//api_key available in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
	$server_key = 'YOUR_SERVER_API_KEY';
				
	$fields = array();
	$fields['data'] = $data;
	if(is_array($target)){
		$fields['registration_ids'] = $target;
	}else{
		$fields['to'] = $target;
	}
	//header with content_type api key
	$headers = array(
		'Content-Type:application/json',
	  	'Authorization:key='.$server_key
	);
				
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
	$result = curl_exec($ch);
	if ($result === FALSE) {
		die('FCM Send Error: ' . curl_error($ch));
	}
	curl_close($ch);
	return $result;
}

// test
$data = array(
	'post_id'=>'12345',
	'post_title'=>'A Blog post'
);
/*
$target = array(
	'reg_token1',
	'reg_token2',
	'reg_token3'
);
*/
$target = 'reg_token';
$result = sendMessage($data, $target);
echo $result;

/**
 * Use this to get message
 * remoteMessage.getData().get("message") / remoteMessage.getData().get("post_title")
 */