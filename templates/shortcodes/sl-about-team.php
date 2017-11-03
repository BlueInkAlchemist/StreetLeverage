<?php

/*
*  get all custom fields and dump for testing
*/

// $fields = get_fields();
// var_dump( $fields ); 

/*
*  get all custom fields, loop through them and load the field object to create a label => value markup
*/

$fields = get_fields();

if( $fields )
{
	foreach( $fields as $field_name => $value )
	{
		// get_field_object( $field_name, $post_id, $options )
		// - $value has already been loaded for us, no point to load it again in the get_field_object function
		$field = get_field_object($field_name, false, array('load_value' => false));

		echo '<div>';
			echo '<h3>' . $field['label'] . '</h3>';
			foreach( $value as $member ) {
                //print_r( $member );
                echo get_avatar( $member['ID'] );
                echo '<p><strong>' . $member['user_firstname'] . " " . $member['user_lastname'] . '</strong></p>';
                echo '<p>' . $member['user_description'] . '</p>';
            }
		echo '</div>';
	}
}

?>