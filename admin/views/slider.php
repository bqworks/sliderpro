<div class="wrap sliderpro-admin">
	<h2><?php echo isset( $_GET['action'] ) && $_GET['action'] === 'edit' ? __( 'Edit Slider', 'sliderpro' ) : __( 'Add New Slider', 'sliderpro' ); ?></h2>

	<form action="" method="post">
    	<div class="metabox-holder has-right-sidebar">
            <div class="editor-wrapper">
                <div class="editor-body">
                    <div id="titlediv">
                    	<input name="name" id="title" type="text" value="<?php echo esc_attr( $slider_name ); ?>" />
                    </div>
					
					<div class="slides-container">
                    	<?php
                    		if ( isset( $slides ) ) {
                    			if ( $slides !== false ) {
                    				foreach ( $slides as $slide ) {
                    					$this->create_slide( $slide );
                    				}
                    			}
                    		} else {
                    			$this->create_slide( false );
                    		}
	                    ?>
                    </div>

                    <div class="add-slide-group">
                        <a class="button add-slide" href="#"><?php _e( 'Add Slides', 'sliderpro' ); ?> <span class="add-slide-arrow">&#9660</span></a>
                        <ul class="slide-type">
                            <li><a href="#" data-type="image"><?php _e( 'Image Slides', 'sliderpro' ); ?></a></li>
                            <li><a href="#" data-type="posts"><?php _e( 'Posts Slides', 'sliderpro' ); ?></a></li>
                            <li><a href="#" data-type="gallery"><?php _e( 'Gallery Slides', 'sliderpro' ); ?></a></li>
                            <li><a href="#" data-type="flickr"><?php _e( 'Flickr Slides', 'sliderpro' ); ?></a></li>
                            <li><a href="#" data-type="empty"><?php _e( 'Empty Slide', 'sliderpro' ); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="inner-sidebar meta-box-sortables ui-sortable">
				<div class="postbox action">
					<div class="inside">
						<input type="submit" name="submit" class="button-primary" value="<?php echo isset( $_GET['action'] ) && $_GET['action'] === 'edit' ? __( 'Update', 'sliderpro' ) : __( 'Create', 'sliderpro' ); ?>" />
                        <span class="spinner update-spinner"></span>
						<a class="button preview-slider" href="#"><?php _e( 'Preview', 'sliderpro' ); ?></a>
                        <span class="spinner preview-spinner"></span>
					</div>
				</div>
                
                <div class="sidebar-settings">
                    <?php
                        $setting_groups = BQW_SliderPro_Settings::getSettingGroups();
                        $panels_state = BQW_SliderPro_Settings::getPanelsState();
                    ?>

                    <?php $panel_class = isset( $slider_panels_state ) && isset( $slider_panels_state['presets'] ) ? $slider_panels_state['presets'] : $panels_state['presets']; ?>
                    <div class="postbox <?php echo $panel_class; ?>" data-name="presets">
                        <div class="handlediv"></div>
                        <h3 class="hndle"><?php _e( 'Presets', 'sliderpro' ); ?></h3>
                        <div class="inside">
                            <?php
                                $presets = get_option( 'sliderpro_setting_presets' );

                                if ( $presets === false || empty( $presets ) ) {
                                    $presets = array( 'Default' => array() );
                                    $default_settings = BQW_SliderPro_Settings::getSettings();

                                    foreach ( $default_settings as $key => $value ) {
                                        $presets[ 'Default' ][ $key ] = $value[ 'default_value' ];
                                    }

                                    update_option( 'sliderpro_setting_presets', $presets );
                                }

                                echo '<label for="slider-setting-presets">' . __( 'Saved Presets', 'sliderpro' ) . '</label>';
                                echo '<select id="slider-setting-presets" name="slider-setting-presets" class="slider-setting-presets">';

                                foreach ( $presets as $preset_name => $preset_settings ) {
                                    echo '<option value="' . $preset_name . '"' . '>' . $preset_name . '</option>';
                                }

                                echo '</select>';

                                $update_presets_nonce = wp_create_nonce( 'update-presets' );

                                $save_new_preset_url = admin_url( 'admin.php?page=sliderpro&action=update-presets&method=save-new' ) . '&up_nonce=' . $update_presets_nonce;
                                $update_preset_url = admin_url( 'admin.php?page=sliderpro&action=update-presets&method=update' ) . '&up_nonce=' . $update_presets_nonce;
                                $delete_preset_url = admin_url( 'admin.php?page=sliderpro&action=update-presets&method=delete' ) . '&up_nonce=' . $update_presets_nonce;

                                echo '<a href="' . $save_new_preset_url . '" class="button update-presets">' . __( 'Save New', 'sliderpro' ) . '</a>';
                                echo ' <a href="' . $update_preset_url . '" class="button update-presets">' . __( 'Update Preset', 'sliderpro' ) . '</a>';
                                echo ' <a href="' . $delete_preset_url . '" class="button update-presets">' . __( 'Delete Preset', 'sliderpro' ) . '</a>';

                                $hide_info = get_option( 'sliderpro_hide_inline_info' );

                                if ( $hide_info != true ) {
                            ?>
                                <div class="inline-info presets-info">
                                    <input type="checkbox" id="show-hide-presets-info" class="show-hide-info">
                                    <label for="show-hide-presets-info" class="show-info"><?php _e( 'Show info', 'sliderpro' ); ?></label>
                                    <label for="show-hide-presets-info" class="hide-info"><?php _e( 'Hide info', 'sliderpro' ); ?></label>
                                    
                                    <div class="info-content">
                                        <p><?php _e( 'You can save setting configuration in order to easily reuse them for other sliders. After you decided on a certain configuration you just need to click on the <i>Save New</i> button and then you will be prompted to specify a name for the saved preset. The preset will then be saved and added to the list of saved presets. You can later update the configuration of a certain preset or delete it if you want.', 'sliderpro' ); ?></p>
                                    </div>
                                </div>
                            <?php
                                }
                            ?>
                        </div>
                    </div>

                    <?php
                        foreach ( $setting_groups as $group_name => $group ) {
                            $panel_state_class = isset( $slider_panels_state ) && isset( $slider_panels_state[ $group_name ] ) ? $slider_panels_state[ $group_name ] : $panels_state[ $group_name ];
                            $panel_name_class = $group_name . '-panel';
                            ?>
                            <div class="postbox <?php echo $panel_name_class . ' ' . $panel_state_class; ?>" data-name="<?php echo $group_name; ?>">
                                <div class="handlediv"></div>
                                <h3 class="hndle"><?php echo $group['label']; ?></h3>
                                <div class="inside">
                                    <table>
                                        <tbody>
                                            <?php
                                                foreach ( $group['list'] as $setting_name ) {
                                                    $setting = BQW_SliderPro_Settings::getSettings( $setting_name );
                                            ?>
                                                    <tr>
                                                        <td>
                                                            <label data-info="<?php echo $setting['description']; ?>" for="<?php echo $setting_name; ?>"><?php echo $setting['label']; ?></label>
                                                        </td>
                                                        <td>
                                                            <?php
                                                                $value = isset( $slider_settings ) && isset( $slider_settings[ $setting_name ] ) ? $slider_settings[ $setting_name ] : $setting['default_value'];

                                                                if ( $setting['type'] === 'number' || $setting['type'] === 'text' || $setting['type'] === 'mixed' ) {
                                                                    echo '<input id="' . $setting_name . '" class="setting" type="text" name="' . $setting_name . '" value="' . esc_attr( $value ) . '" />';
                                                                } else if ( $setting['type'] === 'boolean' ) {
                                                                    echo '<input id="' . $setting_name . '" class="setting" type="checkbox" name="' . $setting_name . '"' . ( $value === true ? ' checked="checked"' : '' ) . ' />';
                                                                } else if ( $setting['type'] === 'select' ) {
                                                                    echo'<select id="' . $setting_name . '" class="setting" name="' . $setting_name . '">';
                                                                    
                                                                    if ( $setting_name === 'thumbnail_image_size' ) {
                                                                        $image_sizes = get_intermediate_image_sizes();
                                                                        
                                                                        foreach ( $image_sizes as $image_size ) {
                                                                            echo '<option value="' . $image_size . '"' . ( $value === $image_size ? ' selected="selected"' : '' ) . '>' . $image_size . '</option>';
                                                                        }
                                                                    } else {
                                                                        foreach ( $setting['available_values'] as $value_name => $value_label ) {
                                                                            echo '<option value="' . $value_name . '"' . ( $value === $value_name ? ' selected="selected"' : '' ) . '>' . $value_label . '</option>';
                                                                        }
                                                                    }
                                                                    
                                                                    echo '</select>';
                                                                }
                                                            ?>
                                                        </td>
                                                    </tr>
                                            <?php
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                    
                                    <?php
                                        $hide_info = get_option( 'sliderpro_hide_inline_info' );
                                
                                        if ( $hide_info != true && isset( $group['inline_info'] ) ) {
                                    ?>
                                            <div class="inline-info sidebar-slide-info">
                                                <input type="checkbox" id="show-hide-<?php echo $group_name; ?>-info" class="show-hide-info">
                                                <label for="show-hide-<?php echo $group_name; ?>-info" class="show-info"><?php _e( 'Show info', 'sliderpro' ); ?></label>
                                                <label for="show-hide-<?php echo $group_name; ?>-info" class="hide-info"><?php _e( 'Hide info', 'sliderpro' ); ?></label>
                                                
                                                <div class="info-content">
                                                    <?php 
                                                        foreach( $group['inline_info'] as $inline_info_paragraph ) {
                                                            echo '<p>' . $inline_info_paragraph . '</p>';
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                    <?php
                                        }
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                    ?>
                    <?php $panel_class = isset( $slider_panels_state ) && isset( $slider_panels_state['breakpoints'] ) ? $slider_panels_state['breakpoints'] : $panels_state['breakpoints']; ?>
                    <div class="postbox breakpoints-box <?php echo $panel_class; ?>" data-name="breakpoints">
                        <div class="handlediv"></div>
                        <h3 class="hndle"><?php _e( 'Breakpoints', 'sliderpro' ); ?></h3>
                        <div class="inside">
                            <div class="breakpoints">
                                <?php
                                    if ( isset( $slider_settings['breakpoints'] ) ) {
                                        $breakpoints = $slider_settings['breakpoints'];

                                        foreach ( $breakpoints as $breakpoint_settings ) {
                                            include( 'breakpoint.php' );
                                        }
                                    }
                                ?>
                            </div>
                            <a class="button add-breakpoint" href="#"><?php _e( 'Add Breakpoint', 'sliderpro' ); ?></a>
                            <?php
                                $hide_info = get_option( 'sliderpro_hide_inline_info' );

                                if ( $hide_info != true ) {
                            ?>
                                <div class="inline-info breakpoints-info">
                                    <input type="checkbox" id="show-hide-breakpoint-info" class="show-hide-info">
                                    <label for="show-hide-breakpoint-info" class="show-info"><?php _e( 'Show info', 'sliderpro' ); ?></label>
                                    <label for="show-hide-breakpoint-info" class="hide-info"><?php _e( 'Hide info', 'sliderpro' ); ?></label>
                                    
                                    <div class="info-content">
                                        <p><?php _e( 'Breakpoints allow you to modify the look of the slider for different window sizes.', 'sliderpro' ); ?></p>
                                        <p><?php _e( 'Each breakpoint allows you to set the width of the window for which the breakpoint will apply, and then add several settings which will override the global settings.', 'sliderpro' ); ?></p>
                                        <p><a href="https://www.youtube.com/watch?v=AzwZvTU1wKI&list=PLh-6IaZNuPo4MHvfzrTovXRuU7WKXkfWh" target="_blank"><?php _e( 'See the video tutorial', 'sliderpro' ); ?> &rarr;</a></p>
                                    </div>
                                </div>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</form>
</div>