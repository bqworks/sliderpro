<?php
/**
 * Slider Pro admin class.
 * 
 * @since 4.0.0
 */
class BQW_SliderPro_Admin {

	/**
	 * Current class instance.
	 * 
	 * @since 4.0.0
	 * 
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * Stores the hook suffixes for the plugin's admin pages.
	 * 
	 * @since 4.0.0
	 * 
	 * @var array
	 */
	protected $plugin_screen_hook_suffixes = null;

	/**
	 * Current class instance of the public Slider Pro class.
	 * 
	 * @since 4.0.0
	 * 
	 * @var object
	 */
	protected $plugin = null;

	/**
	 * Plugin class.
	 * 
	 * @since 4.0.0
	 * 
	 * @var object
	 */
	protected $plugin_slug = null;

	/**
	 * Initialize the admin by registering the required actions.
	 *
	 * @since 4.0.0
	 */
	private function __construct() {
		$this->plugin = BQW_SliderPro::get_instance();
		$this->plugin_slug = $this->plugin->get_plugin_slug();

		// load the admin CSS and JavaScript
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );

		add_action( 'wp_ajax_sliderpro_get_slider_data', array( $this, 'ajax_get_slider_data' ) );
		add_action( 'wp_ajax_sliderpro_save_slider', array( $this, 'ajax_save_slider' ) );
		add_action( 'wp_ajax_sliderpro_preview_slider', array( $this, 'ajax_preview_slider' ) );
		add_action( 'wp_ajax_sliderpro_update_presets', array( $this, 'ajax_update_presets' ) );
		add_action( 'wp_ajax_sliderpro_get_preset_settings', array( $this, 'ajax_get_preset_settings' ) );
		add_action( 'wp_ajax_sliderpro_get_breakpoints_preset', array( $this, 'ajax_get_breakpoints_preset' ) );
		add_action( 'wp_ajax_sliderpro_delete_slider', array( $this, 'ajax_delete_slider' ) );
		add_action( 'wp_ajax_sliderpro_duplicate_slider', array( $this, 'ajax_duplicate_slider' ) );
		add_action( 'wp_ajax_sliderpro_export_slider', array( $this, 'ajax_export_slider' ) );
		add_action( 'wp_ajax_sliderpro_import_slider', array( $this, 'ajax_import_slider' ) );
		add_action( 'wp_ajax_sliderpro_add_slides', array( $this, 'ajax_add_slides' ) );
		add_action( 'wp_ajax_sliderpro_load_main_image_editor', array( $this, 'ajax_load_main_image_editor' ) );
		add_action( 'wp_ajax_sliderpro_load_thumbnail_editor', array( $this, 'ajax_load_thumbnail_editor' ) );
		add_action( 'wp_ajax_sliderpro_load_caption_editor', array( $this, 'ajax_load_caption_editor' ) );
		add_action( 'wp_ajax_sliderpro_load_html_editor', array( $this, 'ajax_load_html_editor' ) );
		add_action( 'wp_ajax_sliderpro_load_layers_editor', array( $this, 'ajax_load_layers_editor' ) );
		add_action( 'wp_ajax_sliderpro_add_layer_settings', array( $this, 'ajax_add_layer_settings' ) );
		add_action( 'wp_ajax_sliderpro_load_settings_editor', array( $this, 'ajax_load_settings_editor' ) );
		add_action( 'wp_ajax_sliderpro_load_content_type_settings', array( $this, 'ajax_load_content_type_settings' ) );
		add_action( 'wp_ajax_sliderpro_add_breakpoint', array( $this, 'ajax_add_breakpoint' ) );
		add_action( 'wp_ajax_sliderpro_add_breakpoint_setting', array( $this, 'ajax_add_breakpoint_setting' ) );
		add_action( 'wp_ajax_sliderpro_get_taxonomies', array( $this, 'ajax_get_taxonomies' ) );
		add_action( 'wp_ajax_sliderpro_clear_all_cache', array( $this, 'ajax_clear_all_cache' ) );
		add_action( 'wp_ajax_sliderpro_close_getting_started', array( $this, 'ajax_close_getting_started' ) );
	}

	/**
	 * Return the current class instance.
	 *
	 * @since 4.0.0
	 * 
	 * @return object The instance of the current class.
	 */
	public static function get_instance() {
		if ( self::$instance == null ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Loads the admin CSS files.
	 *
	 * It loads the public and admin CSS, and also the public custom CSS.
	 *
	 * @since 4.0.0
	 */
	public function enqueue_admin_styles() {
		if ( ! isset( $this->plugin_screen_hook_suffixes ) ) {
			return;
		}

		$screen = get_current_screen();

		if ( in_array( $screen->id, $this->plugin_screen_hook_suffixes ) ) {
			if ( get_option( 'sliderpro_load_unminified_scripts' ) == true ) {
				wp_enqueue_style( $this->plugin_slug . '-admin-style', plugins_url( 'sliderpro/admin/assets/css/sliderpro-admin.css' ), array(), BQW_SliderPro::VERSION );
				wp_enqueue_style( $this->plugin_slug . '-plugin-style', plugins_url( 'sliderpro/public/assets/css/slider-pro.css' ), array(), BQW_SliderPro::VERSION );
			} else {
				wp_enqueue_style( $this->plugin_slug . '-admin-style', plugins_url( 'sliderpro/admin/assets/css/sliderpro-admin.min.css' ), array(), BQW_SliderPro::VERSION );
				wp_enqueue_style( $this->plugin_slug . '-plugin-style', plugins_url( 'sliderpro/public/assets/css/slider-pro.min.css' ), array(), BQW_SliderPro::VERSION );
			}

			wp_enqueue_style( $this->plugin_slug . '-lightbox-style', plugins_url( 'sliderpro/public/assets/libs/fancybox/jquery.fancybox.css' ), array(), BQW_SliderPro::VERSION );

			if ( get_option( 'sliderpro_is_custom_css') == true ) {
				if ( get_option( 'sliderpro_load_custom_css_js' ) === 'in_files' ) {
					global $blog_id;
					$file_suffix = '';

					if ( ! is_main_site( $blog_id ) ) {
						$file_suffix = '-' . $blog_id;
					}

					$custom_css_path = plugins_url( 'sliderpro-custom/custom' . $file_suffix . '.css' );
					$custom_css_dir_path = WP_PLUGIN_DIR . '/sliderpro-custom/custom' . $file_suffix . '.css';

					if ( file_exists( $custom_css_dir_path ) ) {
						wp_enqueue_style( $this->plugin_slug . '-plugin-custom-style', $custom_css_path, array(), BQW_SliderPro::VERSION );
					}
				} else {
					wp_add_inline_style( $this->plugin_slug . '-plugin-style', stripslashes( get_option( 'sliderpro_custom_css' ) ) );
				}
			}
		}
	}

	/**
	 * Loads the admin JS files.
	 *
	 * It loads the public and admin JS, and also the public custom JS.
	 * Also, it passes the PHP variables to the admin JS file.
	 *
	 * @since 4.0.0
	 */
	public function enqueue_admin_scripts() {
		if ( ! isset( $this->plugin_screen_hook_suffixes ) ) {
			return;
		}

		$screen = get_current_screen();

		if ( in_array( $screen->id, $this->plugin_screen_hook_suffixes ) ) {
			if ( function_exists( 'wp_enqueue_media' ) ) {
		    	wp_enqueue_media();
			}
			
			if ( get_option( 'sliderpro_load_unminified_scripts' ) == true ) {
				wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'sliderpro/admin/assets/js/sliderpro-admin.js' ), array( 'jquery' ), BQW_SliderPro::VERSION );
				wp_enqueue_script( $this->plugin_slug . '-plugin-script', plugins_url( 'sliderpro/public/assets/js/jquery.sliderPro.js' ), array( 'jquery' ), BQW_SliderPro::VERSION );
			} else {
				wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'sliderpro/admin/assets/js/sliderpro-admin.min.js' ), array( 'jquery' ), BQW_SliderPro::VERSION );
				wp_enqueue_script( $this->plugin_slug . '-plugin-script', plugins_url( 'sliderpro/public/assets/js/jquery.sliderPro.min.js' ), array( 'jquery' ), BQW_SliderPro::VERSION );
			}

			wp_enqueue_script( $this->plugin_slug . '-lightbox-script', plugins_url( 'sliderpro/public/assets/libs/fancybox/jquery.fancybox.pack.js' ), array(), BQW_SliderPro::VERSION );

			if ( get_option( 'sliderpro_is_custom_js' ) == true && get_option( 'sliderpro_load_custom_css_js' ) === 'in_files' ) {
				global $blog_id;
				$file_suffix = '';

				if ( ! is_main_site( $blog_id ) ) {
					$file_suffix = '-' . $blog_id;
				}

				$custom_js_path = plugins_url( 'sliderpro-custom/custom' . $file_suffix . '.js' );
				$custom_js_dir_path = WP_PLUGIN_DIR . '/sliderpro-custom/custom' . $file_suffix . '.js';

				if ( file_exists( $custom_js_dir_path ) ) {
					wp_enqueue_script( $this->plugin_slug . '-plugin-custom-script', $custom_js_path, array(), BQW_SliderPro::VERSION );
				}
			}

			$id = isset( $_GET['id'] ) ? $_GET['id'] : -1;

			wp_localize_script( $this->plugin_slug . '-admin-script', 'sp_js_vars', array(
				'admin' => admin_url( 'admin.php' ),
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'plugin' => plugins_url( 'sliderpro' ),
				'page' => isset( $_GET['page'] ) && ( $_GET['page'] === 'sliderpro-new' || ( isset( $_GET['id'] ) && isset( $_GET['action'] ) && $_GET['action'] === 'edit' ) ) ? 'single' : 'all',
				'id' => $id,
				'lad_nonce' => wp_create_nonce( 'load-slider-data' . $id ),
				'sa_nonce' => wp_create_nonce( 'save-slider' . $id ),
				'no_image' => __( 'Click to add image', 'sliderpro' ),
				'posts_slides' => __( 'Posts slides', 'sliderpro' ),
				'gallery_slides' => __( 'Gallery slides', 'sliderpro' ),
				'flickr_slides' => __( 'Flickr slides', 'sliderpro' ),
				'slider_delete' => __( 'Are you sure you want to delete this slider?', 'sliderpro' ),
				'slide_delete' => __( 'Are you sure you want to delete this slide?', 'sliderpro' ),
				'preset_name' => __( 'Preset Name:', 'sliderpro' ),
				'preset_update' => __( 'Are you sure you want to override the selected preset?', 'sliderpro' ),
				'preset_delete' => __( 'Are you sure you want to delete the selected preset?', 'sliderpro' ),
				'yes' => __( 'Yes', 'sliderpro' ),
				'cancel' => __( 'Cancel', 'sliderpro' ),
				'save' => __( 'Save', 'sliderpro' ),
				'slider_update' => __( 'Slider updated.', 'sliderpro' ),
				'slider_create' => __( 'Slider created.', 'sliderpro' )
			) );
		}
	}

	/**
	 * Create the plugin menu.
	 *
	 * @since 4.0.0
	 */
	public function add_admin_menu() {
		$plugin_settings = BQW_SliderPro_Settings::getPluginSettings();
		$access = get_option( 'sliderpro_access', $plugin_settings['access']['default_value'] );

		$restricted_pages = array();
		$restricted_pages = apply_filters( 'sliderpro_restricted_pages' , $restricted_pages );

		add_menu_page(
			'Slider Pro',
			'Slider Pro',
			$access,
			$this->plugin_slug,
			array( $this, 'render_slider_page' ),
			plugins_url( '/sliderpro/admin/assets/css/images/sp-icon.png' )
		);

		if ( ! in_array( $this->plugin_slug, $restricted_pages ) ) {
			$this->plugin_screen_hook_suffixes[] = add_submenu_page(
				$this->plugin_slug,
				__( 'Slider Pro', $this->plugin_slug ),
				__( 'All Sliders', $this->plugin_slug ),
				$access,
				$this->plugin_slug,
				array( $this, 'render_slider_page' )
			);
		}

		if ( ! in_array( $this->plugin_slug . '-new', $restricted_pages ) ) {
			$this->plugin_screen_hook_suffixes[] = add_submenu_page(
				$this->plugin_slug,
				__( 'Add New Slider', $this->plugin_slug ),
				__( 'Add New', $this->plugin_slug ),
				$access,
				$this->plugin_slug . '-new',
				array( $this, 'render_new_slider_page' )
			);
		}

		if ( ! in_array( $this->plugin_slug . '-custom', $restricted_pages ) ) {
			$this->plugin_screen_hook_suffixes[] = add_submenu_page(
				$this->plugin_slug,
				__( 'Custom CSS and JavaScript', $this->plugin_slug ),
				__( 'Custom CSS & JS', $this->plugin_slug ),
				$access,
				$this->plugin_slug . '-custom',
				array( $this, 'render_custom_css_js_page' )
			);
		}

		if ( ! in_array( $this->plugin_slug . '-settings', $restricted_pages ) ) {
			$this->plugin_screen_hook_suffixes[] = add_submenu_page(
				$this->plugin_slug,
				__( 'Plugin Settings', $this->plugin_slug ),
				__( 'Plugin Settings', $this->plugin_slug ),
				$access,
				$this->plugin_slug . '-settings',
				array( $this, 'render_plugin_settings_page' )
			);
		}

		if ( ! in_array( $this->plugin_slug . '-documentation', $restricted_pages ) ) {
			$this->plugin_screen_hook_suffixes[] = add_submenu_page(
				$this->plugin_slug,
				__( 'Documentation', $this->plugin_slug ),
				__( 'Documentation', $this->plugin_slug ),
				$access,
				$this->plugin_slug . '-documentation',
				array( $this, 'render_documentation_page' )
			);
		}
	}

	/**
	 * Renders the slider page.
	 *
	 * Based on the 'action' parameter, it will render
	 * either an individual slider page or the list
	 * of all the sliders.
	 *
	 * If an individual slider page is rendered, delete
	 * the transients that store the post names and posts data,
	 * in order to trigger a new fetching of them.
	 * 
	 * @since 4.0.0
	 */
	public function render_slider_page() {
		if ( isset( $_GET['id'] ) && isset( $_GET['action'] ) && $_GET['action'] === 'edit' ) {
			$slider = $this->plugin->get_slider( $_GET['id'] );

			if ( $slider !== false ) {
				$slider_id = $slider['id'];
				$slider_name = $slider['name'];
				$slider_settings = $slider['settings'];
				$slider_panels_state = $slider['panels_state'];

				$slides = isset( $slider['slides'] ) ? $slider['slides'] : false;

				delete_transient( 'sliderpro_post_names' );
				delete_transient( 'sliderpro_posts_data' );

				include_once( 'views/slider.php' );
			} else {
				include_once( 'views/sliders.php' );
			}
		} else {
			include_once( 'views/sliders.php' );
		}
	}

	/**
	 * Renders the page for a new slider.
	 *
	 * Also, delete the transients that store
	 * the post names and posts data,
	 * in order to trigger a new fetching of them.
	 * 
	 * @since 4.0.0
	 */
	public function render_new_slider_page() {
		$slider_name = 'My Slider';

		delete_transient( 'sliderpro_post_names' );
		delete_transient( 'sliderpro_posts_data' );

		include_once( 'views/slider.php' );
	}

	/**
	 * Renders the custom CSS and JavaScript page.
	 *
	 * It also checks if new data was posted, and saves
	 * it in the options table.
	 * 
	 * @since 4.0.0
	 */
	public function render_custom_css_js_page() {
		$custom_css = get_option( 'sliderpro_custom_css', '' );
		$custom_js = get_option( 'sliderpro_custom_js', '' );

		if ( isset( $_POST['custom_css_update'] ) || isset( $_POST['custom_js_update'] ) ) {
			check_admin_referer( 'custom-css-js-update', 'custom-css-js-nonce' );

			if ( isset( $_POST['custom_css'] ) ) {
				$custom_css = $_POST['custom_css'];
				update_option( 'sliderpro_custom_css', $custom_css );

				if ( $custom_css !== '' ) {
					update_option( 'sliderpro_is_custom_css', true );
				} else {
					update_option( 'sliderpro_is_custom_css', false );
				}
			}

			if ( isset( $_POST['custom_js'] ) ) {
				$custom_js = $_POST['custom_js'];
				update_option( 'sliderpro_custom_js', $custom_js );

				if ( $custom_js !== '' ) {
					update_option( 'sliderpro_is_custom_js', true );
				} else {
					update_option( 'sliderpro_is_custom_js', false );
				}
			}

			if ( get_option( 'sliderpro_load_custom_css_js' ) === 'in_files' ) {
				$this->save_custom_css_js_in_files( $custom_css, $custom_js );
			}
		}

		include_once( 'views/custom-css-js.php' );
	}

	/**
	 * Renders the plugin settings page.
	 *
	 * It also checks if new data was posted, and saves
	 * it in the options table.
	 *
	 * It verifies the purchase code supplied and displays
	 * if it's valid.
	 * 
	 * @since 4.0.0
	 */
	public function render_plugin_settings_page() {
		$plugin_settings = BQW_SliderPro_Settings::getPluginSettings();
		$load_stylesheets = get_option( 'sliderpro_load_stylesheets', $plugin_settings['load_stylesheets']['default_value'] );
		$load_custom_css_js = get_option( 'sliderpro_load_custom_css_js', $plugin_settings['load_custom_css_js']['default_value'] );
		$load_unminified_scripts = get_option( 'sliderpro_load_unminified_scripts', $plugin_settings['load_unminified_scripts']['default_value'] );
		$cache_expiry_interval = get_option( 'sliderpro_cache_expiry_interval', $plugin_settings['cache_expiry_interval']['default_value'] );
		$hide_inline_info = get_option( 'sliderpro_hide_inline_info', $plugin_settings['hide_inline_info']['default_value'] );
		$hide_getting_started_info = get_option( 'sliderpro_hide_getting_started_info', $plugin_settings['hide_getting_started_info']['default_value'] );
		$access = get_option( 'sliderpro_access', $plugin_settings['access']['default_value'] );

		if ( isset( $_POST['plugin_settings_update'] ) ) {
			check_admin_referer( 'plugin-settings-update', 'plugin-settings-nonce' );

			if ( isset( $_POST['load_stylesheets'] ) ) {
				$load_stylesheets = $_POST['load_stylesheets'];
				update_option( 'sliderpro_load_stylesheets', $load_stylesheets );
			}

			if ( isset( $_POST['load_custom_css_js'] ) ) {
				$load_custom_css_js = $_POST['load_custom_css_js'];
				update_option( 'sliderpro_load_custom_css_js', $load_custom_css_js );
			}

			if ( isset( $_POST['load_unminified_scripts'] ) ) {
				$load_unminified_scripts = true;
				update_option( 'sliderpro_load_unminified_scripts', true );
			} else {
				$load_unminified_scripts = false;
				update_option( 'sliderpro_load_unminified_scripts', false );
			}

			if ( isset( $_POST['cache_expiry_interval'] ) ) {
				$cache_expiry_interval = $_POST['cache_expiry_interval'];
				update_option( 'sliderpro_cache_expiry_interval', $cache_expiry_interval );
			}

			if ( isset( $_POST['hide_inline_info'] ) ) {
				$hide_inline_info = true;
				update_option( 'sliderpro_hide_inline_info', true );
			} else {
				$hide_inline_info = false;
				update_option( 'sliderpro_hide_inline_info', false );
			}

			if ( isset( $_POST['hide_getting_started_info'] ) ) {
				$hide_getting_started_info = true;
				update_option( 'sliderpro_hide_getting_started_info', true );
			} else {
				$hide_getting_started_info = false;
				update_option( 'sliderpro_hide_getting_started_info', false );
			}

			if ( isset( $_POST['access'] ) ) {
				$access = $_POST['access'];
				update_option( 'sliderpro_access', $access );
			}
		}

		$purchase_code = get_option( 'sliderpro_purchase_code', '' );
		$purchase_code_status = get_option( 'sliderpro_purchase_code_status', '0' );
		
		if ( isset( $_POST['purchase_code_update'] ) ) {
			check_admin_referer( 'purchase-code-update', 'purchase-code-nonce' );

			if ( isset( $_POST['purchase_code'] ) ) {
				$purchase_code = $_POST['purchase_code'];
				update_option( 'sliderpro_purchase_code', $purchase_code );

				if ( $_POST['purchase_code'] === '' ) {
					$purchase_code_status = '0';
				} else {
					$api = BQW_SliderPro_API::get_instance();

					$verification_result = $api->verify_purchase_code( $purchase_code );

					if ( $verification_result === 'yes' ) {
						$purchase_code_status = '1';
					} else if ( $verification_result === 'no' ) {
						$purchase_code_status = '2';
					} else if ( $verification_result === 'error' ) {
						$purchase_code_status = '3';
					}
				}

				update_option( 'sliderpro_purchase_code_status', $purchase_code_status );
			}
		}
		
		include_once( 'views/plugin-settings.php' );
	}

	/**
	 * Renders the documentation page.
	 * 
	 * @since 4.0.0
	 */
	public function render_documentation_page() {
		echo '<iframe class="sliderpro-documentation" src="' . plugins_url( 'sliderpro/documentation/documentation.html' ) . '" width="100%" height="100%"></iframe>';
	}

	/**
	 * Add the custom CSS and JS in files, using the WP Filesystem API.
	 *
	 * @since 4.0.0
	 * 
	 * @param  string $custom_css The custom CSS.
	 * @param  string $custom_js  The custom JavaScript.
	 */
	private function save_custom_css_js_in_files ( $custom_css, $custom_js ) {
		$url = wp_nonce_url( 'admin.php?page=sliderpro-custom', 'custom-css-js-update', 'custom-css-js-nonce' );
		$context = WP_PLUGIN_DIR;

		// get the credentials and if there aren't any credentials stored,
		// display a form for the user to provide the credentials
		if ( ( $credentials = request_filesystem_credentials( $url, '', false, $context, null ) ) === false  ) {			
			return;
		}

		// check the credentials if they are valid
		// if they aren't, display the form again
		if ( ! WP_Filesystem( $credentials, $context ) ) {
			request_filesystem_credentials( $url, '', true, $context, null );
			return;
		}

		global $wp_filesystem;

		// create the 'sliderpro-custom' folder if it doesn't exist
		if ( ! $wp_filesystem->exists( $context . '/sliderpro-custom' ) ) {
			$wp_filesystem->mkdir( $context . '/sliderpro-custom' );
		}

		global $blog_id;
		$file_suffix = '';

		if ( ! is_main_site( $blog_id ) ) {
			$file_suffix = '-' . $blog_id;
		}

		$wp_filesystem->put_contents( $context . '/sliderpro-custom/custom' . $file_suffix . '.css', stripslashes( $custom_css ), FS_CHMOD_FILE );
		$wp_filesystem->put_contents( $context . '/sliderpro-custom/custom' . $file_suffix . '.js', stripslashes( $custom_js ), FS_CHMOD_FILE );
	}

	/**
	 * AJAX call for getting the slider's data.
	 *
	 * @since 4.0.0
	 * 
	 * @return string The slider data, as JSON-encoded array.
	 */
	public function ajax_get_slider_data() {
		$nonce = $_GET['nonce'];
		$id = $_GET['id'];

		if ( ! wp_verify_nonce( $nonce, 'load-slider-data' . $id ) ) {
			die( 'This action was stopped for security purposes.' );
		}

		$slider = $this->get_slider_data( $_GET['id'] );

		echo json_encode( $slider );

		die();
	}

	/**
	 * Return the slider's data.
	 *
	 * @since 4.0.0
	 * 
	 * @param  int   $id The id of the slider.
	 * @return array     The slider data.
	 */
	public function get_slider_data( $id ) {
		return $this->plugin->get_slider( $id );
	}

	/**
	 * AJAX call for saving the slider.
	 *
	 * It can be called when the slider is created, updated
	 * or when a slider is imported. If the slider is 
	 * imported, it returns a row in the list of sliders.
	 *
	 * @since 4.0.0
	 */
	public function ajax_save_slider() {
		$slider_data = json_decode( stripslashes( $_POST['data'] ), true );
		$nonce = $slider_data['nonce'];
		$id = intval( $slider_data['id'] );
		$action = $slider_data['action'];

		if ( ! wp_verify_nonce( $nonce, 'save-slider' . $id ) ) {
			die( 'This action was stopped for security purposes.' );
		}

		$slider_id = $this->save_slider( $slider_data );

		if ( $action === 'save' ) {
			echo $slider_id;
		} else if ( $action === 'import' ) {
			$slider_name = $slider_data['name'];
			$slider_created = date( 'm-d-Y' );
			$slider_modified = date( 'm-d-Y' );

			include( 'views/sliders-row.php' );
		}

		die();
	}

	/**
	 * Save the slider.
	 *
	 * It either creates a new slider or updates and existing one.
	 *
	 * For existing sliders, the slides and layers are deleted and 
	 * re-inserted in the database.
	 *
	 * The cached slider is deleted every time the slider is saved.
	 *
	 * @since 4.0.0
	 * 
	 * @param  array $slider_data The data of the slider that's saved.
	 * @return int                The id of the saved slider.
	 */
	public function save_slider( $slider_data ) {
		global $wpdb;

		$id = intval( $slider_data['id'] );
		$slides_data = $slider_data['slides'];

		if ( $id === -1 ) {
			$wpdb->insert($wpdb->prefix . 'slider_pro_sliders', array( 'name' => $slider_data['name'],
																		'settings' => json_encode( $slider_data['settings'] ),
																		'created' => date( 'm-d-Y' ),
																		'modified' => date( 'm-d-Y' ),
																		'panels_state' => json_encode( $slider_data['panels_state'] ) ), 
																		array( '%s', '%s', '%s', '%s', '%s' ) );
			
			$id = $wpdb->insert_id;
		} else {
			$wpdb->update( $wpdb->prefix . 'slider_pro_sliders', array( 'name' => $slider_data['name'], 
																	 	'settings' => json_encode( $slider_data['settings'] ),
																	 	'modified' => date( 'm-d-Y' ),
																		'panels_state' => json_encode( $slider_data['panels_state'] ) ), 
																	   	array( 'id' => $id ), 
																	   	array( '%s', '%s', '%s', '%s' ), 
																	   	array( '%d' ) );
				
			$wpdb->query( $wpdb->prepare( "DELETE FROM " . $wpdb->prefix . "slider_pro_slides WHERE slider_id = %d", $id ) );

			$wpdb->query( $wpdb->prepare( "DELETE FROM " . $wpdb->prefix . "slider_pro_slides WHERE slider_id = %d", $id ) );
		}

		foreach ( $slides_data as $slide_data ) {
			$slide = array('slider_id' => $id,
							'label' => isset( $slide_data['label'] ) ? $slide_data['label'] : '',
							'position' => isset( $slide_data['position'] ) ? $slide_data['position'] : '',
							'visibility' => isset( $slide_data['visibility'] ) ? $slide_data['visibility'] : '',
							'main_image_id' => isset( $slide_data['main_image_id'] ) ? $slide_data['main_image_id'] : '',
							'main_image_source' => isset( $slide_data['main_image_source'] ) ? $slide_data['main_image_source'] : '',
							'main_image_retina_source' => isset( $slide_data['main_image_retina_source'] ) ? $slide_data['main_image_retina_source'] : '',
							'main_image_small_source' => isset( $slide_data['main_image_small_source'] ) ? $slide_data['main_image_small_source'] : '',
							'main_image_medium_source' => isset( $slide_data['main_image_medium_source'] ) ? $slide_data['main_image_medium_source'] : '',
							'main_image_large_source' => isset( $slide_data['main_image_large_source'] ) ? $slide_data['main_image_large_source'] : '',
							'main_image_retina_small_source' => isset( $slide_data['main_image_retina_small_source'] ) ? $slide_data['main_image_retina_small_source'] : '',
							'main_image_retina_medium_source' => isset( $slide_data['main_image_retina_medium_source'] ) ? $slide_data['main_image_retina_medium_source'] : '',
							'main_image_retina_large_source' => isset( $slide_data['main_image_retina_large_source'] ) ? $slide_data['main_image_retina_large_source'] : '',
							'main_image_alt' => isset( $slide_data['main_image_alt'] ) ? $slide_data['main_image_alt'] : '',
							'main_image_title' => isset( $slide_data['main_image_title'] ) ? $slide_data['main_image_title'] : '',
							'main_image_width' => isset( $slide_data['main_image_width'] ) ? $slide_data['main_image_width'] : '',
							'main_image_height' => isset( $slide_data['main_image_height'] ) ? $slide_data['main_image_height'] : '',
							'main_image_link' => isset( $slide_data['main_image_link'] ) ? $slide_data['main_image_link'] : '',
							'main_image_link_title' => isset( $slide_data['main_image_link_title'] ) ? $slide_data['main_image_link_title'] : '',
							'thumbnail_source' => isset( $slide_data['thumbnail_source'] ) ? $slide_data['thumbnail_source'] : '',
							'thumbnail_retina_source' => isset( $slide_data['thumbnail_retina_source'] ) ? $slide_data['thumbnail_retina_source'] : '',
							'thumbnail_alt' => isset( $slide_data['thumbnail_alt'] ) ? $slide_data['thumbnail_alt'] : '',
							'thumbnail_title' => isset( $slide_data['thumbnail_title'] ) ? $slide_data['thumbnail_title'] : '',
							'thumbnail_link' => isset( $slide_data['thumbnail_link'] ) ? $slide_data['thumbnail_link'] : '',
							'thumbnail_link_title' => isset( $slide_data['thumbnail_link_title'] ) ? $slide_data['thumbnail_link_title'] : '',
							'thumbnail_content' => isset( $slide_data['thumbnail_content'] ) ? $slide_data['thumbnail_content'] : '',
							'caption' => isset( $slide_data['caption'] ) ? $slide_data['caption'] : '',
							'html' => isset( $slide_data['html'] ) ? $slide_data['html'] : '',
							'settings' => isset( $slide_data['settings'] ) ? json_encode( $slide_data['settings'] ) : '');

			$wpdb->insert( $wpdb->prefix . 'slider_pro_slides', $slide, array( '%d', '%s', '%d', '%s', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' ) );

			if ( ! empty( $slide_data[ 'layers' ] ) ) {
				$slide_id = $wpdb->insert_id;
				$layers_data = $slide_data[ 'layers' ];

				foreach ( $layers_data as $layer_data ) {
					$layer = array('slider_id' => $id,
									'slide_id' => $slide_id,
									'position' => isset( $layer_data['position'] ) ? $layer_data['position'] : 0,
									'name' => isset( $layer_data['name'] ) ? $layer_data['name'] : '',
									'type' => isset( $layer_data['type'] ) ? $layer_data['type'] : '',
									'text' => isset( $layer_data['text'] ) ? $layer_data['text'] : '',
									'heading_type' => isset( $layer_data['heading_type'] ) ? $layer_data['heading_type'] : '',
									'image_source' => isset( $layer_data['image_source'] ) ? $layer_data['image_source'] : '',
									'image_alt' => isset( $layer_data['image_alt'] ) ? $layer_data['image_alt'] : '',
									'image_link' => isset( $layer_data['image_link'] ) ? $layer_data['image_link'] : '',
									'image_retina' => isset( $layer_data['image_retina'] ) ? $layer_data['image_retina'] : '',
									'video_source' => isset( $layer_data['video_source'] ) ? $layer_data['video_source'] : '',
									'video_id' => isset( $layer_data['video_id'] ) ? $layer_data['video_id'] : '',
									'video_poster' => isset( $layer_data['video_poster'] ) ? $layer_data['video_poster'] : '',
									'video_retina_poster' => isset( $layer_data['video_retina_poster'] ) ? $layer_data['video_retina_poster'] : '',
									'video_load_mode' => isset( $layer_data['video_load_mode'] ) ? $layer_data['video_load_mode'] : '',
									'video_params' => isset( $layer_data['video_params'] ) ? $layer_data['video_params'] : '',
									'settings' =>  isset( $layer_data['settings'] ) ? json_encode( $layer_data['settings'] ) : ''
									);

					$wpdb->insert( $wpdb->prefix . 'slider_pro_layers', $layer, array( '%d', '%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' ) );
				}
			}
		}
		
		delete_transient( 'sliderpro_cache_' . $id );

		return $id;
	}

	/**
	 * AJAX call for previewing the slider.
	 *
	 * Receives the current data from the database (in the sliders page)
	 * or from the current settings (in the slider page) and prints the
	 * HTML markup and the inline JavaScript for the slider.
	 *
	 * @since 4.0.0
	 */
	public function ajax_preview_slider() {
		$slider = json_decode( stripslashes( $_POST['data'] ), true );
		$slider_name = $slider['name'];
		$slider_output = $this->plugin->output_slider( $slider, false ) . $this->plugin->get_inline_scripts();

		echo $slider_output;

		die();	
	}

	/**
	 * AJAX call for updating the setting presets.
	 *
	 * @since 4.0.0
	 */
	public function ajax_update_presets() {
		$nonce = $_POST['nonce'];
		$method = $_POST['method'];
		$name = $_POST['name'];
		$settings = $_POST['settings'];

		if ( ! wp_verify_nonce( $nonce, 'update-presets' ) ) {
			die( 'This action was stopped for security purposes.' );
		}

		$presets = get_option( 'sliderpro_setting_presets' );

		if ( $presets === false ) {
			$presets = array();
		}

		if ( $method === 'save-new' || $method === 'update' ) {
			$presets[ $name ] = json_decode( stripslashes( $settings ), true );
		} else if ( $method === 'delete' ) {
			unset( $presets[ $name ] );
		}

		update_option( 'sliderpro_setting_presets', $presets );

		die();
	}

	/**
	 * AJAX call for retrieving the preset settings.
	 *
	 * @since 4.0.0
	 */
	public function ajax_get_preset_settings() {
		$name = $_GET['name'];

		$presets = get_option( 'sliderpro_setting_presets' );

		if ( isset( $presets[ $name ] ) ) {
			echo json_encode( $presets[ $name ] );
		}

		die();
	}

	/**
	 * AJAX call for retrieving the preset settings.
	 *
	 * @since 4.0.0
	 */
	public function ajax_get_breakpoints_preset() {
		$breakpoints_data = json_decode( stripslashes( $_GET['data'] ), true );

		foreach ( $breakpoints_data as $breakpoint_settings ) {
			include( 'views/breakpoint.php' );
		}

		die();
	}

	/**
	 * AJAX call for duplicating a slider.
	 *
	 * Loads a slider from the database and re-saves it with an id of -1, 
	 * which will determine the save function to add a new slider in the 
	 * database.
	 *
	 * It returns a new slider row in the list of all sliders.
	 *
	 * @since 4.0.0
	 */
	public function ajax_duplicate_slider() {
		$nonce = $_POST['nonce'];
		$original_slider_id = $_POST['id'];

		if ( ! wp_verify_nonce( $nonce, 'duplicate-slider' . $original_slider_id ) ) {
			die( 'This action was stopped for security purposes.' );
		}

		if ( ( $original_slider = $this->plugin->get_slider( $original_slider_id ) ) !== false ) {
			$original_slider['id'] = -1;
			$slider_id = $this->save_slider( $original_slider );
			$slider_name = $original_slider['name'];
			$slider_created = date( 'm-d-Y' );
			$slider_modified = date( 'm-d-Y' );

			include( 'views/sliders-row.php' );
		}

		die();
	}

	/**
	 * AJAX call for deleting a slider.
	 *
	 * It's called from the list of sliders, when the
	 * 'Delete' link is clicked.
	 *
	 * It calls the 'delete_slider()' method and passes
	 * it the id of the slider to be deleted.
	 *
	 * @since 4.0.0
	 */
	public function ajax_delete_slider() {
		$nonce = $_POST['nonce'];
		$id = intval( $_POST['id'] );

		if ( ! wp_verify_nonce( $nonce, 'delete-slider' . $id ) ) {
			die( 'This action was stopped for security purposes.' );
		}

		echo $this->delete_slider( $id ); 

		die();
	}

	/**
	 * Delete the slider indicated by the id.
	 *
	 * @since 4.0.0
	 * 
	 * @param  int $id The id of the slider to be deleted.
	 * @return int     The id of the slider that was deleted.
	 */
	public function delete_slider( $id ) {
		global $wpdb;

		$wpdb->query( $wpdb->prepare( "DELETE FROM " . $wpdb->prefix . "slider_pro_slides WHERE slider_id = %d", $id ) );

		$wpdb->query( $wpdb->prepare( "DELETE FROM " . $wpdb->prefix . "slider_pro_sliders WHERE id = %d", $id ) );

		return $id;
	}

	/**
	 * AJAX call for exporting a slider.
	 *
	 * It loads a slider from the database and encodes 
	 * its data as JSON, after removing the id of the slider.
	 *
	 * The JSON string created is presented in a modal window.
	 *
	 * @since 4.0.0
	 */
	public function ajax_export_slider() {
		$nonce = $_POST['nonce'];
		$id = intval( $_POST['id'] );

		if ( ! wp_verify_nonce( $nonce, 'export-slider' . $id ) ) {
			die( 'This action was stopped for security purposes.' );
		}

		$slider = $this->plugin->get_slider( $id );

		if ( $slider !== false ) {
			unset( $slider['id'] );
			$export_string = json_encode( $slider );

			include( 'views/export-window.php' );
		}

		die();
	}

	/**
	 * AJAX call for displaying the modal window
	 * for importing a slider.
	 *
	 * @since 4.0.0
	 */
	public function ajax_import_slider() {
		include( 'views/import-window.php' );

		die();
	}

	/**
	 * Create a slide from the passed data.
	 *
	 * Receives some data, like the main image, or
	 * the slide's content type. A new slide is created by 
	 * passing 'false' instead of any data.
	 *
	 * @since 4.0.0
	 * 
	 * @param  array|bool $data The data of the slide or false, if the slide is new.
	 */
	public function create_slide( $data ) {
		$slide_default_settings = BQW_SliderPro_Settings::getSlideSettings();

		$slide_type = $slide_default_settings['content_type']['default_value'];
		$slide_image = '';

		if ( $data !== false ) {
			$slide_type = isset( $data['settings'] ) && isset( $data['settings']['content_type'] ) ? $data['settings']['content_type'] : $slide_type;
			$slide_image = isset( $data['main_image_source'] ) ? $data['main_image_source'] : $slide_image;
		}

		include( 'views/slide.php' );
	}
	
	/**
	 * AJAX call for adding multiple or a single slide.
	 *
	 * If it receives any data, it tries to create multiple
	 * slides by padding the data that was received, and if
	 * it doesn't receive any data it tries to create a
	 * single slide.
	 *
	 * @since 4.0.0
	 */
	public function ajax_add_slides() {
		if ( isset( $_POST['data'] ) ) {
			$slides_data = json_decode( stripslashes( $_POST['data'] ), true );

			foreach ( $slides_data as $slide_data ) {
				$this->create_slide( $slide_data );
			}
		} else {
			$this->create_slide( false );
		}

		die();
	}

	/**
	 * AJAX call for displaying the main image editor.
	 *
	 * The aspect of the editor will depend on the slide's
	 * content type. Dynamic slides will not have the possibility
	 * to load images from the library.
	 *
	 * @since 4.0.0
	 */
	public function ajax_load_main_image_editor() {
		$slide_default_settings = BQW_SliderPro_Settings::getSlideSettings();

		$data = json_decode( stripslashes( $_POST['data'] ), true );
		$content_type = isset( $_POST['content_type'] ) ? $_POST['content_type'] : $slide_default_settings['content_type']['default_value'];
		$content_class = $content_type === 'custom' ? 'custom' : 'dynamic';

		include( 'views/main-image-editor.php' );

		die();
	}

	/**
	 * AJAX call for displaying the thumbnail editor.
	 *
	 * The aspect of the editor will depend on the slide's
	 * content type. Dynamic slides will not have the possibility
	 * to load images from the library.
	 *
	 * @since 4.0.0
	 */
	public function ajax_load_thumbnail_editor() {
		$slide_default_settings = BQW_SliderPro_Settings::getSlideSettings();

		$data = json_decode( stripslashes( $_POST['data'] ), true );
		$content_type = isset( $_POST['content_type'] ) ? $_POST['content_type'] : $slide_default_settings['content_type']['default_value'];
		$content_class = $content_type === 'custom' ? 'custom' : 'dynamic';

		include( 'views/thumbnail-editor.php' );

		die();
	}

	/**
	 * AJAX call for displaying the Caption editor.
	 *
	 * @since 4.0.0
	 */
	public function ajax_load_caption_editor() {
		$slide_default_settings = BQW_SliderPro_Settings::getSlideSettings();

		$caption_content = $_POST['data'];
		$content_type = isset( $_POST['content_type'] ) ? $_POST['content_type'] : $slide_default_settings['content_type']['default_value'];

		include( 'views/caption-editor.php' );

		die();
	}

	/**
	 * AJAX call for displaying the inline HTML editor.
	 *
	 * @since 4.0.0
	 */
	public function ajax_load_html_editor() {
		$slide_default_settings = BQW_SliderPro_Settings::getSlideSettings();

		$html_content = $_POST['data'];
		$content_type = isset( $_POST['content_type'] ) ? $_POST['content_type'] : $slide_default_settings['content_type']['default_value'];

		include( 'views/html-editor.php' );

		die();
	}

	/**
	 * AJAX call for displaying the layers editor.
	 *
	 * @since 4.0.0
	 */
	public function ajax_load_layers_editor() {
		$slide_default_settings = BQW_SliderPro_Settings::getSlideSettings();
		$layer_default_settings = BQW_SliderPro_Settings::getLayerSettings();

		$layers = json_decode( stripslashes( $_POST['data'] ), true );
		$content_type = isset( $_POST['content_type'] ) ? $_POST['content_type'] : $slide_default_settings['content_type']['default_value'];
		
		include( 'views/layers-editor.php' );

		die();
	}

	/**
	 * AJAX call for adding a new block of layer settings
	 *
	 * It receives the id and type of the layer, and creates 
	 * the appropriate setting fields.
	 *
	 * @since 4.0.0
	 */
	public function ajax_add_layer_settings() {
		$layer = array();
		$layer_id = $_POST['id'];
		$layer_type = $_POST['type'];
		$layer_settings;

		if ( isset( $_POST['settings'] ) ) {
			$layer_settings = json_decode( stripslashes( $_POST['settings'] ), true );
		}

		if ( isset( $_POST['text'] ) ) {
			$layer['text'] = $_POST['text'];
		}

		if ( isset( $_POST['heading_type'] ) ) {
			$layer['heading_type'] = $_POST['heading_type'];
		}

		if ( isset( $_POST['image_source'] ) ) {
			$layer['image_source'] = $_POST['image_source'];
		}

		if ( isset( $_POST['image_alt'] ) ) {
			$layer['image_alt'] = $_POST['image_alt'];
		}

		if ( isset( $_POST['image_link'] ) ) {
			$layer['image_link'] = $_POST['image_link'];
		}

		if ( isset( $_POST['image_retina'] ) ) {
			$layer['image_retina'] = $_POST['image_retina'];
		}

		$layer_default_settings = BQW_SliderPro_Settings::getLayerSettings();

		include( 'views/layer-settings.php' );

		die();
	}

	/**
	 * AJAX call for displaying the slide's settings editor.
	 *
	 * @since 4.0.0
	 */
	public function ajax_load_settings_editor() {
		$slide_settings = json_decode( stripslashes( $_POST['data'] ), true );

		$slide_default_settings = BQW_SliderPro_Settings::getSlideSettings();

		$content_type = isset( $slide_settings['content_type'] ) ? $slide_settings['content_type'] : $slide_default_settings['content_type']['default_value'];

		include( 'views/settings-editor.php' );

		die();
	}

	/**
	 * AJAX call for displaying the setting fields associated 
	 * with the current content type of the slide.
	 *
	 * It's called when the content type is changed manually 
	 * in the slide's settings window
	 *
	 * @since 4.0.0
	 */
	public function ajax_load_content_type_settings() {
		$type = $_POST['type'];
		$slide_settings = json_decode( stripslashes( $_POST['data'] ), true );

		echo $this->load_content_type_settings( $type, $slide_settings );

		die();
	}

	/**
	 * Return the setting fields associated with the content type.
	 *
	 * If the content type is set to 'posts', the names of the
	 * registered post types will be loaded.
	 *
	 * @since 4.0.0
	 * 
	 * @param  string $type           The slide's content type.
	 * @param  array  $slide_settings The slide's settings.
	 */
	public function load_content_type_settings( $type, $slide_settings = NULL ) {
		$slide_default_settings = BQW_SliderPro_Settings::getSlideSettings();

		if ( $type === 'posts' ) {
			$post_names = $this->get_post_names();

			include( 'views/posts-slide-settings.php' );
		} else if ( $type === 'gallery' ) {
			include( 'views/gallery-slide-settings.php' );
		} else if ( $type === 'flickr' ) {
			include( 'views/flickr-slide-settings.php' );
		} else {
			include( 'views/custom-slide-settings.php' );
		}
	}

	/**
	 * Return the names of all registered post types
	 *
	 * It arranges the data in an associative array that contains
	 * the name of the post type as the key and and an array, containing 
	 * both the post name and post value, as the value:
	 *
	 * name => ( name, label )
	 *
	 * After the data is fetched, it is stored in a transient for 5 minutes.
	 * Before fetching the data, the function tries to get the data
	 * from the transient.
	 *
	 * @since 4.0.0
	 * 
	 * @return array The list of names for the registered post types.
	 */
	public function get_post_names() {
		$result = array();
		$post_names_transient = get_transient( 'sliderpro_post_names' );

		if ( $post_names_transient === false ) {
			$post_types = get_post_types( '', 'objects' );

			unset( $post_types['attachment'] );
			unset( $post_types['revision'] );
			unset( $post_types['nav_menu_item'] );

			foreach ( $post_types as $post_type ) {
				$result[ $post_type->name ] = array( 'name' => $post_type->name , 'label' => $post_type->label );
			}

			set_transient( 'sliderpro_post_names', $result, 5 * 60 );
		} else {
			$result = $post_names_transient;
		}

		return $result;
	}

	/**
	 * AJAX call for getting the registered taxonomies.
	 *
	 * It's called when the post names are selected manually
	 * in the slide's settings window.
	 *
	 * @since 4.0.0
	 */
	public function ajax_get_taxonomies() {
		$post_names = json_decode( stripslashes( $_GET['post_names'] ), true );

		echo json_encode( $this->get_taxonomies_for_posts( $post_names ) );

		die();
	}

	/**
	 * Loads the taxonomies associated with the selected post names.
	 *
	 * It tries to find cached data for post names and their taxonomies,
	 * stored in the 'sliderpro_posts_data' transient. If there is any
	 * cached data and if selected post names are in the cached data, those
	 * post names and their taxonomy data are added to the result. Post names 
	 * that are not found in the transient are added to the list of posts to load.
	 * After these posts are loaded, the transient is updated to include the
	 * newly loaded post names, and their taxonomy data.
	 *
	 * While the transient will contain all the post names and taxonomies
	 * loaded in the past and those requested now, the result will include
	 * only post names and taxonomies requested now.
	 *
	 * @since 4.0.0
	 * 
	 * @param  array $post_names The array of selected post names.
	 * @return array             The array of selected post names and their taxonomies.
	 */
	public function get_taxonomies_for_posts( $post_names ) {
		$result = array();
		$posts_to_load = array();

		$posts_data_transient = get_transient( 'sliderpro_posts_data' );

		if ( $posts_data_transient === false || empty( $posts_data_transient ) === true ) {
			$posts_to_load = $post_names;
			$posts_data_transient = array();
		} else {
			foreach ( $post_names as $post_name ) {
				if ( array_key_exists( $post_name, $posts_data_transient ) === true ) {
					$result[ $post_name ] = $posts_data_transient[ $post_name ];
				} else {
					array_push( $posts_to_load, $post_name );
				}
			}
		}

		foreach ( $posts_to_load as $post_name ) {
			$taxonomies = get_object_taxonomies( $post_name, 'objects' );

			$result[ $post_name ] = array();

			foreach ( $taxonomies as $taxonomy ) {
				$terms = get_terms( $taxonomy->name, 'objects' );

				if ( ! empty( $terms ) ) {
					$result[ $post_name ][ $taxonomy->name ] = array(
						'name' => $taxonomy->name,
						'label' => $taxonomy->label,
						'terms' => array()
					);

					foreach ( $terms as $term ) {
						$result[ $post_name ][ $taxonomy->name ]['terms'][ $term->name ] = array(
							'name' => $term->name,
							'slug' => $term->slug,
							'full' => $taxonomy->name . '|' . $term->slug
						);
					}
				}
			}

			$posts_data_transient[ $post_name ] = $result[ $post_name ];
		}

		set_transient( 'sliderpro_posts_data', $posts_data_transient, 5 * 60 );
		
		return $result;
	}

	/**
	 * AJAX call for adding a new breakpoint section.
	 *
	 * @since 4.0.0
	 */
	public function ajax_add_breakpoint() {
		$width = $_GET['data'];

		include( 'views/breakpoint.php' );

		die();
	}

	/**
	 * AJAX call for adding a new breakpoint setting.
	 *
	 * @since 4.0.0
	 */
	public function ajax_add_breakpoint_setting() {
		$setting_name = $_GET['data'];

		echo $this->create_breakpoint_setting( $setting_name, false );

		die();
	}

	/**
	 * Return the HTML markup for the breakpoint setting.
	 *
	 * Generates a unique number that will be attributed to
	 * the label and to the input/select field.
	 *
	 * @since 4.0.0
	 * 
	 * @param  string $name  The name of the setting.
	 * @param  mixed  $value The value of the setting. If false, the default setting value will be assigned.
	 * @return string        The HTML markup for the setting.
	 */
	public function create_breakpoint_setting( $name, $value ) {
		$setting = BQW_SliderPro_Settings::getSettings( $name );
		$setting_value = $value !== false ? $value : $setting['default_value'];
		$setting_html = '';
		$uid = mt_rand();

		if ( $setting['type'] === 'number' || $setting['type'] === 'mixed' ) {
            $setting_html = '
            	<tr>
            		<td>
            			<label data-info="' . $setting['description'] . '" for="breakpoint-' . $name . '-' . $uid . '">' . $setting['label'] . '</label>
            		</td>
            		<td class="setting-cell">
            			<input id="breakpoint-' . $name . '-' . $uid . '" class="breakpoint-setting" type="text" name="' . $name . '" value="' . esc_attr( $setting_value ) . '" />
            			<span class="remove-breakpoint-setting"></span>
            		</td>
            	</tr>';
        } else if ( $setting['type'] === 'boolean' ) {
            $setting_html = '
            	<tr>
            		<td>
            			<label data-info="' . $setting['description'] . '" for="breakpoint-' . $name . '-' . $uid . '">' . $setting['label'] . '</label>
            		</td>
            		<td class="setting-cell">
            			<input id="breakpoint-' . $name . '-' . $uid . '" class="breakpoint-setting" type="checkbox" name="' . $name . '"' . ( $setting_value === true ? ' checked="checked"' : '' ) . ' />
            			<span class="remove-breakpoint-setting"></span>
            		</td>
            	</tr>';
        } else if ( $setting['type'] === 'select' ) {
            $setting_html ='
            	<tr>
            		<td>
            			<label data-info="' . $setting['description'] . '" for="breakpoint-' . $name . '-' . $uid . '">' . $setting['label'] . '</label>
            		</td>
            		<td class="setting-cell">
            			<select id="breakpoint-' . $name . '-' . $uid . '" class="breakpoint-setting" name="' . $name . '">';
            
            foreach ( $setting['available_values'] as $value_name => $value_label ) {
                $setting_html .= '<option value="' . $value_name . '"' . ( $setting_value == $value_name ? ' selected="selected"' : '' ) . '>' . $value_label . '</option>';
            }
            
            $setting_html .= '
            			</select>
            			<span class="remove-breakpoint-setting"></span>
            		</td>
            	</tr>';
        }

        return $setting_html;
	}

	/**
	 * AJAX call for deleting the cached sliders
	 * stored using transients.
	 *
	 * It's called from the Plugin Settings page.
	 *
	 * @since 4.0.0
	 */
	public function ajax_clear_all_cache() {
		$nonce = $_POST['nonce'];

		if ( ! wp_verify_nonce( $nonce, 'clear-all-cache' ) ) {
			die( 'This action was stopped for security purposes.' );
		}

		global $wpdb;

		$wpdb->query( "DELETE FROM " . $wpdb->prefix . "options WHERE option_name LIKE '%sliderpro_cache%'" );

		echo true;

		die();
	}

	/**
	 * AJAX call for closing the Getting Started info box.
	 *
	 * @since 4.0.0
	 */
	public function ajax_close_getting_started() {
		update_option( 'sliderpro_hide_getting_started_info', true );

		die();
	}
}