<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once TPQUIZDELUXE_PATH . 'includes/class-quizzes-list-table.php';

if ( !class_exists('TPQuizDeluxe_Admin' ) ) {
    class TPQuizDeluxe_Admin {
        function __construct() {
            add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
            add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
        }

        public function admin_scripts() {
            wp_enqueue_style( 'tpquizdeluxe-admin-main', TPQUIZDELUXE_URI . 'assets/admin/css/main.css', array(), TPQUIZDELUX_VERSION );
            wp_register_script( 'tpquizdeluxe-admin-main', TPQUIZDELUXE_URI . 'assets/admin/js/main.js', array('jquery'), TPQUIZDELUX_VERSION );
        }

        public function add_admin_menu() {
            global $quizz_page;

            add_menu_page(
                __( 'TP Quiz Deluxe Dashboard', 'textdomain' ),
                __( 'TP Quiz Deluxe', 'textdomain' ),
                'manage_options',
                'tpquizdeluxe',
                array( $this, 'dashboard_page' )
            );
            add_submenu_page(
                'tpquizdeluxe',
                __('Dashboard', 'textdomain'),
                __('Dashboard', 'textdomain'),
                'manage_options',
                'tpquizdeluxe',
                array( $this, 'dashboard_page' )
            );
            $quizz_page = add_submenu_page(
                'tpquizdeluxe',
                __('Quizzes Management', 'textdomain'),
                __('Quizzes Management', 'textdomain'),
                'manage_options',
                // 'edit.php?post_type=quizz',
                'quizzes',
                array( $this, 'quizzes_page' )
            );
            add_submenu_page(
                'tpquizdeluxe',
                __('Questions Management', 'textdomain'),
                __('Questions Management', 'textdomain'),
                'manage_options',
                // 'edit.php?post_type=question',
                'questions',
                array( $this, 'dashboard_page' )
            );
            add_submenu_page(
                'tpquizdeluxe',
                __('Results', 'textdomain'),
                __('Results', 'textdomain'),
                'manage_options',
                'results',
                array( $this, 'dashboard_page' )
            );
            add_submenu_page(
                'tpquizdeluxe',
                __('Configuration', 'textdomain'),
                __('Configuration', 'textdomain'),
                'manage_options',
                'config',
                array( $this, 'dashboard_page' )
            );

            add_action('load-'. $quizz_page, array( $this, 'quizz_screen_options') );
        }

        // add screen options
        public function quizz_screen_options() {
        
            global $quizz_page;
            global $table;
        
            $screen = get_current_screen();
            $action = isset($_GET['action']) ? $_GET['action'] : '';
        
            // get out of here if we are not on our settings page
            if(!is_object($screen) || $screen->id != $quizz_page || $action !== '')
                return;
        
            $args = array(
                'label' => __('Quizzes per page', 'textdomain'),
                'default' => 10,
                'option' => 'elements_per_page'
            );
            add_screen_option( 'per_page', $args );

            $table = new TPQuizDeluxe_Quizzes_List_Table();

        }

        public function dashboard_page() {
            require_once __DIR__ . '/views/dashboard.php';
        }

        public function quizzes_page() {
            $actions = isset($_GET['action']) ? $_GET['action'] : '';
            if ( $actions === 'edit' ) {
                require_once __DIR__ . '/views/quiz/edit.php';
            } else {
                require_once __DIR__ . '/views/quiz/list.php';
            }
        }
    }
}