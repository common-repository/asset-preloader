<?php
defined( 'ASSET_PRELOADER_PLUGIN_DIR' ) || exit; // Exit if accessed directly

add_action( 'wp_ajax_eos_asset_preloader_save','eos_asset_preloader_save' );
//Save plugin settings
function eos_asset_preloader_save(){
  if(
    !current_user_can( 'manage_options' )
    || !isset( $_POST['data'] )
  ){
    die();
    exit;
  }
  $arr = json_decode( stripslashes( sanitize_text_field( $_POST['data'] ) ),true );
  if( !isset( $arr['data'] ) || !isset( $arr['nonce'] ) || !wp_verify_nonce( sanitize_text_field( $arr['nonce'] ),'eos-asset-preloader-nonce' ) ){
    die();
    exit;
  }
  $opts = get_site_option( 'eos_asset_preloader' );
  $data = $arr['data'];
  if( $opts && is_array( $opts ) && $data === implode( "\n",$opts ) ){
    echo 1;
    die();
    exit;
  }
  echo absint( update_site_option( 'eos_asset_preloader',array_map( 'sanitize_textarea_field',explode( "\n",$data ) ) ) );
  die();
  exit;
}
