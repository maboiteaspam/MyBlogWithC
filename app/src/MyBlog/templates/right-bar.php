<?php
/* @var $this \C\View\ConcreteContext */
/* @var $blocks array The blocks to display in the right bar */
?>
<div class="right-bar">
    <?php $this->display('right-bar', true) ?>
    <?php foreach ($blocks as $block){ ?>
        <?php $this->display($block) ?>
    <?php } ?>
</div>
