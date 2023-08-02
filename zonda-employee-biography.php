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

// TODO: Include ACF locally https://www.advancedcustomfields.com/resources/including-acf-within-a-plugin-or-theme/

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
    'description' => __('A post type for collecting and displaying employee information.', 'zonda'),
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
    'description' => __('A taxonomy that represents the various divisions in the company in which employees are organized.', 'zonda'),
    'public' => true,
    'meta_box_cb' => false,

  );

  register_taxonomy( 'zonda_division', 'zonda_employee', $args );
}
add_action( 'init', 'zonda_register_taxonomy' );

function zonda_register_meta_fields() {
  acf_add_local_field_group(array (
    'key' => 'employee_information',
    'title' => __('Employee\'s Biographic Information', 'zonda'),
    'fields' => array(
      array(
        'key' => 'first_name',
        'label' => __('First Name', 'zonda'),
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
        'label' => __('Last Name', 'zonda'),
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
        'label' => __('Image', 'zonda'),
        'name' => 'bio_image',
        'type' => 'image',
        'instructions' => __('Height/Width 200px >< 1200px File size < 1MB', 'zonda'),
        'instruction_placement' => 'field',
        'required' => false,
        'return_format' => 'url',
        'min_width' => 200,
        'min_height' => 200,
        'max_width' => 1200,
        'max_height' => 1200,
        'max_size' => '1MB',
        // 'mime_types' => 'image/jpeg, image/pjpeg, image/png, image/webp', // TODO: Add webp to WordPress MIME types https://www.isitwp.com/modify-allowed-upload-mime-types/
        'wrapper' => array(
          'width' => '20%'
        )
      ),
      array(
        'key' => 'position_title',
        'label' => __('Position', 'zonda'),
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
        'label' => __('Division', 'zonda'),
        'name' => 'division_title',
        'type' => 'taxonomy',
        'taxonomy' => 'zonda_division',
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
        'label' => __('Start Date', 'zonda'),
        'name' => 'start_date',
        'type' => 'text',
        'instructions' => __('Please enter the date for the first day of employment for the employee.', 'zonda'),
        'instruction_placement' => 'field',
        'required' => true,
        'wrapper' => array(
          'width' => '20%'
        )
      ),
      array(
        'key' => 'bio',
        'label' => __('Bio', 'zonda'),
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
  /* TODO: change columns in admin screen -> first name, last name, division, position 
  * https://www.smashingmagazine.com/2017/12/customizing-admin-columns-wordpress/
  * https://developer.wordpress.org/reference/hooks/manage_post_type_posts_columns/
  * https://pluginrepublic.com/add-acf-fields-to-admin-columns/
  */

  // TODO: use site title for comapny name in admin screen

  acf_add_local_field_group(array (
    'key' => 'division_information',
    'title' => __('Information regarding company divisions', 'zonda'),
    'fields' => array(
      array(
        'key' => 'division_image',
        'label' => __('Image', 'zonda'),
        'name' => 'division_image',
        'type' => 'image',
        'instructions' => __('Height/Width 200px >< 600px File size < 1MB', 'zonda'),
        'instruction_placement' => 'field',
        'required' => false,
        'return_format' => 'url',
        'min_width' => 200,
        'min_height' => 200,
        'max_width' => 600,
        'max_height' => 600,
        'max_size' => '1MB',
        'wrapper' => array(
          'width' => '100%'
        )
      ),
    ),
    'position' => 'normal',
    'location' => array ( 
      array (
        array (
          'param' => 'taxonomy',
          'operator' => '==',
          'value' => 'zonda_division'
        )
      )
    )
  ));

  // TODO: limit division entries to Admin users only
}
add_action( 'acf/init', 'zonda_register_meta_fields' );

function zonda_register_shortcode() {
// Register shortcode

  function zonda_employee_biography_template( $atts ) {
    // Normalizing key case
    $atts = array_change_key_case( (array) $atts, CASE_LOWER );
    // Setting the acceptable attribute pairs
    extract(shortcode_atts(array (
      ids => [],
      divisions => []
    ), $atts));
    
    $args = array (
      'post_type' => 'zonda_employee',
      'numberposts' => -1,
      'include' => $atts['ids'],
      'suppress_filters' => false
    );

    // TODO: Add a `tax_query` to args for searching by department 

    $employees = get_posts($args);
    $output = '<section class="zonda-employees-container">';
    $output .= 'Bingo! ' . $ids;

    // Loop through employees
    if( $employees ) {
      foreach( $employees as $e ) {

        setup_postdata( $e );

        // Cards
        $output .= '<div>';
        $output .= '<h3>#' . the_field('first_name') . ' ' . the_field('last_name') . '</h3>';
        $output .= '</div>';
      }
    }
    $output .= '</section>';
    
    wp_reset_postdata();

    return $output;
  }

  add_shortcode( 'zonda_employee_biography', 'zonda_employee_biography_template' );
}
add_action( 'init', 'zonda_register_shortcode' );

function zonda_activate() {
  zonda_register_post_type();
  zonda_register_taxonomy();
  zonda_register_meta_fields();
  zonda_register_shortcode();
  flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'zonda_activate');

function zonda_deactivate() {
  unregister_post_type( 'zonda_employee' );
  flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'zonda_deactivate');

// Remove shortcode on deactivation?

// [] Field validation
// [] Sanitization
// [] Escaping
// [] Localization

?>