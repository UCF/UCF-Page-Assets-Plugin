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
	}
}
