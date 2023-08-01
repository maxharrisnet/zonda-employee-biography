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

// Include ACF locally

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
    'description' => 'A post type for collecting and displaying employee information.',
    'public' => true,
    'supports' => array('custom_fields')
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
    'labels' =>  $labels,
    'description' => 'A taxonomy that represents the various divisions in the company in which employees are organized.',
    'public' => true
  );

  // Add image meta

  register_taxonomy( 'division', 'zonda_employee', $args );
}
add_action( 'init', 'zonda_register_taxonomy' );

function zonda_register_post_meta_fields() {
// Register ACF group/fields
  acf_add_local_field_group(array (
    'key' => 'employee_information',
    'title' => 'Employee\'s Biographic Information',
    'fields' => array(
      array(
        'key' => 'first_name',
        'label' => 'First Name',
        'name' => 'first_name',
        'type' => 'text',
        'maxlength' => '100',
        'required' => true,
        'wrapper' => array(
          'width' => '40%'
        ),
      ),
      array(
        'key' => 'last_name',
        'label' => 'Last Name',
        'name' => 'last_name',
        'type' => 'text',
        'maxlength' => '100',
        'required' => true,
        'wrapper' => array(
          'width' => '40%'
        ),
      ),
      array(
        'key' => 'bio_image',
        'label' => 'Image',
        'name' => 'bio_image',
        'type' => 'image',
        'instructions' => 'Height/Width 200px >< 1200px File size < 1MB',
        'instruction_placement' => 'field',
        'required' => false,
        'return_format' => 'url',
        'min_width' => 200,
        'min_height' => 200,
        'max_width' => 1200,
        'max_height' => 1200,
        'max_size' => '1MB',
        'wrapper' => array(
          'width' => '20%'
        )
      ),
      array(
        'key' => 'position_title',
        'label' => 'Position',
        'name' => 'position_title',
        'type' => 'text',
        'maxlength' => '100',
        'required' => true,
        'wrapper' => array(
          'width' => '40%'
        )
      ),
      array(
        'key' => 'division_title',
        'label' => 'Division',
        'name' => 'division_title',
        'type' => 'taxonomy',
        'taxonomy' => 'division',
        'field_type' => 'multi_select',
        'return_format' => 'object',
        'add_term' => 'false',
        'required' => true,
        'wrapper' => array(
          'width' => '40%'
        )
      ),
      array(
        'key' => 'start_date',
        'label' => 'Start Date',
        'name' => 'start_date',
        'type' => 'text',
        'instructions' => 'Please enter the date for the first day of employment for the employee.',
        'instruction_placement' => 'field',
        'required' => true,
        'wrapper' => array(
          'width' => '20%'
        )
      ),
      array(
        'key' => 'bio',
        'label' => 'Bio',
        'name' => 'bio',
        'type' => 'textarea',
        'required' => true,
        'maxlength' => '100',
        'new_lines' => 'br',
        'wrapper' => array(
          'width' => '100%'
        ),
      ),
    ),
    'location' => array ( 
      array (
        array (
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'zonda_employee'
        )
      )
    )
  ));

  // Validation and santization
}
add_action( 'acf/init', 'zonda_register_post_meta_fields' );

// function zonda_register_shortcode() {
// Register shortcode
// Markup for container
// Markup for employee cards
// }

function zonda_activate() {
  zonda_register_post_type();
  zonda_register_taxonomy();
  zonda_register_post_meta_fields();
  // zonda_register_shortcode();
  flush_rewrite_rules();
}

function zonda_deactivate() {
  unregister_post_type( 'zonda_employee' );
  flush_rewrite_rules();
}

register_activation_hook( __FILE__, 'zonda_activate');
register_deactivation_hook( __FILE__, 'zonda_deactivate');


// Output template (escape)


// Remove shortcode 

?>