<div class="col-xs-12">
    <ul class="pagination">
        <?php $url=$var->get('pagination.url'); ?>
        <?php for($page=1;$page<=$var->get('pagination.max-page');$page++): ?>
            <li>
                <a href="<?php echo $url,$page; ?>">
                    <?php echo $page; ?>
                </a>
            </li>
        <?php endfor; ?>
    </ul>
</div>