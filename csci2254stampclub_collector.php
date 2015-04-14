<?php
/**
 **  This file contains all the support functions for viewing and managing
 **  stamp enthusiasts.
 **/
function csci2254stampclub_collector(){
 	global $debug;
 	if ($debug) echo "[csci2254stampclub_collector]";
	
	if ( ! is_user_logged_in() ) {
		echo "Sorry you must logged in as a collector to access this page.<br>
				<a href=".  wp_login_url() . " title='Login'>Log in</a>";
		return;
	}	
	$current_user = wp_get_current_user();
	$username = get_current_user_name($current_user);
	echo "Hello $username.  Welcome to the stamp club:<br><br>
			Here is a list of all the stamps in your collection...";
			
	csci2254stampclub_addtocollection($current_user);
	csci2254stampclub_showcollection($current_user);
}
add_shortcode( 'csci2254stampclub_collector',   'csci2254stampclub_collector' );

function csci2254stampclub_addtocollection($current_user){

	display_addtocollection_form();
	if ( isset ( $_POST['addtocollection'] ) )
		handle_addtocollection_form($current_user);
}

function display_addtocollection_form(){
	global $wpdb;

	$table_name = $wpdb->prefix . "csci2254stamps";  
	$allstamps = $wpdb->get_results( "SELECT stampID, stampname FROM $table_name" );

	if ( $allstamps ) {
		echo "<form method='post'>";
		createmenuID("stamp", $allstamps);
		echo "<input type='submit' name='addtocollection' value='Add Stamp to your Collection'/>
		      </form>";
	} else { 
		?><h3>No stamps.  Add one!</h3><?php
	}

}

function createmenuID( $name, $option ){
	echo "<select name=\"$name\">";
	foreach ( $option as $opt ){
		echo "<option value=\"$opt->stampID\">$opt->stampname</option>";
	}
	echo "</select>";
}

function handle_addtocollection_form($current_user){
    	add_user_meta(  $current_user->ID, 'stamp', $_POST['stamp'], false);
}

function csci2254stampclub_showcollection($current_user){

	$stamplist = get_user_meta($current_user->ID, 'stamp', false);	
	
	if ( empty( $stamplist ) ){
		echo "<h3>No stamps in your collection!  Enter some...</h3>";
		return;
	}
	//echo "<pre>" . print_r($stamplist) . "</pre>";
	$newlist = array_unique($stamplist);
	$stampIDs = implode(",",$newlist);
	//echo "The stamp IDs are $stampIDs";
	
	global $wpdb;
	
	$table_name = $wpdb->prefix . "csci2254stamps";  
	$query = "SELECT * FROM $table_name where stampID IN ($stampIDs)";
	$allstamps = $wpdb->get_results( $query );
	csci2254stampclub_showstamps($allstamps);
}