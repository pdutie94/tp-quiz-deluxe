<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

wp_enqueue_script('tpquizdeluxe-admin-main');

require_once TPQUIZDELUXE_PATH . 'includes/class-quizzes-list-table.php';
// Creating an instance
$table = new TPQuizDeluxe_Quizzes_List_Table();
?>
<div class="wrap">
    <h2>Quizzes</h2>
    <?php $table->views(); ?>
    <form method="post">
    <?php
    // Prepare table.
    $table->prepare_items();
    // Search form.
    $table->search_box('search', 'search_id');
    // Display table.
    $table->display();
    ?>
    </form>
</div>