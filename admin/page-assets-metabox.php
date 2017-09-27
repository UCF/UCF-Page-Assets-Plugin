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
                __( 'Custom Assets' ),
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
			$stylesheet_url = wp_get_attachment_url( $stylesheet );
			$javascript = get_post_meta( $post->ID, 'page_javascript', TRUE );
			$javascript_url = wp_get_attachment_url( $javascript );

			// Existing asset IDs are invalid if the attachment URL can't be retrieved
			// (e.g. if the attachment was deleted)
			if ( !$stylesheet_url ) {
				$stylesheet = null;
			}
			if ( !$javascript_url ) {
				$javascript = null;
			}
        ?>
            <table class="form-table">
                <tbody>
                    <tr>
                        <th><strong>Custom Stylesheet</strong></th>
                        <td>
                            <div class="css-preview meta-file-wrap <?php if ( ! $stylesheet ) { echo 'hidden'; }?>">
                                <span class="dashicons dashicons-media-code"></span>
                                <span id="css-filename"><?php if ( $stylesheet_url ) { echo basename( $stylesheet_url ); } ?></span>
                            </div>
                            <p class="hide-if-no-js">
                                <a class="css-upload meta-file-upload <?php if ( $stylesheet ) { echo 'hidden'; }?>" href="<?php echo $upload_link; ?>">
                                    Add File
                                </a>
                                <a class="css-remove meta-file-upload <?php if ( !$stylesheet ) { echo 'hidden'; }?>" href="#">
                                    Remove File
                                </a>
                            </p>

                            <input class="meta-file-field" id="page_stylesheet" name="page_stylesheet" type="hidden" value="<?php if ( $stylesheet ) { echo htmlentities( $stylesheet ); } ?>">
                        </td>
                    </tr>
                    <tr>
                        <th><strong>Custom Javascript</strong></th>
                        <td>
                            <div class="js-preview meta-file-wrap <?php if ( ! $javascript ) { echo 'hidden'; }?>">
                                <span class="dashicons dashicons-media-code"></span>
                                <span id="js-filename"><?php if ( $javascript_url ) { echo basename( $javascript_url ); } ?></span>
                            </div>
                            <p class="hide-if-no-js">
                                <a class="js-upload meta-file-upload <?php if ( $javascript ) { echo 'hidden'; }?>" href="<?php echo $upload_link; ?>">
                                    Add File
                                </a>
                                <a class="js-remove meta-file-upload <?php if ( !$javascript ) { echo 'hidden'; }?>" href="#">
                                    Remove File
                                </a>
                            </p>

                            <input class="meta-file-field" id="page_javascript" name="page_javascript" type="hidden" value="<?php if ( $javascript ) { echo htmlentities( $javascript ); } ?>">
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
            if ( ! in_array( $post_type, UCF_Page_Assets_Config::enabled_posts() ) ) return;

			if ( ! wp_verify_nonce( $_POST['ucf_page_assets_nonce'], 'ucf_page_assets_nonce_save' ) ) return;

			$stylesheet = isset( $_POST['page_stylesheet'] ) ? intval( $_POST['page_stylesheet'] ) : null;
			$javascript = isset( $_POST['page_javascript'] ) ? intval( $_POST['page_javascript'] ) : null;

            if ( ! add_post_meta( $post_id, 'page_stylesheet', $stylesheet, true ) ) {
				update_post_meta( $post_id, 'page_stylesheet', $stylesheet );
			}

            if ( ! add_post_meta( $post_id, 'page_javascript', $javascript, true ) ) {
				update_post_meta( $post_id, 'page_javascript', $javascript );
			}
        }
    }
}
