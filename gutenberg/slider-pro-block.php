<?php
class BQW_SliderPro_Block {
	public function __construct() {
		add_action( 'init', array( $this, 'init' ) );
	}

	public function init() {
		register_block_type( __DIR__ . '/build' );

		add_action( 'rest_api_init', function() {
			register_rest_route('sliderpro/v1', '/get_sliders', array(
				'method' => 'GET',
				'callback' => array( $this, 'get_sliders' ),
				'permission_callback' => '__return_true'
			));
		} );

		wp_localize_script( 'bqworks-sliderpro-editor-script', 'sp_gutenberg_js_vars', array(
			'admin_url' => admin_url( 'admin.php' )
		));
	}

	public function get_sliders( $request ) {
		global $wpdb;
		$prefix = $wpdb->prefix;
		$response = array();

		$sliders = $wpdb->get_results( "SELECT * FROM " . $prefix . "slider_pro_sliders ORDER BY id" );

		foreach ( $sliders as $slider ) {
			$slider_id = $slider->id;
			$slider_name = stripslashes( $slider->name );
			
			$response[ $slider_id ] = $slider_name;
		}
		
		return rest_ensure_response( $response );
	}
}

$slider_pro_block = new BQW_SliderPro_Block();