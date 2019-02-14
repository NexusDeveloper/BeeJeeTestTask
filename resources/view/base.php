<!doctype html>
<html>
<head><?php /** @var \View\PHPViewDirectives $inc */ ?>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=0"/>
	
	<title><?php echo $this->getSection('head.title'); ?></title>
	
	<?php echo $inc->css('assets/librs/bootstrap/css/bootstrap.min.css'); ?>
	<?php echo $inc->css('assets/css/main.css'); ?>
 
	<?php echo $this->getSection('head.resources'); ?>
</head>
<body>
<?php echo $this->getSection('body.begin'); ?>

<div id="__layout">
	<?php echo $this->getSection('body.header'); ?>
	
	<?php echo $this->getSection('body.content'); ?>
	
	<?php echo $this->getSection('body.footer'); ?>
</div>

<?php echo $this->getSection('body.end'); ?>
</body>
</html>