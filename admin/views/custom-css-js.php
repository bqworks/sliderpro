<div class="wrap sliderpro-admin">
	<h2><?php _e( 'Custom CSS and JavaScript', 'sliderpro' ); ?></h2>
    
    <?php
        $hide_info = get_option( 'sliderpro_hide_inline_info' );

        if ( $hide_info != true ) {
    ?>
        <div class="inline-info custom-css-js-info">
            <input type="checkbox" id="show-hide-info" class="show-hide-info">
            <label for="show-hide-info" class="show-info"><?php _e( 'Show info', 'sliderpro' ); ?></label>
            <label for="show-hide-info" class="hide-info"><?php _e( 'Hide info', 'sliderpro' ); ?></label>
            
            <div class="info-content">
                <p><?php _e( 'The fields below can be used for all your custom CSS or JavaScript code.', 'sliderpro' ); ?></p>
                <p><?php _e( 'If you want to target a specific slider, you need to assign a <i>Custom Class</i> to the slider, in the slider\'s settings, and then use that custom class in the <i>Custom CSS</i> or <i>Custom JavaScript</i> fields below.', 'sliderpro' ); ?></p>
                <p><?php _e( 'By default, the custom CSS and JavaScript code will be loaded inline, but in the', 'sliderpro' ); ?> <a href="<?php echo admin_url('admin.php?page=sliderpro-settings') ?>"><?php _e( 'Plugin Settings', 'sliderpro' ); ?></a> <?php _e( 'page you can set to load the code in files instead of inline.', 'sliderpro' ); ?></p>
                <p><a href="https://www.youtube.com/watch?v=y_XeEjplSdo&list=PLh-6IaZNuPo4MHvfzrTovXRuU7WKXkfWh" target="_blank"><?php _e( 'See the video tutorial', 'sliderpro' ); ?> &rarr;</a></p>
            </div>
        </div>
    <?php
        }
    ?>

	<form action="" method="post">
        <?php wp_nonce_field( 'custom-css-js-update', 'custom-css-js-nonce' ); ?>

        <h3><?php _e( 'Custom CSS', 'sliderpro' ); ?></h3>
        <textarea class="custom-css" name="custom_css" cols="80" rows="20"><?php echo isset( $custom_css ) ? stripslashes( esc_textarea( $custom_css ) ) : ''; ?></textarea>
        
        <input type="submit" name="custom_css_update" class="button-primary custom-css-js-update" value="Update CSS" />

        <h3><?php _e( 'Custom JavaScript', 'sliderpro' ); ?></h3>
        <textarea class="custom-js" name="custom_js" cols="80" rows="20"><?php echo isset( $custom_js ) ? stripslashes( esc_textarea( $custom_js ) ) : ''; ?></textarea>

    	<input type="submit" name="custom_js_update" class="button-primary custom-css-js-update" value="Update JavaScript" />
	</form>
</div>