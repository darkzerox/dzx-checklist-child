<?php
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
	wp_enqueue_style( 'bootstrap-reboot-css', get_stylesheet_directory_uri().'/assets/css/bootstrap-reboot.min.css');
	wp_enqueue_style( 'bootstrap-select-css', get_stylesheet_directory_uri().'/assets/css/bootstrap-select.min.css');
	

	wp_enqueue_style('bootstrap-datepicker3', get_stylesheet_directory_uri().'/assets/css/bootstrap-datepicker3.min.css');


	wp_enqueue_script("jquery");
	wp_enqueue_script('dzx_checklist_plugin_js', get_stylesheet_directory_uri().'/assets/js/property.js', array("jquery"));	
	
	wp_localize_script('dzx_checklist_plugin_js', 'darkxee_plist', array( 'callurl' => admin_url( 'admin-ajax.php')));

	wp_enqueue_script('fontawesome_js','https://use.fontawesome.com/releases/v5.0.8/js/all.js', array("jquery"));	
	wp_enqueue_script('datepicker-js', get_stylesheet_directory_uri().'/assets/js/bootstrap-datepicker.min.js', array("jquery"));
	wp_enqueue_script('bootstrap-select-search', get_stylesheet_directory_uri().'/assets/js/bootstrap-select.min.js', array("jquery"));

	wp_enqueue_script('signature_pad', get_stylesheet_directory_uri().'/assets/js/signature_pad.umd.js', array("jquery"));


	wp_enqueue_media();
	wp_enqueue_script('dzx_upload_plugin_js', get_stylesheet_directory_uri().'/assets/js/wp_media_uploader.min.js', array("jquery"),1.0);


	

}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );
add_action('admin_enqueue_scripts', 'child_enqueue_styles',15);




function butter_modified_fields( $contact_methods ){ 
	$contact_methods['phone'] = __('Phone', 'butter');
	$contact_methods['address'] = __('Address','butter'); 
	$contact_methods['district'] = __('District','butter'); 
	$contact_methods['city'] = __('City', 'butter'); 
  $contact_methods['provice'] = __('Provice', 'butter'); 
  $contact_methods['zipcode'] = __('Zip Code', 'butter');
  

	return $contact_methods;
}

add_filter('user_contactmethods', 'butter_modified_fields');






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

function showSess(){
	echo 'landlordID : '.$_SESSION['landlord']."<br/>";
	echo 'tenantID : '.$_SESSION['tenant']."<br/>";
	echo 'ProID : '.$_SESSION['pro']."<br/>";
	echo 'RoomID : '.$_SESSION['roID']."<br/>";
	echo 'RoomName : '.$_SESSION['roN']."<br/>";
}
add_action('wp_footer','showSess');

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

function get_property_detail(){
	global $wpdb;	
	global $dzx_prefix;


	if (isusr("administrator")){
		$property_detail  = "SELECT *	
		FROM ".$dzx_prefix.$_POST['t']." WHERE
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
	add_menu_page( 'Property List', 'Property List', 'manage_options', 'checklist-admin.php', 'property_list', 'dashicons-admin-home'  );
//	add_submenu_page( 'myplugin/myplugin-admin-page.php', 'My Sub Level Menu Example', 'Sub Level Menu', 'manage_options', 'myplugin/myplugin-admin-sub-page.php', 'myplguin_admin_sub_page' );
}
add_action( 'admin_menu', 'checklist_admin' );


function property_list(){
  include_once( 'admin/checklist-admin.php' );
}


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