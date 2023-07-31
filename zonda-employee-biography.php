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
  register_post_type( 'zonda_employee', array(
    'label' => 'Employees',
    'public' => true 
  ) );
}

add_action( 'init', 'zonda_register_post_type' );

function zonda_activate() {
  zonda_register_post_type();
  zonda_register_taxonomy();
  zonda_register_post_meta();

  flush_rewrite_rules();
}

function zonda_deactivate() {
  unregister_post_type('zonda_employee');
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