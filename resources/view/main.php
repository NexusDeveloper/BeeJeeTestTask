<?php
/** @var \View\PHPView $this */
$this->extend('base','body.content');
?><div class="container">
	<div class="col-md-3">
		<?php
		if(!user()):
			include __DIR__.'/blocks/sidebar/auth-form.php';
		else: ?>
			<div>
                Welcome, <?php echo user()->login; ?>.
                <a href="<?php echo url()->route('logout'); ?>">Sign out</a>
			</div>
		<?php endif; ?>
	</div>
    <div class="col-md-9">
	    <?php if($error=app('flash')->get('error')): ?>
            <div class="col-xs-12 alert alert-danger">
			    <?php echo $var->escape($error); ?>
            </div>
	    <?php endif; ?>
     
		<?php echo $this->getSection('content'); ?>
    </div>
</div>