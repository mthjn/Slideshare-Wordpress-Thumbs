# Slideshare-Wordpress-Thumbs

Get thumb from a CDN via [Slideshare API (need to register own)](http://www.slideshare.net/developers)

## Requires
[metabox plugin](https://metabox.io/)
  
## Do
* getThumbs.php code comes in functions.php, with API credentials
* there will be two metaboxes in post, fill in slideshow URL
* on save there will be admin notice with link to thumb, copypaste it
* call it in your theme, like:

```
<?php if ( !empty( rwmb_meta( 'rw_cdnurl' )  )) { ?>
	   <img src="<?php echo rwmb_meta( 'rw_cdnurl' ); ?>" width="210" height="143" class="attachment-homepage-thumb wp-post-image" alt="" title="">
<?php } else { ?>
<?php the_post_thumbnail('homepage-thumb', array('alt' => '', 'title' => '')) ?>
<?php } ?>
```
