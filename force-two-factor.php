<?php
/**
 * Aiwos - Force Two Factor
 *
 * @package     Force_Two_Factor
 * @author      Jurriaan Koops
 * @copyright   2021 Aiwos BV
 * @license     GPL-3.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name: Force Two Factor
 * Plugin URI: https://github.com/aiwos/force-two-factor
 * Description: Redirects any user which hasn't setup two factor authentication yet to /2fa/. Use together with the forked two-factor plugin at https://github.com/aiwos/two-factor featuring the frontend totp activation shortcode.
 * Author: Aiwos, Jurriaan Koops
 * Version: 1.0
 * Author URI: https://aiwos.com
 * Text Domain: force-two-factor
 */

defined( 'ABSPATH' ) || die();

/*
* Redirect when:
* - The custom filtered condition is true. Filter: 'aiwos/force-two-factor/force-2fa-condition';
* - The user is logged in,
* - The request is about visiting any post type (this excludes other requests like admin pages and api requests),
* - and the two-factor core class is loaded.
*/
add_action(
	'wp',
	function () {
		$force_2fa_condition = apply_filters( 'aiwos/force-two-factor/force-2fa-condition', true);
		if ( $force_2fa_condition && is_user_logged_in() && is_singular() && class_exists( 'Two_Factor_Core' ) ) {

			// check if user is not yet using two factor authentication.
			if ( ! Two_Factor_Core::is_user_using_two_factor( get_current_user_id() ) ) {

				// Check if 2fa page exists to prevent endless loop, if yes redirect to it, if not, die.
				if ( empty( get_page_by_path( '2fa' ) ) ) {
					wp_die( 'The Two Factor setup page does not exist. Contact the administrator.' );
				}

				// Redirect top /2fa/ if any other page than the 2fa page is being requested.
				if ( ! ( $_SERVER['REQUEST_URI'] === '/2fa' || $_SERVER['REQUEST_URI'] === '/2fa/' ) ) {
					wp_safe_redirect( site_url( '2fa/' ) );
					exit();
				}
			}
		}
	}
);
