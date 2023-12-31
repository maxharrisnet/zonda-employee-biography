<?php
  // Post Type
  add_action( 'init', 'zonda_register_post_type' );
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
      'rewrite' => array('slug' => 'employee'),
      'has_archive' => 'employees',
      'show_in_rest' => false, // Intentionally excluding possibly sensitive employee information from the REST API
      'supports' => array('custom_fields')
    );

    register_post_type( 'zonda_employee', $args );
  }

  add_filter( 'archive_template', 'zonda_get_archive_template' ) ;
  function zonda_get_archive_template( $archive_template ) {
    global $post;
    if ( is_post_type_archive ( 'zonda_employee' ) ) {
      $archive_template = __DIR__ . '/' . 'archive-zonda-employee.php';
    }
    return $archive_template;
  }


  // Taxonomy
  add_action( 'init', 'zonda_register_taxonomy' );
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

  // Meta Fields
  add_action( 'acf/init', 'zonda_register_meta_fields' );
  if( function_exists('acf_add_local_field_group') ) {
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
            'instructions' => esc_html__('Image height/width must be between 200px - 1300px. File size must be under 1MB.', 'zonda'),
            'instruction_placement' => 'field',
            'required' => false,
            'return_format' => 'id',
            'min_width' => 200,
            'min_height' => 200,
            'max_width' => 1300,
            'max_height' => 1300,
            'max_size' => '1MB',
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
  }

  // Validating fields
  add_filter('acf/validate_value/name=first_name', 'zonda_validate_text_field', 10, 4); 
  add_filter('acf/validate_value/name=last_name', 'zonda_validate_text_field', 10, 4); 
  function zonda_validate_text_field( $valid, $value, $field, $input ){
    if( !$valid ) {
      return $valid;
    }

    /*  
    * Regex via ChatGPT allows names that:
    *
    * Start and end with a letter.
    * Do not contain consecutive symbols.
    * Can contain letters, spaces, dashes, and apostrophes anywhere within the name, but no underscores.
    */

    if( !preg_match("/^(?!.*\W{2})[a-zA-Z][a-zA-Z\s'-]*[a-zA-Z]$/", $value) ) {
      $valid = esc_html__('Name must only contain alphabetical characters.', 'zonda');
    }

    return $valid;
  }
  
  // Validating image fields
  add_filter('acf/validate_value/type=image', 'zonda_validate_image_field', 10, 4);
  function zonda_validate_image_field( $valid, $value, $field, $input ){
    if( !$valid ) {
      return $valid;
    }
    
    $value = wp_get_attachment_image_src( $value, 'thumbnail' )[0];

    if ( !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $value) ) {
      $valid = esc_html__('Image must be a valid URL.', 'zonda');
    }

    if( !preg_match("/\.(gif|jpg|png|webp)$/i", $value) ) {
      $valid = esc_html__('Image must be a valid image file. ####' . $value, 'zonda');
    }
    
    return $valid;
  }

  // Validating bio textarea field
  add_filter('acf/validate_value/name=bio', 'zonda_validate_bio_field', 10, 4);
  function zonda_validate_bio_field( $valid, $value, $field, $input ){
    if( !$valid ) {
      return $valid;
    }

    if( strlen($value) > 1000 ) {
      $valid = esc_html__('Bio must be less than 1000 characters.', 'zonda');
    }

    return $valid;
  }

  add_filter('acf/validate_value/name=division_title', 'zonda_validate_taxonomy_field', 10, 4);
  function zonda_validate_taxonomy_field( $valid, $value, $field, $input ){
    if( !$valid ) {
      return $valid;
    }

    $value = get_term_by( 'term_id', $value,'zonda_division' );
    
    if( !term_exists( $value->name, 'zonda_division' ) ) {
      $valid = esc_html__('Division must be an existing division. Add divisions in WP Admin -> Employees -> Divisions.' , 'zonda');
    }

    return $valid;
  }

  // Validating start date field
  add_filter('acf/validate_value/name=start_date', 'zonda_validate_date_field', 10, 4); 
  function zonda_validate_date_field( $valid, $value, $field, $input ){
    if( !$valid ) {
      return $valid;
    }

    $value = DateTime::createFromFormat( 'Ymd', $value );
    $now = new DateTime();

    if ( $value > $now ) {
      $valid = esc_html__('Start date must be in the past.', 'zonda');
    }

    if ( !wp_checkdate( $value->format('m'), $value->format('d'), $value->format('Y'), $value ) ) {
      $valid = esc_html__('Start date must be a valid date.', 'zonda');
    }
    
    return $valid;
  }

  add_filter('save_post', 'zonda_set_post_data', 10, 3);
  function zonda_set_post_data( $post_id, $post, $update ) {
    // Preventing infinite loop
    remove_filter('save_post', __FUNCTION__ );

    if ( $post->post_type != 'zonda_employee' ) {
      return;
    }

    $first_name = get_field('first_name', $post_id);
    $last_name = get_field('last_name', $post_id);
    $title = $first_name . ' ' . $last_name;
    $slug = $first_name . '-' . $last_name; // This could be a more robust slugify function, but works for most inputs
    $image = wp_get_attachment_image_src( get_field('bio_image'), 'medium' );
    $bio = get_field('bio', $post_id);

    $content = '<div><img src="' . esc_url($image[0])  . '" alt="A photo of ' . esc_attr($title) . '" loading="lazy" style="max-width: 100%" />';
    $content .= '<br>' . wp_kses_post($bio) .'</div><br>';
    $content .= '<em>' . $first_name . ' has been at the company for ' . esc_html__(zonda_get_time_at_company($post_id)) . '</em>';
    $content .= '<div><a href="' . esc_url( get_post_type_archive_link( 'zonda_employee' ) ) . '">Back to Employee Bios</a></div>';
    
    print_r($title);
    wp_update_post(array(
      'ID' => $post_id,
      'post_title' => esc_html($title),
      'post_name' => esc_url($slug),
      'post_content' => wp_kses_post($content),
    ));

    add_filter('save_post', __FUNCTION__, 10, 3 );
  }

?>