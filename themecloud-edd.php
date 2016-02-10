<?php
/**
 * Plugin Name: Themecloud EDD
 * Plugin URI: https://www.themecloud.io
 * Description: Integrates Themecloud with EDD
 * Author: Alessandro Siragusa
 * Version: 0.1.0
 *
 * Themecloud EDD is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Themecloud EDD is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Easy Digital Downloads. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package ThemecloudEDD
 * @category Core
 * @author Alessandro Siragusa
 * @version 0.1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Themecloud_EDD' ) ) :

final class Themecloud_EDD {
    private static $instance;

    public static function getInstance() {
        if (! isset(self::$instance) && ! (self::$instance instanceof Themecloud_EDD)) {
            self::$instance = new Themecloud_EDD();
            self::defineConstants();
            self::$instance->doIncludes();
        }
        return self::$instance;
    }

    private function defineConstants() {
        if (! defined('THEMECLOUD_EDD_DIR')) {
            define('THEMECLOUD_EDD_DIR', plugin_dir_path( __FILE__ ));
        }
    }

    private function doIncludes() {
        $includesDir = THEMECLOUD_EDD_DIR . "includes";

        require_once($includesDir . "/shortcodes.php");
        require_once($includesDir . "/actions.php");
        require_once($includesDir . "/install.php");
        require_once($includesDir . "/download_files.php");

        if (is_admin()) {
            $adminDir = $includesDir . "/admin";

            require_once($adminDir . "/metabox.php");
            require_once($adminDir . "/settings/register-settings.php");
        }
    }

    public static function getApiKey() {
        $options = get_option( 'themecloud_settings' );
        return $options['api_key'];
    }

    public static function isDebug() {
        $options = get_option( 'themecloud_settings' );
        return $options['debug'];
    }

    public static function getDownloadUrl($download_id) {
        $apiKey = self::getApiKey();

        return home_url('/', 'relative') . "?themecloud_edd_action=install&download_id=$download_id";
    }

    public static function getUserEmail() {
        global $user_ID;

        $user_info = get_userdata($user_ID);

        return $user_info->user_email;
    }

    public static function getApiUrl($themeId) {
        $apiKey = urlencode(self::getApiKey());
        $email = urlencode(self::getUserEmail());

        return "https://www.themecloud.io/developer/api/activate/$themeId/$email?apikey=$apiKey";
    }

    public static function getThemeId ($download_id) {
        return get_post_meta( $download_id, '_themecloud_edd_tpl_id', true);
    }
}

endif; // End if class_exists check

function Themecloud_EDD() {
    return Themecloud_EDD::getInstance();
}

Themecloud_EDD();

