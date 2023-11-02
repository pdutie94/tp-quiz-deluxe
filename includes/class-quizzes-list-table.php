<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

if ( !class_exists('TPQuizDeluxe_Quizzes_List_Table') ) {
    class TPQuizDeluxe_Quizzes_List_Table extends WP_List_Table {
         // define $table_data property
        private $table_data;

        function get_columns() {
            $columns = array(
                    'cb'            => '<input type="checkbox" />',
                    'title'          => __('Name', 'textdomain'),
                    'status'        => __('Status', 'textdomain'),
                    'cat_id'         => __('Category', 'textdomain'),
                    'author'   => __('Author', 'textdomain'),
                    'created_date'   => __('Creation Date', 'textdomain'),
            );
            return $columns;
        }

         // Bind table with columns, data and all
        function prepare_items() {
            //data
            if ( isset($_POST['s']) ) {
                $this->table_data = $this->get_table_data($_POST['s']);
            } else {
                $this->table_data = $this->get_table_data();
            }

            $columns = $this->get_columns();
            $hidden = ( is_array(get_user_meta( get_current_user_id(), 'managetp-quiz-deluxe_page_quizzescolumnshidden', true)) ) ? get_user_meta( get_current_user_id(), 'managetp-quiz-deluxe_page_quizzescolumnshidden', true) : array();
            $sortable = $this->get_sortable_columns();
            $primary  = 'title';
            $this->_column_headers = array($columns, $hidden, $sortable, $primary);

            usort($this->table_data, array(&$this, 'usort_reorder'));

            /* pagination */
            $per_page = $this->get_items_per_page('elements_per_page', 10);
            $current_page = $this->get_pagenum();
            $total_items = count($this->table_data);

            $this->table_data = array_slice($this->table_data, (($current_page - 1) * $per_page), $per_page);

            $this->set_pagination_args(array(
                    'total_items' => $total_items, // total number of items
                    'per_page'    => $per_page, // items to show on a page
                    'total_pages' => ceil( $total_items / $per_page ) // use ceil to round up
            ));
            
            $this->items = $this->table_data;
        }

        // Get table data
        private function get_table_data( $search = '' ) {
            global $wpdb;

            $table = $wpdb->prefix . 'tpquiz_quiz';

            $query = "SELECT * FROM {$table}";

            $cat_id = isset( $_GET['cat-id'] ) ? $_GET['cat-id'] : 0;
            $status = isset( $_GET['status'] ) ? $_GET['status'] : '';
            $query_conditions = array();
            if ( !empty($search) ) {
                $query_conditions[] = "title Like '%{$search}%'";
            }
            if ( $cat_id > 0 ) {
                $query_conditions[] = 'cat_id = ' . esc_attr($cat_id);
            }
            if ( $status !== '' ) {
                $query_conditions[] = 'status = ' . esc_attr($status);
            }

            if ( !empty( $query_conditions ) ) {
                $query .= ' WHERE ' . implode( ' AND ', $query_conditions );
            }

            return $wpdb->get_results(
                $query,
                ARRAY_A
            );
        }

        function column_default($item, $column_name) {
            switch ($column_name) {
                    case 'id':
                    case 'title':
                    case 'status':
                    case 'cat_id':
                    case 'author':
                    case 'created_date':
                    default:
                        return $item[$column_name];
            }
        }

        function column_cb($item) {
            return sprintf(
                    '<input type="checkbox" name="element[]" value="%s" />',
                    $item['id']
            );
        }
        protected function get_sortable_columns() {
            $sortable_columns = array(
                    'title'  => array('title', false),
                    'status' => array('status', false),
                    'cat_id'   => array('cat_id', true),
                    'author'   => array('author', true),
                    'created_date'   => array('created_date', true),
            );
            return $sortable_columns;
        }

        // Sorting function
        function usort_reorder($a, $b) {
            // If no sort, default to id
            $orderby = (!empty($_GET['orderby'])) ? $_GET['orderby'] : 'id';

            // If no order, default to desc
            $order = (!empty($_GET['order'])) ? $_GET['order'] : 'desc';

            // Determine sort order
            $result = strcmp($a[$orderby], $b[$orderby]);

            // Send final sort direction to usort
            return ($order === 'asc') ? $result : -$result;
        }

        // Adding action links to column
        function column_title($item) {
            $edit_link = '?page='.$_REQUEST['page'].'&action=edit&quizz_id=' .  $item['id'];
            $actions = array(
                'edit'      => sprintf('<a href="?page=%s&action=%s&quizz_id=%s">' . __('Edit', 'textdomain') . '</a>', $_REQUEST['page'], 'edit', $item['id']),
                'delete'    => sprintf('<a href="?page=%s&action=%s&quizz_id=%s">' . __('Delete', 'textdomain') . '</a>', $_REQUEST['page'], 'delete', $item['id']),
            );

            return sprintf('<a href="%1$s">%2$s</a> %3$s', $edit_link, $item['title'], $this->row_actions($actions));
        }

        // To show bulk action dropdown
        function get_bulk_actions()
        {
            $actions = array(
                'published_all' => __('Published', 'textdomain'),
                'unpublished_all' => __('Unpublished', 'textdomain'),
                'delete_all'    => __('Delete', 'textdomain'),
            );
            return $actions;
        }

        function extra_tablenav( $which) {
            global $wpdb, $testiURL, $tablename, $tablet;
            $move_on_url = '&cat-id=';
            $cat_id = isset( $_GET['cat-id'] ) ? $_GET['cat-id'] : '';
            if ( $which == "top" ){
                ?>
                <div class="alignleft actions">
                    <select name="cat-filter" class="tpquizdeluxe-filter-cat">
                        <option value=""><?php _e('Filter by Category', 'textdomain'); ?></option>
                        <option value="1" <?php selected($cat_id, 1, true); ?>>Cat 1</option>
                        <option value="2" <?php selected($cat_id, 2, true); ?>>Cat 2</option>
                        <option value="3" <?php selected($cat_id, 3, true); ?>>Cat 3</option>
                    </select>
                    <input type="button" id="cat-filter-top" class="cat-filter-button cat-filter-top button" value="<?php _e('Filter', 'textdomain'); ?>">
                </div>
                <?php
            } else {
                ?>
                <div class="alignleft actions">
                    <select name="cat-filter" class="tpquizdeluxe-filter-cat">
                        <option value=""><?php _e('Filter by Category', 'textdomain'); ?></option>
                        <option value="1" <?php selected($cat_id, 1, true); ?>>Cat 1</option>
                        <option value="2" <?php selected($cat_id, 2, true); ?>>Cat 2</option>
                        <option value="3" <?php selected($cat_id, 3, true); ?>>Cat 3</option>
                    </select>
                    <input type="button" id="cat-filter-bottom" class="cat-filter-button cat-filter-bottom button" value="<?php _e('Filter', 'textdomain'); ?>">
                </div>
                <?php
            }
        }

        protected function countItems($status = '') {
            global $wpdb;

            $table = $wpdb->prefix . 'tpquiz_quiz';

            $query = "SELECT COUNT(id) FROM {$table}";

            if ( $status !== '') {
                $query .= " WHERE status = " . esc_attr($status);
            }

            return $wpdb->get_var($query);
        }

        function get_views(){
            $views = array();
            $current = ( isset($_GET['status']) ? $_GET['status'] : 'all');
         
            //All link
            $class = ($current == 'all' ? ' class="current"' :'');
            $all_url = remove_query_arg('status');
            $views['all'] = "<a href='{$all_url }' {$class} >All <span class='count'>(".$this->countItems().")</span></a>";
         
            //Published link
            $published_url = add_query_arg('status','1');
            $class = ($current === '1' ? ' class="current"' :'');
            $views['published'] = "<a href='{$published_url}' {$class} >Published <span class='count'>(".$this->countItems('1').")</span></a>";
         
            //Unpublished link
            $unpublished_url = add_query_arg('status','0');
            $class = ($current === '0' ? ' class="current"' :'');
            $views['unpublished'] = "<a href='{$unpublished_url}' {$class} >Unpublished <span class='count'>(".$this->countItems('0').")</span></a>";
         
            return $views;
         }
    }
} 