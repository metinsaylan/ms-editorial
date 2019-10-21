<?php 

add_action( 'init', 'ms_editorial_section_post_type' );
function ms_editorial_section_post_type() {
  register_post_type( 'section',
  // CPT Options
    array(
      'labels' => array(
        'name' => __( 'Sections' ),
        'singular_name' => __( 'Section' )
      ),
      'exclude_from_search' => true,
      'publicly_queryable' => false,
      'show_in_nav_menus' => false,
      'show_ui' => true,
      'has_archive' => false,
      'rewrite' => array('slug' => 'sections'),
      'menu_icon' => 'dashicons-layout'
    )
  );
}

