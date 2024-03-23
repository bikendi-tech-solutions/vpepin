<?php
if(current_user_can("vtupress_admin")){

?>

<div class="container-fluid license-container">
            <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
            <style>
                div.vtusettings-container *{
                    font-family:roboto;
                }
                .swal-button.swal-button--confirm {
                    width: fit-content;
                    padding: 10px !important;
                }
            </style>

<p style="visibility:hidden;">
Please take note to always have security system running and checked. DO not disclose your login details to anyone except for confidential reasons. 
Not even the developers of this plugin should be trusted enough to grant access anyhow.

                  </p>


<?php
if(!defined('ABSPATH')){
    $pagePath = explode('/wp-content/', dirname(__FILE__));
    include_once(str_replace('wp-content/' , '', $pagePath[0] . '/wp-load.php'));
}
if(WP_DEBUG == false){
error_reporting(0);	
}
include_once(ABSPATH."wp-load.php");
include_once(ABSPATH .'wp-content/plugins/vtupress/admin/pages/history/functions.php');
include_once(ABSPATH .'wp-content/plugins/vtupress/functions.php');
$option_array = json_decode(get_option("vp_options"),true);

?>

<div class="row">

    <div class="col-12">
    <link
      rel="stylesheet"
      type="text/css"
      href="<?php echo esc_url(plugins_url("vtupress/admin")); ?>/assets/extra-libs/multicheck/multicheck.css"
    />
    <link
      href="<?php echo esc_url(plugins_url("vtupress/admin")); ?>/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css"
      rel="stylesheet"
    />
<div class="card">
                <div class="card-body">

                


                <div class="form-check form-switch card-title d-flex">
<div class="input-group">
<label class="form-check-label float-start input-group-text" for="flexSwitchCheckChecked">Exam Pin Vending Status</label>
<input onchange="changestatus('epins')" value="checked" class="form-check-input epins input-group-text h-100 float-start" type="checkbox" role="switch" id="flexSwitchCheckChecked" <?php echo vp_option_array($option_array,"epinscontrol");?>>
</div>
</div>
<script>
function changestatus(type){
var obj = {}
if(jQuery("input."+type).is(":checked")){
  obj["set_status"] = "checked";
}
else{
  obj["set_status"] = "unchecked";
}
obj["set_control"] = type;
obj["spraycode"] = "<?php echo vp_getoption("spraycode");?>";


  jQuery.ajax({
  url: "<?php echo esc_url(plugins_url('vtupress/controls.php'));?>",
  data: obj,
  dataType: "text",
  "cache": false,
  "async": true,
  error: function (jqXHR, exception) {
	  jQuery(".preloader").hide();
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
	jQuery(".preloader").hide();
        if(data == "100" ){
	location.reload();
	  }
	  else{
		  
	jQuery(".preloader").hide();
	 swal({
  title: "Error",
  text: data,
  icon: "error",
  button: "Okay",
});
	  }
  },
  type: "POST"
});

}

</script>


                  <div class="table-responsive">
<div class="p-4">

<div id="epinseasyaccess">



<div class="alert alert-primary mb-2" role="alert">
<b>EPINS NOTE:</b>

<h5>Determining User Prices</h5>
<p>The <span style="color:blue;"> blue</span> bordered field is where you are to set prices. Each field is next to an exam type</p>
<h5>Determining Discount</h5>
<p>The <span style="color:green;"> green </span> bordered field is where you are to set discount against the normal user price. Each discount field is next to an exam type price</p>
<h5>Adding Exam Pin</h5>
<ol>
<li>Select the Exam Type Such as Waec, Jamd e.t.c you wanna add pin for. The Drop-Down is next to [EXAM] below</li>
<li>In the large textarea next to the Exam Type which you\'ve selected is where you have to enter the pin. For Waec you need to enter the PIN and SERIAL Number so to do that, kindly enter the pin and serial number in this format <b>12345-6789</b>. Where 12345 is the pin and 6789 is the serial number. for any pin that doesn\'t need serial number, just enter the pin alone</li>
<li>Set DELIMITER: if you are uploading one pin for an exam type, kindly leave the delimiter as none or enter comma [,] to let the system know you are entering multiple PINS. NOTE: if you enter commer [,] in the delimiter, make sure you separate each pin in the step above with comma [,]. E.g 12345-6789, 5678-9355</li>
<li> Click the Add Pin Button</li>
</ol>
<b>Read more by clicking this link: <a href="https://vtupress.com/doc/how-to-setup-exam-pins/">EPINS</a></b>
</div>



<label>Educations</label><br>
<div class="epineasy">
<div class="input-group mb-3">
<span class="input-group-text">[WAEC] PRICE FOR USERS</span>
<input type="text" value="<?php echo vp_getoption("epinswaec");?>" name="epinswaec" placeholder="Price For Neco Per Unit" style="border: 3px solid green;">

</div>
<div class="input-group mb-3">
<span class="input-group-text">[NECO] PRICE FOR USERS</span>
<input type="text" value="<?php echo vp_getoption("epinsneco");?>" name="epinsneco" placeholder="Price For WAEC Per Unit" style="border: 3px solid green;">


</div>
<div class="input-group mb-3">
<span class="input-group-text">[JAMB] PRICE FOR USERS</span>
<input type="text" value="<?php echo vp_getoption("epinsjamb");?>" name="epinsjamb" placeholder="Price For NABTEB Per Unit" style="border: 3px solid green;">


</div>
<div class="input-group mb-3">
<span class="input-group-text">[NABTEB] PRICE FOR USERS</span>
<input type="text" value="<?php echo vp_getoption("epinsnabteb");?>" name="epinsnabteb" placeholder="Price For NABTEB Per Unit" style="border: 3px solid green;">


</div>
<input type="button" class="savepin btn btn-success" value="SAVE EPIN">
</div>
<!--END OF EPIN EASY-->
<br>

<div class="neglect border border-secondary">
<div style="background-color:grey;">
<label style="color:white;" class="ml-2">ADD EXAM PIN[s]</label>
<div class="p-2">
<form class="vpn">
<div class="input-group md-3">
<span class="input-group-text">EXAM</span>
<select class="enetwork form-control" name="enetwork">
<option value="waec">WAEC</option>
<option value="neco">NECO</option>
<option value="nabteb">NABTEB</option>
<option value="jamb">JAMB</option>
</select>
<span class="input-group-text form-control visually-hidden">VALUE</span>
<input type="number" class="evalue visually-hidden" name="evalue" placeholder="(e.g 100, 200, 500, 1000)" value="777">
</div>

<textarea name="epin" class="epin form-control" placeholder="Enter Pin(s). Separate Pins By Comma sign and enter Comma sign in the delimiter field if you are importing more than one pin"></textarea>
<div class="input-group mb-3">
<span class="input-group-text" title="[use none if you are uploading a single pin or separate each pins by {, or / or ;}]">DELIMITER </span>
<input type="text" class="edelimiter" name="edelimiter" value="none" placeholder="separate pins by comma \',\'">
<span class="input-group-text">ACTION</span>
<input type="button" name="eadd_pin" class="eadd_pin btn btn-success" value="ADD PIN[s]">
</div>

</form>
</div>
</div>
</div>

<?php

global $wpdb;
$etable_name = $wpdb->prefix.'vpepinsa';
$eresultfad = $wpdb->get_results("SELECT * FROM  $etable_name WHERE status = 'unused' ORDER BY id DESC");
$eused = $wpdb->get_results("SELECT * FROM  $etable_name WHERE status = 'used' ORDER BY id DESC");

?>

<div  style='background-color:grey;'>
<label style='color:white;' class='ml-2'>SHOW EXAM(s)</label>
<div class='p-2'>
<div class='input-group mb-3'>
<span class='input-group-text'>FIND EXAM</span>
<select class='theexam group-text' name='epin'>
<option value='all'>ALL</option>
<option value='waec'>WEAC</option>
<option value='neco'>NECO</option>
<option value='jamb'>JAMB</option>
<option value='nabteb'>NABTEB</option>
</select>
<span class='input-group-text'>STATUS</span>
<select class='educationvisibility group-text' name='epin'>
<option value='eunused'>UNUSED</option>
<option value='eused'>USED</option>
</select>
<input type='button' value='SHOW EPINS' name='submitedution' class='btn btn-primary group-text searcheducation'>
</div>
</div>
</div>
<div  style='background-color:grey;' class='epindel'>
<label style='color:white;' class='ml-2'>ACTION</label>
<div class='p-2'>
<div class='input-group mb-3'>
<span class='input-group-text'>TARGET</span>
<select class='target group-text' name='target'>
<option value='checked'>CHECKED</option>
<option value='unchecked'>UNCHECKED</option>
</select>
<span class='input-group-text'>STATUS</span>
<select class='targetstatus group-text' name='targetstatus'>
<option value='eused'>USED</option>
<option value='eunused'>UNUSED</option>
</select>
<span class='input-group-text'>ACTION</span>
<select class='target-action group-text' name='target-action'>
<option value='delete'>DELETE</option>
</select>
<input type='button' value='RUN' name='runtarget' class='btn btn-primary group-text eruntarget'>
</div>
</div>
</div>
<div class='input-group'>
<input class='eusedbtn btn btn-primary' type='button' value='USED'> <input class='eunusedbtn btn btn-primary' type='button' value='UN USED'>
</div>

<div class='container dtable d-flex justify-content-start' >
  <table class='table table-striped table-hover table-bordered table-responsive'>
	<thead>
	<tr>
	<th scope='col'><input type='checkbox' class='eunused emastercheckbox border-success' name=''> <input name='' type='checkbox' class='eused emastercheckbox border-danger'></th>
	<th scope='col'>Id</th>
	<th scope='col'>Network</th>
	<th scope='col'>Pin - Serial No:</th>
	<th scope='col'>Time</th>
	<th scope='col'>Status</th>
	</tr>
	</thead>
	<tbody>

<?php
foreach($eresultfad as $pins){
	
	$id = $pins->id;
	$pin = $pins->pin;
	$network = $pins->network;
	$time = $pins->the_time;
	$status = $pins->status;	
	echo"
	<tr class='eunused $network educationresult all'>
	<th scope='col'><input type='checkbox' class='eunusedcheckbox border-success' value='$id'></th>
	<th scope='row'>$id</th>
	<td>$network</td>
	<td>$pin</td>
	<td>$time</td>
	<td>$status</td>
	</tr>
	";

	
}
foreach($eused as $pins){
	
	$id = $pins->id;
	$pin = $pins->pin;
	$network = $pins->network;
	$time = $pins->the_time;
	$status = $pins->status;	
	echo"
	<tr class='eused $network educationresult all'>
	<th scope='col'><input type='checkbox' class='eusedcheckbox border-danger' value='$id'></th>
	<th scope='row'>$id</th>
	<td>$network</td>
	<td>$pin</td>
	<td>$time</td>
	<td>$status</td>
	</tr>
	";

	
}
?>
	</tbody>
</table>
</div>




<script>


	
jQuery(document).ready(function(){
jQuery("input[type=checkbox].eused").removeProp("checked");
jQuery("input[type=checkbox].eunused").removeProp("checked");
});
		 
	jQuery(".eused.emastercheckbox").on("change",function(){

	 jQuery("input[type=checkbox].eusedcheckbox").prop("checked", jQuery(this).prop("checked"));

	});
	
	jQuery(".eunused.emastercheckbox").on("change",function(){

	 jQuery("input[type=checkbox].eunusedcheckbox").prop("checked", jQuery(this).prop("checked"));

	});
	
	
	jQuery(".epindel .eruntarget").on("click",function(){
	jQuery("#cover-spin").show();
	var etargetstatus = jQuery(".epindel .targetstatus").val();
	var ids = "/";
	var etarget = jQuery(".epindel .target").val();
	
	var etargetaction = jQuery(".epindel .target-action").val();
	
	if(etarget == "checked"){
	
	jQuery("."+etargetstatus+"checkbox:checked").each(function(){
	ids = ids+"/"+jQuery(this).val();	
	});
	
	}
	else{
	jQuery("."+etargetstatus+"checkbox:not(:checked)").each(function(){
	ids = ids+"/"+jQuery(this).val();
	});	
	}
	
	obj = {};
	obj["target"] = etarget;
	obj["targetstatus"] = etargetstatus;
	obj["targetaction"] = etargetaction;
	obj["keys"] = ids;
	
	jQuery.ajax({
  url: "<?php echo esc_url(plugins_url('vpepin/index.php'));?>",
  data: obj,
  dataType: "json",
  "cache": false,
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
  title: "Error",
  text: msg,
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
		  swal({
  title: "Successfully Added",
  text: data.message,
  icon: "success",
  button: "Okay",
}).then((value) => {
	location.reload();
});
	  }
	  else{
	swal(data.message, {
      icon: "error",
    }); 
	  }
  },
  type: "POST"
});
	
	
	});
	
	
	
	
jQuery(".eused").hide();
jQuery(".eunusedbtn").on("click",function(){
	jQuery(".eused").hide();
	jQuery(".eunused").show();
});
jQuery(".eusedbtn").on("click",function(){
	jQuery(".eunused").hide();
	jQuery(".eused").show();
});

jQuery(".searcheducation").on("click",function(){
	var val = jQuery(".theexam").val();
	var vis = jQuery(".educationvisibility").val();
	jQuery(".educationresult").hide();
	jQuery(".emastercheckbox").hide();
	jQuery("."+vis+"."+val).show();
	jQuery("."+vis+".emastercheckbox").show();
	
});





jQuery(".savepin").click(function(){

jQuery("#cover-spin").show();
	
var obj = {};
var toatl_input = jQuery(".epineasy input,.epineasy select").length;
var run_obj;

for(run_obj = 0; run_obj <= toatl_input; run_obj++){
var current_input = jQuery(".epineasy input,.epineasy select").eq(run_obj);


var obj_name = current_input.attr("name");
var obj_value = current_input.val();

if(typeof obj_name !== typeof undefined && obj_name !== false){
obj[obj_name] = obj_value;
}

	
}

	jQuery.ajax({
  url: "<?php echo esc_url(plugins_url('vpepin/saveauth.php'));?>",
  data: obj,
  dataType: "text",
  "cache": false,
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
  title: "Error",
  text: msg,
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
        if(data == "100" ){
	
		  swal({
  title: "SAVED",
  text: "Update Completed",
  icon: "success",
  button: "Okay",
}).then((value) => {
});
	  }
	  else{
		  
	jQuery("#cover-spin").hide();
	swal({
  buttons: {
    cancel: "Why?",
    defeat: "Okay",
  },
  title: "Update Wasn\'t Successful",
  text: "Click \'Why\' To See reason",
  icon: "error",
})
.then((value) => {
  switch (value) {
 
    case "defeat":
      break;
    default:
      swal({
		title: "Details",
		text: data,
      icon: "info",
    });
  }
}); 

  }
  },
  type: "POST"
});

	
});


jQuery(".eadd_pin").on("click",function(){
		  jQuery("#cover-spin").show();
var ob = {};
ob["enetwork"] = jQuery(".enetwork").val();
ob["epin"] = jQuery(".epin").val();
ob["evalue"] = jQuery(".evalue").val();
ob["eadd_pin"] = jQuery(".epin").val();
ob["edelimiter"] = jQuery(".edelimiter").val();


jQuery.ajax({
  url: '<?php echo esc_url(plugins_url("vpepin/pins.php"));?>',
  data: ob,
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
  title: "Error",
  text: msg,
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
		  swal({
  title: "Successfully Added",
  text: data.message,
  icon: "success",
  button: "Okay",
}).then((value) => {
	location.reload();
});
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






function deactivate( ){
var obj = {};
obj['setactivation'] = "no";
obj['actid'] = "";
obj['actkey'] = "";
jQuery(".preloader").show();

    jQuery.ajax({
  url: "<?php echo esc_url(plugins_url('vtupress/vend.php'));?>",
  data: obj,
  dataType: "json",
  "cache": false,
  "async": true,
  error: function (jqXHR, exception) {
	  jQuery(".preloader").hide();
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
	jQuery(".preloader").hide();
        if(data.status == "100" ){
	
		  swal({
  title: "DONE",
  text: "Activated Successfully!",
  icon: "success",
  button: "Okay",
}).then((value) => {
	location.reload();
});
	  }
	  else{
		  
	jQuery(".preloader").hide();
	 swal({
  title: "Off-Site",
  text: "Deactivated!!!",
  icon: "warning",
  button: "Okay",
}).then((value) => {
	location.reload();
});
	  }
  },
  type: "POST"
});
}
</script>

</div>





                  </div>
                </div>
              </div>
</div>


</div>



</div>
<?php   
}
    
?>