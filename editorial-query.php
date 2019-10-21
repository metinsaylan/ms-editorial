<?php 

function editorial_query( $section_id ){

  $args = array( 
    'post_type' => 'section', 
    'ignore_sticky_posts' => 1, 
    'posts_per_page' => 1,
    'meta_query' => array(
        array(
          'key' => 'section_id',
          'value' => $section_id
        )
      ),
    'fields' => array('id')
  );

  $sections = get_posts( $args );
  if( $sections ){
    // get first post
    $section = $sections[0];
    $section_meta = get_post_meta( $section->ID );

    // post list
    $post_list = $section_meta[ 'post_list' ][0];
    $post__in = explode( ',', $post_list );
    $max_posts = array_key_exists( 'max_posts', $section_meta ) ? $section_meta[ 'max_posts' ][0] : 5;

    $args = array(
      'post_type' => 'post',
      'ignore_sticky_posts' => 1,
      'posts_per_page' => $max_posts,
      'post__in' => $post__in,
      'orderby' => 'post__in'
    );
    
    return new WP_Query( $args );

  }
  
}

/* 
add_action( 'the_content', 'editorial_test' );
function editorial_test(){
  $eq = editorial_query( 'home-slider' );

  if( $eq->have_posts() ){
    while( $eq->have_posts() ){
      $eq->the_post();

      the_title();
    }
  }
}
*/