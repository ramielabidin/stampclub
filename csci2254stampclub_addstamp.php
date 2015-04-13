<?php
/**
 **  This file contains all the support functions for viewing and managing
 **  stamp enthusiasts.
 **/
 
function csci2254stampclub_addstamp(){
 	global $debug;
 	if ($debug) echo "[csci2254stampclub_addstamp]";
	
	if ( ! is_user_logged_in() ) {
		echo "Sorry you must logged in as a collector or scholar to add a stamp.<br>
				<a href=".  wp_login_url() . " title='Login'>Log in</a>";
		return;
	}
		
	if ( isset ($_POST['addstamp'])){
		csci2254stamp_club_handleform_addstamp();
	}
	
	$current_user = wp_get_current_user();
	$username = get_current_user_name($current_user);
	
	csci2254stamp_club_displayform_addstamp();
}
add_shortcode( 'csci2254stampclub_addstamp',   'csci2254stampclub_addstamp' );

		
		
function csci2254stamp_club_displayform_addstamp(){
?>
<br><br>Add a stamp<br><br>
	<div style="font-family:sans-serif; background-color: grey; margin-left:30px;">
	<fieldset>
			<form method="post">
				<label for="stampname">Name of stamp:</label>
				<input type="text" name="stampname" id="stampname" class="input"  />
				<label for="stampvalue">Value:</label>
				<input type="text" name="stampvalue" id="stampvalue" class="input" />
				<br><br>
	    		<label for="type">Stamp Type</label>
				<?php createmenu("stamptype", 
								array("airmail", "commemorative", "definitive", "postage_due")); ?>
				
				<label for="stamptopic">Stamp Topic</label>
				<?php createmenu("stamptopic", 
								array("bird", "ship", "insect", "people", "stamps", "revenue", "FDC")); ?>
				<br><br>
				<label for="stampcomment">Comment/Description:</label>
				<textarea rows="4" cols="50" name="stampcomment" id="stampcomment"></textarea>
				<input type='submit' name='addstamp' value='Add Stamp' />
			</form>
	</fieldset>
	</div>
<?php
}

function csci2254stamp_club_handleform_addstamp(){
    global $wpdb; 
    
    $stampname     = $_POST['stampname'];
    $stampvalue    = $_POST['stampvalue'];
    $stamptype     = $_POST['stamptype'];
    $stamptopic    = $_POST['stamptopic'];
    $stampcomment  = $_POST['stampcomment'];

    
	$table_name = $wpdb->prefix . "csci2254stamps";  
	$wpdb->query( $wpdb->prepare ( 
				"
				INSERT INTO $table_name
				( stampname, stamptype, stamptopic, stampvalue, stampcomment)
				values ( %s, %s, %s, %f, %s)
				",
				$stampname,
				$stamptype,
				$stamptopic,
				$stampvalue,
				$stampcomment
	) );
				
}
