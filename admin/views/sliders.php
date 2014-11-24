<div class="wrap sliderpro-admin">
	<h2><?php _e( 'All Sliders' ); ?></h2>
	
	<?php
		$hide_info = get_option( 'sliderpro_hide_getting_started_info' );

		if ( $hide_info != true ) {
	?>
	    <div class="inline-info getting-started-info">
			<h3><?php _e( '1. Getting started', 'sliderpro' ); ?></h3>
			<p><?php _e( 'If you want to reproduce one of the examples showcased online, you can easily import those examples into your own Slider Pro installation.', 'sliderpro' ); ?></p>
			<p><?php _e( 'The examples can be found in the <i>examples</i> folder, which is included in the plugin\'s folder, and can be imported using the <i>Import Slider</i> button below.', 'sliderpro' ); ?></p>
			<p><?php _e( 'For quick usage instructions, please see the video tutorials below. For more detailed instructions, please see the', 'sliderpro' ); ?> <a href="<?php echo admin_url('admin.php?page=sliderpro-documentation'); ?>"><?php _e( 'Documentation', 'sliderpro' ); ?></a> <?php _e( 'page.', 'sliderpro' ); ?></p>
			<ul class="video-tutorials-list">
				<li><a href="https://www.youtube.com/watch?v=lf5FzcwAhdc&list=PLh-6IaZNuPo4MHvfzrTovXRuU7WKXkfWh" target="_blank"><?php _e( '1. Create and publish sliders', 'sliderpro' ); ?></a></li>
				<li><a href="https://www.youtube.com/watch?v=Y7NeYK3QBuQ&list=PLh-6IaZNuPo4MHvfzrTovXRuU7WKXkfWh" target="_blank"><?php _e( '2. Create sliders from posts', 'sliderpro' ); ?></a></li>
				<li><a href="https://www.youtube.com/watch?v=Bj8xSH-sScY&list=PLh-6IaZNuPo4MHvfzrTovXRuU7WKXkfWh" target="_blank"><?php _e( '3. Create sliders from galleries', 'sliderpro' ); ?></a></li>
				<li><a href="https://www.youtube.com/watch?v=LVvn-hv0A88&list=PLh-6IaZNuPo4MHvfzrTovXRuU7WKXkfWh" target="_blank"><?php _e( '4. Adding thumbnails', 'sliderpro' ); ?></a></li>
				<li><a href="https://www.youtube.com/watch?v=IxqLUNS2BCk&list=PLh-6IaZNuPo4MHvfzrTovXRuU7WKXkfWh" target="_blank"><?php _e( '5. Adding layers', 'sliderpro' ); ?></a></li>
				<li><a href="https://www.youtube.com/watch?v=y_XeEjplSdo&list=PLh-6IaZNuPo4MHvfzrTovXRuU7WKXkfWh" target="_blank"><?php _e( '6. Adding custom CSS', 'sliderpro' ); ?></a></li>
				<li><a href="https://www.youtube.com/watch?v=AzwZvTU1wKI&list=PLh-6IaZNuPo4MHvfzrTovXRuU7WKXkfWh" target="_blank"><?php _e( '7. Working with breakpoints', 'sliderpro' ); ?></a></li>
				<li><a href="https://www.youtube.com/watch?v=p9Buf6BrF3k&list=PLh-6IaZNuPo4MHvfzrTovXRuU7WKXkfWh" target="_blank"><?php _e( '8. Import and Export sliders', 'sliderpro' ); ?></a></li>
			</ul>

			<h3><?php _e( '2. Support', 'sliderpro' ); ?></h3>
			<p><?php _e( 'When you need support, please contact us at our support center:', 'sliderpro' ); ?> <a href="http://support.bqworks.com">support.bqworks.com</a>.</p>
			
			<?php
				$purchase_code_status = get_option( 'sliderpro_purchase_code_status', '0' );

				if ( $purchase_code_status !== '1' ) {
			?>
					<h3><?php _e( '3. Updates', 'sliderpro' ); ?></h3>
					<p><?php _e( 'In order to have access to automatic updates, please enter your purchase code', 'sliderpro' ); ?> <a href="<?php echo admin_url('admin.php?page=sliderpro-settings'); ?>"><?php _e( 'here', 'sliderpro' ); ?></a>.</p>
			<?php
				}
			?>

			<a href="#" class="getting-started-close">Close</a>
		</div>
	<?php
		}
	?>

	<table class="widefat sliders-list">
	<thead>
	<tr>
		<th><?php _e( 'ID', 'sliderpro' ); ?></th>
		<th><?php _e( 'Name', 'sliderpro' ); ?></th>
		<th><?php _e( 'Shortcode', 'sliderpro' ); ?></th>
		<th><?php _e( 'Created', 'sliderpro' ); ?></th>
		<th><?php _e( 'Modified', 'sliderpro' ); ?></th>
		<th><?php _e( 'Actions', 'sliderpro' ); ?></th>
	</tr>
	</thead>
	
	<tbody>
		
	<?php
		global $wpdb;
		$prefix = $wpdb->prefix;

		$sliders = $wpdb->get_results( "SELECT * FROM " . $prefix . "slider_pro_sliders ORDER BY id" );
		
		if ( count( $sliders ) === 0 ) {
			echo '<tr class="no-slider-row">' .
					 '<td colspan="100%">' . __( 'You don\'t have saved sliders.', 'sliderpro' ) . '</td>' .
				 '</tr>';
		} else {
			foreach ( $sliders as $slider ) {
				$slider_id = $slider->id;
				$slider_name = stripslashes( $slider->name );
				$slider_created = $slider->created;
				$slider_modified = $slider->modified;

				include( 'sliders-row.php' );
			}
		}
	?>

	</tbody>
	
	<tfoot>
	<tr>
		<th><?php _e( 'ID', 'sliderpro' ); ?></th>
		<th><?php _e( 'Name', 'sliderpro' ); ?></th>
		<th><?php _e( 'Shortcode', 'sliderpro' ); ?></th>
		<th><?php _e( 'Created', 'sliderpro' ); ?></th>
		<th><?php _e( 'Modified', 'sliderpro' ); ?></th>
		<th><?php _e( 'Actions', 'sliderpro' ); ?></th>
	</tr>
	</tfoot>
	</table>
    
    <div class="new-slider-buttons">    
		<a class="button-secondary" href="<?php echo admin_url( 'admin.php?page=sliderpro-new' ); ?>"><?php _e( 'Create New Slider', 'sliderpro' ); ?></a>
        <a class="button-secondary import-slider" href=""><?php _e( 'Import Slider', 'sliderpro' ); ?></a>
    </div>    
    
</div>