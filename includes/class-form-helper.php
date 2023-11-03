<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( !class_exists('TPQuizDeluxe_Form_Helper') ) {
    class TPQuizDeluxe_Form_Helper {
        function __construct() {}

        public function get_columns($table_name, $exclude_list = array()) {
            global $wpdb;
            $full_table_name = $wpdb->prefix . $table_name;
            $columns = $wpdb->get_col("DESC " . $full_table_name, 0);


            return array_diff($columns, $exclude_list);
        }

        public function render_form_field($title, $name, $value, $type, $attrs=array()) {
            global $field_data;
            $field_data = array(
                'label' => $title,
                'name' => $name,
                'value' => $value,
                'attrs' => $attrs
            );
            switch($type) {
                case 'text':
                    include TPQUIZDELUXE_PATH . 'includes/form/fields/text.php';
                    break;
            }
        }
    }
}