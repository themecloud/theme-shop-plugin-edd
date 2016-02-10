<?php

if ( ! defined( 'ABSPATH' ) ) exit;

function themecloud_edd_template_id ($postId) {
    $current = Themecloud_EDD::getThemeId($postId);

?><p><strong>Themecloud template id:</strong></p>
<input name="_themecloud_edd_tpl_id" value="<?php echo $current; ?>" />
<?php
}

add_action( 'edd_meta_box_settings_fields', themecloud_edd_template_id, 10);

function themecloud_edd_show_shortcode($postId) {
    global $post;

    if( $post->post_type != 'download' ) {
        return;
    }

    $shortcode = '[themecloud_edd_install id="' . absint( $post->ID ) . '" style="" class="themecloud-install" text="Install on Themecloud" type="form" target="_blank" ]';
?>
<p><strong>Themecloud Shortcode:</strong></p>
<input type="text" id="themecloud-edd-install-shortcode" class="widefat" readonly="readonly" value="<?php echo htmlentities( $shortcode ); ?>">
<?php
}

add_action( 'edd_meta_box_settings_fields', themecloud_edd_show_shortcode, 11);

function themecloud_edd_metabox_fields($fields) {
    $fields[] = '_themecloud_edd_tpl_id';
    return $fields;
}

add_action('edd_metabox_fields_save', themecloud_edd_metabox_fields);

function edd_metabox_save_themecloud_edd_tpl_id( $value ) {
    return intval($value);
}

add_filter( 'edd_metabox_save__themecloud_edd_tpl_id', edd_metabox_save_themecloud_edd_tpl_id);

