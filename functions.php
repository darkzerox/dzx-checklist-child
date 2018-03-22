<?php
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

	wp_enqueue_style('parent-style',get_template_directory_uri() .'/style.css');
	wp_enqueue_style( 'child-css', get_stylesheet_directory_uri() . '/asset/css/style.css', array('parent-style'), child_v, 'all' );
	wp_enqueue_style( 'jquery-ui-css', get_stylesheet_directory_uri() . '/asset/css/jquery-ui.css', array('parent-style'), child_v, 'all' );
	wp_enqueue_style( 'datepicker-css', get_stylesheet_directory_uri() . '/asset/css/bootstrap-datepicker3.min.css', array('parent-style'), child_v, 'all' );


	wp_enqueue_script("jquery");
	wp_enqueue_script('dzx_checklist_js', get_stylesheet_directory_uri().'/asset/js/property.js', array("jquery"));	
	wp_localize_script( 'dzx_checklist_js', 'darkxee_plist', array( 'callurl' => admin_url( 'admin-ajax.php')));
	
	wp_enqueue_script('typeahead-js', get_stylesheet_directory_uri().'/asset/js/typeahead.jquery.min.js', array("jquery"));	
	wp_enqueue_script('datepicker-js', get_stylesheet_directory_uri().'/asset/js/bootstrap-datepicker.min.js', array("jquery"));	

	
}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );


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

function getlList(){
	global $dzx_prefix;
	$table_data = $_POST['attr'];
	if ($table_data == 'property'){
		$field = 'pro_name';
	}else{
		$field = 'name';
	}
	//  echo $field;
	$querty = "SELECT id,".$field." FROM ".$dzx_prefix.$_POST['attr']; 
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
add_action('wp_ajax_nopriv_get_people', 'get_people');


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

