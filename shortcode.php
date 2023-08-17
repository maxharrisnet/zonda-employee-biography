<?php
  add_action( 'init', 'zonda_register_shortcode' );
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

      $divisions = get_terms( 'zonda_division', array( 'hide_empty' => false ) );
      $division_ids = array_map( function($division) {
        return $division->term_id;
      }, $divisions );

      // Adding all employees from the division if it exists
      if( !empty($atts['divisions']) ) {
        $divisions = array_filter( explode( ',', $atts['divisions'] ));
        $division_ids = array_intersect( $divisions, $division_ids );
        $division_ids = array_map( function($division) {
          return 'zonda_division_' . $division;
        }, $division_ids );
        $division_ids = implode( ',', $division_ids );
        $division_ids = get_posts( array(
          'post_type' => 'zonda_employee',
          'post_status' => 'publish',
          'numberposts' => -1,
          'fields' => 'ids',
          'tax_query' => array(
            array(
              'taxonomy' => 'zonda_division',
              'field' => 'term_id',
              'terms' => $division_ids
            )
          )
        ));
        $ids = array_merge( $ids, $division_ids );
      }

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
          $division = get_the_terms( $post_id, 'zonda_division' );
          
          $output .= '<li class="card">';
          $output .= '<header>';
          $output .= '<img class="profile-image" src="' . esc_url($image[0]) . '" alt="A photo of ' . esc_attr($fn) . ' ' . esc_attr($ln) . '" height="62" width="62" />';
          $output .= '<div><h3>' . esc_html($fn) . ' ' . esc_html($ln) . '</h3>'; // Not localizing these because they are names
          $output .= '<img class="division-logo" src="' . esc_url(get_field('division_logo', $division[0])) . '" alt="The logo of ' . esc_attr($division[0]->name) . '" height="62" width="62" />';
          $output .= '<h4>' . esc_html__(get_field('position_title')) . ', ' . esc_html__($division[0]->name) . '</h4></div>';
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

  function zonda_get_time_at_company() {
    // Subtract the start date from today's date to get the duration at the company
    $start_string = get_field('start_date');
    $start = DateTime::createFromFormat( 'm#d#Y', $start_string );
    $now = new DateTime();
    $duration = $now->diff($start);
    
    return $duration->format( '%y years %m months' );
  }
?>