<?php 

/* 
Plugin Name: Editorial
*/

/*

1. Define Sections for Editorial

2. Assign Posts to Sections
section_name:1,5,7,9

3. Get posts using editorial query:
$posts = editorial_get_posts( 'section_name' );

*/


if ( ! defined( 'ABSPATH' ) ) {
	die( 'Invalid request.' );
}

define( 'MS_ED_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'MS_ED_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

global $ms_editorial;

require_once( MS_ED_PLUGIN_PATH . 'inc/class-wpa-plugin.php' ); 
require_once( MS_ED_PLUGIN_PATH . '/editorial-section.php' );
require_once( MS_ED_PLUGIN_PATH . '/editorial-metaboxes.php' );
require_once( MS_ED_PLUGIN_PATH . '/editorial-query.php' );

$ms_editorial = new WPA_Plugin(
  'Editorial',
  'ms-editorial',
  MS_ED_PLUGIN_PATH
);

$ms_editorial->options_nav = array( 
  array(
    'label' => 'Plugin Page',
    'link' => 'https://metinsaylan.com/wordpress/plugins/adsense-widget/'
  )
);

$ms_editorial->options = array(

  array( 
    "name" => 'general-settings',
    "label" => __( 'General Settings', 'ms-editorial' ),
    "type" => "section"
  ),
	
		array(
			"type" => "text",
			"name" => __( "Publisher ID", 'adsense-widget' ),
			"id" => "adsense_id",
			"desc" => __( "Your unique Adsense ID. This field is required for your ads to work <a href='https://metinsaylan.com/wordpress/plugins/adsense-widget/help/#adsenseid' class='helplink' target='_blank'>(?)</a> </span>", 'adsense-widget' ),
			"std" => "",
			"placeholder" => "pub-00000000000000"
    ),

    array( "type" => "close")

  );


  
