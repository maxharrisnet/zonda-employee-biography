<?php
  add_action( 'init', 'zonda_register_shortcode' );
  function zonda_register_shortcode() {
    function zonda_employee_biography_template( $atts ) {
      // Normalizing key case
      $atts = array_change_key_case( (array) $atts, CASE_LOWER );
      // Setting the acceptable attribute pairs
      extract(shortcode_atts(array (
        'ids' => []
      ), $atts));

      global $post;
      $ids = [];

      // Converting the ids string to an array
      // array_filter gives us an empty array if there are no values, which causes the query to return all posts      
      if( !empty($atts['ids']) ) {
        $ids = array_filter( explode( ',', $atts['ids'] ));
      } else {
        $ids = [];
      }

      $args = array (
        'post_type' => 'zonda_employee',
        'post_status' => 'publish',
        'numberposts' => -1,
        'post__in' => $ids,
        'suppress_filters' => false
      );

      $employee_query = new WP_Query( $args );

      $output = '';

      if( $employee_query->have_posts() ) {
        $output .= '<ul class="card-container">';

        while( $employee_query->have_posts() ) {
          $employee_query->the_post();

          $fn = get_field('first_name');
          $ln = get_field('last_name');
          $image = wp_get_attachment_image_src( get_field('bio_image'), 'medium' );
          $division = get_the_terms( $post, 'zonda_division' );
          
          $output .= '<li class="card">';
          $output .= '<figure>';
          $output .= '<img class="bio-image" src="' . esc_url($image[0]) . '" alt="A photo of ' . esc_attr($fn) . ' ' . esc_attr($ln) . '" loading="lazy" />';
          $output .= '<figcaption>';
          $output .= '<h2>' . esc_html($fn) . ' ' . esc_html($ln) . '</h2>'; 
          $output .= '<div class="division-title-container">';
          if( get_field('division_image', $division[0]) ) {
            $division_image = wp_get_attachment_image_src( get_field('division_image', $division[0]), 'medium' );
            $output .= '<img class="division-image" src="' . esc_url($division_image[0]) . '" alt="The ' . esc_attr($division[0]->name) . ' division logo" loading="lazy" />';
          }
          $output .= '<h4>' . esc_html__(get_field('position_title')) . ', ' . esc_html__($division[0]->name) . '</h4>';
          $output .= '</div>';
          $output .= '<a href="' . esc_url(get_permalink()) . '"><strong>Read ' . $fn . '\'s Bio</strong></a>';
          $output .= '</figcaption>';
          $output .= '</figure>';
          $output .= '</li>';
        }
        
        $output .= '</ul>';

      } else {
        $output .= '<strong>No employees found!</strong>';
        $output .= '<p>Please see the <a href="https://github.com/maxharrisnet/zonda-employee-biography#readme" target="_blank">README</a> for instructions on how to use the plugin<br>';
      }
      
      wp_reset_query();

      return wp_kses_post($output);
    }

    add_shortcode( 'zonda_employee_biography', 'zonda_employee_biography_template' );
  }

?>