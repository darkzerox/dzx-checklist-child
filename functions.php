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
define( 'CHILD_THEME_WP_BOOTSTRAP_STARTER_VERSION', '1.0.0' );
global $dzx_prefix ;
			$dzx_prefix = "dzx_";


/**
 * Enqueue styles
 */
function child_enqueue_styles() {

	wp_enqueue_style('parent-style',get_template_directory_uri() .'/style.css');
	wp_enqueue_style( 'child-css', get_stylesheet_directory_uri() . '/asset/css/style.css', array('parent-style'), CHILD_THEME_WP_BOOTSTRAP_STARTER_VERSION, 'all' );
	wp_enqueue_script("jquery");
	wp_enqueue_script('dzx_checklist_js', get_stylesheet_directory_uri().'/asset/js/property.js', array("jquery"));	
	wp_localize_script( 'dzx_checklist_js', 'darkxee_plist', array( 'callurl' => admin_url( 'admin-ajax.php')));	
	
	

}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );


function getQuery($query){
	global $wpdb;
	$get_data = $wpdb->get_results($query);
	echo json_encode($get_data);
	die();
}

function checklist(){
	global $wpdb;	
	global $dzx_prefix;
	global $current_user; 
	 
		if (user_can( $current_user, "hr")){
			echo 'hrrrr';
		}
		
	//if admin
  if (user_can( $current_user, "administrator")){   

    $property_option_list = "<select id='property_list'><option>เลือก Property</option>";
    
    $property_lists  = $wpdb->get_results("SELECT id,pro_name FROM ".$dzx_prefix."property");
    
    foreach ( $property_lists as $property )   {
     
     $property_option_list.= '<option value="'.$property->id.'">'.$property->pro_name.'</option>';
    }

    $property_option_list.='</select>';


    echo $property_option_list;

  }

}
add_action('checklist_propertylist','checklist');


function get_property_detail(){
	global $wpdb;	
	global $dzx_prefix;
	global $current_user; 
	// $_POST['pid'] = 1;

	if (user_can( $current_user, "administrator")){  

		$property_detail  = "SELECT *	
		FROM ".$dzx_prefix."property WHERE
		id = ". $wpdb->prepare($_POST['pid']);

		getQuery(	$property_detail );
	
	}


}
add_action('wp_ajax_get_property_detail', 'get_property_detail');
add_action('wp_ajax_nopriv_get_property_detail', 'get_property_detail');



function checklist_update_table(){
	global $dzx_prefix;	
	global $wpdb;	
	$table_data =  $_POST['table_data'];
	$table_name = 	$_POST['table_name'];
	
	foreach ($table_data as $key => $value) {
		if ($value['field'] !="id"){
			$updateState .= $value['field'] . " = '" . $value['val'] . "'";
			if ($key < sizeof($table_data )-1){
				$updateState .=", ";
			}

		}else{
			$id = $value['val'];
		}
	}

	$sql_state = "UPDATE ". $dzx_prefix . $table_name." SET ".$updateState." WHERE id LIKE ". $id;
	echo $sql_state;
	$wpdb->query( 	
		$wpdb->prepare($sql_state)
	);
	die();

}

add_action('wp_ajax_checklist_update_table', 'checklist_update_table');
add_action('wp_ajax_nopriv_checklist_update_table', 'checklist_update_table');


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

