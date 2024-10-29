<?php
/*
Plugin Name: Asset Preloader
Description: Decide which assets you want to preload depending on the page
Author: Jose Mortellaro
Author URI: https://josemortellaro.com
Domain Path: /languages/
Text Domain: asset-preloader
Version: 0.0.7
*/
/*  This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/
defined( 'ABSPATH' ) || exit; // Exit if accessed directly

//Definitions
define( 'ASSET_PRELOADER_PLUGIN_DIR', untrailingslashit( dirname( __FILE__ ) ) );
define( 'ASSET_PRELOADER_PLUGIN_URL', untrailingslashit( plugins_url( '', __FILE__ ) ) );

if( is_admin() ){
  require ASSET_PRELOADER_PLUGIN_DIR . '/inc/ap-admin.php';
}

add_action( 'wp_head',function(){
  global $post;
  $urls = array();
  $params = apply_filters( 'asset_preloader_file_extensions',array(
    'jpg' => array( 'as' => 'image','other_attributes' => '' ),
    'jpeg' => array( 'as' => 'image','other_attributes' => '' ),
    'png' => array( 'as' => 'image','other_attributes' => '' ),
    'gif' => array( 'as' => 'image','other_attributes' => '' ),
    'tiff' => array( 'as' => 'image','other_attributes' => '' ),
    'webp' => array( 'as' => 'image','other_attributes' => '' ),
    'eot' => array( 'as' => 'font','other_attributes' => ' type="font/eot"' ),
    'ttf' => array( 'as' => 'font','other_attributes' => ' type="font/ttf"' ),
    'woff' => array( 'as' => 'font','other_attributes' => ' type="font/woff"' ),
    'woff2' => array( 'as' => 'font','other_attributes' => ' type="font/woff2"' )
  ) );
  if( $post && is_object( $post ) ){
    $single_urls = get_post_meta( $post->ID,'_eos_asset_preloader',true );
    $urls = $single_urls && is_array( $single_urls ) && !empty( $single_urls ) ? $single_urls : $urls;
  }
  $opts = get_site_option( 'eos_asset_preloader' );
  $urls = $opts && is_array( $opts ) && !empty( $opts ) ? array_merge( $opts,$urls ) : $urls;
  if( !empty( $urls ) ){
    $urls = array_unique( $urls );
    foreach( $urls as $url ){
      $urlA = explode( ' media="',$url );
      $url = $urlA[0];
      $media = isset( $urlA[1] ) ? str_replace( '))',')',str_replace( '((','(',str_replace( '(none)','none',str_replace( '(all)','all','('.rtrim( $urlA[1],'"' ).')' ) ) ) ) : 'all';
      $ext = pathinfo( $url,PATHINFO_EXTENSION );
      if( in_array( $ext,array_keys( $params ) ) ){
        $arr = $params[$ext];
      ?>
      <link rel="preload" href="<?php echo esc_url( $url ); ?>" as="<?php echo $arr['as']; ?>" media="<?php echo esc_attr( $media ); ?>"<?php echo $arr['other_attributes']; ?>>
      <?php
      }
    }
  }
},0 );
