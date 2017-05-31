<?php
/**
 * Handles creating the page assets metaboxes
 **/
if ( ! class_exists( 'UCF_Page_Assets_Metabox' ) ) {
    class UCF_Page_Assets_Metabox {

		/**
		 * Enqeues admin assets
		 * @author Jim Barnes
		 * @since 1.0.0
		 * @param $hook string | The current admin hook
		 **/
		public static function enqueue_assets( $hook ) {
			if ( 'post.php' === $hook ) {
				wp_enqueue_script(
					'ucf-page-assets-js',
					UCF_PAGE_ASSETS__JS_URL . '/ucf-page-assets.min.js',
					array( 'jquery' ),
					null,
					true
				);
			}
		}

		/**
		 * Adds the Custom Page Assets metabox
		 * @author Jim Barnes
		 * @since 1.0.0
		 **/
		public static function add_meta_box() {
			add_meta_box(
				'ucf-page-assets',
				__( 'Custom Page Assets' ),
				array( 'UCF_Page_Assets_Metabox', 'metabox_markup' ),
				UCF_Page_Assets_Config::enabled_posts()	
			);
		}
        
		/**
		 * The markup callback for the Custom Page Assets metabox
		 * @author Jim Barnes
		 * @since 1.0.0
		 * @param $post WP_Post | The current post object
		 * @return string | The function output is echoed
		 **/
        public static function metabox_markup( $post ) {
            wp_nonce_field(  'ucf_page_assets_nonce_save', 'ucf_page_assets_nonce' );
			$upload_link = esc_url( get_upload_iframe_src( 'media', $post->ID ) );
            $stylesheet = get_post_meta( $post->ID, 'page_stylesheet', TRUE );
            $javascript = get_post_meta( $post->ID, 'page_javascript', TRUE );

        ?>
            <table class="form-table">
                <tbody>
                    <tr>
                        <th><strong>Custom Stylesheet</strong></th>
                        <td>
                            <div class="css-preview meta-file-wrap <?php if ( ! $stylesheet ) { echo 'hidden'; }?>">
								<span class="dashicons dashicons-media-code"></span>
								<?php echo basename( wp_get_attachment_url( $stylesheet ) ); ?>
                            </div>
                            <p class="hide-if-no-js">
                                <a class="css-upload meta-file-upload <?php if ( ! empty( $stylesheet ) ) { echo 'hidden'; }?>" href="<?php echo $upload_link; ?>">
                                    Add File
                                </a>
                                <a class="css-remove meta-file-upload <?php if ( empty( $stylesheet ) ) { echo 'hidden'; }?>" href="#">
                                    Remove File
                                </a>
                            </p>

                            <input class="meta-file-field" id="page_stylesheet" name="page_stylesheet" type="hidden" value="<?php echo htmlentities( $stylesheet ); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th><strong>Custom Javascript</strong></th>
                        <td>
                            <div class="js-preview meta-file-wrap <?php if ( ! $javascript ) { echo 'hidden'; }?>">
								<span class="dashicons dashicons-media-code"></span>
								<?php echo basename( wp_get_attachment_url( $javascript ) ); ?>
                            </div>
                            <p class="hide-if-no-js">
                                <a class="js-upload meta-file-upload <?php if ( ! empty( $javascript ) ) { echo 'hidden'; }?>" href="<?php echo $upload_link; ?>">
                                    Add File
                                </a>
                                <a class="js-remove meta-file-upload <?php if ( empty( $javascript ) ) { echo 'hidden'; }?>" href="#">
                                    Remove File
                                </a>
                            </p>

                            <input class="meta-file-field" id="page_javascript" name="page_javascript" type="hidden" value="<?php echo htmlentities( $javascript ); ?>">
                        <td>
                    </tr>
                </tbody>
            </table>
        <?php
        }

        /**
         * Saves the data from the metabox
         * @author Jim Barnes
         * @since 1.0.0
         **/
        public static function save_metabox( $post_id ) {
            $post_type = get_post_type( $post_id );
			// If this isn't a spotlight, return.
			if ( ! in_array( $post_type, UCF_Page_Assets_Config::enabled_posts() ) ) return;

            if ( ! wp_verify_nonce( $_POST['ucf_page_assets_nonce'], 'ucf_page_assets_nonce_save' ) ) return;

            if ( isset( $_POST['page_stylesheet'] ) ) {
                $stylesheet = (int)$_POST['page_stylesheet'];

                if ( $stylesheet > 0 ) {
                    if ( ! add_post_meta( $post_id, 'page_stylesheet', (int)$stylesheet, true ) ) {
                        update_post_meta( $post_id, 'page_stylesheet', (int)$stylesheet );
                    }
                }
            }

            if ( isset( $_POST['page_javascript'] ) ) {
                $javascript = (int)$_POST['page_javascript'];

                if ( $javascript > 0) {
                    if ( ! add_post_meta( $post_id, 'page_javascript', (int)$javascript, true ) ) {
                        update_post_meta( $post_id, 'page_javascript', (int)$javascript );
                    }
                }
            }
        }
    }
}
