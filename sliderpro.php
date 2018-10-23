<?php

/*
	Plugin Name: Slider Pro
	Plugin URI:  http://bqworks.com/slider-pro/
	Description: Elegant and professional sliders.
	Version:     4.6.0
	Author:      bqworks
	Author URI:  http://bqworks.com
*/

// if the file is called directly, abort
if ( ! defined( 'WPINC' ) ) {
	die();
}

require_once( plugin_dir_path( __FILE__ ) . 'public/class-sliderpro.php' );
require_once( plugin_dir_path( __FILE__ ) . 'public/class-slider-renderer.php' );
require_once( plugin_dir_path( __FILE__ ) . 'public/class-slide-renderer.php' );
require_once( plugin_dir_path( __FILE__ ) . 'public/class-slide-renderer-factory.php' );
require_once( plugin_dir_path( __FILE__ ) . 'public/class-dynamic-slide-renderer.php' );
require_once( plugin_dir_path( __FILE__ ) . 'public/class-posts-slide-renderer.php' );
require_once( plugin_dir_path( __FILE__ ) . 'public/class-gallery-slide-renderer.php' );
require_once( plugin_dir_path( __FILE__ ) . 'public/class-flickr-slide-renderer.php' );
require_once( plugin_dir_path( __FILE__ ) . 'public/class-layer-renderer.php' );
require_once( plugin_dir_path( __FILE__ ) . 'public/class-layer-renderer-factory.php' );
require_once( plugin_dir_path( __FILE__ ) . 'public/class-paragraph-layer-renderer.php' );
require_once( plugin_dir_path( __FILE__ ) . 'public/class-heading-layer-renderer.php' );
require_once( plugin_dir_path( __FILE__ ) . 'public/class-image-layer-renderer.php' );
require_once( plugin_dir_path( __FILE__ ) . 'public/class-div-layer-renderer.php' );
require_once( plugin_dir_path( __FILE__ ) . 'public/class-video-layer-renderer.php' );
require_once( plugin_dir_path( __FILE__ ) . 'public/class-lightbox-slider.php' );

require_once( plugin_dir_path( __FILE__ ) . 'includes/class-sliderpro-activation.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/class-sliderpro-widget.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/class-sliderpro-settings.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/class-flickr.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/class-hideable-gallery.php' );

register_activation_hook( __FILE__, array( 'BQW_SliderPro_Activation', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'BQW_SliderPro_Activation', 'deactivate' ) );

add_action( 'plugins_loaded', array( 'BQW_SliderPro', 'get_instance' ) );
add_action( 'plugins_loaded', array( 'BQW_SliderPro_Activation', 'get_instance' ) );
add_action( 'plugins_loaded', array( 'BQW_Hideable_Gallery', 'get_instance' ) );
add_action( 'plugins_loaded', array( 'BQW_SP_Lightbox_Slider', 'get_instance' ) );

// register the widget
add_action( 'widgets_init', 'bqw_sp_register_widget' );

if ( is_admin() ) {
	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-sliderpro-admin.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'admin/class-sliderpro-updates.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'includes/class-sliderpro-api.php' );
	add_action( 'plugins_loaded', array( 'BQW_SliderPro_Admin', 'get_instance' ) );
	add_action( 'plugins_loaded', array( 'BQW_SliderPro_API', 'get_instance' ) );
	add_action( 'admin_init', array( 'BQW_SliderPro_Updates', 'get_instance' ) );
}