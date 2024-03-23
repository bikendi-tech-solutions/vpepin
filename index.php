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
$path = WP_PLUGIN_DIR.'/vtupress/functions.php';
if(file_exists($path) && in_array('vtupress/vtupress.php', apply_filters('active_plugins', get_option('active_plugins')))){
include_once(ABSPATH .'wp-content/plugins/vtupress/functions.php');
}
else{
	if(!function_exists("vp_updateuser")){
function vp_updateuser(){
	
}

function vp_getuser(){
	
}

function vp_adduser(){
	
}

function vp_updateoption(){
	
}

function vp_getoption(){
	
}

function vp_option_array(){
	
}

function vp_user_array(){
	
}

function vp_deleteuser(){
	
}

function vp_addoption(){
	
}

	}

}

if(isset($_REQUEST["edutype"])){
$dtype = $_REQUEST["edutype"];
$quantity = $_REQUEST["quantity"];
$amount = intval($_REQUEST["amount"]);

$id = get_current_user_id();
$bal = intval(vp_getuser($id,"vp_bal",true));



$pin = sanitize_text_field($_REQUEST["pin"]);
$mypin = sanitize_text_field(vp_getuser($id,"vp_pin",true));

if($pin == $mypin){
if($bal>=$amount || $name == $sca  || current_user_can('manage_options') && $bal > 0 && stripos($amount, '-') === false){


if(is_plugin_active("vpmlm/vpmlm.php")){
$id = get_current_user_id();
do_action("vp_mlm");
}

$ans = "true";
global $wpdb;
$table_name = $wpdb->prefix.'vpepinsa';
$resultfad = $wpdb->get_results("SELECT * FROM  $table_name WHERE network='$dtype' AND status='unused' LIMIT $quantity");

$total = 0;
$amt = 0;


foreach($resultfad as $result){
	$pinow = $result->pin;
	$red = $result->id;
	if(!empty($pinow)){
	$ans = "true";
	$pinow = $result->pin;
	
	$balg = vp_getuser($id,"vp_bal",true);
$balnowg = $balg - floatval($amount/$quantity);
global $wpdb;
$name= get_userdata($id)->user_login;
$email= get_userdata($id)->user_email;
$type= strtoupper($_REQUEST["edutype"]);
$bal_bf = $balg;
$bal_nw = $balnowg;
$tid = $id;
$table_name = $wpdb->prefix.'sepins';
$wpdb->insert($table_name, array(
'name'=> $name,
'email'=> $email,
'type' => $type,
'pin' => $pinow,
'quantity' => "1",
'bal_bf' => $bal_bf,
'bal_nw' => $bal_nw,
'amount' => ($amount/$quantity),
'user_id' => $tid,
'status' => 'Successful',
'the_time' => current_time('mysql', 1)
));

$table_name = $wpdb->prefix.'vpepinsa';
$wpdb->update($table_name , array( 'status' => 'used', 'the_time' => current_time('mysql', 1) ), array( 'id' => $red ) );

$total += 1;


vp_updateuser($id, 'vp_bal',$balnowg);

$amt += $amount;


	
	
	}
	else{

	
global $wpdb;
$name= get_userdata($id)->user_login;
$email= get_userdata($id)->user_email;
$type = strtoupper($_REQUEST["edutype"]);
$tid = $id;
$table_name = $wpdb->prefix.'sepins';
$wpdb->insert($table_name, array(
'name'=> $name,
'email'=> $email,
'type' => $type,
'quantity' => "1",
'user_id' => $tid,
'status' => 'Failed',
'the_time' => current_time('mysql', 1)
));

$obj = new stdClass;
$obj->code = "200";
$obj->message = "$type Pin Of NGN$amount Currently Not Available";

die(json_encode($obj));


	}
}

if($quantity == 1 && !empty($pinow)){
	
$obj = new stdClass;
$obj->code = "100";
$obj->pin = "$pinow";

die(json_encode($obj));	
}
elseif($quantity > 1 && !empty($pinow)){
	
$obj = new stdClass;
$obj->code = "100";
$obj->pin = "$total Number Of EPins Have Been Printed. Check History For Lists";
die(json_encode($obj));	
	
}
else{
	$obj = new stdClass;
$obj->code = "200";
$obj->message = "Error Fetching Database";

die(json_encode($obj));
}
	


}
else{
$remtot = $amount-$bal;
die('{"status":"200","message":"'.$remtot.' Needed To Complete Transaction"}');	
}
}
else{
die('{"status":"200","message":"Transaction Pin Not Valid"}');
}

}
	
if(isset($_REQUEST["targetaction"])){
	$action = $_REQUEST["targetaction"];
	$keys = $_REQUEST["keys"];
$num = 0;
if($action == "delete"){

$array = explode("/",$keys);

foreach($array as $arr){

if(!empty($arr)){
$num = $num+1;
global $wpdb;
$table_name = $wpdb->prefix.'vpepinsa';
$wpdb->delete($table_name , array( 'id' => $arr ));
}	
	
}

if($num != 0){
$obj = new stdClass;
$obj->code = "100";
$obj->message = "$num Pins Have Been Deleted";
die(json_encode($obj));
}
else{
$obj = new stdClass;
$obj->code = "200";
$obj->message = "$num Rows Can't Be Deleted";
die(json_encode($obj));	
}

}
elseif($action == "change"){
$obj = new stdClass;
$obj->code = "100";
$obj->message = "$num Pins Have Been Changed";
die(json_encode($obj));
}
	
}
?>