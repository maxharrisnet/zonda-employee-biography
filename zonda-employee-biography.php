<?php
/*
* Plugin Name: Zonda Employee Bios
* Plugin URI: https://github.com/maxharrisnet/zonda-employee-biography
* Description: This plugin is for a coding assessment for the Senior Web Developer (WordPress CMS) role at Zonda. The function of the plugin is to create a shortcode that displays biographical information of employees.
* Version: 1.0
* Author: Max Harris
* Author URI: https://github.com/maxharrisnet
* Text Domain: zonda
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function zonda_register_post_type() {
  $labels = array(
    'name'              => _x( 'Employees', 'taxonomy general name', 'zonda' ),
		'singular_name'     => _x( 'Employee', 'taxonomy singular name', 'zonda' ),
		'search_items'      => __( 'Search Genres', 'zonda' ),
		'all_items'         => __( 'All Employees', 'zonda' ),
		'edit_item'         => __( 'Edit Employee info', 'zonda' ),
		'update_item'       => __( 'Update Employee info', 'zonda' ),
		'add_new_item'      => __( 'Add New Employee', 'zonda' ),
		'new_item_name'     => __( 'New Employee Name', 'zonda' ),
		'menu_name'         => __( 'Employees', 'zonda' ),
  );

  $args = array(
    'labels' =>  $labels,
    'public' => true
  );

  register_post_type( 'zonda_employee', $args );
}
add_action( 'init', 'zonda_register_post_type' );


function zonda_register_taxonomy() {
  $labels = array(
    'name'              => _x( 'Division', 'taxonomy general name', 'zonda' ),
		'singular_name'     => _x( 'Division', 'taxonomy singular name', 'zonda' ),
		'search_items'      => __( 'Search Division', 'zonda' ),
		'all_items'         => __( 'All Divisions', 'zonda' ),
		'edit_item'         => __( 'Edit Division', 'zonda' ),
		'update_item'       => __( 'Update Division', 'zonda' ),
		'add_new_item'      => __( 'Add New Division', 'zonda' ),
		'new_item_name'     => __( 'New Division Name', 'zonda' ),
		'menu_name'         => __( 'Divisions', 'zonda' ),
  );

  $args = array(
    'labels' =>  $labels
  );

  // Add imaage meta

  register_taxonomy( 'division', 'zonda_employee', $args );
}
add_action( 'init', 'zonda_register_taxonomy' );

// function zonda_register_post_meta() {

// }

function zonda_activate() {
  zonda_register_post_type();
  zonda_register_taxonomy();
  // zonda_register_post_meta();

  // zonda_register_shortcode();

  flush_rewrite_rules();
}

function zonda_deactivate() {
  unregister_post_type( 'zonda_employee' );
  flush_rewrite_rules();
}

register_activation_hook( __FILE__, 'zonda_activate');
register_deactivation_hook( __FILE__, 'zonda_deactivate');



// Register meta fields

// Create inputs
//  Validation and santization

// Output template (escape)


// Remove shortcode 

?>