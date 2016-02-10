<?php

if ( ! defined( 'ABSPATH' ) ) exit;

function themecloud_edd_download_files($files, $download_id, $variable_price_id) {
    $template_id = Themecloud_EDD::getThemeId($download_id);

    if(! $template_id) {
         return $files;
    }

    foreach($files as $file) {
        if(preg_match('/themecloud_edd_action=install/', $file['file'])) {
            return $files;
        }
    }

    $files[] = array(
        'attachment_id' => "themecloud",
        'name' => "Install on Themecloud",
        'file' => Themecloud_EDD::getDownloadUrl( $download_id ),
        'condition' => 'all'
    );
    return $files;
}

add_filter('edd_download_files', themecloud_edd_download_files, 10, 3);

