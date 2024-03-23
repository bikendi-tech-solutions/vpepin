<?php
/**
*Plugin Name: VP EPINS
*Plugin URI: http://vtupress.com
*Description: Add E-Pins feature to your vtu business . An extension for vtupress plugin
*Version: 1.3.8
*Author: Akor Victor
*Author URI: https://facebook.com/akor.victor.39
*/

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


add_action("user_feature","epins_user_feature");
add_action("template_user_feature","epins_template_user_feature");
add_action("set_control","epins_set_control");
add_action("set_control_post","epins_set_control_post");


vp_addoption("epinswaec",1);
vp_addoption("epinsneco",1);
vp_addoption("epinsjamb",1);
vp_addoption("epinsnabteb",1);
vp_addoption("epinscontrol","unchecked");
vp_addoption("waecdiscount",0);
vp_addoption("necodiscount",0);
vp_addoption("jambdiscount",0);
vp_addoption("nabtebdiscount",0);

if(vp_getoption("resolve_epins") != "1"){
	global $wpdb;
	$table_name = $wpdb->prefix.'sepins';
    $data = [ 'status' => 'Successful' ];
    $where = [ 'status' => NULL ];
    $updated = $wpdb->update( $table_name, $data, $where);
	

vp_updateoption("resolve_epins","1");
}




add_action("vtupress_gateway_tab","vpepintab");
function vpepintab(){
$tab = false;
if($tab){

}elseif($_GET["subpage"] == "epin"){
    include_once(ABSPATH .'wp-content/plugins/vpepin/pages/vpepin.php');
}

}

add_action("vtupress_gateway_submenu","vpepinsubmenu");
function vpepinsubmenu(){
?>
  <li class="sidebar-item">
                    <a href="?page=vtupanel&adminpage=gateway&subpage=epin" class="sidebar-link"
                      ><i class="fas fa-barcode"></i
                      ><span class="hide-menu">Exam Pin</span></a
                    >
  </li>
<?php
}

add_action("vtupress_history_condition","addepinservices");
function addepinservices(){
  $bill = false;
  if($bill){

  }
  elseif($_GET["subpage"] == "epin" && $_GET["type"] == "successful"){
    include_once(ABSPATH .'wp-content/plugins/vpepin/pages/sepin.php');
  }
  elseif($_GET["subpage"] == "epin" && $_GET["type"] == "unsuccessful"){
    include_once(ABSPATH .'wp-content/plugins/vpepin/pages/fepin.php');
  }
}

add_action("vtupress_history_submenu","addepinsubmenu");
function addepinsubmenu(){
?>
<li class="sidebar-item bg bg-success">   
                  <a
                  class="sidebar-link has-arrow waves-effect waves-dark"
                  href="javascript:void(0)"
                  aria-expanded="false"
                  ><i class="fas fa-barcode"></i
                  ><span class="hide-menu">Exam Pins</span></a
                >
                <ul aria-expanded="false" class="collapse first-level">
                   <li class="sidebar-item">
                      <a href="?page=vtupanel&adminpage=history&subpage=epin&type=successful" class="sidebar-link"
                      ><i class="far fa-check-circle"></i
                      ><span class="hide-menu">Successful</span></a
                    >
                  </li>
                  <li class="sidebar-item">
                      <a href="?page=vtupanel&adminpage=history&subpage=epin&type=unsuccessful" class="sidebar-link"
                      ><i class="fas fa-ban"></i
                      ><span class="hide-menu">Failed</span></a
                    >
                  </li>
				</ul> 
</li>
<?php
}



function create_epins(){

global $wpdb;
$table_name = $wpdb->prefix.'vpepinsa';
$charset_collate=$wpdb->get_charset_collate();
$sql= "CREATE TABLE IF NOT EXISTS $table_name(
id int NOT NULL AUTO_INCREMENT,
network text,
value text,
pin text,
status text,
the_time text,
PRIMARY KEY (id))$charset_collate;";
require_once(ABSPATH.'wp-admin/includes/upgrade.php');
dbDelta($sql);
}
//Default Datas to sairtime (s-airtime db)
function add_epins(){
global $wpdb;
$network='waec';
$pin ='123456-9772929';
$status ='used';
$serial ='22222222';
$table_name = $wpdb->prefix.'vpepinsa';
$wpdb->insert($table_name, array(
'network' => $network,
'value' => '100',
'pin' => $pin,
'status' => $status,
'the_time' => current_time('mysql', 1)
));
}


function create_epins_transaction(){

global $wpdb;
$table_name = $wpdb->prefix.'sepins';
$charset_collate=$wpdb->get_charset_collate();
$sql= "CREATE TABLE IF NOT EXISTS $table_name(
id int NOT NULL AUTO_INCREMENT,
name text NOT NULL,
email text,
type text,
pin text,
quantity text,
bal_bf text,
bal_nw text,
amount text,
user_id text,
the_time text,
status text,
PRIMARY KEY (id))$charset_collate;";
require_once(ABSPATH.'wp-admin/includes/upgrade.php');
dbDelta($sql);

}
//Default Datas to sepins (s-airtime db)
function addepinsdata(){
global $wpdb;
$name='Akor Victor';
$email='vtupress.com@gmail.com';
$type ='waec';
$pin ='11111111';
$quantity = '1'; 
$bal_bf ='10';
$bal_nw ='0';
$amount= '0001';
$tid = '1';
$table_name = $wpdb->prefix.'sepins';
$wpdb->insert($table_name, array(
'name'=> $name,
'email'=> $email,
'type' => $type,
'pin' => $pin,
'quantity' => $quantity,
'bal_bf' => $bal_bf,
'bal_nw' => $bal_nw,
'amount' => $amount,
'user_id' => $tid,
'status' => 'successful',
'the_time' => current_time('mysql', 1)
));
}





function epins_template_user_feature(){
	if(isset($_GET["vend"]) && $_GET["vend"]=="epins" && vp_getoption("epinscontrol") == "checked" && vp_getoption("resell") == "yes"){
		$id = get_current_user_id();

		$option_array = json_decode(get_option("vp_options"),true);
		$user_array = json_decode(get_user_meta($id,"vp_user_data",true),true);
		$data = get_userdata($id);
		
		$bal = vp_getuser($id, 'vp_bal', true);
		
		$plan = vp_getuser($id,'vr_plan',true);
?>
		
<div id="container">



		<style>
		.user-vends{
			border: 1px solid grey;
			border-radius: 5px;
			padding: 1rem !important;
		}
		</style>
		
		<div id="side-epins-w" class="pt-4 px-3">


		<div class="user-vends">




		<?php
global $level;
		?>
<form class="for" id="cfor" method="post" <?php echo apply_filters('formaction','target="_self"');?>>

		 <div class="visually-hidden">
                <input type="hidden" name="vpname" class="form-control epins-name" placeholder="Name" aria-label="Name" aria-describedby="basic-addon1" value="<?php echo $data->user_login; ?>">
            </div>
            <div class="visually-hidden">
                <input type="hidden" name="vpemail" class="form-control epins-email" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1" value="<?php echo $data->user_email; ?>">
            </div>
			<div class="visually-hidden">		
				<input type="hidden" id="tcode" name="tcode" value="cepins">
				<input type="hidden" id="url" name="url">
				<input type="hidden" id="uniqidvalue" name="uniqidvalue" value="<?php echo uniqid('VTU-',false);?>">
				<input type="hidden" id="url1" name="url1" value="<?php echo esc_url(plugins_url('vtupress/process.php'));?>">
				<input type="hidden" id="id" name="id" value="<?php echo uniqid('VTU-',false);?>">
			</div>

<div class="input-group mb-2 ">
<span class="input-group-text">EXAM</span>
<select name="dutype" class="form-control form-select edutype">
<option value="none">---Select---</option>
	<option value="waec">WAEC [<?php 
				

				$s = (floatval($level[0]->epin_waec)*vp_getoption("epinswaec"))/100;
				echo vp_getoption("epinswaec") - $s;
			
				
				?>]</option>
<option value="neco">NECO [<?php

				$s = (floatval($level[0]->epin_neco)*vp_getoption("epinsneco"))/100;
				echo vp_getoption("epinsneco") - $s;

				?>]</option>
<option value="jamb">JAMB [<?php 

				$s = (floatval($level[0]->epin_jamb)*vp_getoption("epinsjamb"))/100;
				echo vp_getoption("epinsjamb") - $s;

				
				?>]</option>
<option value="nabteb">NABTEB [<?php 

					$s = (floatval($level[0]->epin_nabteb)*vp_getoption("epinsnabteb"))/100;	
				echo vp_getoption("epinsnabteb") - $s;

				
				?>]</option>
</select>
 <div id="validationServer04Feedback" class="invalid-feedback">
                      Error: <span class="epins-edutype-message"></span>
						</div>
</div>
<div class="input-group mb-2">
<span class="input-group-text">Quantity</span>
<select name="dunumber" class="form-control form-select edunumber">
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="10">10</option>
</select>
 <div id="validationServer04Feedback" class="invalid-feedback">
                      Error: <span class="epins-sender-error-message"></span>
						</div>
</div>
<div class="input-group mb-2 visually-hidden">
<span class="input-group-text visually-hidden">DOMINATION</span>
<select name="domination" class="form-control form-select domination">
<option value="100">100</option>
<option value="200">200</option>
<option value="500">500</option>
<option value="1000">1000</option>
</select>
 <div id="validationServer04Feedback" class="invalid-feedback">
                      Error: <span class="epins-sender-error-message"></span>
						</div>
</div>
<br>

 <div class="input-group mb-2">
                    <span class="input-group-text" id="basic-addon1">NGN.</span>
                    <input id="amt" name="amount" type="number" class="form-control epins-amount" max="<?php echo $bal;?>" placeholder="Amount" aria-label="Username" aria-describedby="basic-addon1" readonly required>
                    <span class="input-group-text" id="basic-addon1">.00</span>
                    <div id="validationServer04Feedback" class="invalid-feedback">
                      Error: <span class="epins-amount-error-message"></span>
                      </div>
 </div>
   <div class="vstack gap-2">
                    <button type="button" class="w-full p-2 text-xs font-bold text-white uppercase bg-indigo-600 rounded shadow purchase-epins btn" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@getbootstrap">PRINT</button>
  </div>	
			
</form>
</div>
	  <!--The Modal-->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">epins Purchase Confirmation</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <div>
                    Network : <span class="epins-network-confirm"></span><br>
                    Quantity : <span class="epins-quantity-confirm"></span><br>
                    Amount : ₦<span class="epins-amount-confirm"></span><br>
                    Status : <span class="epins-status-confirm"></span><br>
					<div class="input-group form">
					<span class="input-group-text">PIN</span>
					<input class="form-control pin" type="number" name="pin">
					</div>
                    </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="p-2 text-xs font-bold text-white uppercase bg-gray-600 rounded shadow data-proceed-cancled btn-danger" data-bs-dismiss="modal">Cancel</button>
                      <button type="button" name="wallet" id="wallet" class="p-2 text-xs font-bold text-white uppercase bg-indigo-600 rounded shadow  epins-proceed btn-success" form="cfor">Proceed</button>
                    </div>
                  </div>
                </div>
            </div>
    	
		
		</div>
		
		<script>
		jQuery(".edunumber").on("change",function(){
			qnty();
		});
function qnty(){
		epinprice();
		var amount = jQuery(".epins-amount").val();
		var quantity = jQuery(".edunumber").val();
	jQuery(".epins-amount").val(amount*quantity);
		
	};

jQuery(".edutype").on("change",function(){
	
	epinprice();
});

function epinprice(){
		
		
			//var str = jQuery(".domination").val();
			var epins = jQuery(".edutype").val();
			var numbers;
			var price;
			var discount;
			switch(epins){
				case"neco":
				
				numbers  = <?php

				$s = (floatval($level[0]->epin_neco)*vp_getoption("epinsneco"))/100;
				echo vp_getoption("epinsneco") - $s;

				?>;
				
				jQuery(".discount-amount-confirm").text('<?php echo floatval($level[0]->epin_neco);?>');
				jQuery(".epins-amount").val(numbers);
				jQuery(".necoprice").text(numbers);
				jQuery(".epins-amount-confirm").val(numbers);
				break;
				case "jamb":
				numbers  = <?php 

				$s = (floatval($level[0]->epin_jamb)*vp_getoption("epinsjamb"))/100;
				echo vp_getoption("epinsjamb") - $s;

				
				?>;
				
				jQuery(".discount-amount-confirm").text('<?php echo floatval($level[0]->epin_jamb);?>');
				jQuery(".epins-amount").val(numbers);
				jQuery(".jambprice").text(numbers);
				jQuery(".epins-amount-confirm").val(numbers);
				break;
				case "waec":
				numbers  = <?php 
				

				$s = (floatval($level[0]->epin_waec)*vp_getoption("epinswaec"))/100;
				echo vp_getoption("epinswaec") - $s;
			
				
				?>;
				jQuery(".discount-amount-confirm").text('<?php echo floatval($level[0]->epin_waec);?>');
				jQuery(".epins-amount").val(numbers);
				jQuery(".waecprice").text(numbers);
				jQuery(".epins-amount-confirm").val(numbers);
				break;
				case "nabteb":
				numbers  = <?php 

					$s = (floatval($level[0]->epin_nabteb)*vp_getoption("epinsnabteb"))/100;	
				echo vp_getoption("epinsnabteb") - $s;

				
				?>;
				jQuery(".discount-amount-confirm").text('<?php echo floatval($level[0]->epin_nabteb);?>');
				jQuery(".epins-amount").val(numbers);
				jQuery(".nabtebprice").text(numbers);
				jQuery(".epins-amount-confirm").val(numbers);
				break;
			}

			var total_amount = numbers;
			jQuery(".epins-amount").val(total_amount);
			jQuery(".epins-amount-confirm").val(numbers);
	
		//	alert(total_amount);
};
		
jQuery(".purchase-epins").click(function(){
epinprice();
qnty();
		
var total_amount = jQuery(".epins-amount").val();
			
			jQuery(".epins-network-confirm").text(jQuery(".edutype").val());
			jQuery(".epins-quantity-confirm").text(jQuery(".edunumber").val());
			jQuery(".epins-amount-confirm").text(jQuery(".epins-amount").val());

			
if(jQuery(".edutype").val() == "none"){
				jQuery(".edutype").addClass("is-invalid");
				jQuery(".epins-edutype-message").text("Please Select One");
				jQuery(".epins-proceed").hide();
				jQuery(".epins-status-confirm").text("Please Select One Network");
}
else{
	
				
if(total_amount <= <?php echo $bal;?> && total_amount > 0){
			jQuery(".epins-proceed").show();
				jQuery(".epins-amount").removeClass("is-invalid");
				jQuery(".epins-amount").addClass("is-valid");
				jQuery(".epins-status-confirm").text("Correct");
jQuery(".epins-proceed").show();
jQuery(".edutype").addClass("is-valid");
jQuery(".edutype").removeClass("is-invalid");
jQuery(".epins-status-confirm").text("Correct");
			}
			else if(total_amount > <?php echo $bal;?> || total_amount <= 0){
			jQuery(".epins-status-confirm").text("Balance Too Low");
			jQuery(".epins-proceed").hide();
			jQuery(".epins-amount").addClass("is-invalid");
			jQuery(".epins-amount-error-message").text("Balance Too Low");
			}

}	
		
	
		});
		
		
		
				
jQuery(".epins-proceed").click(function(){
	
epinprice();
qnty();
		
	
	jQuery('.btn-close').trigger('click');
	jQuery.LoadingOverlay("show");
	
var obj = {};
obj["vend"] = "vend";
obj["vpname"] = jQuery(".epins-name").val();
obj["vpemail"] = jQuery(".epins-email").val();
obj["tcode"] = jQuery("#tcode").val();
obj["uniqidvalue"] = jQuery("#uniqidvalue").val();
obj["id"] = jQuery("#id").val();
obj["amount"] = jQuery("#amt").val();
obj["quantity"] = jQuery(".edunumber").val();
obj["edutype"] = jQuery(".edutype").val();
obj["domination"] = jQuery(".domination").val();
obj["pin"] = jQuery(".pin").val();


jQuery.ajax({
  url: '<?php echo esc_url(plugins_url("vpepin/index.php"));?>',
  data: obj,
  dataType: 'json',
  'cache': false,
  "async": true,
  error: function (jqXHR, exception) {
	  jQuery.LoadingOverlay("hide");
        var msg = "";
        if (jqXHR.status === 0) {
            msg = "No Connection.\n Verify Network.";
     swal({
  title: "Error!",
  text: msg,
  icon: "error",
  button: "Okay",
});
  
        } else if (jqXHR.status == 404) {
            msg = "Requested page not found. [404]";
			 swal({
  title: "Error!",
  text: msg,
  icon: "error",
  button: "Okay",
});
        } else if (jqXHR.status == 500) {
            msg = "Internal Server Error [500].";
			 swal({
  title: "Error!",
  text: msg,
  icon: "error",
  button: "Okay",
});
        } else if (exception === "parsererror") {
            msg = "Requested JSON parse failed.";
			   swal({
  title: msg,
  text: jqXHR.responseText,
  icon: "error",
  button: "Okay",
});
        } else if (exception === "timeout") {
            msg = "Time out error.";
			 swal({
  title: "Error!",
  text: msg,
  icon: "error",
  button: "Okay",
});
        } else if (exception === "abort") {
            msg = "Ajax request aborted.";
			 swal({
  title: "Error!",
  text: msg,
  icon: "error",
  button: "Okay",
});
        } else {
            msg = "Uncaught Error.\n" + jqXHR.responseText;
			 swal({
  title: "Error!",
  text: msg,
  icon: "error",
  button: "Okay",
});
        }
    },
  
  success: function(data) {
	jQuery.LoadingOverlay("hide");
        if(data.code == "100"){
		var val = data.pin;
		var result = val.includes("-");
		if(result === true){
			var split = val.split("-");
			var pin = split[0];
			var ser = split[1];
		  swal({
  title: "PIN: ["+pin+"]",
  text: "SERIAL NO: ["+ser+"]",
  icon: "success",
  button: "Okay",
}).then((value) => {
	location.reload();
});
		}
		else{
	swal({
  title: "PIN ["+data.pin+"]",
  text: "Thanks For Your Patronage",
  icon: "success",
  button: "Okay",
}).then((value) => {
	location.reload();
});	
		}
	  }
	  else{
	swal(data.message, {
      icon: "error",
    }); 
	  }
  },
  type: 'POST'
});

});
		
		
		
		</script>
		

</div>
		
	
		<?php
		

		}
}







function epins_user_feature(){
	if(isset($_GET["vend"]) && $_GET["vend"]=="epins" && vp_getoption("epinscontrol") == "checked" && vp_getoption("resell") == "yes"){
$id = get_current_user_id();

$option_array = json_decode(get_option("vp_options"),true);
$user_array = json_decode(get_user_meta($id,"vp_user_data",true),true);
$data = get_userdata($id);

$bal = vp_getuser($id, 'vp_bal', true);

$plan = vp_getuser($id,'vr_plan',true);
		
		?>
		
<div id="dashboard-main-content">
<section class="container mx-auto">
<div class="p-md-5 p-1">
<div class="bg-white shadow">
<div class="dark-white flex items-center justify-between p-5 bg-gray-100">
<h1 class="text-xl font-bold">
<span class="lg:inline">Epins</span>
</h1>
<div class="font-bold tracking-wider">
<span class="dark inline-block px-3 py-1 bg-gray-200 border rounded-lg cursor-pointer" x-text="`NGN ${$format(total_sum)}`">NGN<?php echo $bal;?></span>
</div>
</div>
<div class="p-2 bg-white lg:p-5">
<template x-for="transaction in transactions"></template>


		<style>
		.user-vends{
			border: 1px solid grey;
			border-radius: 5px;
			padding: 1rem !important;
		}
		</style>
		
		<div id="side-epins-w">
		
<div class="mb-2 row" style="height:fit-content;">
       <span style="float:left;" class="col"> Wallet: ₦<?php echo $bal;?></span>
<span style="float:right;" class="col"><a href="?vend=wallet" style="text-decoration:none; float:right;" class="btn-primary btn-sm">Fund Wallet</a></span>

</div>


		<div class="user-vends">
		<?php
global $level;
		?>
<form class="for" id="cfor" method="post" <?php echo apply_filters('formaction','target="_self"');?>>

		 <div class="visually-hidden">
                <input type="hidden" name="vpname" class="form-control epins-name" placeholder="Name" aria-label="Name" aria-describedby="basic-addon1" value="<?php echo $data->user_login; ?>">
            </div>
            <div class="visually-hidden">
                <input type="hidden" name="vpemail" class="form-control epins-email" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1" value="<?php echo $data->user_email; ?>">
            </div>
			<div class="visually-hidden">		
				<input type="hidden" id="tcode" name="tcode" value="cepins">
				<input type="hidden" id="url" name="url">
				<input type="hidden" id="uniqidvalue" name="uniqidvalue" value="<?php echo uniqid('VTU-',false);?>">
				<input type="hidden" id="url1" name="url1" value="<?php echo esc_url(plugins_url('vtupress/process.php'));?>">
				<input type="hidden" id="id" name="id" value="<?php echo uniqid('VTU-',false);?>">
			</div>

<div class="input-group mb-2 ">
<span class="input-group-text">NETWORK</span>
<select name="dutype" class="form-control form-select edutype">
<option value="none">---Select---</option>
	<option value="waec">WAEC [<?php 
				

				$s = (floatval($level[0]->epin_waec)*vp_getoption("epinswaec"))/100;
				echo vp_getoption("epinswaec") - $s;
			
				
				?>]</option>
<option value="neco">NECO [<?php

				$s = (floatval($level[0]->epin_neco)*vp_getoption("epinsneco"))/100;
				echo vp_getoption("epinsneco") - $s;

				?>]</option>
<option value="jamb">JAMB [<?php 

				$s = (floatval($level[0]->epin_jamb)*vp_getoption("epinsjamb"))/100;
				echo vp_getoption("epinsjamb") - $s;

				
				?>]</option>
<option value="nabteb">NABTEB [<?php 

					$s = (floatval($level[0]->epin_nabteb)*vp_getoption("epinsnabteb"))/100;	
				echo vp_getoption("epinsnabteb") - $s;

				
				?>]</option>
</select>
 <div id="validationServer04Feedback" class="invalid-feedback">
                      Error: <span class="epins-edutype-message"></span>
						</div>
</div>
<div class="input-group mb-2">
<span class="input-group-text">Quantity</span>
<select name="dunumber" class="form-control form-select edunumber">
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="10">10</option>
</select>
 <div id="validationServer04Feedback" class="invalid-feedback">
                      Error: <span class="epins-sender-error-message"></span>
						</div>
</div>
<div class="input-group mb-2 visually-hidden">
<span class="input-group-text visually-hidden">DOMINATION</span>
<select name="domination" class="form-control form-select domination">
<option value="100">100</option>
<option value="200">200</option>
<option value="500">500</option>
<option value="1000">1000</option>
</select>
 <div id="validationServer04Feedback" class="invalid-feedback">
                      Error: <span class="epins-sender-error-message"></span>
						</div>
</div>
<br>

 <div class="input-group mb-2">
                    <span class="input-group-text" id="basic-addon1">NGN.</span>
                    <input id="amt" name="amount" type="number" class="form-control epins-amount" max="<?php echo $bal;?>" placeholder="Amount" aria-label="Username" aria-describedby="basic-addon1" readonly required>
                    <span class="input-group-text" id="basic-addon1">.00</span>
                    <div id="validationServer04Feedback" class="invalid-feedback">
                      Error: <span class="epins-amount-error-message"></span>
                      </div>
 </div>
   <div class="vstack gap-2">
                    <button type="button" class="btn btn-secondary w-full p-2 text-xs font-bold text-white uppercase bg-indigo-600 rounded shadow purchase-epins" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@getbootstrap">Print</button>
  </div>	
			
</form>
</div>
	  <!--The Modal-->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">epins Purchase Confirmation</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <div>
                    Network : <span class="epins-network-confirm"></span><br>
                    Quantity : <span class="epins-quantity-confirm"></span><br>
                    Amount : ₦<span class="epins-amount-confirm"></span><br>
                    Status : <span class="epins-status-confirm"></span><br>
					<div class="input-group form">
					<span class="input-group-text">PIN</span>
					<input class="form-control pin" type="number" name="pin">
					</div>
                    </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary  p-2 text-xs font-bold text-dark uppercase bg-gray-600 rounded shadow data-proceed-cancled" data-bs-dismiss="modal">Cancel</button>
                      <button type="button" name="wallet" id="wallet" class="btn btn-primary p-2 text-xs font-bold text-white uppercase bg-indigo-600 rounded shadow  epins-proceed" form="cfor">Proceed</button>
                    </div>
                  </div>
                </div>
            </div>
    	
		
		</div>
		
		<script>
		jQuery(".edunumber").on("change",function(){
			qnty();
		});
function qnty(){
		epinprice();
		var amount = jQuery(".epins-amount").val();
		var quantity = jQuery(".edunumber").val();
	jQuery(".epins-amount").val(amount*quantity);
		
	};

jQuery(".edutype").on("change",function(){
	
	epinprice();
});

function epinprice(){
		
		
			//var str = jQuery(".domination").val();
			var epins = jQuery(".edutype").val();
			var numbers;
			var price;
			var discount;
			switch(epins){
				case"neco":
				
				numbers  = <?php

				$s = (floatval($level[0]->epin_neco)*vp_getoption("epinsneco"))/100;
				echo vp_getoption("epinsneco") - $s;

				?>;
				
				jQuery(".discount-amount-confirm").text('<?php echo floatval($level[0]->epin_neco);?>');
				jQuery(".epins-amount").val(numbers);
				jQuery(".necoprice").text(numbers);
				jQuery(".epins-amount-confirm").val(numbers);
				break;
				case "jamb":
				numbers  = <?php 

				$s = (floatval($level[0]->epin_jamb)*vp_getoption("epinsjamb"))/100;
				echo vp_getoption("epinsjamb") - $s;

				
				?>;
				
				jQuery(".discount-amount-confirm").text('<?php echo floatval($level[0]->epin_jamb);?>');
				jQuery(".epins-amount").val(numbers);
				jQuery(".jambprice").text(numbers);
				jQuery(".epins-amount-confirm").val(numbers);
				break;
				case "waec":
				numbers  = <?php 
				

				$s = (floatval($level[0]->epin_waec)*vp_getoption("epinswaec"))/100;
				echo vp_getoption("epinswaec") - $s;
			
				
				?>;
				jQuery(".discount-amount-confirm").text('<?php echo floatval($level[0]->epin_waec);?>');
				jQuery(".epins-amount").val(numbers);
				jQuery(".waecprice").text(numbers);
				jQuery(".epins-amount-confirm").val(numbers);
				break;
				case "nabteb":
				numbers  = <?php 

					$s = (floatval($level[0]->epin_nabteb)*vp_getoption("epinsnabteb"))/100;	
				echo vp_getoption("epinsnabteb") - $s;

				
				?>;
				jQuery(".discount-amount-confirm").text('<?php echo floatval($level[0]->epin_nabteb);?>');
				jQuery(".epins-amount").val(numbers);
				jQuery(".nabtebprice").text(numbers);
				jQuery(".epins-amount-confirm").val(numbers);
				break;
			}

			var total_amount = numbers;
			jQuery(".epins-amount").val(total_amount);
			jQuery(".epins-amount-confirm").val(numbers);
	
		//	alert(total_amount);
};
		
jQuery(".purchase-epins").click(function(){
epinprice();
qnty();
		
var total_amount = jQuery(".epins-amount").val();
			
			jQuery(".epins-network-confirm").text(jQuery(".edutype").val());
			jQuery(".epins-quantity-confirm").text(jQuery(".edunumber").val());
			jQuery(".epins-amount-confirm").text(jQuery(".epins-amount").val());

			
if(jQuery(".edutype").val() == "none"){
				jQuery(".edutype").addClass("is-invalid");
				jQuery(".epins-edutype-message").text("Please Select One");
				jQuery(".epins-proceed").hide();
				jQuery(".epins-status-confirm").text("Please Select One Network");
}
else{
	
				
if(total_amount <= <?php echo $bal;?> && total_amount > 0){
			jQuery(".epins-proceed").show();
				jQuery(".epins-amount").removeClass("is-invalid");
				jQuery(".epins-amount").addClass("is-valid");
				jQuery(".epins-status-confirm").text("Correct");
jQuery(".epins-proceed").show();
jQuery(".edutype").addClass("is-valid");
jQuery(".edutype").removeClass("is-invalid");
jQuery(".epins-status-confirm").text("Correct");
			}
			else if(total_amount > <?php echo $bal;?> || total_amount <= 0){
			jQuery(".epins-status-confirm").text("Balance Too Low");
			jQuery(".epins-proceed").hide();
			jQuery(".epins-amount").addClass("is-invalid");
			jQuery(".epins-amount-error-message").text("Balance Too Low");
			}

}	
		
	
		});
		
		
		
				
jQuery(".epins-proceed").click(function(){
	
epinprice();
qnty();
		
	
	jQuery('.btn-close').trigger('click');
	jQuery("#cover-spin").show();
	
var obj = {};
obj["vend"] = "vend";
obj["vpname"] = jQuery(".epins-name").val();
obj["vpemail"] = jQuery(".epins-email").val();
obj["tcode"] = jQuery("#tcode").val();
obj["uniqidvalue"] = jQuery("#uniqidvalue").val();
obj["id"] = jQuery("#id").val();
obj["amount"] = jQuery("#amt").val();
obj["quantity"] = jQuery(".edunumber").val();
obj["edutype"] = jQuery(".edutype").val();
obj["domination"] = jQuery(".domination").val();
obj["pin"] = jQuery(".pin").val();


jQuery.ajax({
  url: '<?php echo esc_url(plugins_url("vpepin/index.php"));?>',
  data: obj,
  dataType: 'json',
  'cache': false,
  "async": true,
  error: function (jqXHR, exception) {
	  jQuery("#cover-spin").hide();
        var msg = "";
        if (jqXHR.status === 0) {
            msg = "No Connection.\n Verify Network.";
     swal({
  title: "Error!",
  text: msg,
  icon: "error",
  button: "Okay",
});
  
        } else if (jqXHR.status == 404) {
            msg = "Requested page not found. [404]";
			 swal({
  title: "Error!",
  text: msg,
  icon: "error",
  button: "Okay",
});
        } else if (jqXHR.status == 500) {
            msg = "Internal Server Error [500].";
			 swal({
  title: "Error!",
  text: msg,
  icon: "error",
  button: "Okay",
});
        } else if (exception === "parsererror") {
            msg = "Requested JSON parse failed.";
			   swal({
  title: msg,
  text: jqXHR.responseText,
  icon: "error",
  button: "Okay",
});
        } else if (exception === "timeout") {
            msg = "Time out error.";
			 swal({
  title: "Error!",
  text: msg,
  icon: "error",
  button: "Okay",
});
        } else if (exception === "abort") {
            msg = "Ajax request aborted.";
			 swal({
  title: "Error!",
  text: msg,
  icon: "error",
  button: "Okay",
});
        } else {
            msg = "Uncaught Error.\n" + jqXHR.responseText;
			 swal({
  title: "Error!",
  text: msg,
  icon: "error",
  button: "Okay",
});
        }
    },
  
  success: function(data) {
	jQuery("#cover-spin").hide();
        if(data.code == "100"){
		var val = data.pin;
		var result = val.includes("-");
		if(result === true){
			var split = val.split("-");
			var pin = split[0];
			var ser = split[1];
		  swal({
  title: "PIN: ["+pin+"]",
  text: "SERIAL NO: ["+ser+"]",
  icon: "success",
  button: "Okay",
}).then((value) => {
	location.reload();
});
		}
		else{
	swal({
  title: "PIN ["+data.pin+"]",
  text: "Thanks For Your Patronage",
  icon: "success",
  button: "Okay",
}).then((value) => {
	location.reload();
});	
		}
	  }
	  else{
	swal(data.message, {
      icon: "error",
    }); 
	  }
  },
  type: 'POST'
});

});
		
		
		
		</script>
		
</div>
</div>

</div>
</section>
</div>
		
	
		<?php
		

		}
}








function epins_set_control(){
	
	echo'
	if(jQuery("#epinscontrol").is(":checked")){
		var epinsc = "checked";
	}
	else{
		var epinsc = "unchecked";
	}
	
obj["epinscontrol"] = epinsc;
	';
	
}

function epins_set_control_post(){
vp_updateoption("epinscontrol",$_REQUEST["epinscontrol"]);	
}

add_action("transaction_button","vpepins_transaction_button");
add_action("transaction_style","vpepins_transaction_style");
add_action("transaction_failed_case","vpepins_failed");
add_action("transaction_successful_case","vpepins_success");






$id = get_current_user_id();
add_action("add_user_history_button","epins_history_button");
add_action("add_user_history_tab","epins_history_tab");

function epins_history_button(){
	echo'
	<a href="?vend=history&for=transactions&type=epins" class="pe-2 text-decoration-none">	<button class="epins-hist btn-sm btn-primary btn"> <i class="mdi mdi-barcode "></i> >Epins</button> </a>
	';
	
}



function epins_history_tab(){
	if($_GET["for"] == "transactions"){
		if($_GET["type"] == "epins"){	
	$id = get_current_user_id();
	$user_name = get_userdata($id)->user_login;
echo'	

	<div id="epinshist" class="thistory bg bg-white">

		<div class="clo">
		
		</div>
		<button class="btn download_epins_s_history btn-primary" style="float:left;">DOWNLOAD EPINS HISTORY</button>
		<br>
		<br>
		<br>

		<table class="d-flex justify-content-md-center table table-responsive table-hover history-successful epins_s_history" id="epinsshistory">
		<tbody>
		';
$id = get_current_user_id();
/*
global $wpdb;
$table_name = $wpdb->prefix.'sepins';
$resultsad = $wpdb->get_results($wpdb->prepare("SELECT * FROM  $table_name WHERE user_id= %d ORDER BY id DESC", $id));
*/

pagination_before_front("?vend=history","epins","epins", "sepins", "resultsad", "WHERE user_id = $id");

pagination_after_front("?vend=history","epins","epins");

global $resultsad;
echo"
<tr>
<th scope='col'>Id</th>
<th scope='col'>Exam</th>
<th scope='col'>Pin - Serial Number</th>
<th scope='col'>Amount</th>
<th scope='col'>Previous Balance</th>
<th scope='col'>Current Balance</th>
<th scope='col'>Time</th>
<th scope='col'>Receipt</th>
</tr>
";
foreach ($resultsad as $resultsa){ 
echo "
<tr>
<td scope='row'>".$resultsa->id."</td>
<td>".$resultsa->type."</td>
<td>".$resultsa->pin."</td>
<td>".$resultsa->amount."</td>
<td>".$resultsa->bal_bf."</td>
<td>".$resultsa->bal_nw."</td>
<td>".$resultsa->the_time."</td>
<td>
<button type='button' class=\"btn btn-secondary  btn-sm p-2 text-xs font-bold text-white uppercase bg-indigo-600 rounded shadow  show_epins".$resultsa->id."\" data-bs-toggle=\"modal\" data-bs-target=\"#exampleModal".$resultsa->id."\" data-bs-whatever='@getbootstrap'>VIEW</button>
";
echo '
            <div class="modal fade" id="exampleModal'.$resultsa->id.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">'.strtoupper($resultsa->type).' Purchase Confirmation</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
						<div class="container-fluid border border-secondary" id="epinsreceipt'.$resultsa->id.'">
													
							
							
								<div class="row bg bg-dark text-white">
									<div class="col bg bg-dark text-white">
										<span class=""><h3>@INVOICE</h3></span>
									</div>
								</div>
							
							
						<div class="row p-4">
							
							<div class="row bg text-dark border border-bottom-primary md-2">
								<div class="col">
										<span class="input-group-text1"><h5>ID</h5></span>
								</div>
								<div class="col right">
										<span class="input-group-text1"><h5>'.strtoupper($resultsa->id).'</h5></span>
								</div>
							</div>
							
							<div class="row bg text-dark border border-bottom-primary md-2">
								<div class="col">
										<span class="input-group-text1"><h5>TYPE</h5></span>
								</div>
								<div class="col right">
										<span class="input-group-text1"><h5>'.strtoupper($resultsa->type).'</h5></span>
								</div>
							</div>
							
							<div class="row bg text-dark border border-bottom-primary md-2">
								<div class="col">
										<span class="input-group-text1"><h5>TIME</h5></span>
								</div>
								<div class="col right">
										<span class="input-group-text1"><h5>'.strtoupper($resultsa->the_time).'</h5></span>
								</div>
							</div>
							';
							if(stripos(strtoupper($resultsa->pin), '-')){
								$pin = explode('-',strtoupper($resultsa->pin));
								echo'
							<div class="row bg bg-secondary text-white border border-bottom-primary md-2">
								<div class="col">
										<span class="input-group-text1"><h5>PIN</h5></span>
								</div>
								<div class="col right">
										<span class="input-group-text1"><h5>'.$pin[0].'</h5></span>
								</div>
							</div>
							<div class="row bg bg-secondary text-white border border-bottom-primary md-2">
								<div class="col">
										<span class="input-group-text1"><h5>Serial Number</h5></span>
								</div>
								<div class="col right">
										<span class="input-group-text1"><h5>'.$pin[1].'</h5></span>
								</div>
							</div>
							';
							}
							else{
							echo'
							<div class="row bg bg-secondary text-white border border-bottom-primary md-2">
								<div class="col">
										<span class="input-group-text1"><h5>PIN</h5></span>
								</div>
								<div class="col right">
										<span class="input-group-text1"><h5>'.strtoupper($resultsa->pin).'</h5></span>
								</div>
							</div>
';							
								
							}
							
							echo'
							
						</div>
							
						
						
						</div>
		
					</div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary p-2 text-xs font-bold text-black uppercase bg-grey-600 rounded shadow data-proceed-cancled" data-bs-dismiss="modal">Cancel</button>
					  <button type="button" id="" class="btn btn-info p-2 text-xs font-bold text-white uppercase bg-blue-600 rounded shadow "  onclick="printContent(\'epinsreceipt'.$resultsa->id.'\');">Print</button>
                      <button type="button" name="epin_receipt" id="epinreceipt'.$resultsa->id.'" class="btn btn-primary p-2 text-xs font-bold text-white uppercase bg-indigo-600 rounded shadow  epin_proceed'.$resultsa->id.'" >Download</button>
                    </div>
                  </div>
                </div>
            </div>
';
echo"
		<script>
jQuery(\".epin_proceed".$resultsa->id."\").on(\"click\",function(){
 var element = document.getElementById(\"epinsreceipt".$resultsa->id."\");
  jQuery('#cover-spin').show();
html2pdf(element, {
  margin:       10,
  filename:     'epins.pdf',
  image:        { type: 'jpeg', quality: 0.98 },
  html2canvas:  { scale: 2, logging: true, dpi: 192, letterRendering: true },
  jsPDF:        { unit:'mm', format: 'a4', orientation:'portrait' }
});

 jQuery('#cover-spin').hide();
});
/*
var el = jQuery(\'.epins_s_history\').clone();
            jQuery(\'.clo\').append(el);
			*/
</script>
</td>
</tr>
";
}
echo'</tbody>
		</table>
		<br>
</div>	
	
';	
}
}
}



register_activation_hook(__FILE__,"create_epins_transaction");
register_activation_hook(__FILE__,"addepinsdata");
register_activation_hook(__FILE__,"create_epins");
register_activation_hook(__FILE__,"add_epins");