<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
wp_enqueue_script('tpquizdeluxe-admin-edit');

require_once TPQUIZDELUXE_PATH . 'includes/class-form-helper.php';
$form_helper = new TPQuizDeluxe_Form_Helper();

$exclude_cols = array();
$columns = $form_helper->get_columns('tpquiz_quiz');


$tab_list = array(
    array(
        'id' => 'quiz-details',
        'title' => __('Quiz Details'),
    ),
    array(
        'id' => 'quiz-desc',
        'title' => __('Quiz Description'),
    ),
    array(
        'id' => 'additional-options',
        'title' => __('Additional Options'),
    ),
    array(
        'id' => 'feedback-options',
        'title' => __('Feedback Options'),
    ),
);
?>
<div class="wrap">
    <div class="page-header">
        <h2>Edit Quiz</h2>
    </div>
    
    <form method="post" name="tpquizdeluxe-edit-form">
        <div class="main-card">
            <nav class="tpquizdeluxe-tablist nav-tab-wrapper d-flex flex-wrap">
                <?php foreach($tab_list as $k => $tab_item) { ?>
                    <a href="javascript:;" class="nav-tab<?php echo $k === 0 ? ' nav-tab-active' : ''; ?>" data-tab="<?php echo $tab_item['id']; ?>"><?php echo $tab_item['title']; ?></a>
                <?php } ?>
            </nav>
            <div class="tpquizdeluxe-tabcontent">
                <?php foreach($tab_list as $k => $tab_item) { ?>
                    <div id="<?php echo $tab_item['id']; ?>" class="tpquizdeluxe-tab-content<?php echo $k === 0 ? ' active' : ''; ?>">
                        <?php 
                        if ($tab_item['id'] === 'quiz-details') {
                            $form_helper->render_form_field(__('Title','textdomain'), 'title', '', 'text', array('required'=> 1));
                            $form_helper->render_form_field(__('Author','textdomain'), 'author', '', 'text');
                        }
                        ?>
                    </div>
                <?php } ?>
                
            </div>
        </div>
        
        <div class="edit-action-buttons d-flex gap-1">
            <button class="save-button tpquizdeluxe-button"><span class="dashicons dashicons-saved"></span>Save</button>
            <button class="save-n-close-button tpquizdeluxe-button"><span class="dashicons dashicons-saved"></span>Save & Close</button>
            <button class="cancel-button tpquizdeluxe-button"><span class="dashicons dashicons-no-alt"></span>Cancel</button>
        </div>
    </form>
</div>