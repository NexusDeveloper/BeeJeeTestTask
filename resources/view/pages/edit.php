<?php
/** @var \View\PHPView $this */
$this->extend('main','content');
view('base')->setSection('head.title','Edit task');
/** @var PHPViewParameters $var */
?><form method="post"
        action="<?php echo url()->route('todo-edit-action',['id'=>$var->get('task')->id]);?>"
        enctype="application/x-www-form-urlencoded">
	<?php $var->setDataModel( $var->get('task') );?>
	<div class="form-group">
		<label for=text-field">Text</label>
		<textarea class="form-control"
		          id="text-field"
		          placeholder="Text"
		          name="text"><?php echo $var->field('text')?></textarea>
	</div>
	
	<div class="form-check">
		<label class="form-check-label">
			<input type="checkbox"
                   name="completed"
                   class="form-check-input" <?php if($var->field('completed')) echo 'checked'; ?>/>
			Task completed
		</label>
	</div>
	
	<div style="margin-top:30px">
		<button type="submit" class="btn btn-primary">Save</button>
        <a href="<?php echo url()->route('index'); ?>" class="btn btn-default">Cancel</a>
	</div>
</form>