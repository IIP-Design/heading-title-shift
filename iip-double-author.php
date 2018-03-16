<?php
/**
 * Plugin Name: Second Author Plugin for IIP Properties
 * Description: Adds extra metabox to admin panel which can be used to add a second author to a post byline
 * Version: 1.0.0
 * Author: Marek Rewers
 * Text Domain: iip-double-author
 * License: GPLv2 or later
 */

// Adds a meta box to the post editing screen
function double_author_custom_meta() {
  add_meta_box( 'double_author_meta', __( 'Second Author', 'iip-double-author' ), 'double_author_meta_callback', 'post' );
}

add_action( 'add_meta_boxes', 'double_author_custom_meta' );


// Callback for the content of the meta box
function double_author_meta_callback( $post ) {
 	wp_nonce_field( basename( __FILE__ ), 'double_author_nonce' );
 	$double_author_stored_meta = get_post_meta( $post->ID );
 	?>

 	<p>
 		<div class="double-author-row-content">
      <span class="double-author-row-title"><?php _e( 'Add second author?', 'iip-double-author' )?></span>
 			<label for="meta-radio-one">
 				<input type="radio" name="meta-radio" id="meta-radio-one" value="radio-one" <?php if ( isset ( $double_author_stored_meta['meta-radio'] ) ) checked( $double_author_stored_meta['meta-radio'][0], 'radio-one' ); ?>>
 				<?php _e( 'Yes', 'iip-double-author' )?>
      </label>
      <label for="meta-radio-two">
				<input type="radio" name="meta-radio" id="meta-radio-two" value="radio-two" <?php if ( isset ( $double_author_stored_meta['meta-radio'] ) ) checked( $double_author_stored_meta['meta-radio'][0], 'radio-two' ); ?>>
				<?php _e( 'No', 'iip-doubleauthor' )?>
			</label>
 		</div>
 	</p>

 	<?php
 }

// Saves the custom meta input
function double_author_meta_save( $post_id ) {

 	// Checks save status
 	$is_autosave = wp_is_post_autosave( $post_id );
 	$is_revision = wp_is_post_revision( $post_id );
 	$is_valid_nonce = ( isset( $_POST[ 'double_author_nonce' ] ) && wp_verify_nonce( $_POST[ 'double_author_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

 	// Exits script depending on save status
 	if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
 		return;
 	}

 	// Checks for input and saves if needed
 	if( isset( $_POST[ 'meta-radio' ] ) ) {
 		update_post_meta( $post_id, 'meta-radio', $_POST[ 'meta-radio' ] );
 	}
 }

add_action( 'save_post', 'double_author_meta_save' );
