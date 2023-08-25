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

  add_action( 'wp_enqueue_scripts', 'zonda_enqueue_styles' );
  function zonda_enqueue_styles() {
    $styles = plugins_url( 'styles.css', __FILE__ );
    wp_enqueue_style( 'zonda-employee-styles', $styles );
  }

  function zonda_get_time_at_company() {
    // Subtract the start date from today's date to get the duration at the company
    $start_string = get_field('start_date');
    $start = DateTime::createFromFormat( 'm#d#Y', $start_string );
    $now = new DateTime();
    $duration = $now->diff($start);
    
    // Only returns years if there are years, otherwise returns months
    if( $duration->y == 0 ) {
      return $duration->format( '%m months' );
    } else {
      return $duration->format( '%y years %m months' );
    }
  }

  require_once( plugin_dir_path( __FILE__ ) . 'register.php' );
  require_once( plugin_dir_path( __FILE__ ) . 'admin.php' );
  require_once( plugin_dir_path( __FILE__ ) . 'shortcode.php' );

  register_activation_hook( __FILE__, 'zonda_activate');
  function zonda_activate() {
    zonda_enqueue_styles();
    zonda_register_post_type();
    zonda_register_taxonomy();
    zonda_register_meta_fields();
    zonda_register_shortcode();
    flush_rewrite_rules();
  }

  register_deactivation_hook( __FILE__, 'zonda_deactivate');
  function zonda_deactivate() {
    unregister_post_type( 'zonda_employee' );
    flush_rewrite_rules();
  }

?>