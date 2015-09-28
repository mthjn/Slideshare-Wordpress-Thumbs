<?php
/* === FUNCTIONS ==== */

add_filter( 'rwmb_meta_boxes', 'tooltip_register_meta_boxes' );

function tooltip_register_meta_boxes( $meta_boxes )
{
    $prefix = 'rw_';
    // metabox tooltip
    $meta_boxes[] = array(
        'id'       => 'tooltip',
        'title'    => 'Tooltip',
        'pages'    => array( 'ehproject' ),
        'context'  => 'normal',
        'priority' => 'high',
        'fields' => array(
            array(
                'name'  => 'Tooltip HTML contents',
                'desc'  => 'Type content in here',
                'id'    => $prefix . 'content',
                'type'  => 'textarea',
                'std'   => 'No further information',
                'class' => 'tootltip-class',
                'clone' => false,
            ),
        )
    );
    // metabox slideshare
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

function getSlideshareThumb() {

  //global $post;
  //$post_id = $post->ID;

  $url = rwmb_meta( 'rw_ssurl' );

  $key = 'DATBl1YA';
  $sec = 'pEet3vrG';
  $t=time();
  $str = $sec . $t;
  $h = sha1($str);

  $request = 'https://www.slideshare.net/api/2/get_slideshow?api_key='. $key .'&ts='. $t .'&hash='. $h  .'&slideshow_url='. $url;

  $response = file_get_contents($request);

  $xml = new SimpleXMLElement($response);

  $thumb = $xml->ThumbnailURL;

  echo $thumb;

}

add_action( 'admin_notices', 'ss_admin_notice' );
add_action( 'save_post', 'ss_admin_notice' );

function ss_admin_notice() {
if ( !empty( rwmb_meta( 'rw_ssurl' ) ) && empty( rwmb_meta( 'rw_cdnurl' ) )  ) {
    ?>
    <div class="updated">
        <p>The SlideShare Thumbnail URL:</p>
        <p> <?php getSlideshareThumb(); ?> </p>
    </div>
    <?php
  }
}
