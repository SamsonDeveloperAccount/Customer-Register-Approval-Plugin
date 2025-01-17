<?php
require_once get_stylesheet_directory() . '/inc/mime-types.php';
require_once get_stylesheet_directory() . '/inc/custom-sorting.php';
require_once get_stylesheet_directory() . '/inc/custom-registration.php';
require_once get_stylesheet_directory() . '/inc/redirection.php';
require_once get_stylesheet_directory() . '/inc/admin-styles.php';
require_once get_stylesheet_directory() . '/inc/custom-prices.php';
require_once get_stylesheet_directory() . '/inc/bulk-discounts.php';
require_once get_stylesheet_directory() . '/inc/enqueue-scripts.php';
require_once get_stylesheet_directory() . '/inc/ajax-handler.php';
//require_once get_stylesheet_directory() . '/inc/cart-checkout.php';

add_filter('doing_it_wrong_trigger_error', function ($trigger, $function) {
    if ($function === '_load_textdomain_just_in_time') {
        return false; // Suppress the notice
    }
    return $trigger;
}, 10, 2);