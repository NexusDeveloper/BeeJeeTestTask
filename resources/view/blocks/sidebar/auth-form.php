<form action="<?php echo url()->route('login'); ?>" method="post">
	<div>
		<label>
			<input type="text" placeholder="Login" name="login" class="form-control"/>
		</label>
	</div>
	<div>
		<label>
			<input type="password" placeholder="Password" name="password" class="form-control"/>
		</label>
	</div>
	<div>
		<input type="submit" value="Sign in" class="btn btn-primary"/>
	</div>
</form>