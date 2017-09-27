<?php
/**
 * Responsible for common functions
 **/
if ( ! class_exists( 'UCF_Page_Assets_Common' ) ) {
	class UCF_Page_Assets_Common {

		/**
		 * Enqueues assets assigned to pages.
		 * @author Jim Barnes
		 * @since 1.0.0
		 **/
		public static function enqueue_assets() {
			global $post;

			$stylesheet_id = (int)get_post_meta( $post->ID, 'page_stylesheet', TRUE );
			$javascript_id = (int)get_post_meta( $post->ID, 'page_javascript', TRUE );

			if ( $stylesheet_id ) {
				$stylesheet_url = wp_get_attachment_url( $stylesheet_id );
				if ( $stylesheet_url ) {
					wp_enqueue_style( $post->post_name . '-css', $stylesheet_url );
				}
			}

			if ( $javascript_id ) {
				$javascript_url = wp_get_attachment_url( $javascript_id );
				if ( $javascript_url ) {
					wp_enqueue_script( $post->post_name . '-js', $javascript_url, null, null, true );
				}
			}
		}

		/**
		 * Removes references to deleted css/js attachments from css and js
		 * meta fields.
		 * @author Jo Dickson
		 * @since 1.0.1
		 **/
		public static function delete_post_metadata( $attachment_id ) {
			$meta_key = '';
			$mimetype = get_post_mime_type( $attachment_id );
			if ( $mimetype ) {
				switch ( $mimetype ) {
					case 'text/css':
						$meta_key = 'page_stylesheet';
						break;
					case 'application/javascript':
						$meta_key = 'page_javascript';
						break;
					default:
						break;
				}
			}
			if ( $meta_key ) {
				delete_metadata( 'post', null, $meta_key, $attachment_id, true );
			}
		}
	}
}
