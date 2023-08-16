<?php
  add_action( 'manage_zonda_employee_posts_columns', 'zonda_filter_culumns' );
  function zonda_filter_culumns( $columns ) {
    $columns = array(
      'cb' => $columns['cb'],
      'bio_image' => 'Image',
      'first_name' => esc_html__( 'First Name', 'zonda' ), 
      'last_name' => esc_html__( 'Last Name', 'zonda' ), 
      'position_title' => esc_html__( 'Position', 'zonda' ),
      'division_title' => esc_html__( 'Division', 'zonda' ),
      'date' => 'Status'
    );

    return $columns;
  }

  add_action( 'manage_zonda_employee_posts_custom_column', 'zonda_populate_columns', 10, 2 );
  function zonda_populate_columns( $column, $post_id ) {
    $fn = get_field('first_name');
    $ln = get_field('last_name');
    $divisions = get_the_terms( $post_id, 'zonda_division' );

    if ( 'bio_image' === $column ) {
      $image = wp_get_attachment_image_src( get_field('bio_image'), 'thumbnail' );
      if ( !empty($image) ) {
        esc_html(_e('<img class="profile-image" src="' . esc_url($image[0]) . '" alt="A photo of ' . esc_attr($fn) . ' ' . esc_attr($ln) . '" height="40" width="40" style="border-radius: 50%;  border: 1px solid #ccc;" />', 'zonda' ));
      }
    } 
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
  }
?>