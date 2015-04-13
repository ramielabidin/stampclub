<?php
/**
 **  This file contains all the support functions for viewing and managing
 **  stamp enthusiasts.
 **/
 
function csci2254stampclub_scholar(){
 	global $debug;
 	if ($debug) echo "[csci2254stampclub_scholar]";
	
	if ( ! is_user_logged_in() ) {
		echo "Sorry you must logged in as a scholar to access this page.<br>
				<a href=".  wp_login_url() . " title='Login'>Log in</a>";
		return;
	}
	
	$current_user = wp_get_current_user();
	$username = get_current_user_name($current_user);
	echo "Hello $username.  Welcome to the stamp club:<br><br>
			Here is a list of all the stamps...";
	
}
add_shortcode( 'csci2254stampclub_scholar',   'csci2254stampclub_scholar' );
?>