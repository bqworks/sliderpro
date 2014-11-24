<?php
/**
 * Factory for slide renderers.
 *
 * Implements the appropriate functionality for each slide, depending on the slide's type.
 *
 * @since  1.0.0
 */
class BQW_SP_Slide_Renderer_Factory {

	/**
	 * List of slide types and the associated slide renderer class name.
	 *
	 * @since 4.0.0
	 * 
	 * @var array
	 */
	protected static $registered_types = array(
		'custom' => 'BQW_SP_Slide_Renderer',
		'posts' => 'BQW_SP_Posts_Slide_Renderer',
		'gallery' => 'BQW_SP_Gallery_Slide_Renderer',
		'flickr' => 'BQW_SP_Flickr_Slide_Renderer'
	);

	/**
	 * Default slide type.
	 *
	 * @since 4.0.0
	 *
	 * @var string
	 */
	protected static $default_type = null;

	/**
	 * Return an instance of the renderer class based on the type of the slide.
	 *
	 * @since 4.0.0
	 * 
	 * @param  array  $data The data of the slide.
	 * @return object       An instance of the appropriate renderer class.
	 */
	public static function create_slide( $data ) {
		if ( is_null( self::$default_type ) ) {
			$default_settings = BQW_SliderPro_Settings::getSlideSettings();
			self::$default_type = $default_settings['content_type']['default_value'];
		}

		$type = isset( $data['settings']['content_type'] ) ? $data['settings']['content_type'] : self::$default_type;

		foreach( self::$registered_types as $registered_type_name => $registered_type_class ) {
			if ( $type === $registered_type_name ) {
				return new $registered_type_class();
			}
		}
	}
}