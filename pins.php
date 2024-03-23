<?php
if(!defined('ABSPATH')){
    $pagePath = explode('/wp-content/', dirname(__FILE__));
    include_once(str_replace('wp-content/' , '', $pagePath[0] . '/wp-load.php'));
};
if(WP_DEBUG == false){
error_reporting(0);	
}
include_once(ABSPATH."wp-load.php");
include_once(ABSPATH.'wp-admin/includes/plugin.php');

if(isset($_REQUEST["eadd_pin"])){
	
	$network = strtolower($_REQUEST["enetwork"]);
	$pin = $_REQUEST["epin"];
	$delimiter = strtolower($_REQUEST["edelimiter"]);
	$value = $_REQUEST["evalue"];
	$str = explode($delimiter,$pin);
if(!empty($pin)){
if(empty($str) && $delimiter != "none" && !empty($delimiter)){
	
$obj = new stdClass;
$obj->code = "200";
$obj->message = "Delimiter Not Found In The Pin(s)";

die(json_encode($obj));
}
elseif($delimiter == "none" || empty($delimiter) && empty(strpos($pin,",")) && empty(strpos($pin,";"))  && empty(strpos($pin,"/")) ){
	$valid = "true";
	global $wpdb;
	$table_name = $wpdb->prefix.'vpepinsa';
	$resultfad = $wpdb->get_results($wpdb->prepare("SELECT * FROM  $table_name WHERE status='unused' ORDER BY %s DESC", 'ID'));

foreach($resultfad as $pinsa){
	if($pinsa->pin == $pin){
$valid = "false";
$where = $pinsa->network;
	}		
}

if($valid == "true"){
$network =  $_REQUEST["enetwork"];
$pin = $pin;
$status ='unused';
$table_name = $wpdb->prefix.'vpepinsa';
$wpdb->insert($table_name, array(
'network' => $network,
'value' => $value,
'pin' => $pin,
'status' => $status,
'the_time' => current_time('mysql', 1)
));
$obj = new stdClass;
$obj->code = "100";
$obj->message = "Pin [$pin] Added For $network";
die(json_encode($obj));
}
else{
	
$obj = new stdClass;
$obj->code = "200";
$obj->message = "[$pin] Already Exist In $where";
die(json_encode($obj));	
	
}

}
elseif(!empty($str)){
	
	$valid = "true";
		
global $wpdb;	
$array = explode($delimiter,$pin);

$num = 0;


	$table_name = $wpdb->prefix.'vpepinsa';
	$resultfad = $wpdb->get_results("SELECT pin FROM  $table_name WHERE status='unused'");
	
$not = 0;


foreach($array as $pinsa){
foreach($resultfad as $res){
	if($pinsa == $res->pin){
		$valid = "false";
		$where = $pinsa->network;
		$not = $not+1;
	}
}
	
if($valid == "true"){
	if(!empty($pinsa)){
	$num = $num +1;	
$network = $_REQUEST["enetwork"];
$status ='unused';
$table_name = $wpdb->prefix.'vpepinsa';
$wpdb->insert($table_name, array(
'network' => $network,
'pin' => $pinsa,
'value' => $value,
'status' => $status,
'the_time' => current_time('mysql', 1)
));
		
	}
	


}
}
if($valid == "true"){
$obj = new stdClass;
$obj->code = "100";
$obj->message = "$num Pins Added For $network And $not Already Exist";
die(json_encode($obj));
}
else{
$obj = new stdClass;
$obj->code = "200";
$obj->message = "$num Pins Added For $network And $not Already Exist";
die(json_encode($obj));
}


}
elseif($delimiter == "none" || !empty($delimiter) || !empty(strpos($pin,",")) || !empty(strpos($pin,";"))  || !empty(strpos($pin,"/")) ){
$obj = new stdClass;
$obj->code = "200";
$obj->message = "Use None in Delimiter If You Wanna Import A Single Pin Or Separate Pins By Comma Sign[,] And Enter Comma Sign[,] In Delimiter";

die(json_encode($obj));	
}
else{
$obj = new stdClass;
$obj->code = "200";
$obj->message = "Unknown Error";

die(json_encode($obj));	
}
}else{
$obj = new stdClass;
$obj->code = "200";
$obj->message = "Pin Can't Be Empty";

die(json_encode($obj));		
}

}

?>