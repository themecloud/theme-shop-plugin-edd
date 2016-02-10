<?php

if ( ! defined( 'ABSPATH' ) ) exit;

function themecloud_edd_get_actions() {
    if ( isset( $_GET['themecloud_edd_action'] ) ) {
        do_action( 'themecloud_edd_' . $_GET['themecloud_edd_action'], $_GET );
    }
}
add_action(init, themecloud_edd_get_actions);

function themecloud_edd_post_actions() {
    if ( isset( $_POST['themecloud_edd_action'] ) ) {
        do_action( 'themecloud_edd_' . $_POST['themecloud_edd_action'], $_POST );
    }
}
add_action(init, themecloud_edd_post_actions);

