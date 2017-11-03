<?php

// Hooks for our user reg Gravityform 
add_filter( 'gform_pre_render_2', array($this, 'generate_posts' ) ); 
add_filter( 'gform_pre_validation_2', array($this, 'generate_posts' ) );
add_filter( 'gform_pre_submission_filter_2', array($this, 'generate_posts' ) );
add_filter( 'gform_admin_pre_render_2', array($this, 'generate_posts' ) );
add_filter( 'gform_gf_field_create', array($this, 'new_dynamic_field'), 10, 2 ); 
add_filter( 'gform_field_value_your_parameter', array($this, 'checkbox_population') );
add_filter( 'gform_field_value_your_parameter', array($this, 'multiselect_population') );

?>