<?php
$data = $field_data;
$field_prefix = 'tpquizdeluze-';
$field_id = $field_prefix . $data['name'];
?>
<div class="tpquizdeluxe-control-group">
    <div class="control-label">
        <label for="<?php echo $field_id; ?>"><?php echo $data['label']; ?></label>
    </div>
    <div class="controls">
        <input type="text" name="<?php echo $field_id; ?>" id="<?php echo $field_id; ?>" class="form-control" value="<?php echo $data['value']; ?>">
    </div>
</div>