<?php
defined( 'ASSET_PRELOADER_PLUGIN_DIR' ) || exit; // Exit if accessed directly

require ASSET_PRELOADER_PLUGIN_DIR . '/inc/ap-metaboxes.php';

if( wp_doing_ajax() ){
  require_once ASSET_PRELOADER_PLUGIN_DIR.'/inc/ap-ajax-admin.php';
}

add_action( 'admin_menu',function(){
  add_menu_page(
    esc_html__( 'Asset Preloader','asset-preloader' ),
    esc_html__( 'Asset Preloader','asset-preloader' ),
    'manage_options',
    'asset-preloader',
    'eos_ap_menu__page_callback',
    'dashicons-arrow-up-alt2',
    40
  );
} );

//Callback for Settings Page
function eos_ap_menu__page_callback(){
  $value = get_site_option( 'eos_asset_preloader' );
  $value = $value && is_array( $value ) ? implode( PHP_EOL,array_unique( $value ) ) : '';
  $upload_dir_array = wp_get_upload_dir();
  wp_nonce_field( 'eos-asset-preloader-nonce','eos-asset-preloader-nonce' );
  ?>
  <style id="asset-preloader-css">
  #asset-preloader .ap-hidden{
    display:none !important
  }
  #asset-preloader .notice{
    padding:20px;
    margin-top:16px;
    margin-left:0;
    margin-right:0
  }
  #eos-asset-preloader-save{
    background-image:url("<?php echo esc_url( ASSET_PRELOADER_PLUGIN_URL.'/assets/images/ajax-loader.gif' ); ?>");
    background-repeat:no-repeat;
    background-size:18px 18px;
    background-position:-9999px -9999px
  }
  </style>
  <h1><?php esc_html_e( 'Asset Preloader','asset-preloader' ); ?></h1>
  <section id="asset-preloader">
    <div>
      <p><label for="asset-preloader-textarea"><?php esc_html_e( 'Write the URL of the assets that you want to preload on every page. Separate them by a return line','asset-preloader' ); ?></label></p>
  		<p><?php esc_html_e( 'Use the media attribute if you want to specify what media/device the asset should be preloaded for. E.g.: ' . esc_url( $upload_dir_array['baseurl'] ) . date ( '/Y/m' ) . '/your-image.jpg media="(min-width: 601px)"','asset-preloader' ); ?></p>
      <p><textarea id="asset-preloader-textarea" name="asset-preloader-textarea" style="width:100%;min-height:200px"><?php echo esc_html( $value ); ?></textarea></p>
    </div>
    <div style="margin-top:32px">
      <input id="eos-asset-preloader-save" class="button" type="submit" value="<?php esc_html_e( 'Save changes','asset-preloader' ); ?>" />
    </div>
    <div id="eos-asset-preloader-success-msg" class="eos-asset-preloader-msg ap-hidden">
      <div class="notice notice-success"><?php esc_html_e( 'Settings saved successflly','asset-preloader' ); ?></div>
    </div>
    <div id="eos-asset-preloader-error-msg" class="eos-asset-preloader-msg ap-hidden">
      <div class="notice notice-error"><?php esc_html_e( 'Something went wrong','asset-preloader' ); ?></div>
    </div>
  </section>
  <script id="eos-asset-preloader-js">
  function eos_asset_preloader(){
    var xhr=new XMLHttpRequest(),fd=new FormData(),data={},ajaxurl='<?php echo esc_js( admin_url( 'admin-ajax.php' ) ); ?>',msgs=document.getElementsByClassName('eos-asset-preloader-msg');
    document.getElementById('eos-asset-preloader-save').addEventListener('click',function(){
      var button=this;
      for(var i=0;i<msgs.length;++i){
        msgs[i].className='eos-asset-preloader-msg ap-hidden';
      }
      this.style.backgroundPosition = 'center center';
      data['data'] = document.getElementById('asset-preloader-textarea').value;
      data['nonce'] = document.getElementById('eos-asset-preloader-nonce').value;
      fd.append('data',JSON.stringify(data));
      xhr.open("POST",ajaxurl + '?action=eos_asset_preloader_save',true);
      xhr.send(fd);
      xhr.onload = function() {
        if (xhr.status === 200){
          var idx='' !== xhr.responseText ? parseInt(xhr.responseText) : 0;
          for(i=0;i<msgs.length;++i){
            msgs[i].className='eos-asset-preloader-msg ap-hidden';
          }
          document.getElementById(['eos-asset-preloader-error-msg','eos-asset-preloader-success-msg'][idx]).className='eos-asset-preloader-msg';
          button.style.backgroundPosition = '-9999px -9999px';
        }
      };
      return false;
    });
  }
  eos_asset_preloader();
  </script>
  <?php
}
