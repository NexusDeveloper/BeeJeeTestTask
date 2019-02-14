<?php
/** @var \View\PHPView $this */
$this->extend('main','content');
view('base')->setSection('head.title','Main page title');
/** @var PHPViewParameters $var */
?><div class="row">
    <div class="col-sm-3">
        <a href="<?php echo url()->route('todo-add'); ?>" class="btn btn-success">Add task</a>
    </div>
    <div class="col-sm-9">
        <form method="post" action="<?php echo url()->route('todo-set-sort'); ?>">
            <?php $curValue=\App\Services\ToDoSortingService::getSortType(); ?>
            Сортировать по
            <select name="sort-type" class="form-control" style="width:auto;display:inline-block;">
                <?php foreach(\App\Services\ToDoSortingService::AVAILABLE_SORT_TYPES as $val=>$title): ?>
                    <option value="<?php echo $val; ?>"<?php if($curValue===$val) echo ' selected';?>><?php echo $title; ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn">Apply</button>
        </form>
    </div>
</div>
<hr/>
<?php
    /** @var \App\Models\ToDo[] $list */
    $list=$var->get('todo-list');
    if(empty($list)):
?>
    <div class="text-center text-muted" style="padding:50px 0;">
        List is empty
    </div>
<?php else: ?>
    <div class="task-list">
        <?php $userLogged=!!user(); ?>
        <?php foreach($list as $item):?>
            <div class="task-list__item row">
                <div class="col-xs-2">
                    <?php echo date('d-m H:i',$item->created_at)?>
                </div>
                <div class="col-xs-2">
		            <?php echo $item->author_name; ?>
                </div>
                <div class="col-xs-<?php echo $userLogged?6:8; ?>">
	                <?php if($item->completed): ?>
                        <span class="badge" style="background-color:#5cb85c">Completed</span>
	                <?php endif; ?>
                    <?php echo $item->text; ?>
                </div>
                <?php if($userLogged): ?>
                    <div class="col-xs-2">
                        <a href="<?php echo url()->route('todo-edit',['id'=>$item->id]); ?>"
                           class="btn btn-sm btn-default">Edit</a>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        
        <div style="margin-top:30px">
            <?php include __DIR__.'/../blocks/pagination.php'; ?>
        </div>
        
    </div>
<?php endif; ?>