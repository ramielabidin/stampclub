<?php
/**
 * This file contains support for user functions.  
 * This includes all access to user and user meta data.
 *
 * Member registration.
 * The user is registered with an stampclubID and CSCI2254_stampclub_role of scholar or collector 
 **/
 //1. Add a new form element...
add_action( 'register_form', 'csci2254stampclub_register_form' );

function csci2254stampclub_register_form() {
	?>
	<h3>Register for the CSCI 2254 Stamp Club</h3>
	<p>
	    <label for="firstname">First name</label>
		<input type="text" name="firstname" id="firstname" class="input" size="25" />
	    <label for="lastname">Last name</label>
		<input type="text" name="lastname" id="lastname" class="input" size="25" />
		<label for="yog">Membership Type</label>
		<?php createmenu("memtype", array("collector", "scholar")); ?>
	</p>
<?php
}
function createmenu( $name, $option ){
	echo "<select name=\"$name\">";
	foreach ( $option as $opt ){
		echo "<option value=\"$opt\">$opt</option>";
	}
	echo "</select>";
}
//2. Add validation. In this case, we make sure first_name is required.
add_filter( 'registration_errors', 'csci2254stampclub_registration_errors', 10, 3 );
function csci2254stampclub_registration_errors( $errors, $sanitized_user_login, $user_email ) {

    if ( ! isset( $_POST['firstname'] ) || trim( $_POST['firstname'] == false ) ) {
		$errors->add( 'firstname_error', __( '<strong>ERROR</strong>: You must include a firstname.', 'ifcrush' ) );
    }
    if ( ! isset( $_POST['lastname'] ) || trim( $_POST['lastname'] == false ) ) {
		$errors->add( 'lastname_error', __( '<strong>ERROR</strong>: You must include a firstname.', 'ifcrush' ) );
    }
    return $errors;
}





//3. Finally, save our extra registration user meta.
add_action( 'user_register', 'csci2254stampclub_user_register' );
function csci2254stampclub_user_register( $user_id ) {
	if ( isset( $_POST['netID'] ) ) {
    	update_user_meta(  $user_id, 'first_name', $_POST['firstname']  );
    	update_user_meta(  $user_id, 'last_name', $_POST['lastname']  );    	
    	update_user_meta(  $user_id, 'csci2254_stampclub_role', $_POST['memtype']  );
    }
}


function is_user_collector( $current_user ){
	$key = 'csci2254stampclub_role';
	$single = true;
	$user_role = get_user_meta($current_user->ID, $key, $single ); 
	return( $user_role == 'collector' );
}

function is_user_scholar( $current_user ){
	$key = 'csci2254stampclub_role';
	$single = true;
	$user_role = get_user_meta($current_user->ID, $key, $single ); 
	return( $user_role == 'scholar' );
}

function get_csci2254_stampclub_ID( $current_user ){
	$key = 'stampclubID';
	$single = true;
	$stampclubID = get_user_meta($current_user->stampclubID, $key, $single ); 
	return( $stampclubID );
}

function get_current_user_name( $current_user ){
	$key = 'first_name';
	$single = true;
	$firstname = get_user_meta($current_user->stampclubID, $key, $single ); 
	$key = 'last_name';
	$single = true;
	$lastname = get_user_meta($current_user->stampclubID, $key, $single ); 
	return( $firstname . " " . $lastname );
}
