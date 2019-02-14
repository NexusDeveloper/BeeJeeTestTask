<?php
/** @var \View\PHPView $this */
$this->extend('main','content');
view('base')->setSection('head.title','Add task');
/** @var PHPViewParameters $var */
?><form method="post" action="<?php echo url()->route('todo-add-action');?>" enctype="application/x-www-form-urlencoded">
	<div class="form-group">
		<label for="author-name-field">Name</label>
		<input type="text"
		       class="form-control"
		       id="author-name-field"
		       placeholder="Name"
		       name="author_name"
		       value="<?php echo $var->field('author_name')?>">
	</div>
	<div class="form-group">
		<label for="author-email-field">Email</label>
		<input type="text"
		       class="form-control"
		       id="author-email-field"
		       placeholder="Email"
		       name="author_email"
		       value="<?php echo $var->field('author_email')?>">
	</div>
	<div class="form-group">
		<label for=text-field">Text</label>
		<textarea class="form-control"
		       id="text-field"
		       placeholder="Text"
		       name="text"><?php echo $var->field('text')?></textarea>
	</div>
	<div>
		<button type="submit" class="btn btn-primary">Create</button>
        <a href="<?php echo url()->route('index'); ?>" class="btn btn-default">Cancel</a>
	</div>
</form>