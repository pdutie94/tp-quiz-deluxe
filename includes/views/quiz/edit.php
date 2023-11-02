<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<div class="wrap">
    <div class="page-header">
        <h2>Edit Quiz</h2>
    </div>
    
    <form method="post" name="tpquizdeluxe-edit-form">
        <div class="main-card">
            <nav class="tpquizdeluxe-tablist nav-tab-wrapper d-flex flex-wrap">
                <a href="javascript:;" class="nav-tab nav-tab-active" data-tab="quiz-details">Quiz Details</a>
                <a href="javascript:;" class="nav-tab" data-tab="quiz-desc">Quiz Description</a>
                <a href="javascript:;" class="nav-tab" data-tab="additional-options">Additional Options</a>
                <a href="javascript:;" class="nav-tab" data-tab="feedback-options">Feedback Options</a>
                <a href="javascript:;" class="nav-tab" data-tab="question-pool-options">Question Pool Options</a>
            </nav>
            <div class="tpquizdeluxe-tabcontent">
                <div id="quiz-details">
                    Tab content
                </div>
            </div>
        </div>
        
        <div class="edit-action-buttons d-flex gap-1">
            <button class="save-button tpquizdeluxe-button"><span class="dashicons dashicons-saved"></span>Save</button>
            <button class="save-n-close-button tpquizdeluxe-button"><span class="dashicons dashicons-saved"></span>Save & Close</button>
            <button class="cancel-button tpquizdeluxe-button"><span class="dashicons dashicons-no-alt"></span>Cancel</button>
        </div>
    </form>
</div>