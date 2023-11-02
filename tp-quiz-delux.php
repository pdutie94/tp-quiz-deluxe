<?php
/**
 * TP Quiz Deluxe
 *
 * @package           TPQuizDeluxe
 * @author            Tien Pham
 * @copyright         2023 Tien Pham
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       TP Quiz Deluxe
 * Plugin URI:        https://flatsomix.com/tp-quiz-deluxe
 * Description:       Easy quiz maker for Wordpress
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.3
 * Author:            Tien Pham
 * Author URI:        https://flatsomix.com/
 * Text Domain:       tpquizdeluxe
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Update URI:        https://flatsomix.com/tp-quiz-deluxe
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define Constants.
define( 'TPQUIZDELUX_VERSION', '1.0.0');
define( 'TPQUIZDELUXE_FILE', __FILE__ );
define( 'TPQUIZDELUXE_PLUGIN_BASE', plugin_basename( TPQUIZDELUXE_FILE ) );
define( 'TPQUIZDELUXE_PATH', plugin_dir_path( TPQUIZDELUXE_FILE ) );
define( 'TPQUIZDELUXE_URI', plugins_url( '/', TPQUIZDELUXE_FILE ) );

if ( is_admin() ) {
    require_once __DIR__ . '/includes/admin.php';
    new TPQuizDeluxe_Admin();
}

function tpquizdeluxe_setup_post_type() {
    $quizz_args = array(
        'public' => true,
        'show_in_menu' => false,
        'labels' => array(
            'name' => __('Quizzes', 'textdomain'),
            'singular_name' => __('Quizz', 'textdomain'),
            'add_new' => __('Add new Quizz', 'textdomain'),
            'add_new_item' => __('Add new Quizz', 'textdomain'),
            'edit_item' => __('Edit Quizz', 'textdomain'),
        ),
    );
    $question_args = array(
        'public' => true,
        'show_in_menu' => false,
        'labels' => array(
            'name' => __('Questions', 'textdomain'),
            'singular_name' => __('Question', 'textdomain'),
            'add_new' => __('Add new Question', 'textdomain'),
            'add_new_item' => __('Add new Question', 'textdomain'),
            'edit_item' => __('Edit Question', 'textdomain'),
        ),
    );
	register_post_type( 'quizz', $quizz_args ); 
	register_post_type( 'question', $question_args ); 
} 
add_action( 'init', 'tpquizdeluxe_setup_post_type' );

/**
 * Activate the plugin.
 */
function tpquizdeluxe_activate() {
    tpquizdeluxe_setup_post_type();
    flush_rewrite_rules();
}
register_activation_hook( TPQUIZDELUXE_FILE, 'tpquizdeluxe_activate' );

/**
 * Deactivation hook.
 */
function tpquizdeluxe_deactivate() {
    unregister_post_type( 'quizz' );
    unregister_post_type( 'question' );
    flush_rewrite_rules();
}
register_deactivation_hook( TPQUIZDELUXE_FILE, 'tpquizdeluxe_deactivate' );