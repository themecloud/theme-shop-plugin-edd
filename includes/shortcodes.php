<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

function themecloud_edd_install_shortcode($atts, $content = null) {
    global $post, $user_ID;

    if(! is_user_logged_in()) {
        return "";
    }
    
    $post_id = is_object( $post ) ? $post->ID : 0;

    $download = new EDD_Download( $post_id );

    if(! $download->is_free() && ! edd_has_user_purchased($user_ID, $download->ID)) {
	return "";
    }

    $atts = shortcode_atts( array(
        'id' => $post_id,
        'style' => '',
        'class' => 'themecloud-install',
        'text' => "Install on Themecloud",
        'target' => '_blank',
        'type' => 'form'
    ), $atts, 'themecloud_edd_install');

    if ($atts['type'] == "form") {

ob_start();
?>
<form id="themecloud_edd_install_<?php echo esc_attr($atts['id']) ?>" class="themecloud-edd-install-form" method="POST" target="<?php echo esc_attr($atts['target']); ?>" >
<input type="submit" class="<?php echo esc_attr($atts['class']) ?>" style="<?php echo esc_attr($atts['style']) ?>" value="<?php echo esc_attr($atts['text']) ?>" />
<input type="hidden" name="download_id" value="<?php echo esc_attr( $download->ID ); ?>">
<input type="hidden" name="themecloud_edd_action" value="install">
</form>
<?php
$link = ob_get_clean();

    } else {

    $url = Themecloud_EDD::getDownloadUrl($atts['id']);
ob_start();
?>
<a href="<?php echo $url; ?>" style="<?php echo esc_attr($atts['style']) ?>" class="<?php echo esc_attr($atts['class']) ?>" target="<?php echo esc_attr($atts['target']) ?>" ><?php echo esc_attr($atts['text']) ?></a>
<?php
$link = ob_get_clean();

    }

    return $link;
}

add_shortcode('themecloud_edd_install', themecloud_edd_install_shortcode);
