<?PHP
$public = ""; //Recaptcha Public Key
$secret = ""; // Recaptcha Privat Key

$ts3_host = "localhost";
$ts3_q_port = "10011";
$ts3_s_port = "9987";
$ts3_username = "serveradmin";
$ts3_password = "";
$ts3_nick = "Channel Creator V2";

$cpid = 68; //SPACER ID (the root) the created channels will be collected as sub channel there
$chadmin_group_id = 5; // Channel Admin Group ID Default 5

$channel_description = "";
$channel_topic = "CHADD | WebUI @ ".date("H:i:s")." - ".date("d.m.Y");
$server_conn_url = "ts3server://myip:port";
$imprint_url = "";

//BADWORDS will be replaced with XXXX
$badwords = array("example", "example");

// Allowed groups whitelist
$allowed_groups = array();
?>