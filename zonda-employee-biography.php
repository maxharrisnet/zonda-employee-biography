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

// TODO: Enqueue conditionally according to shortcode presence in content
function zonda_enqueue_styles() {
  $styles = plugins_url( 'styles.css', __FILE__ );
  wp_enqueue_style( 'zonda-employee-styles', $styles );
}
add_action( 'wp_enqueue_scripts', 'zonda_enqueue_styles' );

function zonda_register_post_type() {
  $labels = array(
    'name'              => esc_html_x( 'Employees', 'taxonomy general name', 'zonda' ),
		'singular_name'     => esc_html_x( 'Employee', 'taxonomy singular name', 'zonda' ),
		'search_items'      => esc_html__( 'Search Genres', 'zonda' ),
		'all_items'         => esc_html__( 'All Employees', 'zonda' ),
		'edit_item'         => esc_html__( 'Edit Employee info', 'zonda' ),
		'update_item'       => esc_html__( 'Update Employee info', 'zonda' ),
		'add_new_item'      => esc_html__( 'Add New Employee', 'zonda' ),
		'new_item_name'     => esc_html__( 'New Employee Name', 'zonda' ),
		'menu_name'         => esc_html__( 'Employees', 'zonda' ),
  );

  $args = array(
    'labels' =>  $labels,
    'description' => esc_html__('A post type for collecting and displaying employee information.', 'zonda'),
    'public' => true,
    'show_in_rest' => false, // Intentionally excluding sensitive employee information from the REST API
    'supports' => array('custom_fields')
  );

  register_post_type( 'zonda_employee', $args );
}
add_action( 'init', 'zonda_register_post_type' );

function zonda_register_taxonomy() {
  $labels = array(
    'name'              => esc_html_x( 'Division', 'taxonomy general name', 'zonda' ),
		'singular_name'     => esc_html_x( 'Division', 'taxonomy singular name', 'zonda' ),
		'search_items'      => esc_html__( 'Search Division', 'zonda' ),
		'all_items'         => esc_html__( 'All Divisions', 'zonda' ),
		'edit_item'         => esc_html__( 'Edit Division', 'zonda' ),
		'update_item'       => esc_html__( 'Update Division', 'zonda' ),
		'add_new_item'      => esc_html__( 'Add New Division', 'zonda' ),
		'new_item_name'     => esc_html__( 'New Division Name', 'zonda' ),
		'menu_name'         => esc_html__( 'Divisions', 'zonda' ),
  );

  $args = array(
    'labels' =>  $labels,
    'description' => esc_html__('A taxonomy that represents the various divisions in the company in which employees are organized.', 'zonda'),
    'public' => true,
    'show_in_rest' => false,
    'meta_box_cb' => false,
  );

  register_taxonomy( 'zonda_division', 'zonda_employee', $args );
}
add_action( 'init', 'zonda_register_taxonomy' );

function zonda_register_meta_fields() {
  acf_add_local_field_group(array (
    'key' => 'employee_information',
    'title' => esc_html__('Employee\'s Biographic Information', 'zonda'),
    'fields' => array(
      array(
        'key' => 'first_name',
        'label' => esc_html__('First Name', 'zonda'),
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
        'label' => esc_html__('Last Name', 'zonda'),
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
        'label' => esc_html__('Image', 'zonda'),
        'name' => 'bio_image',
        'type' => 'image',
        'instructions' => esc_html__('Image height/width must be between 200px - 1200px. File size must be under 1MB.', 'zonda'),
        'instruction_placement' => 'field',
        'required' => false,
        'return_format' => 'id',
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
        'label' => esc_html__('Position', 'zonda'),
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
        'label' => esc_html__('Division', 'zonda'),
        'name' => 'division_title',
        'type' => 'taxonomy',
        'taxonomy' => 'zonda_division',
        'load_save_terms' => 1,
        'field_type' => 'radio',
        'return_format' => 'object',
        'add_term' => 'false',
        'required' => true,
        'wrapper' => array(
          'width' => '40%'
        )
      ),
      array(
        'key'   => 'start_date',
        'label' => esc_html__('Start Date', 'zonda'),
        'name'  => 'start_date',
        'type'  => 'date_picker',
        'display_format' => 'm-d-Y',
        'instructions' => esc_html__('Please enter the date for the first day of employment for the employee.', 'zonda'),
        'instruction_placement' => 'field',
        'required' => true,
        'wrapper' => array(
          'width' => '20%'
        )
      ),
      array(
        'key' => 'bio',
        'label' => esc_html__('Bio', 'zonda'),
        'name' => 'bio',
        'type' => 'textarea',
        'required' => true,
        'maxlength' => '1000',
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
          'operator' => '===',
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
    'title' => esc_html__('Information regarding company divisions', 'zonda'),
    'fields' => array(
      array(
        'key' => 'division_image',
        'label' => esc_html__('Image', 'zonda'),
        'name' => 'division_image',
        'type' => 'image',
        'instructions' => esc_html__('Image height/width must be between 200px - 600px. File size must be under 1MB.', 'zonda'),
        'instruction_placement' => 'field',
        'required' => false,
        'return_format' => 'id',
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
}
add_action( 'acf/init', 'zonda_register_meta_fields' );

function zonda_filter_culumns( $columns ) {
  $columns = array(
    'cb' => $columns['cb'],
    'first_name' => esc_html__( 'First Name', 'zonda' ), 
    'last_name' => esc_html__( 'Last Name', 'zonda' ), 
    'position_title' => esc_html__( 'Position', 'zonda' ),
    'division_title' => esc_html__( 'Division', 'zonda' ),
    'bio_image' => 'Image',
    'date' => 'Status'
  );

  return $columns;
}
add_action( 'manage_zonda_employee_posts_columns', 'zonda_filter_culumns' );

function zonda_populate_columns( $column, $post_id ) {
  $divisions = get_the_terms( $post_id, 'zonda_division' );

  if ( 'first_name' === $column ) {
    esc_html(_e(get_post_meta( $post_id, 'first_name', true ), 'zonda' ));
  }
  if ( 'last_name' === $column ) {
    esc_html(_e(get_post_meta( $post_id, 'last_name', true ), 'zonda' ));
  }
  if ( 'position_title' === $column ) {
    esc_html(_e(get_post_meta( $post_id, 'position_title', true ), 'zonda' ));
  }
  if ( 'division_title' === $column ) {
    if ( !empty($divisions) ) {
      foreach ( $divisions as $division ) {
        esc_html(_e( $division->name, 'zonda' ));
      }
    }
  }
  if ( 'bio_image' === $column ) {
    $image = wp_get_attachment_image_src( get_field('bio_image'), 'thumbnail' );
    if ( !empty($image) ) {
      esc_html(_e('<img class="profile-image" src="' . esc_url($image[0]) . '" alt="A photo of ' . esc_attr($fn) . ' ' . esc_attr($ln) . '" height="40" width="40" style="border-radius: 50%;  border: 1px solid #ccc;" />', 'zonda' ));
    }
  }   
}
add_action( 'manage_zonda_employee_posts_custom_column', 'zonda_populate_columns', 10, 2 );

function zonda_get_time_at_company() {
  $start_string = get_field('start_date');
  $start = DateTime::createFromFormat( 'm#d#Y', $start_string );
  $now = new DateTime();
  $duration = $now->diff($start);
  
  return $duration->format( '%y years %m months' );
}

function zonda_register_shortcode() {
  function zonda_employee_biography_template( $atts ) {
    // Normalizing key case
    $atts = array_change_key_case( (array) $atts, CASE_LOWER );
    // Setting the acceptable attribute pairs
    extract(shortcode_atts(array (
      'ids' => [],
      'divisions' => []
    ), $atts));

    // Converting the ids string to an array
    // array_filter gives us an empty array if there are no values, which causes the query to return all posts
    $ids = array_filter( explode( ',', $atts['ids'] ));

    $args = array (
      'post_type' => 'zonda_employee',
      'post_status' => 'publish',
      'numberposts' => -1,
      'post__in' => $ids,
      'suppress_filters' => false
    );

    $employee_query = new WP_Query( $args );

    $output = '<section class="zonda-employees-container">';

    if( $employee_query->have_posts() ) {
      $output .= '<ul class="card-container">';

      while( $employee_query->have_posts() ) {
        $employee_query->the_post();

        $fn = get_field('first_name');
        $ln = get_field('last_name');
        $image = wp_get_attachment_image_src( get_field('bio_image'), 'thumbnail' );
        $divison = get_the_terms( $post_id, 'zonda_division' );
        
        $output .= '<li class="card">';
        $output .= '<header>';
        $output .= '<img class="profile-image" src="' . esc_url($image[0]) . '" alt="A photo of ' . esc_attr($fn) . ' ' . esc_attr($ln) . '" height="62" width="62" />';
        $output .= '<div><h3>' . esc_html($fn) . ' ' . esc_html($ln) . '</h3>'; // Not escaping these because they are proper nouns
        $output .= '<h4>' . esc_html__(get_field('position_title')) . ', ' . esc_html__($divison[0]->name) . '</h4></div>';
        $output .= '</header>';
        $output .= '<details>';
        $output .= '<summary>Bio</summary>';
        $output .= '<p>' . esc_html(get_field('bio')) . '</p>';
        $output .= '<em>' . $fn . ' has been at the company for ' . '<time>' .  esc_html(zonda_get_time_at_company()) . '</time></em>';
        $output .= '</details>';
        $output .= '</li>';
      }
      
      $output .= '</ul>';

    } else {
      $output .= '<strong>No employees found!</strong>';
      $output .= '<p>Please see the <a href="https://github.com/maxharrisnet/zonda-employee-biography#readme" target="_blank">README</a> for instructions on how to use the plugin<br>';
    }

    $output .= '</section>';
    
    wp_reset_query();

    return wp_kses_post($output);
  }

  add_shortcode( 'zonda_employee_biography', 'zonda_employee_biography_template' );
}
add_action( 'init', 'zonda_register_shortcode' );

function zonda_activate() {
  zonda_enqueue_styles();
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

// [] Field validation
// [] Sanitization
// [] Escaping
// [] Localization

?>