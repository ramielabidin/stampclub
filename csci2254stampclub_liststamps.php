<?php
function csci2254stampclub_liststamps(){
	global $wpdb;
	$table_name = $wpdb->prefix . "csci2254stamps";  
	$query = "SELECT * FROM $table_name";
	$allstamps = $wpdb->get_results( $query );
	
	if ( $allstamps ) {
		csci2254stampclub_showstamps($allstamps);
	} else 	{
		echo "<h3>No stamps</h3>";
	}		
}
add_shortcode( 'csci2254stampclub_liststamps',   'csci2254stampclub_liststamps' );

function csci2254stampclub_showstamps($allstamps){
		create_stamp_table_header(); 
		foreach ( $allstamps as $stamp ) {
			//echo "<pre>" . print_r($stamp) . "</pre>";
			create_stamp_table_row( $stamp );
		}
		create_stamp_table_footer(); // end the table
}
function create_stamp_table_header() {
	?>
		<div id="stamperror"></div>
		<table class="stamptable">
			<tr class="stamptablerow">
				<th>Stamp Information</th>
				<th>Description</th>
			</tr>
	<?php
}
function create_stamp_table_footer() {
	?></table><?php
}
function create_stamp_table_row($stamp) {
	setlocale(LC_MONETARY, 'en_US');
	?>
	<tr class="stamptablerow">
		<td><?php echo  $stamp->stampname . " <br>".
						$stamp->stamptype . " <br>" .
						money_format('%i', $stamp->stampvalue);
			?></td>
		<td><?php echo $stamp->stampcomment;?></td>
	</tr>
	<?php
}