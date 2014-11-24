<?php
/**
 * Contains the default settings for the slider, slides, layers etc.
 * 
 * @since 4.0.0
 */
class BQW_SliderPro_Settings {

	/**
	 * The slider's settings.
	 * 
	 * The array contains the name, label, type, default value, 
	 * JavaScript name and description of the setting.
	 *
	 * @since 4.0.0
	 * 
	 * @var array
	 */
	protected static $settings = array();

	/**
	 * The groups of settings.
	 *
	 * The settings are grouped for the purpose of generating
	 * the slider's admin sidebar.
	 *
	 * @since 4.0.0
	 * 
	 * @var array
	 */
	protected static $setting_groups = array();

	/**
	 * Layer settings.
	 *
	 * The array contains the name, label, type, default value
	 * and description of the setting.
	 *
	 * @since 4.0.0
	 * 
	 * @var array
	 */
	protected static $layer_settings = array();

	/**
	 * Slide settings.
	 *
	 * The array contains the name, label, type, default value
	 * and description of the setting.
	 *
	 * @since 4.0.0
	 * 
	 * @var array
	 */
	protected static $slide_settings = array();

	/**
	 * List of settings that can be used for breakpoints.
	 *
	 * @since 4.0.0
	 * 
	 * @var array
	 */
	protected static $breakpoint_settings = array(
		'width',
		'height',
		'responsive',
		'visible_size',
		'aspect_ratio',
		'orientation',
		'slide_distance',
		'thumbnail_width',
		'thumbnail_height',
		'thumbnails_position'
	);

	/**
	 * Hold the state (opened or closed) of the sidebar slides.
	 *
	 * @since 4.0.0
	 * 
	 * @var array
	 */
	protected static $panels_state = array(
		'presets' => 'closed',
		'appearance' => '',
		'animations' => 'closed',
		'navigation' => 'closed',
		'captions' => 'closed',
		'full_screen' => 'closed',
		'layers' => 'closed',
		'thumbnails' => 'closed',
		'video' => 'closed',
		'miscellaneous' => 'closed',
		'breakpoints' => 'closed'
	);

	/**
	 * Holds the plugin settings.
	 *
	 * @since 4.0.0
	 * 
	 * @var array
	 */
	protected static $plugin_settings = array();

	/**
	 * Return the slider settings.
	 *
	 * @since 4.0.0
	 * 
	 * @param  string      $name The name of the setting. Optional.
	 * @return array|mixed       The array of settings or the value of the setting.
	 */
	public static function getSettings( $name = null ) {
		if ( empty( self::$settings ) ) {
			self::$settings = array(
				'width' => array(
					'js_name' => 'width',
					'label' => __( 'Width', 'sliderpro' ),
					'type' => 'number',
					'default_value' => 500,
					'description' => __( 'Sets the width of the slide. Can be set to a fixed value, like 900 (indicating 900 pixels), or to a percentage value, like \'100%\'.', 'sliderpro' )
				),

				'height' => array(
					'js_name' => 'height',
					'label' => __( 'Height', 'sliderpro' ),
					'type' => 'number',
					'default_value' => 300,
					'description' => __( 'Sets the height of the slide. Can be set to a fixed value, like 900 (indicating 900 pixels), or to a percentage value, like \'100%\'.', 'sliderpro' )
				),

				'responsive' => array(
					'js_name' => 'responsive',
					'label' => __( 'Responsive', 'sliderpro' ),
					'type' => 'boolean',
					'default_value' => true,
					'description' => __( 'Makes the slider responsive. The slider can be responsive even if the \'width\' and/or \'height\' properties are set to fixed values. In this situation, \'width\' and \'height\' will act as the maximum width and height of the slides.', 'sliderpro' )
				),

				'aspect_ratio' => array(
					'js_name' => 'aspectRatio',
					'label' => __( 'Aspect Ratio', 'sliderpro' ),
					'type' => 'number',
					'default_value' => -1,
					'description' => __( 'Sets the aspect ratio of the slides. If set to a value different than -1, the height of the slides will be overridden in order to maintain the specified aspect ratio.', 'sliderpro' )
				),

				'image_scale_mode' => array(
					'js_name' => 'imageScaleMode',
					'label' => __( 'Image Scale Mode', 'sliderpro' ),
					'type' => 'select',
					'default_value' => 'cover',
					'available_values' => array(
						'cover' => __( 'Cover', 'sliderpro' ),
						'contain' => __( 'Contain', 'sliderpro' ),
						'exact' => __( 'Exact', 'sliderpro' ),
						'none' => __( 'None', 'sliderpro' )
					),
					'description' => __( 'Sets the scale mode of the main slide images.', 'sliderpro' )
				),

				'center_image' => array(
					'js_name' => 'centerImage',
					'label' => __( 'Center Image', 'sliderpro' ),
					'type' => 'boolean',
					'default_value' => true,
					'description' => __( 'Indicates if the image will be centered.', 'sliderpro' )
				),

				'auto_height' => array(
					'js_name' => 'autoHeight',
					'label' => __( 'Auto Height', 'sliderpro' ),
					'type' => 'boolean',
					'default_value' => false,
					'description' => __( 'Indicates if height of the slider will be adjusted to the height of the selected slide.', 'sliderpro' )
				),

				'start_slide' => array(
					'js_name' => 'startSlide',
					'label' => __( 'Start Slide', 'sliderpro' ),
					'type' => 'number',
					'default_value' => 0,
					'description' => __( 'Sets the slide that will be selected when the slider loads.', 'sliderpro' )
				),

				'shuffle' => array(
					'js_name' => 'shuffle',
					'label' => __( 'Shuffle', 'sliderpro' ),
					'type' => 'boolean',
					'default_value' => false,
					'description' => __( 'Indicates if the slides will be shuffled.', 'sliderpro' )
				),

				'orientation' => array(
					'js_name' => 'orientation',
					'label' => __( 'Orientation', 'sliderpro' ),
					'type' => 'select',
					'default_value' => 'horizontal',
					'available_values' => array(
						'horizontal' => __( 'Horizontal', 'sliderpro' ),
						'vertical' => __( 'Vertical', 'sliderpro' )
					),
					'description' => __( 'Indicates whether the slides will be arranged horizontally or vertically.', 'sliderpro' )
				),

				'force_size' => array(
					'js_name' => 'forceSize',
					'label' => __( 'Force Size', 'sliderpro' ),
					'type' => 'select',
					'default_value' => 'none',
					'available_values' => array(
						'fullWidth' => __( 'Full Width', 'sliderpro' ),
						'fullWindow' => __( 'Full Window', 'sliderpro' ),
						'none' => __( 'None', 'sliderpro' )
					),
					'description' => __( 'Indicates if the size of the slider will be forced to full width or full window.', 'sliderpro' )
				),

				'loop' => array(
					'js_name' => 'loop',
					'label' => __( 'Loop', 'sliderpro' ),
					'type' => 'boolean',
					'default_value' => true,
					'description' => __( 'Indicates if the slider will be loopable (infinite scrolling).', 'sliderpro' )
				),

				'slide_distance' => array(
					'js_name' => 'slideDistance',
					'label' => __( 'Slide Distance', 'sliderpro' ),
					'type' => 'number',
					'default_value' => 10,
					'description' => __( 'Sets the distance between the slides.', 'sliderpro' )
				),

				'slide_animation_duration' => array(
					'js_name' => 'slideAnimationDuration',
					'label' => __( 'Slide Animation Duration', 'sliderpro' ),
					'type' => 'number',
					'default_value' => 700,
					'description' => __( 'Sets the duration of the slide animation.', 'sliderpro' )
				),

				'height_animation_duration' => array(
					'js_name' => 'heightAnimationDuration',
					'label' => __( 'Height Animation Duration', 'sliderpro' ),
					'type' => 'number',
					'default_value' => 700,
					'description' => __( 'Sets the duration of the height animation.', 'sliderpro' )
				),

				'visible_size' => array(
					'js_name' => 'visibleSize',
					'label' => __( 'Visible Size', 'sliderpro' ),
					'type' => 'mixed',
					'default_value' => 'auto',
					'description' => __( 'Sets the size of the visible area, allowing for more slides to become visible near the selected slide.', 'sliderpro' )
				),

				'fade' => array(
					'js_name' => 'fade',
					'label' => __( 'Fade', 'sliderpro' ),
					'type' => 'boolean',
					'default_value' => false,
					'description' => __( 'Indicates if fade will be used.', 'sliderpro' )
				),

				'fade_out_previous_slide' => array(
					'js_name' => 'fadeOutPreviousSlide',
					'label' => __( 'Fade Out Previous Slide', 'sliderpro' ),
					'type' => 'boolean',
					'default_value' => true,
					'description' => __( 'Indicates if the previous slide will be faded out (in addition to the next slide being faded in).', 'sliderpro' )
				),

				'fade_duration' => array(
					'js_name' => 'fadeDuration',
					'label' => __( 'Fade Duration', 'sliderpro' ),
					'type' => 'number',
					'default_value' => 500,
					'description' => __( 'Sets the duration of the fade effect.', 'sliderpro' )
				),

				'autoplay' => array(
					'js_name' => 'autoplay',
					'label' => __( 'Autoplay', 'sliderpro' ),
					'type' => 'boolean',
					'default_value' => true,
					'description' => __( 'Indicates whether or not autoplay will be enabled.', 'sliderpro' )
				),

				'autoplay_delay' => array(
					'js_name' => 'autoplayDelay',
					'label' => __( 'Autoplay Delay', 'sliderpro' ),
					'type' => 'number',
					'default_value' => 5000,
					'description' => __( 'Sets the delay/interval (in milliseconds) at which the autoplay will run.', 'sliderpro' )
				),

				'autoplay_direction' => array(
					'js_name' => 'autoplayDirection',
					'label' => __( 'Autoplay Direction', 'sliderpro' ),
					'type' => 'select',
					'default_value' => 'normal',
					'available_values' => array(
						'normal' => __( 'Normal', 'sliderpro' ),
						'backwards' => __( 'Backwards', 'sliderpro' )
					),
					'description' => __( 'Indicates whether autoplay will navigate to the next slide or previous slide.', 'sliderpro' )
				),

				'autoplay_on_hover' => array(
					'js_name' => 'autoplayOnHover',
					'label' => __( 'Autoplay On Hover', 'sliderpro' ),
					'type' => 'select',
					'default_value' => 'pause',
					'available_values' => array(
						'pause' => __( 'Pause', 'sliderpro' ),
						'stop' => __( 'Stop', 'sliderpro' ),
						'none' => __( 'None', 'sliderpro' )
					),
					'description' => __( 'Indicates if the autoplay will be paused or stopped when the slider is hovered.', 'sliderpro' )
				),

				'arrows' => array(
					'js_name' => 'arrows',
					'label' => __( 'Arrows', 'sliderpro' ),
					'type' => 'boolean',
					'default_value' => false,
					'description' => __( 'Indicates whether the arrow buttons will be created.', 'sliderpro' )
				),

				'fade_arrows' => array(
					'js_name' => 'fadeArrows',
					'label' => __( 'Fade Arrows', 'sliderpro' ),
					'type' => 'boolean',
					'default_value' => true,
					'description' => __( 'Indicates whether the arrows will fade in only on hover.', 'sliderpro' )
				),

				'buttons' => array(
					'js_name' => 'buttons',
					'label' => __( 'Buttons', 'sliderpro' ),
					'type' => 'boolean',
					'default_value' => true,
					'description' => __( 'Indicates whether the buttons will be created.', 'sliderpro' )
				),

				'keyboard' => array(
					'js_name' => 'keyboard',
					'label' => __( 'Keyboard', 'sliderpro' ),
					'type' => 'boolean',
					'default_value' => true,
					'description' => __( 'Indicates whether keyboard navigation will be enabled.', 'sliderpro' )
				),

				'keyboard_only_on_focus' => array(
					'js_name' => 'keyboardOnlyOnFocus',
					'label' => __( 'Keyboard Only On Focus', 'sliderpro' ),
					'type' => 'boolean',
					'default_value' => false,
					'description' => __( 'Indicates whether the slider will respond to keyboard input only when the slider is in focus.', 'sliderpro' )
				),

				'touch_swipe' => array(
					'js_name' => 'touchSwipe',
					'label' => __( 'Touch Swipe', 'sliderpro' ),
					'type' => 'boolean',
					'default_value' => true,
					'description' => __( 'Indicates whether the touch swipe will be enabled for slides.', 'sliderpro' )
				),

				'touch_swipe_threshold' => array(
					'js_name' => 'touchSwipeThreshold',
					'label' => __( 'Touch Swipe Threshold', 'sliderpro' ),
					'type' => 'number',
					'default_value' => 50,
					'description' => __( 'Sets the minimum amount that the slides should move.', 'sliderpro' )
				),

				'fade_caption' => array(
					'js_name' => 'fadeCaption',
					'label' => __( 'Fade Caption', 'sliderpro' ),
					'type' => 'boolean',
					'default_value' => true,
					'description' => __( 'Indicates whether or not the captions will be faded.', 'sliderpro' )
				),

				'caption_fade_duration' => array(
					'js_name' => 'captionFadeDuration',
					'label' => __( 'Caption Fade Duration', 'sliderpro' ),
					'type' => 'number',
					'default_value' => 500,
					'description' => __( 'Sets the duration of the fade animation.', 'sliderpro' )
				),

				'full_screen' => array(
					'js_name' => 'fullScreen',
					'label' => __( 'Full Screen', 'sliderpro' ),
					'type' => 'boolean',
					'default_value' => false,
					'description' => __( 'Indicates whether the full-screen button is enabled.', 'sliderpro' )
				),

				'fade_full_screen' => array(
					'js_name' => 'fadeFullScreen',
					'label' => __( 'Fade Full Screen', 'sliderpro' ),
					'type' => 'boolean',
					'default_value' => true,
					'description' => __( 'Indicates whether the button will fade in only on hover.', 'sliderpro' )
				),

				'wait_for_layers' => array(
					'js_name' => 'waitForLayers',
					'label' => __( 'Wait For Layers', 'sliderpro' ),
					'type' => 'boolean',
					'default_value' => false,
					'description' => __( 'Indicates whether the slider will wait for the layers to disappear before going to a new slide.', 'sliderpro' )
				),

				'auto_scale_layers' => array(
					'js_name' => 'autoScaleLayers',
					'label' => __( 'Auto Scale Layers', 'sliderpro' ),
					'type' => 'boolean',
					'default_value' => true,
					'description' => __( 'Indicates whether the layers will be scaled automatically.', 'sliderpro' )
				),

				'auto_scale_reference' => array(
					'js_name' => 'autoScaleReference',
					'label' => __( 'Auto Scale Reference', 'sliderpro' ),
					'type' => 'number',
					'default_value' => -1,
					'description' => __( 'Sets a reference width which will be compared to the current slider width in order to determine how much the layers need to scale down. By default, the reference width will be equal to the slide width. However, if the slide width is set to a percentage value, then it\'s necessary to set a specific value for \'Auto Scale Reference\'.', 'sliderpro' )
				),

				'lazy_loading' => array(
					'label' => __( 'Lazy Loading', 'sliderpro' ),
					'type' => 'boolean',
					'default_value' => false,
					'description' => __( 'Indicates if the main images will be loaded only when they are visible.', 'sliderpro' )
				),

				'lightbox' => array(
					'js_name' => 'lightbox',
					'label' => __( 'Lightbox', 'sliderpro' ),
					'type' => 'boolean',
					'default_value' => false,
					'description' => __( 'Indicates if the links specified to the main images will be opened in a lightbox.', 'sliderpro' )
				),

				'custom_class' => array(
					'label' => __( 'Custom Class', 'sliderpro' ),
					'type' => 'text',
					'default_value' => '',
					'description' => __( 'Adds a custom class to the slider, for use in custom css. Add the class name without the dot, i.e., you need to add <i>my-slider</i>, not <i>.my-slider</i>.', 'sliderpro' )
				),

				'small_size' => array(
					'js_name' => 'smallSize',
					'label' => __( 'Small Size', 'sliderpro' ),
					'type' => 'number',
					'default_value' => 480,
					'description' => __( 'If the slider size is below this size, the small version of the images will be used.', 'sliderpro' )
				),

				'medium_size' => array(
					'js_name' => 'mediumSize',
					'label' => __( 'Medium Size', 'sliderpro' ),
					'type' => 'number',
					'default_value' => 768,
					'description' => __( 'If the slider size is below this size, the medium version of the images will be used.', 'sliderpro' )
				),

				'large_size' => array(
					'js_name' => 'largeSize',
					'label' => __( 'Large Size', 'sliderpro' ),
					'type' => 'number',
					'default_value' => 1024,
					'description' => __( 'If the slider size is below this size, the large version of the images will be used.', 'sliderpro' )
				),

				'hide_image_title' => array(
					'label' => __( 'Hide Image Title', 'sliderpro' ),
					'type' => 'boolean',
					'default_value' => true,
					'description' => __( 'Indicates if the title tag will be removed from images in order to prevent the title to show up in a tooltip when the image is hovered.', 'sliderpro' )
				),

				'update_hash' => array(
					'js_name' => 'updateHash',
					'label' => __( 'Update Hash', 'sliderpro' ),
					'type' => 'boolean',
					'default_value' => false,
					'description' => __( 'Indicates whether the hash will be updated when a new slide is selected.', 'sliderpro' )
				),

				'reach_video_action' => array(
					'js_name' => 'reachVideoAction',
					'label' => __( 'Reach Video Action', 'sliderpro' ),
					'type' => 'select',
					'default_value' => 'none',
					'available_values' => array(
						'playVideo' => __( 'Play Video', 'sliderpro' ),
						'none' => __( 'None', 'sliderpro' )
					),
					'description' => __( 'Indicates if the autoplay will be paused or stopped when the slider is hovered.', 'sliderpro' )
				),

				'leave_video_action' => array(
					'js_name' => 'reachVideoAction',
					'label' => __( 'Leave Video Action', 'sliderpro' ),
					'type' => 'select',
					'default_value' => 'pauseVideo',
					'available_values' => array(
						'stopVideo' => __( 'Stop Video', 'sliderpro' ),
						'pauseVideo' => __( 'Pause Video', 'sliderpro' ),
						'removeVideo' => __( 'Remove Video', 'sliderpro' ),
						'none' => __( 'None', 'sliderpro' )
					),
					'description' => __( 'Sets the action that the video will perform when another slide is selected.', 'sliderpro' )
				),

				'play_video_action' => array(
					'js_name' => 'playVideoAction',
					'label' => __( 'Leave Video Action', 'sliderpro' ),
					'type' => 'select',
					'default_value' => 'stopAutoplay',
					'available_values' => array(
						'stopAutoplay' => __( 'Stop Autoplay', 'sliderpro' ),
						'none' => __( 'None', 'sliderpro' )
					),
					'description' => __( 'Sets the action that the slider will perform when the video starts playing.', 'sliderpro' )
				),

				'pause_video_action' => array(
					'js_name' => 'pauseVideoAction',
					'label' => __( 'Pause Video Action', 'sliderpro' ),
					'type' => 'select',
					'default_value' => 'none',
					'available_values' => array(
						'startAutoplay' => __( 'Start Autoplay', 'sliderpro' ),
						'none' => __( 'None', 'sliderpro' )
					),
					'description' => __( 'Sets the action that the slider will perform when the video starts playing.', 'sliderpro' )
				),

				'end_video_action' => array(
					'js_name' => 'endVideoAction',
					'label' => __( 'End Video Action', 'sliderpro' ),
					'type' => 'select',
					'default_value' => 'none',
					'available_values' => array(
						'startAutoplay' => __( 'Start Autoplay', 'sliderpro' ),
						'nextSlide' => __( 'Next Slide', 'sliderpro' ),
						'replayVideo' => __( 'Replay Video', 'sliderpro' ),
						'none' => __( 'None', 'sliderpro' )
					),
					'description' => __( 'Sets the action that the slider will perform when the video ends.', 'sliderpro' )
				),

				'auto_thumbnail_images' => array(
					'label' => __( 'Auto Thumbnail Images', 'sliderpro' ),
					'type' => 'boolean',
					'default_value' => false,
					'description' => __( 'Indicates whether the thumbnail images will be generated automatically based on the main image specified for the slide.', 'sliderpro' )
				),

				'thumbnail_image_size' => array(
					'js_name' => 'thumbnailImageSize',
					'label' => __( 'Thumbnail Image Size', 'sliderpro' ),
					'type' => 'select',
					'default_value' => '',
					'available_values' => array(),
					'description' => __( 'Sets the registered image size that will be used for automatically generated thumbnails.', 'sliderpro' )
				),

				'thumbnail_width' => array(
					'js_name' => 'thumbnailWidth',
					'label' => __( 'Thumbnail Width', 'sliderpro' ),
					'type' => 'number',
					'default_value' => 100,
					'description' => __( 'Sets the width of the thumbnail.', 'sliderpro' )
				),

				'thumbnail_height' => array(
					'js_name' => 'thumbnailHeight',
					'label' => __( 'Thumbnail Height', 'sliderpro' ),
					'type' => 'number',
					'default_value' => 80,
					'description' => __( 'Sets the height of the thumbnail.', 'sliderpro' )
				),

				'thumbnails_position' => array(
					'js_name' => 'thumbnailsPosition',
					'label' => __( 'Thumbnails Position', 'sliderpro' ),
					'type' => 'select',
					'default_value' => 'bottom',
					'available_values' => array(
						'top' => __( 'Top', 'sliderpro' ),
						'bottom' => __( 'Bottom', 'sliderpro' ),
						'right' => __( 'Right', 'sliderpro' ),
						'left' => __( 'Left', 'sliderpro' )
					),
					'description' => __( 'Sets the position of the thumbnail scroller.', 'sliderpro' )
				),

				'thumbnail_pointer' => array(
					'js_name' => 'thumbnailPointer',
					'label' => __( 'Thumbnail Pointer', 'sliderpro' ),
					'type' => 'boolean',
					'default_value' => false,
					'description' => __( 'Indicates if a pointer will be displayed for the selected thumbnail.', 'sliderpro' )
				),

				'thumbnail_arrows' => array(
					'js_name' => 'thumbnailArrows',
					'label' => __( 'Thumbnail Arrows', 'sliderpro' ),
					'type' => 'boolean',
					'default_value' => false,
					'description' => __( 'Indicates whether the thumbnail arrows will be enabled.', 'sliderpro' )
				),

				'fade_thumbnail_arrows' => array(
					'js_name' => 'fadeThumbnailArrows',
					'label' => __( 'Fade Thumbnail Arrows', 'sliderpro' ),
					'type' => 'boolean',
					'default_value' => true,
					'description' => __( 'Indicates whether the thumbnail arrows will be faded.', 'sliderpro' )
				),

				'thumbnail_touch_swipe' => array(
					'js_name' => 'thumbnailTouchSwipe',
					'label' => __( 'Thumbnail Touch Swipe', 'sliderpro' ),
					'type' => 'boolean',
					'default_value' => true,
					'description' => __( 'Indicates whether the touch swipe will be enabled for thumbnails.', 'sliderpro' )
				),
			);

			self::$settings = apply_filters( 'sliderpro_default_settings', self::$settings );
		}

		if ( ! is_null( $name ) ) {
			return self::$settings[ $name ];
		}

		return self::$settings;
	}

	/**
	 * Return the setting groups.
	 *
	 * @since 4.0.0
	 * 
	 * @return array The array of setting groups.
	 */
	public static function getSettingGroups() {
		if ( empty( self::$setting_groups ) ) {
			self::$setting_groups = array(
				'appearance' => array(
					'label' => __( 'Appearance', 'sliderpro' ),
					'list' => array(
						'width',
						'height',
						'responsive',
						'visible_size',
						'aspect_ratio',
						'orientation',
						'force_size',
						'auto_height',
						'start_slide',
						'loop',
						'shuffle',
						'image_scale_mode',
						'center_image',
						'slide_distance'
					)
				),

				'animations' => array(
					'label' => __( 'Animations', 'sliderpro' ),
					'list' => array(
						'fade',
						'fade_out_previous_slide',
						'fade_duration',
						'slide_animation_duration',
						'height_animation_duration'
					)
				),
						
				'navigation' => array(
					'label' => __( 'Navigation', 'sliderpro' ),
					'list' => array(
						'autoplay',
						'autoplay_delay',
						'autoplay_direction',
						'autoplay_on_hover',
						'arrows',
						'fade_arrows',
						'buttons',
						'keyboard',
						'keyboard_only_on_focus',
						'touch_swipe',
						'touch_swipe_threshold'
					)
				),
				
				'captions' => array(
					'label' => __( 'Captions', 'sliderpro' ),
					'list' => array(
						'fade_caption',
						'caption_fade_duration'
					)
				),

				'full_screen' => array(
					'label' => __( 'Full Screen', 'sliderpro' ),
					'list' => array(
						'full_screen',
						'fade_full_screen'
					)
				),

				'layers' => array(
					'label' => __( 'Layers', 'sliderpro' ),
					'list' => array(
						'wait_for_layers',
						'auto_scale_layers',
						'auto_scale_reference'
					)
				),

				'thumbnails' => array(
					'label' => __( 'Thumbnails', 'sliderpro' ),
					'list' => array(
						'auto_thumbnail_images',
						'thumbnail_image_size',
						'thumbnail_width',
						'thumbnail_height',
						'thumbnails_position',
						'thumbnail_pointer',
						'thumbnail_arrows',
						'fade_thumbnail_arrows',
						'thumbnail_touch_swipe',
					)
				),

				'video' => array(
					'label' => __( 'Video', 'sliderpro' ),
					'list' => array(
						'reach_video_action',
						'leave_video_action',
						'play_video_action',
						'pause_video_action',
						'end_video_action'
					)
				),

				'miscellaneous' => array(
					'label' => __( 'Miscellaneous', 'sliderpro' ),
					'list' => array(
						'lazy_loading',
						'lightbox',
						'small_size',
						'medium_size',
						'large_size',
						'update_hash',
						'hide_image_title',
						'custom_class'
					)
				)
			);
		}

		return self::$setting_groups;
	}
	
	/**
	 * Return the breakpoint settings.
	 *
	 * @since 4.0.0
	 * 
	 * @return array The array of breakpoint settings.
	 */
	public static function getBreakpointSettings() {
		return self::$breakpoint_settings;
	}

	/**
	 * Return the default panels state.
	 *
	 * @since 4.0.0
	 * 
	 * @return array The array of panels state.
	 */
	public static function getPanelsState() {
		return self::$panels_state;
	}

	/**
	 * Return the layer settings.
	 *
	 * @since 4.0.0
	 * 
	 * @return array The array of layer settings.
	 */
	public static function getLayerSettings() {
		if ( empty( self::$layer_settings ) ) {
			self::$layer_settings = array(
				'type' => array(
					'label' => __( 'Type', 'sliderpro' ),
					'type' => 'select',
					'default_value' => 'div',
					'available_values' => array(
						'paragraph' => __( 'Paragraph', 'sliderpro' ),
						'heading' => __( 'Heading', 'sliderpro' ),
						'image' => __( 'Image', 'sliderpro' ),
						'video' => __( 'Video', 'sliderpro' ),
						'div' => __( 'DIV', 'sliderpro' )
					),
					'description' => ''
				),
				'heading_type' => array(
					'label' => __( 'Heading Type', 'sliderpro' ),
					'type' => 'select',
					'default_value' => 'h3',
					'available_values' => array(
						'h1' => __( 'H1', 'sliderpro' ),
						'h2' => __( 'H2', 'sliderpro' ),
						'h3' => __( 'H3', 'sliderpro' ),
						'h4' => __( 'H4', 'sliderpro' ),
						'h5' => __( 'H5', 'sliderpro' ),
						'h6' => __( 'H6', 'sliderpro' )
					),
					'description' => ''
				),
				'video_source' => array(
					'label' => __( 'Video Source', 'sliderpro' ),
					'type' => 'select',
					'default_value' => 'youtube',
					'available_values' => array(
						'youtube' => __( 'YouTube', 'sliderpro' ),
						'vimeo' => __( 'Vimeo', 'sliderpro' )
					),
					'description' => ''
				),
				'video_load_mode' => array(
					'label' => __( 'Video Load Mode', 'sliderpro' ),
					'type' => 'select',
					'default_value' => 'poster',
					'available_values' => array(
						'poster' => __( 'Poster', 'sliderpro' ),
						'video' => __( 'Video', 'sliderpro' )
					),
					'description' => ''
				),
				'display' => array(
					'label' => __( 'Display', 'sliderpro' ),
					'type' => 'radio',
					'default_value' => 'animated',
					'available_values' => array(
						'animated' => __( 'Animated', 'sliderpro' ),
						'static' => __( 'Static', 'sliderpro' )
					),
					'description' => ''
				),
				'position' => array(
					'label' => __( 'Position', 'sliderpro' ),
					'type' => 'select',
					'default_value' => 'topLeft',
					'available_values' => array(
						'topLeft' => __( 'Top Left', 'sliderpro' ),
						'topCenter' => __( 'Top Center', 'sliderpro' ),
						'topRight' => __( 'Top Right', 'sliderpro' ),
						'centerLeft' => __( 'Center Left', 'sliderpro' ),
						'centerCenter' => __( 'Center Center', 'sliderpro' ),
						'centerRight' => __( 'Center Right', 'sliderpro' ),
						'bottomLeft' => __( 'Bottom Left', 'sliderpro' ),
						'bottomCenter' => __( 'Bottom Center', 'sliderpro' ),
						'bottomRight' => __( 'Bottom Right', 'sliderpro' )
					),
					'description' => ''
				),
				'width' => array(
					'label' => __( 'Width', 'sliderpro' ),
					'type' => 'mixed',
					'default_value' => 'auto',
					'description' => ''
				),
				'height' => array(
					'label' => __( 'Height', 'sliderpro' ),
					'type' => 'mixed',
					'default_value' => 'auto',
					'description' => ''
				),
				'horizontal' => array(
					'label' => __( 'Horizontal', 'sliderpro' ),
					'type' => 'mixed',
					'default_value' => '0',
					'description' => ''
				),
				'vertical' => array(
					'label' => __( 'Vertical', 'sliderpro' ),
					'type' => 'mixed',
					'default_value' => '0',
					'description' => ''
				),
				'preset_styles' => array(
					'label' => __( 'Preset Styles', 'sliderpro' ),
					'type' => 'multiselect',
					'default_value' => array( 'sp-black', 'sp-padding' ),
					'available_values' => array(
						'sp-black' => __( 'Black', 'sliderpro' ),
						'sp-white' => __( 'White', 'sliderpro' ),
						'sp-padding' => __( 'Padding', 'sliderpro' ),
						'sp-rounded' => __( 'Round Corners', 'sliderpro' )
					),
					'description' => ''
				),
				'custom_class' => array(
					'label' => __( 'Custom Class', 'sliderpro' ),
					'type' => 'text',
					'default_value' => '',
					'description' => ''
				),
				'show_transition' => array(
					'label' => __( 'Show Transition', 'sliderpro' ),
					'type' => 'select',
					'default_value' => 'fade',
					'available_values' => array(
						'fade' => __( 'Fade', 'sliderpro' ),
						'left' => __( 'Left', 'sliderpro' ),
						'right' => __( 'Right', 'sliderpro' ),
						'up' => __( 'Up', 'sliderpro' ),
						'down' => __( 'Down', 'sliderpro' )
					),
					'description' => ''
				),
				'show_offset' => array(
					'label' => __( 'Show Offset', 'sliderpro' ),
					'type' => 'number',
					'default_value' => 50,
					'description' => ''
				),
				'show_delay' => array(
					'label' => __( 'Show Delay', 'sliderpro' ),
					'type' => 'number',
					'default_value' => 10,
					'description' => ''
				),
				'show_duration' => array(
					'label' => __( 'Show Duration', 'sliderpro' ),
					'type' => 'number',
					'default_value' => 400,
					'description' => ''
				),
				'stay_duration' => array(
					'label' => __( 'Stay Duration', 'sliderpro' ),
					'type' => 'number',
					'default_value' => -1,
					'description' => ''
				),
				'hide_transition' => array(
					'label' => __( 'Hide Transition', 'sliderpro' ),
					'type' => 'select',
					'default_value' => 'fade',
					'available_values' => array(
						'fade' => __( 'Fade', 'sliderpro' ),
						'left' => __( 'Left', 'sliderpro' ),
						'right' => __( 'Right', 'sliderpro' ),
						'up' => __( 'Up', 'sliderpro' ),
						'down' => __( 'Down', 'sliderpro' )
					),
					'description' => ''
				),
				'hide_offset' => array(
					'label' => __( 'Hide Offset', 'sliderpro' ),
					'type' => 'number',
					'default_value' => 50,
					'description' => ''
				),
				'hide_delay' => array(
					'label' => __( 'Hide Delay', 'sliderpro' ),
					'type' => 'number',
					'default_value' => 10,
					'description' => ''
				),
				'hide_duration' => array(
					'label' => __( 'Hide Duration', 'sliderpro' ),
					'type' => 'number',
					'default_value' => 400,
					'description' => ''
				)
			);

			self::$layer_settings = apply_filters( 'sliderpro_default_layer_settings', self::$layer_settings );
		}

		return self::$layer_settings;
	}

	/**
	 * Return the slide settings.
	 *
	 * @since 4.0.0
	 * 
	 * @return array The array of slide settings.
	 */
	public static function getSlideSettings() {
		if ( empty( self::$slide_settings ) ) {
			self::$slide_settings = array(
				'content_type' => array(
					'label' => __( 'Content Type', 'sliderpro' ),
					'type' => 'select',
					'default_value' => 'custom',
					'available_values' => array(
						'custom' => __( 'Custom Content', 'sliderpro' ),
						'posts' => __( 'Content from posts', 'sliderpro' ),
						'gallery' => __( 'Images from post\'s gallery', 'sliderpro' ),
						'flickr' => __( 'Flickr images', 'sliderpro' )
					),
					'description' => ''
				),
				'posts_post_types' => array(
					'label' => __( 'Post Types', 'sliderpro' ),
					'type' => 'multiselect',
					'default_value' => array( 'post' ),
					'description' => ''
				),
				'posts_taxonomies' => array(
					'label' => __( 'Taxonomies', 'sliderpro' ),
					'type' => 'multiselect',
					'default_value' => array(),
					'description' => ''
				),
				'posts_relation' => array(
					'label' => __( 'Match', 'sliderpro' ),
					'type' => 'select',
					'default_value' => 'OR',
					'available_values' => array(
						'OR' => __( 'At least one', 'sliderpro' ),
						'AND' => __( 'All', 'sliderpro' )
					),
					'description' => ''
				),
				'posts_operator' => array(
					'label' => __( 'With selected', 'sliderpro' ),
					'type' => 'select',
					'default_value' => 'IN',
					'available_values' => array(
						'IN' => __( 'Include', 'sliderpro' ),
						'NOT IN' => __( 'Exclude', 'sliderpro' )
					),
					'description' => ''
				),
				'posts_order_by' => array(
					'label' => __( 'Order By', 'sliderpro' ),
					'type' => 'select',
					'default_value' => 'date',
					'available_values' => array(
						'date' => __( 'Date', 'sliderpro' ),
						'comment_count' => __( 'Comments', 'sliderpro' ),
						'title' => __( 'Title', 'sliderpro' ),
						'rand' => __( 'Random', 'sliderpro' )
					),
					'description' => ''
				),
				'posts_order' => array(
					'label' => __( 'Order', 'sliderpro' ),
					'type' => 'select',
					'default_value' => 'DESC',
					'available_values' => array(
						'DESC' => __( 'Descending', 'sliderpro' ),
						'ASC' => __( 'Ascending', 'sliderpro' )
					),
					'description' => ''
				),
				'posts_maximum' => array(
					'label' => __( 'Limit', 'sliderpro' ),
					'type' => 'number',
					'default_value' => 10,
					'description' => ''
				),
				'flickr_api_key' => array(
					'label' => __( 'API Key', 'sliderpro' ),
					'type' => 'text',
					'default_value' => '',
					'description' => ''
				),
				'flickr_load_by' => array(
					'label' => __( 'Load By', 'sliderpro' ),
					'type' => 'select',
					'default_value' => 'set_id',
					'available_values' => array(
						'set_id' => __( 'Set ID', 'sliderpro' ),
						'user_id' => __( 'User ID', 'sliderpro' )
					),
					'description' => ''
				),
				'flickr_id' => array(
					'label' => __( 'ID', 'sliderpro' ),
					'type' => 'text',
					'default_value' => '',
					'description' => ''
				),
				'flickr_per_page' => array(
					'label' => __( 'Limit', 'sliderpro' ),
					'type' => 'number',
					'default_value' => 10,
					'description' => ''
				)
			);

			self::$slide_settings = apply_filters( 'sliderpro_default_slide_settings', self::$slide_settings );
		}

		return self::$slide_settings;
	}

	/**
	 * Return the plugin settings.
	 *
	 * @since 4.0.0
	 * 
	 * @return array The array of plugin settings.
	 */
	public static function getPluginSettings() {
		if ( empty( self::$plugin_settings ) ) {
			self::$plugin_settings = array(
				'load_stylesheets' => array(
					'label' => __( 'Load stylesheets', 'sliderpro' ),
					'default_value' => 'automatically',
					'available_values' => array(
						'automatically' => __( 'Automatically', 'sliderpro' ),
						'homepage' => __( 'On homepage', 'sliderpro' ),
						'all' => __( 'On all pages', 'sliderpro' )
					),
					'description' => __( 'The plugin can detect the presence of the slider in a post, page or widget, and will automatically load the necessary stylesheets. However, when the slider is loaded in PHP code, like in the theme\'s header or another template file, you need to manually specify where the stylesheets should load. If you load the slider only on the homepage, select <i>On homepage</i>, or if you load it in the header or another section that is visible on multiple pages, select <i>On all pages</i>.' , 'sliderpro' )
				),
				'load_custom_css_js' => array(
					'label' => __( 'Load custom CSS and JavaScript', 'sliderpro' ),
					'default_value' => 'inline',
					'available_values' => array(
						'inline' => __( 'Inline', 'sliderpro' ),
						'in_files' => __( 'In files', 'sliderpro' )
					),
					'description' => __( 'By default, custom CSS and JavaScript code added to the slider will be loaded inline. However, if you want to add large amounts of custom CSS or JavaScript, it\'s better to have the code loaded in files, rather than inline. If you chose to load the custom code in files, after selecting this option, you need to re-save the custom CSS and/or JavaScript and the plugin will automatically create the <i>sliderpro-custom</i> folder inside <i>wp-plugins</i> and then <i>custom.css</i> and <i>custom.js</i> inside <i>sliderpro-custom</i>. You might also be prompted to provide credentials if the files can\'t be created due to folder permission issues.' , 'sliderpro' )
				),
				'load_unminified_scripts' => array(
					'label' => __( 'Load unminified scripts', 'sliderpro' ),
					'default_value' => false,
					'description' => __( 'Check this option if you want to load the unminified/uncompressed CSS and JavaScript files for the slider. This is useful for debugging purposes.', 'sliderpro' )
				),
				'cache_expiry_interval' => array(
					'label' => __( 'Cache expiry interval', 'sliderpro' ),
					'default_value' => 24,
					'description' => __( 'Indicates the time interval after which a slider\'s cache will expire. If the cache of a slider has expired, the slider will be rendered again and cached the next time it is viewed.', 'sliderpro' )
				),
				'hide_inline_info' => array(
					'label' => __( 'Hide inline info', 'sliderpro' ),
					'default_value' => false,
					'description' => __( 'Indicates whether the inline information will be displayed in admin slides and wherever it\'s available.', 'sliderpro' )
				),
				'hide_getting_started_info' => array(
					'label' => __( 'Hide <i>Getting Started</i> info', 'sliderpro' ),
					'default_value' => false,
					'description' => __( 'Indicates whether the <i>Getting Started</i> information will be displayed in the <i>All Sliders</i> page, above the list of sliders. This setting will be disabled if the <i>Close</i> button is clicked in the information box.', 'sliderpro' )
				),
				'access' => array(
					'label' => __( 'Access', 'sliderpro' ),
					'default_value' => 'manage_options',
					'available_values' => array(
						'manage_options' => __( 'Administrator', 'sliderpro' ),
						'publish_pages' => __( 'Editor', 'sliderpro '),
						'publish_posts' => __( 'Author', 'sliderpro' ),
						'edit_posts' => __( 'Contributor', 'sliderpro' )
					),
					'description' => __( 'Sets what category of users will have access to the plugin\'s admin area.', 'sliderpro' )
				)
			);
		}

		return self::$plugin_settings;
	}
}