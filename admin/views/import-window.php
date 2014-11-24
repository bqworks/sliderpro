<div class="modal-overlay"></div>
<div class="modal-window-container import-window">
	<div class="modal-window">
		<span class="close-x"></span>
		
		<textarea></textarea>

		<div class="buttons sp-clearfix">
			<a class="button-secondary save" href="#"><?php _e( 'Import', 'sliderpro' ); ?></a>
		</div>
		
		<?php
            $hide_info = get_option( 'sliderpro_hide_inline_info' );

            if ( $hide_info != true ) {
        ?>
				<div class="inline-info import-info">
		            <input type="checkbox" id="show-hide-info" class="show-hide-info">
		            <label for="show-hide-info" class="show-info"><?php _e( 'Show info', 'sliderpro' ); ?></label>
		            <label for="show-hide-info" class="hide-info"><?php _e( 'Hide info', 'sliderpro' ); ?></label>
		            
		            <div class="info-content">
		                <p><?php _e( 'In the field above you need to copy the new slider\'s data, as it was exported. Then, click in the <i>Import</i> button.', 'sliderpro' ); ?></p>
		            	<p><a href="https://www.youtube.com/watch?v=p9Buf6BrF3k&list=PLh-6IaZNuPo4MHvfzrTovXRuU7WKXkfWh" target="_blank"><?php _e( 'See the video tutorial', 'sliderpro' ); ?> &rarr;</a></p>
		            </div>
		        </div>
		<?php
            }
        ?>
	</div>
</div>