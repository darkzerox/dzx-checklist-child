<?php
header('Content-Type: text/plain');
session_cache_expire(3600);
session_start();
/**
 * wp-bootstrap-starter Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package wp-bootstrap-starter
 * @since 1.0.0
 */


function showSess(){
	echo 'landlordID : '.$_SESSION['landlord']."<br/>";
	echo 'tenantID : '.$_SESSION['tenant']."<br/>";
	echo 'ProID : '.$_SESSION['pro']."<br/>";
	echo 'RoomID : '.$_SESSION['roID']."<br/>";
	echo 'RoomName : '.$_SESSION['roN']."<br/>";
}
// add_action('wp_footer','showSess');


global $uploadIcon;
global $faUp;
global $faDown;
$uploadIcon = "/wp-content/uploads/2018/04/upload_icob.png";
$faUp = '<svg class="svg-inline--fa fa-thumbs-up fa-w-16 fa-2x" aria-hidden="true" data-fa-processed="" data-prefix="fa" data-icon="thumbs-up" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M104 224H24c-13.255 0-24 10.745-24 24v240c0 13.255 10.745 24 24 24h80c13.255 0 24-10.745 24-24V248c0-13.255-10.745-24-24-24zM64 472c-13.255 0-24-10.745-24-24s10.745-24 24-24 24 10.745 24 24-10.745 24-24 24zM384 81.452c0 42.416-25.97 66.208-33.277 94.548h101.723c33.397 0 59.397 27.746 59.553 58.098.084 17.938-7.546 37.249-19.439 49.197l-.11.11c9.836 23.337 8.237 56.037-9.308 79.469 8.681 25.895-.069 57.704-16.382 74.757 4.298 17.598 2.244 32.575-6.148 44.632C440.202 511.587 389.616 512 346.839 512l-2.845-.001c-48.287-.017-87.806-17.598-119.56-31.725-15.957-7.099-36.821-15.887-52.651-16.178-6.54-.12-11.783-5.457-11.783-11.998v-213.77c0-3.2 1.282-6.271 3.558-8.521 39.614-39.144 56.648-80.587 89.117-113.111 14.804-14.832 20.188-37.236 25.393-58.902C282.515 39.293 291.817 0 312 0c24 0 72 8 72 81.452z"></path></svg>';
$faDown = '<svg class="svg-inline--fa fa-thumbs-down fa-w-16 fa-2x isCheck" aria-hidden="true" data-fa-processed="" data-prefix="fa" data-icon="thumbs-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M0 56v240c0 13.255 10.745 24 24 24h80c13.255 0 24-10.745 24-24V56c0-13.255-10.745-24-24-24H24C10.745 32 0 42.745 0 56zm40 200c0-13.255 10.745-24 24-24s24 10.745 24 24-10.745 24-24 24-24-10.745-24-24zm272 256c-20.183 0-29.485-39.293-33.931-57.795-5.206-21.666-10.589-44.07-25.393-58.902-32.469-32.524-49.503-73.967-89.117-113.111a11.98 11.98 0 0 1-3.558-8.521V59.901c0-6.541 5.243-11.878 11.783-11.998 15.831-.29 36.694-9.079 52.651-16.178C256.189 17.598 295.709.017 343.995 0h2.844c42.777 0 93.363.413 113.774 29.737 8.392 12.057 10.446 27.034 6.148 44.632 16.312 17.053 25.063 48.863 16.382 74.757 17.544 23.432 19.143 56.132 9.308 79.469l.11.11c11.893 11.949 19.523 31.259 19.439 49.197-.156 30.352-26.157 58.098-59.553 58.098H350.723C358.03 364.34 384 388.132 384 430.548 384 504 336 512 312 512z"></path></svg>';


global $cryptKey;
 $cryptKey  = 'Darkxee_ME_Darkzerox'; 

 

function decryptIt($data, $key) {
    $key = md5($key);
    $data = base64_decode($data);
    $decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_256,
        $key, $data, MCRYPT_MODE_CBC, md5($key));
    $decrypted = rtrim($decrypted, "\0");
    return $decrypted;
}
function encryptIt($data, $key) {
    $key = md5($key);
    $encrypted = mcrypt_encrypt(MCRYPT_RIJNDAEL_256,
        $key, $data, MCRYPT_MODE_CBC, md5($key));
    $encrypted = base64_encode($encrypted);
    return $encrypted;
}

function randomSTR($length = 5) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}



//remove role
remove_role( 'subscriber' );
remove_role( 'editor' );
remove_role( 'contributor' );
remove_role( 'author' );

// remove admin element
function admin_menu_custom(){
	$user_id = get_current_user_id();
	if ($user_id != 1){
		wp_enqueue_style('admin_css', get_stylesheet_directory_uri().'/assets/css/admin.min.css');
	}
}

add_action('admin_enqueue_scripts', 'admin_menu_custom',15);

/**
 * Define Constants
 */
define( 'child_v', '1.0.0' );
global $dzx_prefix ;
			$dzx_prefix = "dzx_";


/**
 * Enqueue styles 
 */
function child_enqueue_styles() {



	wp_enqueue_style('parent-style', get_template_directory_uri().'/style.css'); 
	wp_enqueue_style ('dzx_checklist_css', get_stylesheet_directory_uri (). '/assets/css/child-style.css');

	wp_enqueue_style( 'bootstrap-min-css', get_stylesheet_directory_uri().'/assets/css/bootstrap.min.css');
	wp_enqueue_style( 'bootstrap-grid-css', get_stylesheet_directory_uri().'/assets/css/bootstrap-grid.min.css');
	//wp_enqueue_style( 'bootstrap-reboot-css', get_stylesheet_directory_uri().'/assets/css/bootstrap-reboot.min.css');
	wp_enqueue_style( 'bootstrap-select-css', get_stylesheet_directory_uri().'/assets/css/bootstrap-select.min.css');
	

	wp_enqueue_style('bootstrap-datepicker3', get_stylesheet_directory_uri().'/assets/css/bootstrap-datepicker3.min.css');


	wp_enqueue_script("jquery");
	wp_enqueue_script('dzx_checklist_plugin_js', get_stylesheet_directory_uri().'/assets/js/property.js', array("jquery"));	
	
	wp_localize_script('dzx_checklist_plugin_js', 'darkxee_plist', array( 'callurl' => admin_url( 'admin-ajax.php')));

	wp_enqueue_script('fontawesome_js','https://use.fontawesome.com/releases/v5.0.8/js/all.js', array("jquery"));	
	wp_enqueue_script('datepicker-js', get_stylesheet_directory_uri().'/assets/js/bootstrap-datepicker.min.js', array("jquery"));
	wp_enqueue_script('bootstrap-select-search', get_stylesheet_directory_uri().'/assets/js/bootstrap-select.min.js', array("jquery"));

	wp_enqueue_script('signature_pad', get_stylesheet_directory_uri().'/assets/js/signature_pad.umd.js', array("jquery"));
	
	wp_enqueue_script('html2canvas', get_stylesheet_directory_uri().'/assets/js/html2canvas.min.js', array("jquery"));
	// wp_enqueue_script('jspdf', get_stylesheet_directory_uri().'/assets/js/jspdf.min.js', array("jquery"));
	// wp_enqueue_script('html2pdf', get_stylesheet_directory_uri().'/assets/js/html2pdf.js', array("jquery"));

	
	wp_enqueue_media();
	wp_enqueue_script('dzx_upload_plugin_js', get_stylesheet_directory_uri().'/assets/js/wp_media_uploader.min.js', array("jquery"),1.0);


	

}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );
add_action('admin_enqueue_scripts', 'child_enqueue_styles',15);




function butter_modified_fields_user( $contact_methods ){ 
	$contact_methods['phone'] = __('Phone', 'butter');
	$contact_methods['address'] = __('Address','butter'); 
	$contact_methods['district'] = __('District','butter'); 
	$contact_methods['city'] = __('City', 'butter'); 
  $contact_methods['provice'] = __('Provice', 'butter'); 
  $contact_methods['zipcode'] = __('Zip Code', 'butter');
  

	return $contact_methods;
}

add_filter('user_contactmethods', 'butter_modified_fields_user');

function testttt(){
	echo '
	<h2>Contact Info</h2>
	<table class="form-table">
	<tbody>	
	<tr class="user-phone-wrap">
		<th><label for="phone">
			Phone	</label></th>
		<td><input type="text" name="phone" id="phone" value="" class="regular-text"></td>
	</tr>
	<tr class="user-address-wrap">
		<th><label for="address">
			Address	</label></th>
		<td><input type="text" name="address" id="address" value="" class="regular-text"></td>
	</tr>
	<tr class="user-district-wrap">
		<th><label for="district">
			District	</label></th>
		<td><input type="text" name="district" id="district" value="" class="regular-text"></td>
	</tr>
	<tr class="user-city-wrap">
		<th><label for="city">
			City	</label></th>
		<td><input type="text" name="city" id="city" value="" class="regular-text"></td>
	</tr>
	<tr class="user-provice-wrap">
		<th><label for="provice">
			Provice	</label></th>
		<td><input type="text" name="provice" id="provice" value="" class="regular-text"></td>
	</tr>
	<tr class="user-zipcode-wrap">
		<th><label for="zipcode">
			Zip Code	</label></th>
		<td><input type="text" name="zipcode" id="zipcode" value="" class="regular-text"></td>
	</tr>
	</tbody></table>';
}

add_action('user_new_form','testttt');




function set_body_class( $classes ) {
 
    if ( is_page_template( 'page-checklist.php' ) ) {
        $classes[] = 'menu-2';
		}
		if ( is_page_template( 'page-report.php' ) ) {
			$classes[] = 'page-report';
	}   
    return $classes;
     
}
add_filter( 'body_class','set_body_class' );





function getQuery($query){
	global $wpdb;
	$get_data = $wpdb->get_results($query);
	
	echo json_encode($get_data);
	die();
}

function isusr($usr){
	global $current_user; 
  return user_can($current_user, $usr);
}

function usrClass(){
	if (isusr('administrator')){
		echo "edit-data admin";
	}else if (isusr('hr')){
		echo "data hr";
	}else{
		echo "";
	}
  
}



function getuserData(){

	$id = $_POST['id'];
	$type = $_POST['type'];

	$_SESSION[$type] = 	$id;
	

	$userData = get_userdata($id);	
	$all_meta_for_user = get_user_meta($id);	
	$all_meta_for_user['email'] = $userData->user_email;
	echo json_encode($all_meta_for_user);
	die();
}
add_action('wp_ajax_getuserData', 'getuserData');
add_action('wp_ajax_nopriv_getuserData', 'getuserData');

function getlList(){
	global $dzx_prefix;
	$table_data = $_POST['attr'];
	if ($table_data == 'property'){
		$field = 'pro_name';
		
	}else{
		$field = 'name';
	}
	//  echo $field;
	$querty = "SELECT id, pro_name , pro_id FROM ".$dzx_prefix.$_POST['attr']; 
	// echo $querty;
	getQuery($querty);
}
add_action('wp_ajax_getlList', 'getlList');
add_action('wp_ajax_nopriv_getlList', 'getlList');


function getReportList(){
	global $dzx_prefix;
	global $wpdb;
	global $cryptKey;
	
	
	$uid = $_POST['uid'];
	$uty = $_POST['uty'];

	$querty = "SELECT id,pro_name,pro_id FROM ".$dzx_prefix."property WHERE ".$uty."_id LIKE ".$uid; 
	$get_data = $wpdb->get_results($querty);
	foreach ($get_data as $key => $value) {    
			$value->linkkey = encryptIt($value->id, $cryptKey);		
	}
 	echo json_encode($get_data);
	die();

}
add_action('wp_ajax_getReportList', 'getReportList');
add_action('wp_ajax_nopriv_getReportList', 'getReportList');


function get_property_detail(){
	global $wpdb;	
	global $dzx_prefix;

	if (isusr("administrator")){
		$property_detail  = "SELECT id,pro_name,pro_id,address,district,city,provice,zipcode,tenant_id,landlord_id,		elec_meter,water_meter,startdate,enddate
		FROM ".$dzx_prefix."property WHERE
		id = ". $wpdb->prepare($_POST['pid']);
		$_SESSION['pro'] = 	$_POST['pid'];
		getQuery(	$property_detail );
	
	}


}
add_action('wp_ajax_get_property_detail', 'get_property_detail');
add_action('wp_ajax_nopriv_get_property_detail', 'get_property_detail');

function checklist_insert_table(){
	global $dzx_prefix;	
	global $wpdb;	
	$table_data =  $_POST['td'];
	$table_name =  $_POST['tn'];	

	if (isusr("administrator")){
		foreach ($table_data as $key => $value) {
			if ($value['name'] !="id"){		
				$insertField .= $value['name'];
				$insertValue .= "'".$value['value']."'";
				if ($key < sizeof($table_data)-1){
					$insertField .=", ";	
					$insertValue .=", ";	
				}
			}
		}
		if ( $table_data[1]['value'] !=''){
			$sql_state = "INSERT INTO ".$dzx_prefix.$table_name." (".$insertField.") VALUES (".$insertValue.")";		
				//	echo $sql_state;
				if ( $wpdb->query( $wpdb->prepare( $sql_state ) ) ){
						echo true;
				}
				die();
		}
				
	}
}
add_action('wp_ajax_checklist_insert_table', 'checklist_insert_table');
// add_action('wp_ajax_nopriv_checklist_insert_table', 'checklist_insert_table');

function checklist_update_table(){
	global $dzx_prefix;	
	global $wpdb;	
	$table_data =  $_POST['table_data'];
	$table_name = 	$_POST['table_name'];	
	if (isusr("administrator")){
		foreach ($table_data as $key => $value) {
			if ($value['name'] !="id"){		
				$updateState .= $value['name'] . " = '" . $value['value'] . "'";
				if ($key < sizeof($table_data )-1){
					$updateState .=", ";	
				}
			}else{
				$id = $value['value'];
			}				

		}
		
		if ($id != 'null'){
			$sql_state = "UPDATE ". $dzx_prefix . $table_name." SET ".$updateState." WHERE id LIKE ". $id;
		}

		if (
		$wpdb->query( 	
			$wpdb->prepare($sql_state)
		)){
			echo true;
		}
		die();
	}

}
add_action('wp_ajax_checklist_update_table', 'checklist_update_table');
// add_action('wp_ajax_nopriv_checklist_update_table', 'checklist_update_table');

function checklist_del_table(){
	global $dzx_prefix;	
	global $wpdb;	
	$table_id =  $_POST['tid'];
	$table_name = 	$_POST['tn'];	
	if (isusr("administrator")){
		$sql_state = "DELETE FROM ".$dzx_prefix.$table_name." WHERE id = ".$table_id;
	}
	// echo $sql_state;

	if (
		$wpdb->query( 	
			$wpdb->prepare($sql_state)
		)){
			echo true;
		}
		die();

}
add_action('wp_ajax_checklist_del_table', 'checklist_del_table');
// add_action('wp_ajax_nopriv_checklist_del_table', 'checklist_del_table');


function get_people(){	
	$query = "SELECT * FROM dzx_".$_POST['table_name']." WHERE id Like ".$_POST['id'];
	getQuery(	$query );
}
add_action('wp_ajax_get_people', 'get_people');
// add_action('wp_ajax_nopriv_get_people', 'get_people');


function search($array, $key, $value)
  {
    $results = array();

    if (is_array($array)) {
        if (isset($array[$key]) && $array[$key] == $value) {
            $results[] = $array;
        }

        foreach ($array as $subarray) {
            $results = array_merge($results, search($subarray, $key, $value));
        }
    }

    return $results;
}



function checklist_admin() {
	add_menu_page( 'property-list', 'Property List', 'manage_options', 'checklist-admin.php', 'property_list', 'dashicons-admin-home'  );



}
add_action( 'admin_menu', 'checklist_admin');


function property_list(){
  include_once( 'admin/checklist-admin.php' );
}


function get_report_inout(){
	$proid = $_POST['pro'];
	$target = $_POST['target'];
	if ($target == '0') {
		$query = "SELECT
			room.`name` as room_name,
			fer.`name` as fer_name,		
			fer.move_in_img as img,
			fer.in_comment as comment
		FROM
			dzx_furniture AS fer ,
			dzx_room AS room
		WHERE
			fer.room_id = room.id AND
			fer.move_in = 0 AND
			room.property_id = ".$proid." 
		ORDER BY 
			fer.room_id ASC ";
	}else{
		$query = "SELECT
			room.`name` as room_name,
			fer.`name` as fer_name,		
			fer.move_out_img as img,
			fer.out_comment as comment
		FROM
			dzx_furniture AS fer ,
			dzx_room AS room
		WHERE
			fer.room_id = room.id AND
			fer.move_out = 0 AND
			room.property_id = ".$proid. "
		ORDER BY
			fer.room_id ASC ";
	}

	getQuery(	$query );


}
add_action('wp_ajax_get_report_inout', 'get_report_inout');



function build_sess(){
	$sname = $_POST['sName'];
	$sval = $_POST['sVal'];

	$_SESSION[$sname] =  $sval;

}
add_action('wp_ajax_build_sess', 'build_sess');
add_action('wp_ajax_nopriv_build_sess', 'build_sess');



function fern_insert(){
	global $dzx_prefix;	
	global $wpdb;

	$data = $_POST['d'];
	if (isusr("administrator")){
		foreach ($data as $key => $v) {
			if ( $v['row_1'] > "0"){				

				$updateState = "Update ".$dzx_prefix."furniture SET `name` = '".$v['row_name']."', `image` = '".$v['row_img']."', `move_in` = '".$v['row_check_in']."', `move_in_img` = '".$v['row_inphoto']."', `in_comment` = '".$v['row_in_comment']."', `move_out` = '".$v['row_check_out']."', `move_out_img` = '".$v['row_outphoto']."', `out_comment` = '".$v['row_out_comment']."', `date` = '".$v['row_date']."' WHERE `id` = ".$v['row_1']." ;";
					if ( $wpdb->query( $wpdb->prepare( $updateState ) ) ){
						echo true;
					}

			}else{
				if ( $v['row_name'] != ''){
					$insertState = "INSERT INTO `dzx_furniture` VALUES (NULL, '".$v['room']."', '".$v['row_name']."', '".$v['row_img']."' , '".$v['row_check_in']."' , '".$v['row_inphoto']."' , '".$v['row_in_comment']."' , '".$v['row_check_out']."' , '".$v['row_outphoto']."' , '".$v['row_out_comment']."' , '".$v['row_date']."');";
					if ( $wpdb->query( $wpdb->prepare( $insertState ) ) ){
						echo true;
					}
				}
			}			
		}	
	}	
	//echo $insertState;
}
add_action('wp_ajax_fern_insert', 'fern_insert');
// add_action('wp_ajax_nopriv_fern_insert', 'fern_insert');


function fern_del(){
	global $dzx_prefix;	
	global $wpdb;

	$id = $_POST['d'];
	if (isusr("administrator")){
		$delState = "DELETE FROM `dzx_furniture` WHERE `id` like ".$id;
		if ( $wpdb->query( $wpdb->prepare( $delState ) ) ){
			echo true;
		}
	}
}
add_action('wp_ajax_fern_del', 'fern_del');
// add_action('wp_ajax_nopriv_fern_del', 'fern_del');



function add_sign(){
	global $dzx_prefix;	
	global $wpdb;

	$blob = $_POST['bs'];
	$role = $_POST['rs'];
	$id = $_POST['rid'];

	// echo  $role ;
	echo  $blob ;

	if (isusr("administrator")){
		$delState = "Update ".$dzx_prefix."property SET `".$role."_sign` = '".$blob."' WHERE id LIKE ".$id;
		if ( $wpdb->query( $wpdb->prepare( $delState ) ) ){
			echo true;
		} 
	}

	die();

}
add_action('wp_ajax_add_sign', 'add_sign');
// add_action('wp_ajax_nopriv_add_sign', 'add_sign');


function getRoom(){
	global $dzx_prefix;	

	$query = "SELECT * FROM ".$dzx_prefix."room WHERE property_id Like ".$_POST['rid'];
	getQuery(	$query );

}
add_action('wp_ajax_getRoom', 'getRoom');

function updateRoom(){
	global $dzx_prefix;	
	global $wpdb;
	$data = $_POST['d'];
	if (isusr("administrator")){
		foreach ($data as $key => $r) {
			if ( $r['acType'] == "change"){				
				
				$updateState = "Update dzx_room SET name = '".$r['roomName']."', `property_id` = '".$r['proID']."', `room_type` = '".$r['roomType']."' WHERE id = ".$r['roomID']." ;";  

			//	echo $updateState;

					if ( $wpdb->query( $wpdb->prepare( $updateState ) ) ){
						echo true;
					}

			}
			if ( $r['acType'] == "new"){
				$insertState = "INSERT INTO `dzx_room` VALUES (NULL, '".$r['proID']."', '".$r['roomName']."', '".$r['roomType']."');";
				
				if ( $wpdb->query( $wpdb->prepare( $insertState ) ) ){
					echo true;
				}
			}		
					
		}	
	}	
	die();
}
add_action('wp_ajax_updateRoom', 'updateRoom');



function skele_inventory($roomID){
	global $faDown;
	global $faUp;
	global $uploadIcon;

	$inID = randomSTR();
	$outID = randomSTR();
	$roomID = ($_POST['room'] != '')? $_POST['room']:$roomID;

	echo "	
	<tr class='new-row' field='-1' room='".$roomID."'>
		<td>
			<textarea class='fer_data fer_name' type='text'></textarea>
		</td>
		<td>
			<div class=' smartcat-uploader fer_img'>
				<img class='smartcat-upload ' src='".$uploadIcon."' />
				<input style='display:none' type='text'>
			</div>
		</td>
		<td>
			<div class='fer_check fer_check_in'>
				<input id='thumbs-up-".$inID."' type='radio' name='fer_check_in".$inID."' value='1' class='thumbs-up'
				  checked/>
				<label class='fer_check_state fer_check_in' for='thumbs-up-".$inID."'>
					".$faUp."
				</label>
				<input id='thumbs-down-".$inID."' type='radio' name='fer_check_in".$inID."' value='0' class='thumbs-down'
				/>
				<label class='fer_check_state fer_check_in' for='thumbs-down-".$inID."'>
				".$faDown."
				</label>
			</div>
		</td>
		<td>
			<div class=' smartcat-uploader fer_img_in'>
				<img class='smartcat-upload ' src='".$uploadIcon."' />
				<input style='display:none' type='text' name=''>
			</div>
		</td>
		<td>
			<textarea class='fer_data fer_comm_in'></textarea>
		</td>
		<td>
			<div class='fer_check fer_check_out'>
				<input id='thumbs-up-".$outID."' type='radio' name='fer_check_out".$outID."' value='1' class='thumbs-up'
				  checked/>
				<label class='fer_check_state fer_check_out' for='thumbs-up-".$outID."'>
				".$faUp."
				</label>
				<input id='thumbs-down-".$outID."' type='radio' name='fer_check_out".$outID."' value='0'
				  class='thumbs-down' />
				<label class='fer_check_state fer_check_out' for='thumbs-down-".$outID."'>
				".$faDown."
				</label>
			</div>
		</td>
		<td>
			<div class=' smartcat-uploader fer_img_out'>
				<img class='smartcat-upload ' src='".$uploadIcon."' />
				<input style='display:none' type='text' name=''>
			</div>
		</td>
		<td>
			<textarea class='fer_data fer_comm_out'></textarea>
		</td>
		<td></td>
	</tr>";

	die();

}
add_action('wp_ajax_skele_inventory', 'skele_inventory');