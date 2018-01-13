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
				<li><a href="https://www.youtube.com/watch?v=Hd54x3GMFlA&list=PLh-6IaZNuPo4MHvfzrTovXRuU7WKXkfWh" target="_blank"><?php _e( '1. Create and publish sliders', 'sliderpro' ); ?></a></li>
				<li><a href="https://www.youtube.com/watch?v=LARRTKJrz8U&list=PLh-6IaZNuPo4MHvfzrTovXRuU7WKXkfWh" target="_blank"><?php _e( '2. Create sliders from posts', 'sliderpro' ); ?></a></li>
				<li><a href="https://www.youtube.com/watch?v=Bj8xSH-sScY&list=PLh-6IaZNuPo4MHvfzrTovXRuU7WKXkfWh" target="_blank"><?php _e( '3. Create sliders from galleries', 'sliderpro' ); ?></a></li>
				<li><a href="https://www.youtube.com/watch?v=LVvn-hv0A88&list=PLh-6IaZNuPo4MHvfzrTovXRuU7WKXkfWh" target="_blank"><?php _e( '4. Adding thumbnails', 'sliderpro' ); ?></a></li>
				<li><a href="https://www.youtube.com/watch?v=3jS0k7ArKOw&list=PLh-6IaZNuPo4MHvfzrTovXRuU7WKXkfWh" target="_blank"><?php _e( '5. Adding layers', 'sliderpro' ); ?></a></li>
				<li><a href="https://www.youtube.com/watch?v=y_XeEjplSdo&list=PLh-6IaZNuPo4MHvfzrTovXRuU7WKXkfWh" target="_blank"><?php _e( '6. Adding custom CSS', 'sliderpro' ); ?></a></li>
				<li><a href="https://www.youtube.com/watch?v=LKcpUz6K70w&list=PLh-6IaZNuPo4MHvfzrTovXRuU7WKXkfWh" target="_blank"><?php _e( '7. Working with breakpoints', 'sliderpro' ); ?></a></li>
				<li><a href="https://www.youtube.com/watch?v=CoBpGNGj3G8&list=PLh-6IaZNuPo4MHvfzrTovXRuU7WKXkfWh" target="_blank"><?php _e( '8. Import and Export sliders', 'sliderpro' ); ?></a></li>
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
		$max_sliders_on_page = get_option( 'sliderpro_max_sliders_on_page', 100 );
		$total_sliders = $wpdb->get_var( "SELECT COUNT(*) FROM " . $prefix . "slider_pro_sliders" );
		$total_pages = ceil( $total_sliders / $max_sliders_on_page );
		$current_page = isset( $_GET['sp_page'] ) ? max( 1, min( $total_pages, intval( $_GET['sp_page'] ) ) ) : 1;
		$offset_row = ( $current_page - 1 ) * $max_sliders_on_page ;

		$sliders = $wpdb->get_results( "SELECT * FROM " . $prefix . "slider_pro_sliders ORDER BY id LIMIT " . $offset_row . ", " . $max_sliders_on_page );
		
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

	<?php
		if ( $max_sliders_on_page < $total_sliders ) {
			echo '<div class="sliders-pagination">';

			for ( $i = $current_page - 2; $i <= $current_page; $i++ ) {
				if ( $i >= 1 ) {
					echo '<a class="sliders-pagination-link' . ( $i === $current_page ? ' selected-page' : '' ) . '" href="' . admin_url( 'admin.php?page=sliderpro&sp_page=' ) . $i . '">' . $i . '</a>';
				}
			}

			$last_page = min( $total_pages, ( $current_page + 2 ) + max( 0, ( 3 - $current_page ) ) );

			for ( $i = $current_page + 1; $i <= $last_page ; $i++ ) {
				echo '<a class="sliders-pagination-link" href="' . admin_url( 'admin.php?page=sliderpro&sp_page=' ) . $i . '">' . $i . '</a>';
			}

			echo '</div>';
		}
	?>

</div>