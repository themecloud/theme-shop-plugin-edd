<?php

if ( ! defined( 'ABSPATH' ) ) exit;

function themecloud_edd_install($data) {
    global $user_ID;
    
    $download_id = absint( $data['download_id'] );

    if(! $download_id ) {
        return;
    }

    $download = new EDD_Download($download_id);

    if( ! $download->is_free() && ! edd_has_user_purchased($user_ID, $download_id)) {
        return;
    }

    $template_id = Themecloud_EDD::getThemeId($download_id);
    $debug = Themecloud_EDD::isDebug();
    $apiUrl = Themecloud_EDD::getApiUrl($template_id);

    $ch = curl_init($apiUrl);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if($debug && $httpCode == 403) {
        die('Please verify your API key!');
    }

    if ($response === false || $httpCode == 404) {
        die('An error occurred, please try again later');
    }

    $decoded = json_decode($response);
    if ($decoded->success === false) {
        if($debug) {
            die($decoded->reason);
        }
        die('An error occurred, please try again later');
    }

    header("Location: {$decoded->url}");
    die();
}

add_action( 'themecloud_edd_install', themecloud_edd_install );

