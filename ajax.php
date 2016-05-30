<?PHP
require_once('libs/TeamSpeak3/TeamSpeak3.php');
require_once('config.php');
require_once('libs/recaptcha/src/autoload.php');
require_once('libs/chadd.php');

$type = @$_GET["type"];

function Response($code, $header, $msg) {
	$resp = array(
		"code" => $code,
		"header" => $header,
		"msg" => $msg,
	);
	$data = json_encode($resp);
	echo $data;
	exit;
}

switch($type) {

case 0:

$request = json_decode(file_get_contents("php://input"));


$recaptcha = new \ReCaptcha\ReCaptcha($secret);
$resp = $recaptcha->verify($request->captcha_resp, $_SERVER['REMOTE_ADDR']);

if($resp->isSuccess()) {

 	if($chadd->CheckCookie()) 
 	{
 		Response(406, "Error :(", "You can't create a channel again.");
 	}

 	//REPLACE bad words
	$request->channelname = $chadd->ReplaceBadString($badwords, $request->channelname);

	if($chadd->CheckStringIP($request->channelname))
	{
		Response(403, "Error :(", "In your Channel Name is no IP Adress or Domain allowed.");
	}

	if($chadd->CheckStringDomain($request->channelname))
	{
		Response(403, "Error :(", "In your Channel Name is no IP Adress or Domain allowed.");
	}

	if($request->quality < 1 || $request->quality > 10)
	{
		$request->quality = 7;
	}

	switch ($request->codec)
	{
						case 1: 
						define("TS3_CODEC", TeamSpeak3::CODEC_OPUS_VOICE);
						break; 

						case 2:
						define("TS3_CODEC", TeamSpeak3::CODEC_CELT_MONO);
						break; 

						case 3: 
						define("TS3_CODEC", TeamSpeak3::CODEC_SPEEX_ULTRAWIDEBAND);
						break; 

						default:
						define("TS3_CODEC", TeamSpeak3::CODEC_OPUS_VOICE);
	}

	try {

			$ts3_VirtualServer = TeamSpeak3::factory("serverquery://$ts3_username:$ts3_password@$ts3_host:$ts3_q_port/?server_port=$ts3_s_port");
			$ts3_VirtualServer->selfUpdate(array('client_nickname'=> $ts3_nick));

			$client = $ts3_VirtualServer->clientGetByUid($request->uuid);
			$groups = $client["client_servergroups"];
			$group_matches = 0;

			foreach($allowed_groups as $g)
			{
				if(in_array($g, $allowed_groups))
				{
					$group_matches++;
				}
			}

			if($group_matches <= 0)
			{
				Response(403, "Not Authorized", "Not allowed to use this tool, you are not in a whitelisted group.");
			}

			$cid = $ts3_VirtualServer->channelCreate(array(
			"channel_name" => $request->channelname,
			"channel_password" => $request->password,
			"channel_topic" => $channel_topic,
			"channel_codec" => TS3_CODEC,
			"channel_codec_quality" => $request->quality,
			"channel_flag_permanent" => FALSE,
			"cpid"                  => $cpid,
			"channel_description" => $channel_description,
			"channel_flag_semi_permanent" => TRUE
			));

			//log cid with IP (abuse)
			$usr_ip = $_SERVER['REMOTE_ADDR'];
			$ts3_VirtualServer->logAdd("Channel $cid created from IP:$usr_ip", TeamSpeak3::LOGLEVEL_INFO);

		
			$token = $ts3_VirtualServer->privilegeKeyCreate(0x01, "$chadmin_group_id"  ,"$cid", "TOKEN created from CHADD.");

			$chadd->SetCookie();


			$resp = array(
					"code" => 1,
					"header" => "All fine! :)",
					"token" => (string)$token,
					"url" => "$server_conn_url?port=$ts3_s_port&cid=$cid&channelpassword=$request->password&token=$token",
			);


			$json = json_encode($resp);
			echo $json;
			exit;

			}

			catch (TeamSpeak3_Exception $e) {
					Response(500, "TS3-Error: "+ $e->getCode(), $e->getMessage());
			}


} else {
 	$errors = $resp->getErrorCodes();
 	if(count($errors) >= 1)
 	{
 		Response(403, "Error :(", $errors[0]);
 	}
}

break;

case 1:

try {
		 $ts3_VirtualServer = TeamSpeak3::factory("serverquery://$ts3_username:$ts3_password@$ts3_host:$ts3_q_port/?server_port=$ts3_s_port");
		 $ts3_VirtualServer->selfUpdate(array('client_nickname'=> $ts3_nick));
		 $clients = $ts3_VirtualServer->clientList(array('connection_client_ip' => $_SERVER["REMOTE_ADDR"]));

		 $matches = count($clients);
		 if($matches > 1 || $matches <= 0)
		 {
		 	Response(404, "Client not found.", "Could not determine your Unique ID. Enter your Unique ID.");
		 }

		 if($matches == 1)
		 {
			 foreach($clients as $c)
			 {

			 if(count($c->getClones()) > 1)
			 {
			 	Response(404, "Client not found.", "Could not determine your Unique ID. Enter your Unique ID.");
			 }

			 $resp = array(
			 	"code" => 200,
			 	"header" => "Authenticated",
			 	"uuid" => (string)$c["client_unique_identifier"],
			 	"name" => (string)$c["client_nickname"],
			 );

			 $json = json_encode($resp);
			 echo $json;
			 exit;

			}
		}
	 
}
catch (TeamSpeak3_Exception $e) {
		  Response(500, "TS3-Error: "+ $e->getCode(), $e->getMessage());
}

break;

}
?>