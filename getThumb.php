<?php


/* === CUSTOM METABOXES ==== */
/**
============== SLIDESHARE THUMBS==============
paste in ss url
get cdn url
save the url as post meta
if that post meta, show it instead of thumb
**/

add_filter( 'rwmb_meta_boxes', 'tooltip_register_meta_boxes' );
function tooltip_register_meta_boxes( $meta_boxes )
{
    $prefix = 'rw_';

    $meta_boxes[] = array(
        'title'    => 'Slideshare Thumbnail',
        'pages'    => array( 'post', 'page' ),
        'fields' => array(
            array(
                'name' => 'Slideshare URL',
                'id'   => $prefix . 'ssurl',
                'type' => 'text',
                'size' => 60,
                'clone' => false,
            ),

            array(
                'name' => 'Thumbnail URL',
                'id'   => $prefix . 'cdnurl',
                'type' => 'text',
                'size' => 60,
                'clone' => false,
            ),

        )
    );

    return $meta_boxes;
}



function getSlideshareThumb( ) {

  global $post;

  $post_id = $post->ID;

  $url = rwmb_meta( 'rw_ssurl' );

  $key = 'xxxxxxxx';
  $sec = 'xxxxxxxx';
  $t=time();
  $str = $sec . $t;
  $h = sha1($str);

  $request = 'https://www.slideshare.net/api/2/get_slideshow?api_key='. $key .'&ts='. $t .'&hash='. $h  .'&slideshow_url='. $url;

  $response = file_get_contents($request);

  $xml = new SimpleXMLElement($response);

  $thumb = $xml->ThumbnailURL;

  echo $thumb;

}

// only if CDN link empty...
function my_admin_notice() {
 if ( !empty( rwmb_meta( 'rw_ssurl' ) ) && empty( rwmb_meta( 'rw_cdnurl' ) )  ) {
    ?>
    <div class="updated">
        <p><?php _e( 'The SlideShare Thumbnail URL: ', 'thumb-text-domain' ); ?> </p>
        <p><?php getSlideshareThumb(); ?> </p>
    </div>
    <?php
  }
}
add_action( 'admin_notices', 'my_admin_notice' );
add_action( 'save_post', 'my_admin_notice' );
