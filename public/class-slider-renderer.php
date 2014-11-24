<?php
/**
 * Renders the slider.
 * 
 * @since 4.0.0
 */
class BQW_SP_Slider_Renderer {

	/**
	 * Data of the slider.
	 *
	 * @since 4.0.0
	 * 
	 * @var array
	 */
	protected $data = null;

	/**
	 * ID of the slider.
	 *
	 * @since 4.0.0
	 * 
	 * @var int
	 */
	protected $id = null;

	/**
	 * Settings of the slider.
	 *
	 * @since 4.0.0
	 * 
	 * @var array
	 */
	protected $settings = null;

	/**
	 * Default slider settings data.
	 *
	 * @since 4.0.0
	 * 
	 * @var array
	 */
	protected $default_settings = null;

	/**
	 * HTML markup of the slider.
	 *
	 * @since 4.0.0
	 * 
	 * @var string
	 */
	protected $html_output = '';

	/**
	 * List of id's for the CSS files that need to be loaded for the slider.
	 *
	 * @since 4.0.0
	 * 
	 * @var array
	 */
	protected $css_dependencies = array();

	/**
	 * List of id's for the JS files that need to be loaded for the slider.
	 *
	 * @since 4.0.0
	 * 
	 * @var array
	 */
	protected $js_dependencies = array();

	/**
	 * Initialize the slider renderer by retrieving the id and settings from the passed data.
	 * 
	 * @since 4.0.0
	 *
	 * @param array $data The data of the slider.
	 */
	public function __construct( $data ) {
		$this->data = $data;
		$this->id = $this->data['id'];
		$this->settings = $this->data['settings'];
		$this->default_settings = BQW_SliderPro_Settings::getSettings();
	}

	/**
	 * Return the slider's HTML markup.
	 *
	 * @since 4.0.0
	 * 
	 * @return string The HTML markup of the slider.
	 */
	public function render() {
		$classes = 'slider-pro sp-no-js';
		$classes .= isset( $this->settings['custom_class'] ) && $this->settings['custom_class'] !== '' ? ' ' . $this->settings['custom_class'] : '';
		$classes = apply_filters( 'sliderpro_classes' , $classes, $this->id );

		$width = isset( $this->settings['width'] ) ? $this->settings['width'] : $this->default_settings['width']['default_value'];
		$height = isset( $this->settings['height'] ) ? $this->settings['height'] : $this->default_settings['height']['default_value'];

		$this->html_output .= "\r\n" . '<div id="slider-pro-' . $this->id . '" class="' . $classes . '" style="width: ' . $width . 'px; height: ' . $height . 'px;">';

		if ( $this->has_slides() ) {
			$this->html_output .= "\r\n" . '	<div class="sp-slides">';
			$this->html_output .= "\r\n" . '		' . $this->create_slides();
			$this->html_output .= "\r\n" . '	</div>';
		}

		$this->html_output .= "\r\n" . '</div>';
		
		$this->html_output = apply_filters( 'sliderpro_markup', $this->html_output, $this->id );

		return $this->html_output;
	}

	/**
	 * Check if the slider has slides.
	 *
	 * @since  1.0.0
	 * 
	 * @return boolean Whether or not the slider has slides.
	 */
	protected function has_slides() {
		if ( isset( $this->data['slides'] ) && ! empty( $this->data['slides'] ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Create the slider's slides and get their HTML markup.
	 *
	 * @since  1.0.0
	 * 
	 * @return string The HTML markup of the slides.
	 */
	protected function create_slides() {
		$slides_output = '';
		$slides = $this->data['slides'];
		$slide_counter = 0;

		foreach ( $slides as $slide ) {
			$slides_output .= $this->create_slide( $slide, $slide_counter );
			$slide_counter++;
		}

		return $slides_output;
	}

	/**
	 * Create a slide.
	 * 
	 * @since 4.0.0
	 *
	 * @param  array  $data          The data of the slide.
	 * @param  int    $slide_counter The index of the slide.
	 * @return string                The HTML markup of the slide.
	 */
	protected function create_slide( $data, $slide_counter ) {
		$lazy_loading = isset( $this->settings['lazy_loading'] ) ? $this->settings['lazy_loading'] : $this->default_settings['lazy_loading'];
		$lightbox = isset( $this->settings['lightbox'] ) ? $this->settings['lightbox'] : $this->default_settings['lightbox'];
		$hide_image_title = isset( $this->settings['hide_image_title'] ) ? $this->settings['hide_image_title'] : $this->default_settings['hide_image_title'];
		$auto_thumbnail_images = isset( $this->settings['auto_thumbnail_images'] ) ? $this->settings['auto_thumbnail_images'] : $this->default_settings['auto_thumbnail_images'];
		$thumbnail_image_size = isset( $this->settings['thumbnail_image_size'] ) ? $this->settings['thumbnail_image_size'] : $this->default_settings['thumbnail_image_size'];

		$extra_data = new stdClass();
		$extra_data->lazy_loading = $lazy_loading;
		$extra_data->lightbox = $lightbox;
		$extra_data->hide_image_title = $hide_image_title;
		$extra_data->auto_thumbnail_images = $auto_thumbnail_images;
		$extra_data->thumbnail_image_size = $thumbnail_image_size;

		$slide = BQW_SP_Slide_Renderer_Factory::create_slide( $data );
		$slide->set_data( $data, $this->id, $slide_counter, $extra_data );
		
		return $slide->render();
	}

	/**
	 * Return the inline JavaScript code of the slider and identify all CSS and JS
	 * files that need to be loaded for the current slider.
	 *
	 * @since 4.0.0
	 * 
	 * @return string The inline JavaScript code of the slider.
	 */
	public function render_js() {
		$js_output = '';
		$settings_js = '';

		foreach ( $this->default_settings as $name => $setting ) {
			if ( ! isset( $setting['js_name'] ) ) {
				continue;
			}

			$setting_default_value = $setting['default_value'];
			$setting_value = isset( $this->settings[ $name ] ) ? $this->settings[ $name ] : $setting_default_value;

			if ( $setting_value != $setting_default_value ) {
				if ( $settings_js !== '' ) {
					$settings_js .= ',';
				}

				if ( is_bool( $setting_value ) ) {
					$setting_value = $setting_value === true ? 'true' : 'false';
				} else if ( is_numeric( $setting_value ) === false ) {
					$setting_value = "'" . $setting_value . "'";
				}

				$settings_js .= "\r\n" . '			' . $setting['js_name'] . ': ' . $setting_value;
			}
		}

		if ( isset ( $this->settings['breakpoints'] ) ) {
			$breakpoints_js = "";

			foreach ( $this->settings['breakpoints'] as $breakpoint ) {
				if ( $breakpoint['breakpoint_width'] === '' ) {
					continue;
				}

				if ( $breakpoints_js !== '' ) {
					$breakpoints_js .= ',';
				}

				$breakpoints_js .= "\r\n" . '				' . $breakpoint['breakpoint_width'] . ': {';

				unset( $breakpoint['breakpoint_width'] );

				if ( ! empty( $breakpoint ) ) {
					$breakpoint_setting_js = '';

					foreach ( $breakpoint as $name => $value ) {
						if ( $breakpoint_setting_js !== '' ) {
							$breakpoint_setting_js .= ',';
						}

						if ( is_bool( $value ) ) {
							$value = $value === true ? 'true' : 'false';
						} else if ( is_numeric( $value ) === false ) {
							$value = "'" . $value . "'";
						}

						$breakpoint_setting_js .= "\r\n" . '					' . $this->default_settings[ $name ]['js_name'] . ': ' . $value;
					}

					$breakpoints_js .= $breakpoint_setting_js;
				}

				$breakpoints_js .= "\r\n" . '				}';
			}

			if ( $settings_js !== '' ) {
				$settings_js .= ',';
			}

			$settings_js .= "\r\n" . '			breakpoints: {' . $breakpoints_js . "\r\n" . '			}';
		}

		$this->add_js_dependency( 'plugin' );

		$js_output .= "\r\n" . '		$( "#slider-pro-' . $this->id . '" ).sliderPro({' .
											$settings_js .
						"\r\n" . '		});' . "\r\n";

		if ( isset ( $this->settings['lightbox'] ) && $this->settings['lightbox'] === true ) {
			$this->add_js_dependency( 'lightbox' );
			$this->add_css_dependency( 'lightbox' );
			$sliderIdAttribute = '#slider-pro-' . $this->id;

			$js_output .= "\r\n" . '		$( "' . $sliderIdAttribute . ' .sp-image" ).parent( "a" ).on( "click", function( event ) {' .
							"\r\n" . '			event.preventDefault();' .
							"\r\n" . '			if ( $( "' . $sliderIdAttribute . '" ).hasClass( "sp-swiping" ) === false ) {' .
							"\r\n" . '				$.fancybox.open( $( "' . $sliderIdAttribute . ' .sp-image" ).parent( "a" ), { index: $( this ).parents( ".sp-slide" ).index() } );' .
							"\r\n" . '			}' .
							"\r\n" . '		});' . "\r\n";
		}

		return $js_output;
	}

	/**
	 * Add the id of a CSS file that needs to be loaded for the current slider.
	 *
	 * @since 4.0.0
	 * 
	 * @param string $id The id of the file.
	 */
	protected function add_css_dependency( $id ) {
		$this->css_dependencies[] = $id;
	}

	/**
	 * Add the id of a JS file that needs to be loaded for the current slider.
	 *
	 * @since 4.0.0
	 * 
	 * @param string $id The id of the file.
	 */
	protected function add_js_dependency( $id ) {
		$this->js_dependencies[] = $id;
	}

	/**
	 * Return the list of id's for CSS files that need to be loaded for the current slider.
	 *
	 * @since 4.0.0
	 * 
	 * @return array The list of id's for CSS files.
	 */
	public function get_css_dependencies() {
		return $this->css_dependencies;
	}

	/**
	 * Return the list of id's for JS files that need to be loaded for the current slider.
	 *
	 * @since 4.0.0
	 * 
	 * @return array The list of id's for JS files.
	 */
	public function get_js_dependencies() {
		return $this->js_dependencies;
	}
}