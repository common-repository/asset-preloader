<?php
defined( 'ASSET_PRELOADER_PLUGIN_DIR' ) || exit; // Exit if accessed directly

//Add metabox
function eos_ap_add_meta_box(){
	if( current_user_can( 'manage_options' ) ){
		$post_types = get_post_types( array( 'publicly_queryable' => true,'public' => true ) );
		if( isset( $post_types['attachment'] ) ){
			unset( $post_types['attachment'] );
		}
		$screens = array_merge( array( 'page' ),$post_types );
		foreach ( $screens as $screen ) {
			add_meta_box(
				'eos_ap_sectionid',
				esc_html__( 'Asset Preloader', 'asset-preloader' ),
				'eos_ap_meta_box_callback',
				$screen,
				'normal',
				'default'
			);
		}
	}
}
add_action( 'add_meta_boxes', 'eos_ap_add_meta_box' );

//Callback to add metabox
function eos_ap_meta_box_callback( $post ){
  $value = get_post_meta( $post->ID,'_eos_asset_preloader',true );
  $value = $value && is_array( $value ) ? implode( PHP_EOL,array_unique( $value ) ) : '';
  wp_nonce_field( 'eos_ap_meta_boxes_nonce','eos_ap_meta_boxes_nonce' );
  $upload_dir_array = wp_get_upload_dir();
  ?>
  <div id="asset-preloader">
    <p><label for="asset-preloader-textarea"><?php esc_html_e( 'Write the URL of the assets that you want to preload when visiting this page. Separate them by a return line','asset-preloader' ); ?></label></p>
		<p><?php esc_html_e( 'Use the media attribute if you want to specify what media/device the asset should be preloaded for. E.g.: ' . esc_url( $upload_dir_array['baseurl'] ) . date ( '/Y/m' ) . '/your-image.jpg media="(min-width: 601px)"','asset-preloader' ); ?></p>
    <p><textarea id="asset-preloader-textarea" name="asset-preloader-textarea" style="width:100%;min-height:200px"><?php echo esc_html( $value ); ?></textarea></p>
  </div>
	<?php
}

//Save metaboxes
function eos_ap_save_meta_box_data( $post_id,$post ) {
  if(
    ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
    || wp_doing_ajax()
    || ( defined( 'DOING_CRON' ) && DOING_CRON )
  ){
    return;
  }
  if( !isset( $_POST['asset-preloader-textarea'] ) || !isset( $_POST['eos_ap_meta_boxes_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( $_POST['eos_ap_meta_boxes_nonce'] ),'eos_ap_meta_boxes_nonce' ) ) return;
	
  update_post_meta( $post->ID,'_eos_asset_preloader',array_map( 'sanitize_textarea_field',explode( "\n",$_POST['asset-preloader-textarea'] ) ) );
  
}
add_action( 'save_post', 'eos_ap_save_meta_box_data',10,2 );
