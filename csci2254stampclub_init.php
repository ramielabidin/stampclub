<?php
/**
 * @package CSCI2254_Stampclub
 * @version 0.1
 */
/*
Plugin Name: Stamp Club
Description: This plugin has support for a stamp collecting club
Author: Lowrie
Version: 0.1
Author URI: nope
*/
global $csci2254stamp_db_version;
$csci2254stamp_db_version = "1.0";
global $debug;
$debug = 0;

/**
 * csci2254_stampclub_install() - creates the table that stores stamps
 **/
function csci2254stampclub_install(){

	global $wpdb;
	global $csci2254stamp_db_version;
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	$table_name = $wpdb->prefix . "csci2254stamps";    
	$sql = 	"
	CREATE TABLE IF NOT EXISTS $table_name (
		stampID 	    int not null auto_increment,
		stampname 	    varchar(40) not null,
		stamptype 		varchar(15) not null,
		stamptopic 		varchar(15) not null,
		stampvalue 		numeric(15,2),
		stampcomment	varchar(250),
		PRIMARY KEY (stampID)
	) engine = InnoDB;";
   	dbDelta( $sql );
   	add_option( "csci2254stamp_db_version", $csci2254stamp_db_version );
}
register_activation_hook( __FILE__, 'CSCI2254stampclub_install' );

/** 
 * csci2254_stampclub_deactivate() - cleans up when the plugin is deactived. 
 * delete database tables.
 *
 * Table deletion is commented out here because I probably don't want to get
 * rid of all the stamps.  But maybe someday I would?
 **/
function csci2254stampclub_deactivate()
{
    global $wpdb; 
    
	/** drop this first before deleting event **/    
	$table_name = $wpdb->prefix . "csci2254stamps";    
    $sql = "DROP TABLE IF EXISTS $table_name;";
    //$wpdb->query( $sql );
}
register_deactivation_hook( __FILE__, 'csci2254stampclub_deactivate');

/* Support for scholars */
include 'csci2254stampclub_scholar.php';
include 'csci2254stampclub_collector.php';
include 'csci2254stampclub_addstamp.php';
include 'csci2254stampclub_liststamps.php';

/**
 * These are the functions to wire in the shortcodes
 **/ 
include 'csci2254stampclub_user_support.php';

/**
 * Redirect user after successful login. - this needs to be after the include
 * for csci2254_stampclub_user_support.php because it uses the user functions
 *
 * @param string $redirect_to URL to redirect to.
 * @param string $request URL the user is coming from.
 * @param object $user Logged users data.
 * @return string
 */

function my_login_redirect( $redirect_to, $request, $user ) {
	//is there a user to check?
	global $user;
	if ( isset( $user->roles ) && is_array( $user->roles ) ) {
		//check for admins
		if ( in_array( 'administrator', $user->roles ) ) {
			// redirect them to the default place
			return $redirect_to;
		} 
	}	
	return home_url();
}
add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );