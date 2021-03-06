<?php
/**
 * Plugin Name: Heading Title Shift for WordPress
 * Description: Adds metabox to admin panel which can be used to move post title beneath featured image
 * Version: 1.0.0
 * Author: Brenton Price
 * Text Domain: heading-title-shift
 * License: GPLv2 or later
 */

// Adds a heading shift metabox to the post editing screen
function heading_shift_custom_meta() {
  add_meta_box( 'heading_shift_meta', __( 'Heading Shift', 'heading-title-shift' ), 'heading_shift_meta_callback', 'post' );
}
add_action( 'add_meta_boxes', 'heading_shift_custom_meta', 100 );

// Admin enqueued script
function show_metabox_scripts() {
	wp_enqueue_script( 'style-click', plugins_url('heading-shift-admin.js',__FILE__ ), array(), '1.0.0', false );
}
add_action( 'admin_enqueue_scripts', 'show_metabox_scripts' );

// Callback for the content of the metabox
function heading_shift_meta_callback( $post ) {
		wp_nonce_field( basename( __FILE__ ), 'heading_shift_nonce' );
		$heading_shift_value = get_post_meta( $post->ID, "_add_heading_title_shift", true );
 	?>

	<div class="heading-shift-row-content">
    <span class="heading-shift-row-title"><?php _e( 'Move post title beneath featured image?', 'heading-title-shift' )?></span><br/>

		<div class="heading-shift-options" style="margin: 10px 0 15px 5px;">
		<input
			type="checkbox"
			id="heading-shift-checkbox"
			name="_add_heading_title_shift"
			value= ""
			style="margin-top:-1px; vertical-align:middle;"
			<?php checked( $heading_shift_value, 1 ); ?> 
		/>
    	<label for="heading-shift-checkbox"><?php _e( 'Yes', 'heading-title-shift' )?></label>
    </div> <!-- End heading-shift-options -->
  </div> <!-- End heading-shift-row-content-->

  <?php
}


// Saves the custom meta input
function heading_shift_meta_save( $post_id ) {
 	// Checks save status
 	$is_autosave = wp_is_post_autosave( $post_id );
 	$is_revision = wp_is_post_revision( $post_id );
 	$is_valid_nonce = ( isset( $_POST[ 'heading_shift_nonce' ] ) && wp_verify_nonce( $_POST[ 'heading_shift_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';



 	// Exits script depending on save status
 	if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
 		return;
	}
	 
 	// Checks for inputs and saves if needed
	if ($_POST['_add_heading_title_shift'] == 1 || $_POST['_add_heading_title_shift'] == "on" || isset($_POST['_add_heading_title_shift'])) {
		update_post_meta( $post_id, '_add_heading_title_shift', "1" );
	} 	elseif ($_POST['_add_heading_title_shift'] == 0 || $_POST['_add_heading_title_shift'] == "off" || empty($_POST['_add_heading_title_shift'])) {
		delete_post_meta( $post_id, '_add_heading_title_shift' );
	}

}

add_action( 'save_post', 'heading_shift_meta_save' );


// Shift Title down on frontend
/* function heading_title_shift_down() {
	$page_id = get_the_ID();
	$heading_shift_meta= get_post_meta( $page_id, "_add_heading_title_shift", true );
	$template_shift_meta = get_post_meta( $page_id, "td_post_theme_settings", true );
	$template_value = $template_shift_meta[td_post_template];
	$template = array("single_template_3" , "single_template_7" , "single_template_8");

	if (in_array($template_value, $template, TRUE) && $heading_shift_meta == "1") {
		// enqueued script moves the title
		add_action( 'wp_enqueue_scripts', 'heading_shift_script' );
		function heading_shift_script() {
			wp_enqueue_script( 'style-click', plugins_url('heading-shift.js',__FILE__ ), array(), false );
		}

		add_action('wp_enqueue_scripts', 'heading_shift_styles');
		function heading_shift_styles() {
			wp_enqueue_style( 'heading_shift_style', plugins_url('heading-title-shift.css', __FILE__) );
		}
	}
}
add_action( 'template_redirect', 'heading_title_shift_down' ); */


