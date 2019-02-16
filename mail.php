<?php
if( $_SERVER['REQUEST_METHOD'] === 'POST' && $_POST != NULL){
	foreach ($_POST as $key => $value) {
		if($key === "senderAddress")
		{
			if (!filter_var($value, FILTER_VALIDATE_EMAIL)) 
				die("You must specify a valid email address");
			
		}
		if($key === "message")
		{
			if(strlen($value) < 5)
				die("The message must be more than 5 chars");
		}
		if($key === "name")
		{
			if(strlen($value) < 1)
				die("You must specify a name");
		}	
    }
    $postData = $_POST;
    $mailgun = sendMailgun($postData);

    if($mailgun) {
    echo "success";
  } else {
    echo "error";
  }
  
}

function sendMailgun($data) {

  $api_key = 'lol nope';
  $api_domain = 'exclnetworks.com';
  $send_to = 'the support email';

    // sumbission data
        $ipaddress = $_SERVER['REMOTE_ADDR'];
        $date = date('d/m/Y');
        $time = date('H:i:s');

    // form data
        $postcontent = $data['message'];
        $reply = $data['senderAddress'];  
		$name = $data['name'];

  $messageBody = "<p>You have received a new message from {$name} .</p>
                {$postcontent}
                <p>This message was sent from the IP Address: {$ipaddress} on {$date} at {$time}</p>";

  $config = array();
  $config['api_key'] = $api_key;
  $config['api_url'] = 'https://api.mailgun.net/v2/'.$api_domain.'/messages';

  $message = array();
  $message['from'] = $reply;
  $message['to'] = $send_to;
  $message['h:Reply-To'] = $reply;
  $message['subject'] = "New Message from {$name}";
  $message['html'] = $messageBody;

  $curl = curl_init();

  curl_setopt($curl, CURLOPT_URL, $config['api_url']);
  curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
  curl_setopt($curl, CURLOPT_USERPWD, "api:{$config['api_key']}");
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($curl, CURLOPT_POST, true); 
  curl_setopt($curl, CURLOPT_POSTFIELDS,$message);

  $result = curl_exec($curl);
  curl_close($curl);
  return $result;
}
?>