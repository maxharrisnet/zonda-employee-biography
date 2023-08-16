<?php
  function zonda_get_time_at_company() {
    $start_string = get_field('start_date');
    $start = DateTime::createFromFormat( 'm#d#Y', $start_string );
    $now = new DateTime();
    $duration = $now->diff($start);
    
    return $duration->format( '%y years %m months' );
  }

  add_action('save_post_zonda_employee','save_post_zonda_employee_callback');
  function save_post_zonda_employee_callback($post_id){
    global $post;
    // TODO: use the first and last name custom fields to create the post title and slug
    $first_name = get_post_meta($post_id, 'first_name', true);
    $last_name = get_post_meta($post_id, 'last_name', true);
    $post_title = $first_name . ' ' . $last_name;
    $post_slug = sanitize_title($post_title);
    $post_data = array(
      'ID' => $post_id,
      'post_title' => $post_title,
      'post_name' => $post_slug
    );
    wp_update_post($post_data);

    if ($post->post_type != 'MY_CUSTOM_POST_TYPE_NAME'){
        return;
    }
  }
?>